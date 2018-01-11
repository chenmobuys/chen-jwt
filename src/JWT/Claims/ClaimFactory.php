<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class ClaimFactory
{
    /**
     * create Claim
     * @param $name
     * @param $value
     * @return Audience|ExpirationTime|IssuedAt|Issuer|JWTID|NotBefore|Subject
     */
    public static function create($name, $value)
    {
        if($name == 'iss'){
            $claim = new Issuer($value);
        }elseif($name == 'sub'){
            $claim = new Subject($value);
        }elseif($name == 'aud'){
            $claim = new Audience($value);
        }elseif($name == 'exp'){
            $claim = new ExpirationTime($value);
        }elseif($name == 'ref'){
            $claim = new RefreshTime($value);
        }elseif($name == 'nbf'){
            $claim = new NotBefore($value);
        }elseif($name == 'iat'){
            $claim = new IssuedAt($value);
        }elseif($name == 'jti'){
            $claim = new JwtId($value);
        }else{
            $claim = new CustomClaim($name, $value);
        }

        return $claim;
    }
}