<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }




    public function Index()
    {
        
        return view('contact');
        
        //echo "This contact page";
    }
}
