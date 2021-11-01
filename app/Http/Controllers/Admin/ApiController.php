<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function gracom($unidade = null){
        if($unidade){
            return view("admin.gracom",compact('unidade'));
        }else{
            return view("admin.gracom",compact('unidade'));
        }
        
    }

    public function imugi($unidade = null){
        if($unidade){
            return view("admin.imugi",compact('unidade'));
        }else{
            return view("admin.imugi",compact('unidade'));
        }
        
    }
}
