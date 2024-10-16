<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbordController extends Controller
{
    public function index(){

        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'analyse',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',

        ];
        return view('panel.Dashbord')->with($data);
    }
}
