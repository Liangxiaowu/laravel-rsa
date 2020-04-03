<?php


namespace LaraRsa;



use Illuminate\Support\Facades\Storage;
use LaraRsa\Exceptions\RsaKeyException;
use LaraRsa\Impl\Rsa;

/**
 * RSA算法类
 * 签名及密文编码：base64字符串/十六进制字符串/二进制字符串流
 * 填充方式: PKCS1Padding（加解密）/NOPadding（解密）
 *
 * Notice:Only accepts a single block. Block size is equal to the RSA key size!
 * 如密钥长度为1024 bit，则加密时数据需小于128字节，加上PKCS1Padding本身的11字节信息，所以明文需小于117字节
 */
class RsaKey extends Rsa
{

    public $pubKey = null;
    public $priKey = null;

    private final function __construct()
    {

        $this->priKey = Storage::get(config("lararsa.private_key_file", "key/private_key.pem"));
        $this->pubKey = Storage::get(config("lararsa.public_key_file", "key/public_key.pem"));
        // 需要开启openssl扩展
        if (!extension_loaded("openssl")) {
            throw new RsaKeyException("RSA Error:Please open the openssl extension first",500);
        }
    }

    private static $ins = null;

    public static function getIns(){
        if(is_null(self::$ins)){
            self::$ins = new RsaKey();
        }
        return self::$ins ;
    }

    /**
     * 生成Rsa公钥和私钥
     * @param int $private_key_bits 建议：[512, 1024, 2048, 4096]
     * @return array
     */
    public function generate(int $private_key_bits = 1024)
    {
        $rsa = [
            "private_key" => "",
            "public_key" => ""
        ];

        $config = [
            "digest_alg" => "sha512",
            "private_key_bits" => $private_key_bits, #此处必须为int类型
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        //创建公钥和私钥
        $res = openssl_pkey_new($config);

        //提取私钥
        openssl_pkey_export($res, $rsa['private_key']);

        //生成公钥
        $rsa['public_key'] = openssl_pkey_get_details($res)["key"];

        return $rsa;
    }


    /**
     * 生成签名
     *
     * @param string $data 签名材料
     * @param string $code 签名编码（base64/hex/bin）
     * @return bool|string 签名值
     */
    public function createdSign($data, $code = 'base64')
    {
        $ret = false;
        if (openssl_sign($data, $ret, $this->priKey)) {
            $ret = $this->_encode($ret, $code);
        }
        return $ret;
    }



    /**
     * 验证签名
     *
     * @param string $data 签名材料
     * @param string $sign 签名值
     * @param string $code 签名编码（base64/hex/bin）
     * @return bool
     */
    public function verifySign($data, $sign, $code = 'base64')
    {
        $ret = false;
        $sign = $this->_decode($sign, $code);
        if ($sign !== false) {
            switch (openssl_verify($data, $sign, $this->pubKey)) {
                case 1:
                    $ret = true;
                    break;
                case 0:
                case -1:
                default:
                    $ret = false;
            }
        }
        return $ret;
    }

    /**
     * 加密
     * @param string $data     明文
     * @param string $code      密文编码（base64/hex/bin）
     * @param int $padding      填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
     * @return bool|string      密文
     * @throws RsaKeyException
     */
    public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING)
    {
        $ret = false;
        if (!$this->_checkPadding($padding, 'en')){
            throw new RsaKeyException("加密有误", 500);
        };
        if (openssl_public_encrypt($data, $result, $this->pubKey, $padding)) {
            $ret = $this->_encode($result, $code);
        }
        return $ret;
    }


    /**
     * 解密
     * @param string $data       密文
     * @param string $code      密文编码（base64/hex/bin）
     * @param int $padding      填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
     * @param bool $rev         是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
     * @return bool|string      明文
     * @throws RsaKeyException
     */
    public function decrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false)
    {
        $ret = false;
        $data = $this->_decode($data, $code);
        if (!$this->_checkPadding($padding, 'de')) throw new RsaKeyException("解密有误", 500);
        if ($data !== false) {
            if (openssl_private_decrypt($data, $result, $this->priKey, $padding)) {
                $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
            }
        }
        return $ret;
    }

    private final function __clone()
    {
        // 防止克隆
    }


}