<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\PublisherRepository;

class PublisherController extends Controller
{
    private $publisher;

    public function __construct(PublisherRepository $publisher)
    {
        $this->publisher = $publisher;
    }

    public function publishMessage($topic, Request $request)
    {
        $message = $request->all();

        $subscribers = $this->publisher->getSubscibers($topic);

        $subscribers = collect($subscribers);

        $subscribers->each(function ($subscriber) use ($message) {

            $data = [
                'message' => $message,
                'url' => $subscriber
            ];

            $subscriber_host = env('SUBSCRIBER_HOST', 'http://subscriber_app:8080');

            $notify_subscriber = $this->notifySubscriber($data, $subscriber_host);

            dd($notify_subscriber);
        });
    }
}
