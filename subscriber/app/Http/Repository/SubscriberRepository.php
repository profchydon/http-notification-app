<?php

namespace App\Http\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SubscriberRepository
{

    public function getFromRedis($url)
    {
        $cache = Redis::get($url);

        // $message = json_decode($cache);

        return $cache;
    }

    public function setToRedis($url, $message)
    {
        return Redis::set($url, json_encode($message));
    }
}
