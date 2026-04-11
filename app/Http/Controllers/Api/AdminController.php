<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Utilisation obligatoire du Query Builder de Laravel (cf User Story).
     */
    public function stats()
    {
        $user = Auth::guard('api')->user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Accès exclusif Administrateur !'], 403);
        }

        // 1. Chiffre d'affaire global
        $totalSales = DB::table('orders')
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');

        // 2. Produits les plus populaires via Agrégation Relationnelle complexe
        $popularProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // 3. Répartition des ventes par Catégorie
        $categorySales = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_sold')
            ->get();

        return response()->json([
            'total_sales' => $totalSales,
            'popular_products' => $popularProducts,
            'category_sales' => $categorySales
        ]);
    }
}
