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

                return view("admin/index");
            }else{
                return view("/");
            }
        }else{
           return redirect("login");
        }
    }

    public function teste(){
        $anoAtual = date("Y");
        $mesAtual = date("m");
        $diaAtual = date("d");
        
        $mesLabels = [];
        
        $period = new DatePeriod(
                new DateTime($anoAtual.'-'.$mesAtual),
                new DateInterval('P1D'),
                new DateTime($anoAtual.'-'.($mesAtual + 1))
            );
        
        foreach ($period as $key => $value) {
            $label = $value->format('Y-m-d');
           // $iniciado = Assinatura::where("assinatura_data", "like", $label."%")->where("assinatura_status", 0)->where("unidade_id", Auth::user()->id)->count();
            array_push($mesLabels, $value->format('d-m-Y'));
        }

        return view("admin/index", compact("mesLabels"));
    }
}
