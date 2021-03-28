<?php

namespace App\Http\Repository;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PublisherRepository
{

    public function getSubscibers($topic)
    {
        $cache = Redis::get($topic);

        $subscribers = json_decode($cache);

        return $subscribers;
    }

    public function publishMessage($topic)
    {
        $cache = Redis::get($topic);

        $subscribers = json_decode($cache);

        return $subscribers;
    }

}
