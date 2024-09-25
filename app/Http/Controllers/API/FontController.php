<?php

namespace App\Http\Controllers\API;
use App\Models\Font;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FontController extends Controller
{
    public function index()
    {
        $output['res'] = 'success';
        $output['msg'] = 'data retrieved successfully';
        $data = Font::orderBy('id', 'desc')->get();
        $output['data'] = $data;
        return response()->json($output, 200);
    }
}
