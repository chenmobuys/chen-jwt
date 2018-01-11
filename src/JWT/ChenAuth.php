<?php

namespace Chenmobuys\ChenJWT\JWT;


use Chenmobuys\ChenJWT\JWT\Core\Parse;
use Chenmobuys\ChenJWT\JWT\Core\Token;

class ChenAuth
{
    use Parse;

    const PREFIX = 'jwt:blacklist:jti:';

    /**
     * @param array $credentials
     * @return string
     */
    public static function createToken($credentials = [])
    {
        return self::getToken($credentials);
    }

    /**
     * @param array $credentials
     * @return string
     */
    public static function refreshToken($token, $credentials = [])
    {
        $token = self::parseToken($token);

        $token->validateRefresh();

        self::addToBlackList($token);

        return self::getToken($credentials);
    }

    /**
     * @param $token
     */
    public static function addToBlackList(Token $token)
    {
        $jti = $token->getClaim('jti')->getValue();

        $refreshExpireTime = $token->getClaim('ref')->getValue();

        $now = time();

        $cacheMinutes = ($refreshExpireTime - $now) / 60;

        app('cache')->put(self::PREFIX . $jti, $now, $cacheMinutes);
    }

    /**
     * @param $data
     * @param int $code
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, $code = 200, $headers = [])
    {
        return response(['data' => $data], $code, [])->json();
    }

    /**
     * @param $message
     * @param int $code
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message, $code = 503, $headers = [])
    {
        return response(['error' => $message], $code, $headers)->json();
    }

    /**
     * @param array $credentials
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