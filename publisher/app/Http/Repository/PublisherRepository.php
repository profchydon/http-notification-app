<?php

namespace App\Http\Repository;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PublisherRepository
{

    /**
     * Get all subscribers to a topic
     *
     * @param  string $topic
     * @return array $subscribers
     */
    public function getSubscibers($topic)
    {
        $cache = Redis::get($topic);

        $subscribers = json_decode($cache);

        return $subscribers;
    }

}
