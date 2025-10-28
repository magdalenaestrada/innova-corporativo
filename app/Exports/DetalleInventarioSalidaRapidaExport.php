<?php

namespace App\Exports;

use App\Models\Invsalidasrapidasdetalles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetalleInventarioSalidaRapidaExport implements FromCollection, WithHeadings, WithMapping
{
  

    protected $destino;
    protected $nombre_solicitante;
    protected $producto_id;
    protected $start_date;
    protected $end_date;


    public function __construct($destino=null, $nombre_solicitante=null, $producto_id=null, $start_date=null, $end_date=null)
    {
        $this->destino = $destino;
        $this->nombre_solicitante = $nombre_solicitante;
        $this->producto_id = $producto_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }





    public function collection()
    {
        $query = Invsalidasrapidasdetalles::query();


        
        $query->whereHas('salidarapida', function ($q) {
            $q->where(function ($subQuery) {
                $subQuery->where('estado', '!=', 'ANULADO')
                         ->orWhereNull('estado');
            });
        });
  

        if ($this->destino) {
            $query->whereHas('salidarapida', function ($q) {
                $q->where('destino', $this->destino);
            });
        }


        if ($this->nombre_solicitante) {
            $query->whereHas('salidarapida', function ($q) {
                $q->where('nombre_solicitante', $this->nombre_solicitante);
            });
        }
        
        if ($this->producto_id) {
            $query->where('producto_id', $this->producto_id);
        }

        
        
        if ($this->start_date) {
            $query->where('created_at', '>=', $this->start_date);
        }

        
       

        if ($this->end_date) {
            $query->where('created_at', '<=', $this->end_date);
        }


        $query->orderBy('created_at', 'desc');


        return $query->get();
    }



    
    public function map($detalle):array
    {
        return[
            $detalle->inv_salidasrapidas_id,
            optional($detalle->salidarapida)->documento_solicitante ?? '-', 
            optional($detalle->salidarapida)->nombre_solicitante ?? '-', 
            optional($detalle->producto)->nombre_producto ?? '-', 

            $detalle->cantidad,
            optional($detalle->salidarapida)->destino ?? '-', 
            optional($detalle->salidarapida)->estado ?? 'CONFIRMADO', 


            $detalle->created_at,
        ];
    }


    public function headings():array
    {
        return[
            'Salida',
            'Documento Solicitante',
            'Nombre Solicitante',
            'Producto',
            'Cantidad',
            'Destino',
            'Estado',
            'Fecha de salida',
            
        ];
    }
}
