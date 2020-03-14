<?php


namespace LaraRsa\Exceptions;


use Throwable;

/**
 * rsa密钥验证的异常类
 * Class RsaKeyException
 * @package App\Exceptions
 */
class RsaKeyException extends \Exception
{

    private $resultMessage;
    private $resultCode;

    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        $this->resultMessage = $message;
        $this->resultCode = $code;
        parent::__construct($message, $code, $previous);
    }

    /**
     * 报告这个异常。
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * 将异常渲染至 HTTP 响应值中。
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            "status_code"=>$this->resultCode,
            "message"=>$this->resultMessage
        ]);
    }
}