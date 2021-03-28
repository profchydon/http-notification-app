<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Repository\SubscriberRepository;


class SubscriberController extends Controller
{

    private $subscriber;

    /**
     * Initialize a new instance of SubscriberRepository
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Http\Repository\SubscriberRepository
     * @return $subscriber
     */
    public function __construct(SubscriberRepository $subscriber)
    {
        $this->subscriber = $subscriber;
    }
    
    /**
     * Create a subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $topic
     * @return \Symfony\Component\HttpFoundation\Response;
     */
    public function createSubscription($topic, Request $request)
    {

        $validator = Validator::make($request->all(), [ // Validate input data

            'url' => 'required',

        ]);

        if($validator->fails()){

            return static::sendResponse($validator->errors(), 'Validation Error.' , Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        $url_array = [];

        $subscribers = $this->subscriber->getFromRedis($topic); // Get all subscribers for $topic from redis

        if (in_array($request->url, (array) $subscribers)) { // Check if subscriber $request->url  has been subscribed to topic $topic

            $url = $request->url;

            $message = "${url} server is already subscribed to ${topic} topic";

            return static::sendResponse("", $message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        !$subscribers ? array_push($url_array, $request->url) : array_push($subscribers, $request->url);

        $data = $url_array ? $url_array : $subscribers;

        $this->subscriber->setToRedis($topic, $data); // Store data to redis

        $response = [
            'url' => $request->url,
            'topic'    => $topic,
        ];

        return response($response, Response::HTTP_CREATED);
        
    }

}
