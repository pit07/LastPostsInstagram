<?php

namespace App\Http\Controllers;


class InstagramController extends Controller
{

    /*
    * Construit l'URL d'appel à l'API selon le type de demande
    type (string) 'media' ou 'children
    fields (string)
    idMedia (int)
    */
    private function constructUrl($type = 'media', $fields = null, $idMedia = null){

        // Récupération des paramètres de connexion Instagram
        $account = env('INSTAGRAM_ACCOUNT');
        $accessToken = env('INSTAGRAM_TOKEN');
        $limit = env('INSTAGRAM_LIMIT');
        $baseUrl = env('INSTAGRAM_BASEURL');

        // Construction de l'URL
        switch($type){
            // Récupération des posts
            case 'media':
                $urltoCall = "{$baseUrl}{$account}/media?fields={$fields}&limit={$limit}&access_token={$accessToken}";
                break;

            // Récupération des images enfants en cas de carousel
            case 'children':
                $urltoCall = "{$baseUrl}{$idMedia}/children?fields={$fields}&access_token={$accessToken}";
                break;
        }

        return $urltoCall;
    }


    /*
    * Appel de l'API Instagram
    url (string)
    */
    private function callInstagramAPI($url)
    {

        // Paramétrage cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $return = false;
        } else {
            $return = json_decode($response, true);
        }

        curl_close($curl);
        return $return;

    }

    /*
    * Fonction de récupération des derniers posts Instagram
    */
    public function getLastInstagramPosts()
    {
        $fieldsToCollect = array(
            'id',
            'caption',
            'media_type',
            'media_url',
            'permalink',
            'thumbnail_url',
            'timestamp'
        );

        $fields = implode(',', $fieldsToCollect);

        // Appel API Media
        $url = $this->constructUrl('media', $fields);
        $response = $this->callInstagramAPI($url);

        if($response){
            return $this->parseInstagramPosts($response['data']);
        }else{
            return false;
        }
    }

    /*
    * Parsage des posts envoyés par l'API Instagram
    * et traitement des différents cas
    * posts (response)
    */
    public function parseInstagramPosts($posts)
    {

        $postsTrait = array();
        foreach($posts as $post){

            // Cas d'un carousel
            if($post['media_type'] == 'CAROUSEL_ALBUM'){
                $fieldsToCollect = array(
                    'id',
                    'media_url'
                );

                // Appel API children
                $fields = implode(',', $fieldsToCollect);
                $url = $this->constructUrl('children', $fields, $post['id']);
                $response = $this->callInstagramAPI($url);
                // Ajout des images enfant
                foreach($response['data'] as $child){
                    $post['children'][] = $child;
                }
            }

            array_push($postsTrait, $post);
        }

        return $postsTrait;
    }



}
