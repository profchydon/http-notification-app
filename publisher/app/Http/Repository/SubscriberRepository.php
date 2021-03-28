<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Redis;

class SubscriberRepository
{

    /**
     * Get all subscribers to a topic
     *
     * @param  string $topic
     * @return array $subscribers
     */
    public function getFromRedis($topic)
    {
        $cache = Redis::get($topic);

        $subscribers = json_decode($cache);

        return $subscribers;
    }

    /**
     * Store topic and its subscribers
     *
     * @param  string $topic
     * @param  string $data
     * @return boolean
     */
    public function setToRedis($topic, $data)
    {
        return Redis::set($topic, json_encode($data));
    }
}
