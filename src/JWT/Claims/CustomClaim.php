<?php

namespace Chenmobuys\ChenJWT\JWT\Claims;


class CustomClaim extends Claim
{
    public function __construct($name, $value, \Closure $validate = null)
    {
        parent::__construct($name, $value);

        if($validate instanceof \Closure){
            call_user_func($validate);
        }
    }

    /**
     * @TODO
     * @return mixed
     */
    function validate()
    {
        return true;
    }
}