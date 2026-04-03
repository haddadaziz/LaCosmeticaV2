<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::with('category')->get();
    }

    public function findBySlug(string $slug)
    {
        return Product::with('category')->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }
}
