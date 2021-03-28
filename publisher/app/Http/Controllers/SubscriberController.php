<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Repository\SubscriberRepository;


class SubscriberController extends Controller
{

    private $subscriber;

    public function __construct(SubscriberRepository $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function sendResponse($data, $message, $HttpCode)
    {
        $response = [
            'message' => $message,
            'data'    => $data,
        ];

        return response($response, $HttpCode);
    }
    //
    public function createSubscription($topic, Request $request)
    {

        $url_array = [];

        $subscribers = $this->subscriber->getFromRedis($topic);

        if (in_array($request->url, (array) $subscribers)) {

            $url = $request->url;

            $message = "${url} server is already subscribed to ${topic} topic";

            return $this->sendResponse("", $message, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        !$subscribers ? array_push($url_array, $request->url) : array_push($subscribers, $request->url);

        $data = $url_array ? $url_array : $subscribers;

        $this->subscriber->setToRedis($topic, $data);

        $response = [
            'url' => $request->url,
            'topic'    => $topic,
        ];

        return response($response, Response::HTTP_CREATED);
    }

}
