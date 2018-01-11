<?php

namespace Chenmobuys\ChenJWT\JWT;


use Chenmobuys\ChenJWT\JWT\Core\Parse;

class ChenAuth
{
    use Parse;

    public static function createToken($credentials = [])
    {
        return self::getToken($credentials);
    }

    public static function refreshToken($token, $credentials = [])
    {
        self::parseToken($token)->validate();

        return self::getToken($credentials);
    }

    /**
     * get token
     * @param array $credentials
     * @param string $token
     * @return string
     */
    protected static function getToken($credentials = [])
    {
        $builder = new Builder();

        $customClaims = array_merge($credentials);

        foreach ($customClaims as $key => $value) {
            $builder->customClaim($key, $value);
        }

        $algorithmId = config('jwt.algorithm_id');
        $issur = app('request')->url();
        $issueAt = time();
        $expireAt = time() + config('jwt.ttl');
        $refreshAt = time() + config('jwt.refresh_ttl');
        $notBefore = time() - config('jwt.not_before');
        $jwtId = uniqid();
        $subject = md5(uniqid());
        $secretKey = config('jwt.secret_key');
        $privateKey = config('jwt.private_key');
        $publicKey = config('jwt.public_key');

        $token = $builder
            ->algorithmId($algorithmId)
            ->issuer($issur)
            ->issueAt($issueAt)
            ->expireAt($expireAt)
            ->refreshAt($refreshAt)
            ->notBefore($notBefore)
            ->subject($subject)
            ->jwtId($jwtId)
            ->secretKey($secretKey)
            ->privateKey($privateKey)
            ->publicKey($publicKey)
            ->build()
            ->toString();

        return $token;
    }

}