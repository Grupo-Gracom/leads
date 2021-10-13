<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogarController extends Controller
{
    public function index(){
        return view('auth.login');
    }
}
