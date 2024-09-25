<?php

namespace App\Http\Controllers;
use App\Models\Font;
use App\Models\Settings;
use Illuminate\Http\Request;

class FontController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Font list',
            'viewurl' => route('admin.addfont'),
            'editurl' => 'admin.editfont',
            'list' => Font::all(),
            'prifix' => Settings::first()->route_web_prifix,
        ];
        return view('admin.fontlist', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Font',
            'backtrack' => 'admin.font',
            'url_action' => route('admin.postaddfont'),
            "obj" => '',
        ];
        return view('admin.font', $data);
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'value' => 'required',
        ], [
            'label.required' => 'The Label field is required.',
            'value.required' => 'The Value field is required.',

        ]);

        $font = new Font;
        $font->value = $request->value;
        $font->label = $request->label;
        $font->save();
        return redirect()->back()->with('success', 'Font added successfully');
    }

    public function edit($id)
    {
        $editdata = Font::find($id);
        if ($editdata == null) {
            return 'no data';
        }
        $data = [
            'title' => 'Edit Font',
            'backtrack' => 'admin.font',
            'url_action' => route('admin.updatestate', ['id' => $editdata['id']]),
            'obj' => $editdata,
        ];
        return view('admin.font', $data);
    }

    public function update(Request $request, $id)
    {
        $obj = Font::find($id);
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'The name field is required.',
        ]);
        $obj->value = $request->value;
        $obj->label = $request->label;
        $obj->save();
        return redirect()->back()->with('success', 'Font updated successfully');
    }

    public function distroy($id)
    {
        if ($id) {
            $font = Font::find($id);
            $font->delete();
            $output['res'] = 'success';
            $output['msg'] = 'Data Deleted';
        } else {
            $output['res'] = 'error';
            $output['msg'] = 'Font Id Required';
        }
        echo json_encode($output);
    }
}
