<?php

namespace App\Helpers;

class ResponseModel
{
  protected static $response = [
    'total_data' => 0,
    'status_code' => 0,
    'message'    => null,
    'data'       => null
  ];

  public static function response($errorCode = 0, $message = null, $data = null, $total_data = -1)
  {
    $total_data = $total_data;
    if($message == "GET") {
        $message = "Berhasil Melihat Data";
        if($total_data == 1) {
          $total_data = 1;
        }
        else if($total_data == 0) {
          $total_data = 0;
        }
        else if($total_data == -1) {
          $total_data = 0;
        }
        else {
          $total_data = count($data);
        }
    }
    else if($message == "POST") {
        $message = "Berhasil Membuat Data";
        $total_data = 1;
    }
    else if($message == "PUT") {
        $message = "Berhasil Mengubah Data";
        $total_data = 1;
    }
    else if($message == "DELETE") {
        $message = "Berhasil Menghapus Data";
        $total_data = 1;
    }
    else {
        if($total_data == -1) {
          $total_data = 0;
        }
    }

    self::$response['status_code'] = $errorCode;
    self::$response['message']    = $message;
    self::$response['data']       = $data;
    self::$response['total_data'] = $total_data;

    return response()->json(self::$response);
  }
}