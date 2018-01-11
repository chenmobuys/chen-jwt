<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


abstract class Claim
{
    //declare name
    protected $name;

    //declare value;
    protected $value;

    /**
     * Claim constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * get name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set name
     * @param $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * get value
     * @return mixed
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

    /**
     * @TODO
     * @return mixed
     */
    abstract function validate();

    /**
     * @return mixed
     */
    function __toString()
    {
        return $this->name;
    }

}