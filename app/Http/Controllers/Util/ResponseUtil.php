<?php


namespace App\Http\Controllers\Util;


use Illuminate\Support\Facades\Response;

/*
 * 返回json工具类
 */

/**
 * @method getData()
 */
class ResponseUtil
{

    public static $SuccessCode="200";//请求成功
    public static $ParamErrorCode="201";//参数错误
    public static $ExceptionCode="400";//异常
    public static $checkCode="401";//token过期

    public static function apply($code='', $data = [], $message = ''){
        return Response::json(array(
            'code'   => $code,
            'message'  => $message,
            'data'=>$data
        ))->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
