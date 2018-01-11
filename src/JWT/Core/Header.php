<?php

namespace Chenmobuys\ChenJWT\JWT\Core;


class Header
{
    /**
     * declare type
     * @var string
     */
    private $type;

    /**
     * declare algorithmId
     * @var
     */
    private $algorithmId;

    public function __construct($algorithmId = 'RSA', $type = 'JWT')
    {
        $this->type = $type;
        $this->algorithmId = $algorithmId;
    }

    /**
     * get type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * set type
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * get algorithmId
     * @return mixed
     */
    public function getAlgorithmId()
    {
        return $this->algorithmId;
    }

    /**
     * set algorithmId
     * @param $algorithmId
     */
    public function setAlgorithmId($algorithmId)
    {
        $this->algorithmId = $algorithmId;
    }

    /**
     * output jsonString
     * @return string
     */
    public function toJsonString()
    {
        $object = new \stdClass();
        $object->typ = $this->type;
        $object->alg = $this->algorithmId;
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