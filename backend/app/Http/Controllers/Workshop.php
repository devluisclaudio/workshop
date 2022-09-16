<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkshopRequest;
use App\Mail\SendMailWorkshop;
use App\Repositories\WorkshopRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Workshop extends Controller
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
    public function index(Request $request)
    {
        $data = $request->all();
        $length = $request->input('length');
        $lista = $this->repository->busca($data, $length);

        if ($lista) {
            return response()->json(['status' => true, 'data' => $lista], 200);
        }

        return response()->json(['status' => false, 'message' => "Nenhum Registro encontrado"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkshopRequest $request)
    {
        $data = $request->all();
        $user = $this->repository->save($data);
        if ($user) {
            try {
                Mail::to($user->email)->send(new SendMailWorkshop($user));
            } catch (Exception $e) {
                return response('Falha ao enviar email: ' . $e->getMessage(), 500);
            }

            return response('Salvo com sucesso', 200);
        } else
            return response('Falha ao cadastrar', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->repository->delete($id))
            return response()->json(['status' => true, 'message' => "Deletado com sucesso!"]);

        return response()->json(['status' => false, 'message' => "Falha ao deletar!"]);
    }


    public function grupos()
    {
        $data = $this->repository->grupos();
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function estadosCivis()
    {
        $data = $this->repository->estadosCivis();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function dispara()
    {
        $data = $this->repository->emails();


        if ($data) {
            foreach ($data as $user) {
                try {
                    Mail::to($user->email)->send(new SendMailWorkshop($user));
                } catch (Exception $e) {
                    return response()->json(['user' => $user, 'msg' => 'Falha ao enviar email: ' . $e->getMessage()]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Terminou tudo']);
    }
}
