<?php

namespace Chenmobuys\ChenJWT\JWT\Core;


use Chenmobuys\ChenJWT\JWT\Claims\ClaimFactory;
use Chenmobuys\ChenJWT\JWT\Exceptions\TokenParseException;

trait Parse
{
    public static function parseToken($token)
    {
        $tokens = self::splitToken($token);

        $header = self::parseHeader($tokens[0]);
        $payload = self::parsePayload($tokens[1]);
        $signature = self::parseSignature($tokens[2])->getValue();
        $secret = config('jwt.secret_key');
        $public = config('jwt.public_key');
        $private = config('jwt.private_key');

        return new Token($header, $payload, $secret, $private, $public, $signature);
    }

    private static function splitToken($token)
    {
        $tokens = explode('.', $token);

        if (count($tokens) != 3) {
            throw new TokenParseException('split token error');
        }

        return $tokens;
    }

    private static function parseHeader($header)
    {
        $headerJson = base64_url_decode($header);

        if (!$headerJson) {
            throw new TokenParseException('error header');
        }

        $header = json_decode($headerJson);

        if (!$header || !is_object($header)) {
            throw new TokenParseException('header can not be json decode');
        }

        if (!property_exists($header, 'typ')) {
            throw new TokenParseException('header has no typ');
        }

        if (!property_exists($header, 'alg')) {
            throw new TokenParseException('header has no alg');
        }

        return new Header($header->alg, $header->typ);
    }

    private static function parsePayload($payload)
    {
        $claimsJson = base64_url_decode($payload);

        if (!$claimsJson) {
            throw new TokenParseException('error payload');
        }

        $claims = json_decode($claimsJson);

        if (!$claims || !is_object($claims)) {
            throw new TokenParseException('payload can not be json decode');
        }

        $payload = new Payload();

        $only = ['iss', 'iat', 'exp', 'ref', 'jti', 'nbf', 'sub'];

        foreach ($only as $name) {
            if (!property_exists($claims, $name)) {
                throw new TokenParseException("payload has no $name claim");
            }
        }

        //注意,解析后claim的顺序一定不能改变
        foreach ($claims as $name => $value) {
            $claim = ClaimFactory::create($name, $claims->{$name});
            $payload->addClaim($claim);
        }

        return $payload;
    }

    private static function parseSignature($signature)
    {
        if (empty($signature)) {
            throw new TokenParseException('signature is null or empty');
        }
        $value = base64_url_decode($signature);
        if (!$value) {
            throw new TokenParseException("signature can not be decode");
        }

        return new Signature($value);
    }

}