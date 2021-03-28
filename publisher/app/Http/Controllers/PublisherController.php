<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\PublishMessageException;
use App\Http\Repository\PublisherRepository;
use Symfony\Component\HttpFoundation\Response;

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

        $success = false;

        $exception_message = "There was an error publishing this message";
        $exception = new PublishMessageException($exception_message);

        $subscribers->each(function ($subscriber) use ($message, $success, $exception) {

            $data = [
                'message' => $message,
                'url' => $subscriber
            ];

            $subscriber_host = env('SUBSCRIBER_HOST', 'http://subscriber_app:8080');

            $success = $this->notifySubscriber($data, $subscriber_host) ? true : false;

            if (!$success) {

                $exception->setReason($success);
                throw $exception;
            }
        });

        $response = [
            'topic'    => $topic,
            'message' => $message,
        ];

        return response($response, Response::HTTP_ACCEPTED);
    }
}
