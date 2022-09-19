<?php

namespace App\Helpers;
use Request;
use App\Models\LogActivity;

class Log
{
    public static function addToLog($subject, $dataOld, $dataNew)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = $_SERVER['REQUEST_URI'];
        $log['method'] = Request::method();
        $log['ip'] = $_SERVER['REMOTE_ADDR'];
        $log['user_id'] = auth()->user() ? auth()->user()->id : null;
        $log['data_old'] = $dataOld;
        $log['data_new'] = $dataNew;
        LogActivity::create($log);
    }
}