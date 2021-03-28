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
     * @return Response
     */
    public function createSubscription($topic, Request $request)
    {

        // VALIDATE INPUT DATA
        $validator = Validator::make($request->all(), [

            'url' => 'required',

        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());

        }

        $url_array = [];

        // GET ALL SUBSCRIBERS FOR $TOPIC FROM REDIS 
        $subscribers = $this->subscriber->getFromRedis($topic);

        // CHECK IF SUBSCRIBER $request->url HAS BEEN SUBSCRIBED TO TOPIC $topic
        if (in_array($request->url, (array) $subscribers)) {

            $url = $request->url;

            $message = "${url} server is already subscribed to ${topic} topic";

            return $this->sendResponse("", $message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        !$subscribers ? array_push($url_array, $request->url) : array_push($subscribers, $request->url);

        $data = $url_array ? $url_array : $subscribers;

        // STORE DATA TO REDIS
        $this->subscriber->setToRedis($topic, $data);

        $response = [
            'url' => $request->url,
            'topic'    => $topic,
        ];

        return response($response, Response::HTTP_CREATED);
    }

}
