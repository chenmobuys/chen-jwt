<?php

namespace Chenmobuys\ChenJWT\JWT\Contracts;


interface Sign
{
    /**
     * get algorithm
     * @return mixed
     */
    public function getAlgorithm();

    /**
     * signature
     * @param $data
     * @param $secretKey
     * @return mixed
     */
    public function sign($data, $secretKey);

    /**
     * validate signature
     * @param $expects
     * @param $data
     * @param $secretKey
     * @return mixed
     */
    public function validate($expects, $data, $secretKey);

    /**
     * validate SecretKey
     * @param $secretKey
     * @return mixed
     */
    public function validateSecretKey($secretKey);
}