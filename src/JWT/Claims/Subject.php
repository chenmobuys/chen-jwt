<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class Subject extends Claim
{
    /**
     * Subject constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('sub', $value);
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