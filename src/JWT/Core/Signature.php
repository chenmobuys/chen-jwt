<?php

namespace Chenmobuys\ChenJWT\JWT\Core;


class Signature
{
    /**
     * @var string
     */
    private $value;

    /**
     * Signature constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * get value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * set value
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}