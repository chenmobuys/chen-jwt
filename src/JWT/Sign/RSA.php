<?php

namespace Chenmobuys\ChenJWT\JWT\Sign;

use Chenmobuys\ChenJWT\JWT\Contracts\Sign;
use Chenmobuys\ChenJWT\JWT\Exceptions\SecretKeyInvalidException;

class RSA implements Sign
{
    public static $algorithmMap = [
        'RSA256' => OPENSSL_ALGO_SHA256,
        'RSA384' => OPENSSL_ALGO_SHA384,
        'RSA512' => OPENSSL_ALGO_SHA512,
    ];

    private $algorithmId;

    const DEFAULT_ALGORITHM_ID = 'RSA256';

    public function __construct($algorithmId = self::DEFAULT_ALGORITHM_ID)
    {
        $this->algorithmId = $algorithmId;
    }

    /**
     * get algorithm
     * @return mixed
     */
    public function getAlgorithm()
    {
        $algorithm = self::$algorithmMap[self::DEFAULT_ALGORITHM_ID];

        if (isset($this->algorithmMap[$this->algorithmId])
            && $algorithm = self::$algorithmMap[$this->algorithmId]) {
            $algorithm = self::$algorithmMap[$this->algorithmId];
        }
        return $algorithm;
    }

    /**
     * signature
     * @param $data
     * @param $privateKey
     * @return mixed
     */
    public function sign($data, $privateKey)
    {
        $privateKeyRes = openssl_pkey_get_private($privateKey);

        $this->validateSecretKey($privateKeyRes);

        openssl_sign($data, $signature, $privateKeyRes, $this->getAlgorithm());

        return $signature;
    }

    /**
     *validate signature
     * @param $data
     * @param $signature
     * @param $publicKey
     * @return bool
     */
    public function validate($data, $signature, $publicKey)
    {
        $publicKeyRes = openssl_get_publickey($publicKey);

        $this->validateSecretKey($publicKeyRes);

        return openssl_verify($data, $signature, $publicKeyRes, $this->getAlgorithm()) === 1;
    }

    /**
     * @param $secretKey
     * @throws SecretKeyInvalidException
     * @return void
     */
    public function validateSecretKey($secretKey)
    {
        if ($secretKey === false) {
            throw new SecretKeyInvalidException(
                'your key can not be parse, because: ' . openssl_error_string()
            );
        }
        $details = openssl_pkey_get_details($secretKey);
        if (!isset($details['key']) || $details['type'] !== OPENSSL_KEYTYPE_RSA) {
            throw new SecretKeyInvalidException('This key is not compatible with RSA signatures');
        }
    }
}