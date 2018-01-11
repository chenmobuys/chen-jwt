<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class ExpirationTime extends Claim
{
    /**
     * ExpirationTime constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('exp', $value);
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