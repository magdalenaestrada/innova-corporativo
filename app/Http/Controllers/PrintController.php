<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rancho;

class PrintController extends Controller
{

  

    public function index()
    {
        $ranchos = Rancho::all();
        return view('ranchos.printticket')->with('ranchos', $ranchos);
    }

    public function prnpriview()
    {
        $ranchos = Rancho::all();
        return view('ranchos.printticket')->with('ranchos', $ranchos);
        
    }
}
