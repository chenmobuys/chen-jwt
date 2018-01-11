<?php

namespace Chenmobuys\ChenJWT\JWT\Core;


use Chenmobuys\ChenJWT\JWT\Exceptions\TokenInvalidException;
use Chenmobuys\ChenJWT\JWT\Sign\HMAC;
use Chenmobuys\ChenJWT\JWT\Sign\RSA;
use Chenmobuys\ChenJWT\JWT\Sign\SignFactory;

class Token
{
    /**
     * declare header
     * @var Header
     */
    private $header;

    /**
     * declare payload
     * @var Payload
     */
    private $payload;

    /**
     * declare secreKey
     * @var string
     */
    private $secretKey;

    /**
     * declare privateKey
     * @var string
     */
    private $privateKey;

    /**
     * declare public
     * @var string
     */
    private $publicKey;

    /**
     * declare signature
     * @var null
     */
    private $signature;

    /**
     * Token constructor.
     * @param Header $header
     * @param Payload $payload
     * @param $secretKey
     * @param $privateKey
     * @param $publicKey
     * @param Signature|null $signature
     */
    public function __construct(Header $header, Payload $payload, $secretKey, $privateKey, $publicKey, $signature = null)
    {
        $this->header = $header;
        $this->payload = $payload;
        $this->secretKey = $secretKey;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->signature = $signature;
    }

    /**
     * validate token
     * @return bool
     */
    public function validate()
    {
        return $this->validateHeader() && $this->validatePayload() && $this->validateSignature();
    }

    /**
     * validate refresh token
     * @return bool
     */
    public function validateRefresh()
    {
        return $this->validateHeader() && $this->validatePayload() && $this->validateRefreshTime() && $this->validateSignature();
    }

    /**
     * validate header
     * @return bool
     * @throws \Exception
     */
    private function validateHeader()
    {
        if ($this->header->getType() != 'JWT') {
            throw new TokenInvalidException('header has wrong typ');
        }

        return true;
    }

    /**
     * validate Claims
     * @return bool
     */
    private function validatePayload()
    {
        foreach ($this->payload->getClaims() as $claim) {
            if (!$claim->validate()) {
                throw new TokenInvalidException("payload has wrong $claim->getName()");
            }
        }

        if (!$this->validateExpriteTime()) {
            throw new TokenInvalidException('token has expired');
        }

        if (!$this->validateNotBefore()) {
            $nbf = $this->payload->getClaim('nbf')->getValue();
            throw new TokenInvalidException("token can not use before $nbf");
        }

        return true;
    }

    /**
     * validate exp
     * @return bool
     * @throws TokenInvalidException
     */
    private function validateExpriteTime()
    {
        $expClaim = $this->payload->getClaim('exp');

        if (!$expClaim) {
            throw new TokenInvalidException('payload has no exp claim');
        }

        $now = new \DateTime();

        $expireAt = new \DateTime();

        $expireAt->setTimestamp($expClaim->getValue());

        return $expireAt > $now;
    }

    /**
     * validate ref
     * @return bool
     * @throws TokenInvalidException
     */
    private function validateRefreshTime()
    {
        $refClaim = $this->payload->getClaim('ref');

        if (!$refClaim) {
            throw new TokenInvalidException('payload has no ref claim');
        }

        $now = new \DateTime();

        $refreshAt = new \DateTime();

        $refreshAt->setTimestamp($refClaim->getValue());

        if ($refreshAt > $now) return true;

        throw new TokenInvalidException("token can not fresh now");
    }

    /**
     * validate nbf
     * @return bool
     */
    private function validateNotBefore()
    {
        $nbfClaim = $this->payload->getClaim('nbf');

        if (!$nbfClaim) {
            return true;
        }

        $now = new \DateTime();

        $notBefore = new \DateTime();

        $notBefore->setTimestamp($nbfClaim->getValue());

        return $notBefore < $now;
    }

    /**
     * validate signature
     * @return bool|mixed
     */
    private function validateSignature()
    {
        $data = $this->getHeaderConcatPayloadString();
        $signer = $this->getSigner();

        if ($signer instanceof HMAC) {
            $result = $signer->validate($data, $this->signature, $this->secretKey);
        } else if ($signer instanceof RSA) {
            $result = $signer->validate($data, $this->signature, $this->publicKey);
        } else {
            throw new TokenInvalidException('unknown signer');
        }

        if ($result) {
            return true;
        }

        throw new TokenInvalidException('wrong signature');
    }

    /**
     * get header & payload string
     * @return string
     */
    public function getHeaderConcatPayloadString()
    {
        return $this->header->toBase64String() . "." . $this->payload->toBase64String();
    }

    /**
     * get signer
     * @return Contracts\ISign
     */
    public function getSigner()
    {
        $algorithmId = $this->header->getAlgorithmId();
        $signer = SignFactory::createByAlgorithmId($algorithmId);
        return $signer;
    }

    /**
     * get signature
     * @return mixed|null|string
     */
    public function getSignatureValue()
    {
        $data = $this->getHeaderConcatPayloadString();
        $signer = $this->getSigner();
        if ($signer instanceof HMAC) {
            return $signer->sign($data, $this->secretKey);
        } else if ($signer instanceof RSA) {
            return $signer->sign($data, $this->privateKey);
        }

        return null;
    }

    /**
     * get customer signature
     * @return Signature|null
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * get token string
     * @return string
     */
    public function toString()
    {
        $signatureValue = $this->getSignatureValue();
        //别忘记BASE64URL编码
        $signatureValue = base64_url_encode($signatureValue);
        return $this->getHeaderConcatPayloadString() . '.' . $signatureValue;
    }

}