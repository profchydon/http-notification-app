<?php

namespace App\Http\Repository;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SubscriberRepository
{

    public function getFromRedis($topic)
    {
        $cache = Redis::get($topic);

        $subscribers = json_decode($cache);

        return $subscribers;
    }

    public function setToRedis($topic, $data)
    {
        return Redis::set($topic, json_encode($data));
    }
}
