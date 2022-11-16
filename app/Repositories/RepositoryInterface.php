<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all($collection = []);
    public function create($collection = []);
    public function update($collection = [], $id);
    public function findById($id);
    public function delete($id);

    public function getCreateRules();
    public function getUpdateRules();
}
