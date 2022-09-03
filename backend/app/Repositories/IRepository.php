<?php

namespace App\Repositories;

/**
 *
 * @author Praxedes
 */
interface IRepository {

    public function find($id);

    public function all();

    public function allPaginate($limit, $offset);

    public function save(array $data);

    public function delete($id);
}
