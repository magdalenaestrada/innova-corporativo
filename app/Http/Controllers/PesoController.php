<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Peso;

use App\Exports\PesoExport;
use Excel;

class PesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function __construct()
    { 
        $this->middleware('permission:ver balanza', ['only' => ['export_excel']]);
        $this->middleware('permission:ver balanza', ['only' => ['index']]);
      
    }


    public function index()
    {
        $pesos = Peso::orderBy('NroSalida','desc')->paginate(200);
        return view('pesos.index', compact('pesos'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    


    public function export_excel(Request $request){

        $observacion = $request->input('Observacion');
        $producto = $request->input('Producto');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');



        return Excel::download(new PesoExport($observacion, $producto, $startDate, $endDate), 'pesos.xlsx');
    }



}
