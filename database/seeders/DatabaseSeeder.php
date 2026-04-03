<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User
        User::factory()->create([
            'name' => 'Jane Postman',
            'email' => 'postman@lacosmetica.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Categories
        $soins = Category::create([
            'name' => 'Soins du Visage',
            'description' => 'Produits naturels pour hydrater et protéger votre visage.'
        ]);

        $corps = Category::create([
            'name' => 'Soins du Corps',
            'description' => 'Laits, crèmes et huiles pour un corps sublimé.'
        ]);

        $maquillage = Category::create([
            'name' => 'Maquillage Bio',
            'description' => 'Sublimez-vous avec nos gammes respectueuses de la peau.'
        ]);

        // 3. Products
        Product::create([
            'category_id' => $soins->id,
            'name' => 'Crème Hydratante à l\'Aloé Vera',
            'description' => 'Une crème onctueuse pour une peau douce et rayonnante.',
            'price' => 24.50,
            'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571',
            'status' => 'available'
        ]);

        Product::create([
            'category_id' => $soins->id,
            'name' => 'Sérum Anti-Âge Nuit',
            'description' => 'Complexe de nuit réparateur enrichi en huiles essentielles.',
            'price' => 35.00,
            'image' => 'https://images.unsplash.com/photo-1570194065650-d99fb4b18b17',
            'status' => 'available'
        ]);

        Product::create([
            'category_id' => $corps->id,
            'name' => 'Huile de Massage Relaxante',
            'description' => 'Parfumée à la lavande pour apaiser vos tensions corporelles.',
            'price' => 19.90,
            'image' => 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b',
            'status' => 'available'
        ]);

        Product::create([
            'category_id' => $maquillage->id,
            'name' => 'Rouge à Lèvres Pivoine',
            'description' => 'Teinte intense et couvrance parfaite pour toute la soirée.',
            'price' => 15.00,
            'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa',
            'status' => 'out_of_stock'
        ]);
    }
}
