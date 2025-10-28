<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Inventarioingreso;

class HomeController extends Controller
{
    public function index(){
        
        $total_productos = Producto::count();
        $total_inventarioingresos = Inventarioingreso::count();
        return view('admin.index', compact('total_productos', 'produtos','total_inventarioingresos'));
    }
}
