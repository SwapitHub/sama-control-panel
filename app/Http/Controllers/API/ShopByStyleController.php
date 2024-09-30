<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopByStyle;

class ShopByStyleController extends Controller
{
    public function index()
    {
        $output['res'] = 'success';
        $output['msg'] = 'data retrieved successfully';

        $data = ShopByStyle::orderBy('order_number', 'asc')->where('status', 'true')->get();
        foreach ($data as $banner) {
            $banner->image = env('AWS_URL') . 'public/' . $banner->image;
        }
        $output['data'] = $data;
        return response()->json($output)
            ->header('Cache-Control', 'max-age=86400, public');
    }
}
