<?php

namespace domain\Services\ProductInventryService;

use App\Models\ProductInventry;

class ProductInventryService
{
    public function __construct()
    {
        $this->inventry = new ProductInventry();
    }

    public function all()
    {
        return $this->inventry->all();
    }

    public function getAllInventries($inventry_id)
    {
        return $this->inventry->getAllInventries($product_id);
    }

    public function store(array $data)
    {
        return $this->inventry->create($data);
    }

    public function get(int $inventry_id)
    {
        return $this->inventry->find($inventry_id);
    }

    public function update(array $data, int $inventry_id)
    {
        $inventry = $this->inventry->find($inventry_id);
        return $inventry->update($this->edit($inventry, $data));
    }

    protected function edit(ProductInventry $inventry, array $data)
    {
        return array_merge($inventry->toArray(), $data);
    }

    public function delete(int $inventry_id)
    {
        return $this->inventry->find($inventry_id)->delete();
    }
}