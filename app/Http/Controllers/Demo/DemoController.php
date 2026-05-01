<?php

namespace App\Http\Controllers\Demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function example(){
        echo "This is from the DemoController through group";
    }

    public function about(){
        return view('about');
    }

    public function contact(){
        return view('contact');
    }
}
