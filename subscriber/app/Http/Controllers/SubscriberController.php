<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\SubscriberRepository;

class SubscriberController extends Controller
{

    private $subscriber;

    public function __construct(SubscriberRepository $subscriber)
    {
        $this->subscriber = $subscriber;
    }
    
    public function consumeTopic(Request $request)
    {


        $response = $request->all();

        $message = $response['message'];

        $url = $response['url'];

        
        $store = $this->subscriber->setToRedis($url, $message);

        if ($store) {

            return true;
            
        }

        return false;

    }

    public function view(Request $request)
    {

        $endpoint = $request->fullUrl();

        $message = $this->subscriber->getFromRedis($endpoint);

        return $message ? $message : "The ${endpoint} endpoint has not been subscribed to a topic";
    }
}
