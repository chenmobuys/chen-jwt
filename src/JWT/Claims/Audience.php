<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class Audience extends Claim
{
    /**
     * Audience constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('aud', $value);
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