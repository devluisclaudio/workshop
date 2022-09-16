<?php

namespace App\Repositories;

use App\Models\Workshop;
use Illuminate\Support\Facades\DB;

class WorkshopRepository extends BaseRepository
{

    /**
     * Model Workshop
     *
     * @var Workshop
     */
    protected $model;


    /**
     * Construtor
     *
     * @param Servico $servico
     */
    public function __construct(Workshop $model)
    {
        $this->model = $model;
    }

    /**
     * Busca
     *
     * @param string $search
     * @param integer $limit
     * @return array
     */
    public function busca($search = '', $limit = false)
    {
        $query = $this->model->select(['workshops.*']);

        if (isset($search['filter'])) {
            $query = $query->where('workshops.nome', 'like', '%' . $search['filter'] . '%')
                ->orWhere('workshops.email', 'like', '%' . $search['filter'] . '%');
        }

        if (isset($search['sexo'])) {
            $query = $query->where('workshops.sexo',  $search['sexo']);
        }

        if (isset($search['grupo_id'])) {
            $query = $query->where('workshops.grupo_id',  $search['grupo_id']);
        }

        if (isset($search['estado_civil_id'])) {
            $query = $query->where('workshops.estado_civil_id',  $search['estado_civil_id']);
        }


        $query = $query->orderBy('workshops.created_at', 'desc');

        if ($limit !== false) {
            return $query->paginate($limit);
        } else {
            return $query->get();
        }
    }


    public function save(array $data)
    {

        if (!isset($data['id']) || empty($data['id'])) {
            $this->model->fill($data)->save();
            return $this->model;
        } else {
            $model = $this->model->find($data['id']);
            $model->fill($data)->save();
            return $model;
        }
    }

    /**
     * Deleta
     *
     * @param integer $id
     * @return boolean
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $this->model->find($id)->delete();

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollback();
            report($ex);
            return false;
        }
    }

    /**
     * Alterar Situação
     *
     * @param integer $id
     * @return boolean
     */
    public function alterarSituacao($data)
    {
        try {
            DB::beginTransaction();

            $this->model->where('id', '=', $data['id'])
                ->update(['status' => $data['status']]);

            DB::commit();
            return true;
        } catch (\Exception $ex) {
            report($ex);
            DB::rollback();
            return false;
        }
    }

    public function verificarServico($nome)
    {
        if ($this->model->where('nome', strtolower($nome))->first()) {
            return true;
        }

        return false;
    }

    /**
     * Busca de serviço
     *
     * @param string $search
     * @param integer $limit
     * @return array
     */
    public function findServico($id)
    {
        $query = $this->model->select(['servicos.*'])->with('user', 'categoria');
        $query = $query->where('servicos.id',  $id);

        return $query->get()->toArray();
    }


    public function grupos()
    {
        $data = Workshop::GRUPOS;
        return $data;
    }

    public function estadosCivis()
    {
        $data = Workshop::ESTADOSCIVIS;
        return $data;
    }

    public function relatorios()
    {
        $dados = $this->model->get();

        $contM = 0;
        $contF = 0;
        $contEstado = ['1' => 0, '2' => 0, '3' => 0, '4' => 0];
        $contGrupo = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
        foreach ($dados as $dado) {
            if ($dado['sexo'] == 1)
                $contM++;
            else
                $contF++;

            (int)$contEstado[$dado['estado_civil_id']] += 1;
            (int)$contGrupo[$dado['grupo_id']] += 1;
        }
        $sexos['masculino'] = $contM;
        $sexos['feminino'] = $contF;
        $total = count($dados);


        $data = Workshop::ESTADOSCIVIS;
        foreach ($data as $estado) {
            $estados[$estado['id']] = $contEstado[$estado['id']];
        }

        $data = Workshop::GRUPOS;
        foreach ($data as $grupo) {
            $grupos[$grupo['id']] = $contGrupo[$grupo['id']];
        }
        return ['total' => $total, 'sexos' => $sexos, 'estados' => $estados, 'grupos' => $grupos];
    }

    /**
     * Emails
     *
     * @return array
     */
    public function emails()
    {
        $query = $this->model;
        $query = $query->where('id', '<', 71);
        $query = $query->orderBy('workshops.created_at', 'desc');

        return $query->get();
    }
}
