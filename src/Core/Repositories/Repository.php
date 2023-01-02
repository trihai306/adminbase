<?php

namespace Modules\Core\Repositories;

interface Repository
{
    public function query(array $conditions);
    public function get();
    public function create(array $attributes);
    public function createMany(array $records, array $additional = []);
    public function find($id);
    public function update(array $attributes, $id);
    public function delete($id);
    public function lockForUpdate();
}
