<?php

namespace App\Repositories\Eloquent\Interfaces;

interface EloquentBase
{
    public function find(int $id);
    public function create(array $data);
    public function update($id, array $data);
    public function all();
    public function delete(int $id);
    public  function paginate(int $paginate);
}
