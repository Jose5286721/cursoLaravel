<?php
namespace App\Traits;
use Illuminate\Http\Response;

trait ResponseApi{
    public function success($message = "", $code = Response::HTTP_OK){
        return response()->json(array(
            "data" => $message
        ),$code);
    }
    public function error($message,$code){
        return response()->json(array(
            "error" => $message,
            "code" => $code
        ),$code);
    }
}