<?php
return [
    /*
    |--------------------------------------------------------------------------
    | HMAC 签名秘钥
    |--------------------------------------------------------------------------
    |
    | HMAC 签名秘钥是用来为token进行HMAC签名的,必须在.env文件中设置。
    |
    */
    'secret_key' => env('JWT_SECRET_KEY'),
    /*
    |--------------------------------------------------------------------------
    | RSA 签名私钥
    |--------------------------------------------------------------------------
    |
    | RSA 签名私钥是用来为token进行RSA签名的,必须在.env文件中设置。
    |
    */
    'private_key' => env('JWT_PRIVATE_KEY', '-----BEGIN PRIVATE KEY-----
MIIBVQIBADANBgkqhkiG9w0BAQEFAASCAT8wggE7AgEAAkEA4VqgBcZM/LP7P3YC
uiDWOPwGFP1wwlPM6QbHfrgEjTk4ZFqQEZmURFExRMR0tiRIVqNF0oPKl+xSkE4i
YLSEmwIDAQABAkEAzgr/PuhlobOp6ActTSMS2z1LDkv/mh3mv7TsGCeGOdu9PsjU
OrUD20rnkLgmWO/8mttpug4aqwHD4106oBJGOQIhAPKf/WvoJW/Sy4vrfzvbTmRs
OEU8gbpdUvXJGZVh9f4lAiEA7cbmuMi8it/l0e+a4rH08GIGZVd5qcHsDH4gkb2G
G78CIQCWS187udl+9LBcI2x0krxz3snYscuWu3rJgGJVtBIi9QIgYkZ2L+OPwdpe
c5GTs6SXtw7c09/+wgILnPI4ZeQuXKMCIG8rY3bospGV47JvmXcrVPd8VFp1h/Ca
MTVCpJZK3pVU
-----END PRIVATE KEY-----
'),
    /*
    |--------------------------------------------------------------------------
    | RSA 签名公钥
    |--------------------------------------------------------------------------
    |
    | RSA 签名公钥是用来为token进行RSA签名解密的,必须在.env文件中设置。
    |
    */
    'public_key' => env('JWT_PUBLIC_KEY', '-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAOFaoAXGTPyz+z92Arog1jj8BhT9cMJT
zOkGx364BI05OGRakBGZlERRMUTEdLYkSFajRdKDypfsUpBOImC0hJsCAwEAAQ==
-----END PUBLIC KEY-----
'),
    /*
    |--------------------------------------------------------------------------
    | Token 有效期
    |--------------------------------------------------------------------------
    |
    | 指定token的有效时间(单位秒)。
    |
    */
    'ttl' => env('JWT_TTL', 60 * 60),
    /*
    |--------------------------------------------------------------------------
    | Token 刷新有效期
    |--------------------------------------------------------------------------
    |
    | 指定token过期后,多长一段时间内(单位秒),使用过期的token能够刷新。
    |
    */
    'refresh_ttl' => env('JWT_REFRESH_TTL', 60 * 60 * 24 * 7),
    /*
    |--------------------------------------------------------------------------
    | JWT 算法ID
    |--------------------------------------------------------------------------
    |
    | Token HMAC签名的HASH算法
    | 对称算法:
    | HS256, HS384, HS512
    | 非对称算法,需提供公私钥:
    | RS256, RS384, RS512
    */
    'algorithm_id' => env('JWT_ALGORITHM_ID', Chenmobuys\ChenJWT\JWT\Sign\RSA::DEFAULT_ALGORITHM_ID),
    /*
    |--------------------------------------------------------------------------
    | 指定Token在某时间之前无法使用
    |--------------------------------------------------------------------------
    |
    | 指定一个时间增量(单位秒),在此签发时间+此事件增量时间之前,Token都不能使用
    |
    */
    'not_before' => env('JWT_NOT_BEFORE', 1),
    /*
    |--------------------------------------------------------------------------
    | 刷新Token次数差值
    |--------------------------------------------------------------------------
    |
    | 最新刷新次数会缓存在Server,如果客户端的token刷新次数与Server缓存相差大于此值,就会判定无效Token
    |
    */
    'refresh_diff_limit=>' => env('JWT_REFRESH_DIFF_LIMIT', 2),
    /*
    |--------------------------------------------------------------------------
    | 黑名单宽限时间,单位秒
    |--------------------------------------------------------------------------
    |
    | 每次刷新后,Token会被加入黑名单,在高并发的情况下,后续请求Token会无效,当设置宽限时间后,
    | Token刷新后,加入黑名单的Token只要处于宽限时间内,则是有效的。
    |
    */
    'blacklist_grace_time' => env('JWT_BLACK_LIST_GRACE_TIME', 30)
];
