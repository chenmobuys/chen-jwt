<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 10:39
 */

namespace Chenmobuys\ChenJWT\JWT\Sign;

use Chenmobuys\ChenJWT\JWT\Contracts\Sign;
use Chenmobuys\ChenJWT\JWT\Exceptions\SecretKeyInvalidException;

class HMAC implements Sign
{
    private $algorithmMap = [
        'SHA256' => 'sha256',
        'SHA384' => 'sha384',
        'SHA512' => 'sha512',
    ];

    private $algorithmId;

    const DEFAULT_ALGORITHM_ID = 'SHA256';

    public function __construct($algorithmId = self::DEFAULT_ALGORITHM_ID)
    {
        $this->algorithmId = $algorithmId;
    }

    /**
     * get algorithm
     * @return mixed
     */
    public function getAlgorithm()
    {
        $algorithm = null;
        if (isset($this->algorithmMap[$this->algorithmId])
            && $algorithm = $this->algorithmMap[$this->algorithmId]) {
            $algorithm = $this->algorithmMap[self::DEFAULT_ALGORITHM_ID];
        }
        return $algorithm;
    }

    /**
     * signature
     * @param $data
     * @param $secretKey
     * @return string
     */
    public function sign($data, $secretKey)
    {
        $this->validateSecretKey($secretKey);

        return hash_hmac($this->getAlgorithm(), $data, $secretKey, true);
    }

    /**
     * validate signature
     * @param $expects
     * @param $data
     * @param $secretKey
     * @return mixed
     */
    public function validate($expects, $data, $secretKey)
    {
        return hash_equals($expects, $this->sign($data, $secretKey));
    }

    /**
     * validate SecretKey
     * @param $secretKey
     * @return bool
     * @throws SecretKeyInvalidException
     */
    public function validateSecretKey($secretKey)
    {
        if (!$secretKey) {
            throw new SecretKeyInvalidException('This key is not compatible with HMAC signatures');
        }
    }

}