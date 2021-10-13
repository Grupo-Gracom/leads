<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $usuario;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->usuario = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        if(Auth::check()){
            if(Auth::user()->cargo_id == 1){
                return view("admin/index");
            }else{
                return view("/");
            }
        }else{
           return redirect("login");
        }
    }
}
