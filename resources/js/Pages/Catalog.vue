<template>
  <div class="min-h-screen bg-pink-50 font-sans pb-12">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center text-pink-600">
        <h1 class="text-3xl font-serif font-bold">✨ Nos Produits Bio</h1>
        <router-link to="/" class="text-sm px-4 py-2 hover:bg-pink-50 rounded-lg transition">&larr; Accueil</router-link>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
      <div v-if="loading" class="text-center py-20 text-pink-500">
        <p class="text-xl animate-pulse">Chargement du catalogue cosmétique...</p>
      </div>

      <div v-else-if="error" class="text-center py-20 text-red-500">
        <p class="text-xl">{{ error }}</p>
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="product in products" :key="product.id" class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
          <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover">
          <div class="p-6 flex flex-col flex-grow">
            <span class="text-xs font-semibold tracking-wider text-pink-500 uppercase">{{ product.category?.name }}</span>
            <h3 class="mt-2 text-xl font-bold text-gray-900">{{ product.name }}</h3>
            <p class="mt-2 text-gray-600 text-sm h-10 overflow-hidden flex-grow">{{ product.description }}</p>
            <div class="mt-6 flex items-center justify-between">
              <span class="text-2xl font-extrabold text-gray-900">{{ product.price }} €</span>
              <router-link :to="`/products/${product.slug}`" class="px-5 py-2 bg-pink-600 text-white text-sm font-semibold rounded-full hover:bg-pink-700 transition shadow">
                Découvrir
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const products = ref([]);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get('/api/products');
        products.value = response.data;
    } catch (e) {
        error.value = "Impossible de récupérer les produits depuis l'API Laravel.";
    } finally {
        loading.value = false;
    }
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
