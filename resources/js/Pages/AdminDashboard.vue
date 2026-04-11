<template>
  <div class="min-h-screen bg-gray-900 font-sans pb-12 text-white">
    <header class="bg-black shadow border-b border-pink-900">
      <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center text-pink-500">
        <h1 class="text-3xl font-serif font-bold">👑 Admin Dashboard</h1>
        <router-link to="/" class="text-sm px-4 py-2 hover:bg-gray-800 rounded-lg transition text-gray-300">Quitter</router-link>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
      <div v-if="loading" class="text-center py-20 text-gray-500 animate-pulse">Minage des données SQL avec Query Builder...</div>
      
      <div v-else-if="error" class="bg-red-900 text-red-200 p-6 rounded-2xl shadow mb-8 text-center border border-red-700">
        🚨 DANGER : {{ error }}
      </div>

      <div v-else class="space-y-8">
        <!-- Chiffre d'Affaires -->
        <div class="bg-gradient-to-r from-pink-600 to-purple-800 rounded-3xl p-8 shadow-2xl flex justify-between items-center transform transition hover:scale-[1.01]">
          <div>
            <h2 class="text-pink-200 text-lg font-bold tracking-widest uppercase mb-2">Chiffre d'Affaires Global</h2>
            <p class="text-gray-100 opacity-80 text-sm">Total des commandes encaissées (hors annulées)</p>
          </div>
          <div class="text-6xl font-extrabold">{{ stats.total_sales }} €</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Top Produits -->
          <div class="bg-gray-800 rounded-2xl shadow p-6 border border-gray-700">
            <h3 class="text-xl font-bold mb-6 text-pink-400">🔥 Top Cosmétiques</h3>
            <ul class="space-y-4">
              <li v-for="prod in stats.popular_products" :key="prod.name" class="flex justify-between items-center bg-gray-900 p-4 rounded-xl">
                <span class="font-semibold text-gray-200">{{ prod.name }}</span>
                <span class="bg-pink-900 text-pink-200 px-3 py-1 rounded-full text-sm font-bold">{{ prod.total_sold }} vendus</span>
              </li>
              <li v-if="stats.popular_products.length === 0" class="text-gray-600 italic">Aucune vente pour l'instant.</li>
            </ul>
          </div>

          <!-- Top Catégories -->
          <div class="bg-gray-800 rounded-2xl shadow p-6 border border-gray-700">
            <h3 class="text-xl font-bold mb-6 text-purple-400">📊 Ventes par Catégorie</h3>
            <ul class="space-y-4">
              <li v-for="cat in stats.category_sales" :key="cat.name" class="flex flex-col bg-gray-900 p-4 rounded-xl">
                <div class="flex justify-between items-center mb-2">
                  <span class="font-semibold text-gray-200">{{ cat.name }}</span>
                  <span class="text-purple-300 font-bold">{{ cat.total_sold }} articles</span>
                </div>
                <!-- Jauge visuelle basique -->
                <div class="w-full bg-gray-800 rounded-full h-2">
                   <div class="bg-purple-500 h-2 rounded-full" :style="{ width: Math.min(100, cat.total_sold * 10) + '%' }"></div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref(null);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        const token = localStorage.getItem('jwt_token');
        if (!token) throw new Error("Aucun token détecté.");

        const response = await axios.get('/api/admin/stats', {
            headers: { Authorization: `Bearer ${token}` }
        });
        stats.value = response.data;
    } catch (e) {
        error.value = "Accès non autorisé. Votre compte n'a pas les droits 'Admin' sur la BDD.";
    } finally {
        loading.value = false;
    }
});
</script>
