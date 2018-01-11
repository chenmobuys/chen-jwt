<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class NotBefore extends Claim
{
    /**
     * NotBefore constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('nbf', $value);
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