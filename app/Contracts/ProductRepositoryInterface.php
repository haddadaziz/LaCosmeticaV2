<?php

namespace App\Contracts;

interface ProductRepositoryInterface
{
    public function all();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
