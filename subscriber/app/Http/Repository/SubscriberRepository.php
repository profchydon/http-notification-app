<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Redis;

class SubscriberRepository
{

    /**
     * Get messages for an endpoint from redis
     *
     * @param string $url
     * @return json $cache
     */
    public function getFromRedis($url)
    {

        $cache = Redis::get($url);
        
        return $cache;

    }

    /**
     * Set messages for an endpoint to redis
     *
     * @param string $url
     * @param array $message
     * @return boolean 
     */
    public function setToRedis($url, $message)
    {

        return Redis::set($url, json_encode($message));

    }
}
