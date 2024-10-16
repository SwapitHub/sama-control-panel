<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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


    // public function diamonds(Request $request)
    // {
    //     $vdb_url = 'https://apiservices.vdbapp.com/v2/diamonds';
    //     $parameters = $request->query();
    //     $query_parts = [];
    //     foreach ($parameters as $key => $value) {
    //         if (is_array($value)) {
    //             foreach ($value as $item) {
    //                 $query_parts[] = $key . '[]=' . urlencode($item);
    //             }
    //         } else {
    //             $query_parts[] = $key . '=' . urlencode($value);
    //         }
    //     }

    //     if (!empty($query_parts)) {
    //         $full_url = $vdb_url . '?' . implode('&', $query_parts);
    //     } else {
    //         $full_url = $vdb_url;
    //     }

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $full_url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: Token token=$this->apiToken, api_key=$this->apiKey"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     curl_close($curl);

    //     return response($response)
    //         ->header('Content-Type', 'application/json')
    //         ->header('Access-Control-Allow-Origin', '*')
    //         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    //         ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    // }



    public function diamonds(Request $request)
    {
        $vdb_url = 'https://apiservices.vdbapp.com/v2/diamonds';
        $cacheKey = 'diamonds_' . md5(http_build_query($request->query()));

        $cachedResponse = Cache::get($cacheKey);
        if ($cachedResponse) {
            return response($cachedResponse)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
        }

        // If no cache is available, make the API request
        $response = Cache::remember($cacheKey, 86400, function () use ($request, $vdb_url) {
            $parameters = $request->query();
            $query_parts = [];
            foreach ($parameters as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $query_parts[] = $key . '[]=' . urlencode($item);
                    }
                } else {
                    $query_parts[] = $key . '=' . urlencode($value);
                }
            }

            $full_url = !empty($query_parts) ? $vdb_url . '?' . implode('&', $query_parts) : $vdb_url;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $full_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Token token=$this->apiToken, api_key=$this->apiKey"
                ),
            ));

            $response = curl_exec($curl);
            if ($response === false) {
                $error = curl_error($curl);
                Log::error('cURL Error: ' . $error);  // Log the error for debugging

                // Return null so Cache::remember doesn't cache a failed response
                return null;
            }

            // Handle HTTP response code
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200) {
                Log::error("Third-party API returned status code: $httpCode");
                return null;
            }

            return $response;  // Return the API response if successful
        });

        if (!$response) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to retrieve data from the third-party API and no cached data is available.'
            ], 500);
        }

        return response($response)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    }



    // public function gemstones(Request $request)
    // {
    //     $vdb_url = 'https://apiservices.vdbapp.com/v2/gemstones';
    //     $parameters = $request->query();
    //     $query_parts = [];


    //     foreach ($parameters as $key => $value) {
    //         if (is_array($value)) {
    //             foreach ($value as $item) {
    //                 $query_parts[] = $key . '[]=' . urlencode($item);
    //             }
    //         } else {
    //             $query_parts[] = $key . '=' . urlencode($value);
    //         }
    //     }
    //     if (!empty($query_parts)) {
    //         $full_url = $vdb_url . '?' . implode('&', $query_parts);
    //     } else {
    //         $full_url = $vdb_url;
    //     }

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $full_url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: Token token=$this->apiToken, api_key=$this->apiKey"
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     curl_close($curl);

    //     return response($response)
    //         ->header('Content-Type', 'application/json')
    //         ->header('Access-Control-Allow-Origin', '*')
    //         ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    //         ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    // }


    public function gemstones(Request $request)
    {
        $vdb_url = 'https://apiservices.vdbapp.com/v2/gemstones';
        $cacheKey = 'gemstones_' . md5(http_build_query($request->query()));

        $cachedResponse = Cache::get($cacheKey);
        if ($cachedResponse) {
            return response($cachedResponse)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
        }
        $response = Cache::remember($cacheKey, 86400, function () use ($request, $vdb_url) {
            $parameters = $request->query();
            $query_parts = [];
            foreach ($parameters as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $query_parts[] = $key . '[]=' . urlencode($item);
                    }
                } else {
                    $query_parts[] = $key . '=' . urlencode($value);
                }
            }

            $full_url = !empty($query_parts) ? $vdb_url . '?' . implode('&', $query_parts) : $vdb_url;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $full_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Token token=$this->apiToken, api_key=$this->apiKey"
                ),
            ));

            $response = curl_exec($curl);

            // Handle cURL errors
            if ($response === false) {
                $error = curl_error($curl);
                Log::error('cURL Error: ' . $error);
                return null;
            }

            // Handle HTTP response code
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200) {
                Log::error("Third-party API returned status code: $httpCode");

                return null;
            }

            return $response;
        });
        if (!$response) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to retrieve data from the third-party API and no cached data is available.'
            ], 500);
        }
        return response($response)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
    }
}
