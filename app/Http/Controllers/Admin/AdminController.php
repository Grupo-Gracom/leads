<?php

namespace App\Http\Controllers\Admin;
use DatePeriod;
use DateTime;
use DateInterval;
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
                $anoAtual = date("Y");
        $mesAtual = date("m");
        $diaAtual = date("d");
        
        $volumeLabels = [];
            $period = new DatePeriod(
                new DateTime($anoAtual.'-'.($mesAtual - 1)),
                new DateInterval('P1D'),
                new DateTime($anoAtual.'-'.$mesAtual)
            );

        foreach ($period as $key => $value) {
            $label = $value->format('Y-m-d');
            array_push($volumeLabels, $value->format('d-m-Y'));

        }

                return view("admin.index", compact("volumeLabels"));
            }else{
                return view("/");
            }
        }else{
           return redirect("login");
        }

    }
}
