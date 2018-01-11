<?php

namespace Chenmobuys\ChenJWT\JWT;


use Chenmobuys\ChenJWT\JWT\Claims\Audience;
use Chenmobuys\ChenJWT\JWT\Claims\CustomClaim;
use Chenmobuys\ChenJWT\JWT\Claims\ExpirationTime;
use Chenmobuys\ChenJWT\JWT\Claims\IssuedAt;
use Chenmobuys\ChenJWT\JWT\Claims\Issuer;
use Chenmobuys\ChenJWT\JWT\Claims\JwtId;
use Chenmobuys\ChenJWT\JWT\Claims\NotBefore;
use Chenmobuys\ChenJWT\JWT\Claims\RefreshTime;
use Chenmobuys\ChenJWT\JWT\Claims\Subject;
use Chenmobuys\ChenJWT\JWT\Core\Header;
use Chenmobuys\ChenJWT\JWT\Core\Payload;
use Chenmobuys\ChenJWT\JWT\Core\Token;

class Builder
{
    private $header;

    private $payload;

    private $secretKey;

    private $privateKey;

    private $publicKey;

    public function __construct()
    {
        $this->header = new Header();

        $this->payload = new Payload();
    }

    public function secretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    public function privateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    public function publicKey($publicKey)
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    public function algorithmId($algorithmId)
    {
        $this->header->setAlgorithmId($algorithmId);
        return $this;
    }

    public function audience($aud)
    {
        $this->payload->addClaim(new Audience($aud));
        return $this;
    }

    public function expireAt($exp)
    {
        $this->payload->addClaim(new ExpirationTime($exp));
        return $this;
    }

    public function refreshAt($ref)
    {
        $this->payload->addClaim(new RefreshTime($ref));
        return $this;
    }

    public function issueAt($iat)
    {
        $this->payload->addClaim(new IssuedAt($iat));
        return $this;
    }

    public function issuer($iss)
    {
        $this->payload->addClaim(new Issuer($iss));
        return $this;
    }

    public function notBefore($nbf)
    {
        $this->payload->addClaim(new NotBefore($nbf));
        return $this;
    }

    public function subject($sub)
    {
        $this->payload->addClaim(new Subject($sub));
        return $this;
    }

    public function jwtId($jti)
    {
        $this->payload->addClaim(new JwtId($jti));
        return $this;
    }

    public function customClaim($name, $value)
    {
        $this->payload->addClaim(new CustomClaim($name, $value));
        return $this;
    }

    public function build()
    {
        return new Token($this->header, $this->payload, $this->secretKey, $this->privateKey, $this->publicKey);
    }
}