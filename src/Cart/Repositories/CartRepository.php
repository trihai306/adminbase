<?php

namespace Modules\Cart\Repositories;

interface CartRepository
{
    public function find($id);
    public function create(array $attributes);
    public function delete($id);
    public function addItem($id, $attributes);
    public function updateItem($id, $itemId, $quantity);
    public function deleteItem($id, $itemId);
}
