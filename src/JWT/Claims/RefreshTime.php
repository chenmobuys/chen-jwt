<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class RefreshTime extends Claim
{
    /**
     * ExpirationTime constructor.
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct('ref', $value);
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