<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class Issuer extends Claim
{
    /**
     * Issuer constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('iss', $value);
    }

    /**
     * validate
     * @return bool
     */
    public function validate()
    {
        return is_string($this->getValue());
    }
}