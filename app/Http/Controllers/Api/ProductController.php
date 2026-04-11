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

    /** Administration : Ajouter un produit (Protégé) */
    public function store(\Illuminate\Http\Request $request)
    {
        $this->authorizeAdmin();
        return response()->json($this->productRepository->create($request->all()), 201);
    }

    /** Administration : Modifier un produit (Protégé) */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $this->authorizeAdmin();
        return response()->json($this->productRepository->update($id, $request->all()));
    }

    /** Administration : Supprimer un produit (Protégé) */
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $this->productRepository->delete($id);
        return response()->json(null, 204);
    }

    private function authorizeAdmin()
    {
        if (\Illuminate\Support\Facades\Auth::guard('api')->user()->role !== 'admin') {
            abort(403, 'Accès Admin Requis');
        }
    }
}
