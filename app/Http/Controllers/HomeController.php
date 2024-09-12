<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        $imageUrl = 'https://assets.rocksama.com/products/images/SA50574-E18W-58/SA50574-E18W-58.em.side.alt1.jpg';

        $response = Http::head($imageUrl);

        if ($response->successful()) {
            echo 'Image URL is accessible.';
        } else {
            echo 'Image URL is not accessible. Status code: ' . $response->status();
        }
    }
}
