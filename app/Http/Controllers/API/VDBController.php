<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VDBController extends Controller
{
    public $base_url;
    public $apiToken;
    public $apiKey;
    public function __construct()
    {
        $this->apiToken = env('VDB_AUTH_TOKEN');
        $this->apiKey = env('VDB_API_KEY');
    }

    public function diamonds(Request $request)
    {
        $vdb_url = 'https://apiservices.vdbapp.com/v2/diamonds';
        $parameters = $request->query();
        $query_string = http_build_query($parameters);
        $full_url = $vdb_url . '?' . $query_string;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $full_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Token token=$this->apiToken, api_key=$this->apiKey"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        return response($response)
        ->header('Content-Type', 'application/json')
        ->header('Access-Control-Allow-Origin', '*') // Allow all origins or specify your frontend domain
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    }


    public function gemstones(Request $request)
    {
        $vdb_url = 'https://apiservices.vdbapp.com/v2/gemstones';
        $parameters = $request->query();
        $query_string = http_build_query($parameters);
        $full_url = $vdb_url . '?' . $query_string;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $full_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Token token=$this->apiToken, api_key=$this->apiKey"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        return response($response)
        ->header('Content-Type', 'application/json')
        ->header('Access-Control-Allow-Origin', '*') // Allow all origins or specify your frontend domain
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    }
}
