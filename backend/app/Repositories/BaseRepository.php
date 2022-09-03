<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Repositories\IRepository;

abstract class BaseRepository implements IRepository{

    protected $model;

    public function find($id) {
        return $this->model->find($id);
    }

    public function findBy($where = []) {
        return $this->model->where($where)->get();
    }

    public function all($orderBy = []) {
        if($orderBy){
            $all =  $this->model->orderBy($orderBy[0], $orderBy[1])->get();
        }else{
            $all = $this->model->all();
        }

        return $all;
    }

    public function allPaginate($limit, $offset) {
        return $this->model->take($limit)->skip($offset);
    }

    public function save(array $data) {

        if (!isset($data['id']) || empty($data['id'])) {
            return $this->model->fill($data)->save();
        } else {
            $model = $this->model->find($data['id']);
            return $model->fill($data)->save();
        }
    }

    public function delete($id) {
        try {
            return $this->model->find($id)->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Salva arquivo
     *
     * @param $arquivo
     * @return array
     */
    public function salvarArquivo($arquivo, $diretorio)
    {
        try {
            if (isset($arquivo)) {
                if (strpos($arquivo, ';') !== false) {
                    $posicao = strpos($arquivo, ';');
                    $extensao = substr($arquivo, 0, $posicao);

                    $posicaoExt = strpos($extensao, '/');
                    $ext = substr($extensao, $posicaoExt + 1);
                    
                    $ext = ($ext == 'jpeg') ? 'jpg' : $ext;
                    $ext = ($ext == 'vnd.openxmlformats-officedocument.wordprocessingml.document') ? 'docx' : $ext;
                    $ext = ($ext == 'msword') ? 'doc' : $ext;
                    $ext = ($ext == 'vnd.ms-excel') ? 'xls' : $ext;
                    $ext = ($ext == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') ? 'xlsx' : $ext;
                    $ext = ($ext == 'vnd.ms-powerpoint') ? 'ppt' : $ext;
                    $ext = ($ext == 'vnd.openxmlformats-officedocument.presentationml.presentation') ? 'pptx' : $ext;
                    
                    $urlFile = $diretorio . DIRECTORY_SEPARATOR . time() . rand(0, 10) . '.' . $ext;

                    $file = str_replace($extensao . ';base64,', '', $arquivo);
                    $file = base64_decode($file);

                    if (!file_exists($diretorio)) {
                        mkdir($diretorio, 0755, true);
                    }

                    file_put_contents($urlFile, $file);
                    return ['success' => true, 'arquivo' => asset($urlFile)];
                } else {
                    return ['success' => true, 'arquivo' => $arquivo];
                }
                
            }
        } catch (\Exception $ex) {
            report($ex);
            return ['success' => false];
        }
    }
    /**
     * Salva arquivo CSV
     *
     * @param $arquivo
     * @return array
     */
    public function salvarArquivoCsv($arquivo, $nome, $diretorio)
    {
        try {
            if (isset($arquivo)) {
                $posicao = strpos($arquivo, ';');
                $extensao = substr($arquivo, 0, $posicao);

                $urlFile = $diretorio . DIRECTORY_SEPARATOR . $nome . '.csv';

                $file = str_replace($extensao . ';base64,', '', $arquivo);
                $file = base64_decode($file);

                if (!file_exists($diretorio)) {
                    mkdir($diretorio, 0755, true);
                }

                file_put_contents($urlFile, $file);
                return ['success' => true, 'arquivo' => asset($urlFile)];
            }
        } catch (\Exception $ex) {
            report($ex);
            return ['success' => false];
        }
    }
    
    /**
     * Deleta arquivo fisico
     *
     * @param $caminho
     * @return bool
     */
    public function deleteFileDisco($caminho)
    {
        $caminho = explode('/', $caminho);
        $remove = unlink('../public/' .$caminho[3]. '/' . $caminho[4]);

        if ($remove) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifica se está em base64
     *
     * @param $caminho
     * @return bool
     */
    public function isBaseEncoded($data)
    {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
            return true;
         } else {
            return false;
         }
    }

}
