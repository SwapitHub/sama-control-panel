<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\ShopByStyle;
use App\Models\Settings;

class ShopByStyleController extends Controller
{
    public function index()
    {
        $data = [
            "title" => 'Shop by style list',
            "viewurl" => 'admin.style.view',
            "editurl" => 'admin.style.edit',
            'list' => ShopByStyle::orderBy('id', 'desc')->get(),
            'prifix' => Settings::first()->route_web_prifix,
        ];
        return view('admin.shop_bystyle_list', $data);
    }

    public function create()
    {
        $data = [
            'url_action' => route('admin.style.add'),
            'backtrack' => 'admin.style.list',
            'title' => 'Add Shopy by style',
            "obj" => '',
        ];
        return view('admin.shopbystyle', $data);
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // Adjust mime types and max size as needed
        ], [
            'name.required' => 'The title field is required.',
            // 'image.required' => 'An image is required.',
            // 'image.image' => 'The uploaded file must be an image.',
            // 'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
            // 'image.max' => 'The image size must not exceed 5 MB.',
        ]);

        if ($request->file('image') != NULL) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = "ring_style_" . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/images/home', $fileName, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $imagepath = 'images/home/' . $fileName;
        }
        $shopbyshape = new ShopByStyle;
        $shopbyshape->title = $request->name;
        $shopbyshape->link = $request->link;
        $shopbyshape->order_number = $request->order_number ?? 0;
        $shopbyshape->image = $imagepath;
        $shopbyshape->image_alt = $request->image_alt;;
        $shopbyshape->status = $request->status ?? 'false';
        $shopbyshape->save();
        return redirect()->back()->with('success', 'Data added successfully');
    }

    public function edit($id)
    {

        $editdata = ShopByStyle::find($id);
        if ($editdata == null) {
            return 'no data';
        }
        $data = [
            'url_action' => route('admin.style.update', ['id' => $editdata['id']]),
            'backtrack' => 'admin.style.list',
            'title' => 'Edit Shop by style',
            'obj' => $editdata,
        ];
        return view('admin.shopbystyle', $data);
    }

    public function update(Request $request, $id)
    {

        $obj = ShopByStyle::find($id);
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'The title field is required.',
        ]);

        if ($request->file('image') != NULL) {
            $oldImagePath = 'public/' . $obj->image; // Replace with the actual path
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = "ring_style_" . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/images/home', $fileName, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $imagepath = 'images/home/' . $fileName;
        } else {
            $imagepath = $obj->image;
        }
        $obj->title = $request->name;
        $obj->link = $request->link;
        $obj->order_number = $request->order_number;
        $obj->image = $imagepath;
        $obj->image_alt = $request->image_alt;
        $obj->status = $request->status ?? 'false';
        $obj->save();
        return redirect()->back()->with('success', 'Data updated successfully');
    }
}
