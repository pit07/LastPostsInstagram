<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function getLastInstagramPosts()
    {
        //Get connection parameters
        $account = env('INSTAGRAM_ACCOUNT');
        $accessToken = env('INSTAGRAM_TOKEN');
        $limit = env('INSTAGRAM_LIMIT');
        $baseUrl = env('INSTAGRAM_BASEURL');

        $fieldsToCollect = array(
            'id',
            'caption',
            'media_url',
            'permalink',
            'thumbnail_url',
            'timestamp'
        );

        // Url Construction
        $fields = implode(',', $fieldsToCollect);
        $urlToCall = "{$baseUrl}{$account}/media?fields={$fields}&limit={$limit}&access_token={$accessToken}";

        // Call API
        $curl = curl_init($urlToCall);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        // Response
        if (curl_errno($curl)) {
            $return['status'] = 500;
            $return['response'] = curl_error($curl);
        } else {
            $return['response'] = json_decode($response, true);
            if(isset($return['response']['error'])){
                $return['status'] = 500;
            }else{
                $return['status'] = 200;
            }
        }

        curl_close($curl);
        return $return;
    }



}
