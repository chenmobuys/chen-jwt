<?php

namespace Chenmobuys\ChenJWT\JWT\Sign;


class SignFactory
{
    /**
     *
     * @param $algorithmId
     * @return HMAC|RSA
     */
    public static function createByAlgorithmId($algorithmId)
    {
        if (starts_with($algorithmId, 'S')) {
            return self::createHMACSigner($algorithmId);
        } elseif (starts_with($algorithmId, 'R')) {
            return self::createRsaSigner($algorithmId);
        }
        throw new \InvalidArgumentException();
    }

    /**
     * 创建一个HMAC签名者
     * @param $algorithmId
     * @return HMAC
     */
    public static function createHMACSigner($algorithmId)
    {
        return new HMAC($algorithmId);
    }

    /**
     * 创建一个RSA签名者
     * @param $algorithmId
     * @return RSA
     */
    public static function createRsaSigner($algorithmId)
    {
        return new RSA($algorithmId);
    }
}