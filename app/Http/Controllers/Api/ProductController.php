<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Liste tous les produits (avec la catégorie associée).
     */
    public function index()
    {
        return response()->json($this->productRepository->all());
    }

    /**
     * Affiche un produit spécifique via son URL propre (Slug).
     */
    public function show($slug)
    {
        try {
            $product = $this->productRepository->findBySlug($slug);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Produit introuvable dans le catalogue'], 404);
        }
    }
}
