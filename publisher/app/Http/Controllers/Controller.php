<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function notifySubscriber($message, $url)
    {

        try {

            $data = json_encode($message, TRUE);

            $url = "${url}/receive/message";

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER, false,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json"
                    ),
                )
            );

            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

                return false;

            } else {

                return $response;
            }

        } catch (\Exception $e) {

            return $e->getMessage();

        }
    }

    public static function sendResponse($data, $message, $HttpCode)
    {
        $response = [
            'message' => $message,
            'data'    => $data,
        ];

        return response($response, $HttpCode);
    }
}
