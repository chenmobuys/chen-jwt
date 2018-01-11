<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class IssuedAt extends Claim
{
    /**
     * IssuedAt constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('iat', $value);
    }

    /**
     * validate
     * @return bool
     */
    function validate()
    {
        return is_int($this->value);
    }
}