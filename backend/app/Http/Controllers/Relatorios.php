<?php

namespace App\Http\Controllers;

use App\Repositories\WorkshopRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Relatorios extends Controller
{
    private $repository;

    public function __construct(WorkshopRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = $this->repository->relatorios();

        if ($lista) {
            return response()->json(['status' => true, 'data' => $lista], 200);
        }

        return response()->json(['status' => false, 'message' => "Nenhum Registro encontrado"]);
    }

    public function pdf($id){
        $lista = $this->repository->pdf($id);
        $link = Pdf::loadView('relatorios.pdf', compact('lista'));
        return $link->stream('relatorio.pdf');
    }
}
