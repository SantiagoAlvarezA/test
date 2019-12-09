<?php
class Utilities
{
    public static function response($code, $msg, $data)
    {
        header("HTTP/1.1 $code $msg");
        header("Content-Type: application/json; charset=UTF-8");

        $response['code'] = $code;
        $response['msg'] = $msg;
        $response['data'] = $data;

        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
