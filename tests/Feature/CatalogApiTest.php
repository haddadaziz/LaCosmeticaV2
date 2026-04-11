<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class CatalogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_all_products_from_api()
    {
        // Préparation du test (Given)
        $category = Category::create(['name' => 'Skin Care', 'description' => 'Test']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Aloe Vera Cream',
            'description' => 'Great cream',
            'price' => 20.00,
            'status' => 'available'
        ]);

        // Exécution de l'action (When)
        $response = $this->getJson('/api/products');

        // Assertions (Then)
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonPath('0.name', 'Aloe Vera Cream');
    }

    public function test_can_fetch_single_product_by_slug()
    {
        $category = Category::create(['name' => 'Skin Care', 'description' => 'Test']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Aloe Vera Cream', // Le slug "aloe-vera-cream" sera généré par Spatie Automatically
            'description' => 'Great cream',
            'price' => 20.00,
            'status' => 'available'
        ]);

        $response = $this->getJson('/api/products/aloe-vera-cream');

        $response->assertStatus(200);
        $response->assertJsonPath('name', 'Aloe Vera Cream');
        $response->assertJsonPath('category.name', 'Skin Care');
    }

    public function test_returns_404_if_slug_does_not_exist()
    {
        $response = $this->getJson('/api/products/non-existent-slug');
        
        $response->assertStatus(404);
        $response->assertJsonPath('error', 'Produit introuvable dans le catalogue');
    }
}
