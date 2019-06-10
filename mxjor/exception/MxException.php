<?php

namespace mxjor\exception;

/**
 * 框架异常类
 *
 * @author itaken <regelhh@gmail.com>
 * @since 2019-06-11
 */
class MxException extends \Exception
{
    /**
     * 初始化异常
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct($message = '', $code = 500)
    {
        parent::__construct($message, $code);
    }
}
