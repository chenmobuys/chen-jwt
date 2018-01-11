<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class JwtId extends Claim
{
    /**
     * JwtId constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('jti', $value);
    }

    /**
     * validate
     * @return bool
     */
    function validate()
    {
        return is_string($this->value);
    }
}