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
        $query = $this->model->select(['workshops.*'])->with('user', 'categoria');

        if (isset($search['filter'])) {
            $query = $query->where('workshops.nome', 'ilike', '%' . $search['filter'] . '%');
        }

        if (isset($search['status'])) {
            $query = $query->where('workshops.status',  $search['status']);
        }

        if (isset($search['estrutura'])) {
            $query = $query->where('workshops.estrutura',  $search['estrutura']);
        }
            

        $query = $query->orderBy('servicos.created_at', 'desc');

        if ($limit !== false) {
            return $query->paginate($limit);
        } else {
            return $query->get();
        }
    }

    /**
     * Lista
     *
     * @param string $search
     * @param integer $limit
     * @return array
     */
    public function lista()
    {
        $registros = $this->model->select(['servicos.id', 'servicos.nome', 'servicos.descricao'])->get()->toArray();

        foreach ($registros as $registro) {
            $dado[] = [
                'id'        => $registro['id'],
                'texto'     => $registro['nome'],
                'descricao' => $registro['descricao']
            ];
        }

        return $dado;
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

    /**
     * Lista de serviços pai
     *
     * @param string $search
     * @param integer $limit
     * @return array
     */
    public function listaPai()
    {
        $registros = $this->model->select(['servicos.id', 'servicos.nome', 'servicos.descricao'])->where('estrutura', true)->get()->toArray();
        $dado = [];
        foreach ($registros as $registro) {
            $dado[] = [
                'id'        => $registro['id'],
                'texto'     => $registro['nome'],
                'descricao' => $registro['descricao']
            ];
        }

        return $dado;
    }

    /**
     * Lista de serviços pai
     *
     * @param string $search
     * @param integer $limit
     * @return array
     */
    public function listaFilho($id)
    {
        $registros = $this->model->select(['servicos.id', 'servicos.nome', 'servicos.descricao'])->where('estrutura_pai_id', $id)->get()->toArray();
        $dado = [];
        foreach ($registros as $registro) {
            $dado[] = [
                'id'        => $registro['id'],
                'texto'     => $registro['nome'],
                'descricao' => $registro['descricao']
            ];
        }

        return $dado;
    }
}
