<?php

namespace Chenmobuys\ChenJWT\JWT\Core;


use Chenmobuys\ChenJWT\JWT\Claim\Claim;

class Payload
{
    /**
     * @var array
     */
    private $claims;

    /**
     * Payload constructor.
     * @param array $claims
     */
    public function __construct($claims = [])
    {
        $this->claims = array_unique($claims);
    }

    /**
     * get claims
     * @return array
     */
    public function getClaims()
    {
        return $this->claims;
    }

    /**
     * get claim by name
     * @param $name
     * @return \Chenmobuys\ChenJWT\JWT\Claims\Claim $claim|null
     */
    public function getClaim($name)
    {
        foreach ($this->claims as $claim) {
            if ($claim->getName() == $name) {
                return $claim;
            }
        }
        return;
    }

    /**
     * add claim
     * @param $claim
     */
    public function addClaim($claim)
    {
        foreach ($this->claims as $c) {
            if ($c == $claim) {
                return;
            } elseif ($c->getName() == $claim->getName()) {
                $c->setValue($claim->getValue());
            }
        }

        array_push($this->claims, $claim);
    }

    /**
     * output jsonString
     * @return string
     */
    public function toJsonString()
    {
        $object = new \stdClass();
        foreach ($this->claims as $claim) {
            $object->{$claim->getName()} = $claim->getValue();
        }

        return json_encode($object);
    }

    /**
     * output base64String
     * @return mixed
     */
    public function toBase64String()
    {
        return base64_url_encode($this->toJsonString());
    }

}