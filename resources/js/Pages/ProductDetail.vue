<template>
  <div class="min-h-screen bg-white font-sans pb-12">
    <header class="bg-pink-50 border-b border-pink-100">
      <div class="max-w-7xl mx-auto px-4 py-4">
        <router-link to="/catalog" class="text-pink-600 hover:underline font-medium">&larr; Retour au catalogue</router-link>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
      <div v-if="loading" class="text-center py-20 text-pink-500 animate-pulse">Chargement des détails doux de ce produit...</div>
      <div v-else-if="error" class="text-center py-20 text-red-500 text-xl">{{ error }}</div>
      <div v-else class="flex flex-col md:flex-row gap-12">
        <!-- Image -->
        <div class="md:w-1/2">
          <img :src="product.image" :alt="product.name" class="w-full rounded-3xl shadow-lg object-cover h-96 border-4 border-pink-50">
        </div>
        <!-- Infos -->
        <div class="md:w-1/2 flex flex-col justify-center">
          <span class="text-sm font-bold tracking-widest text-pink-500 uppercase">{{ product.category?.name }}</span>
          <h1 class="mt-2 text-4xl font-serif font-extrabold text-gray-900">{{ product.name }}</h1>
          <p class="mt-6 text-lg text-gray-600 leading-relaxed">{{ product.description }}</p>
          <div class="mt-8 flex items-center justify-between">
            <span class="text-4xl font-extrabold text-gray-900">{{ product.price }} €</span>
            <button class="px-8 py-4 bg-gray-900 text-white font-bold rounded-full hover:bg-black transition shadow-xl transform hover:-translate-y-1">
              Ajouter au panier 🛍️
            </button>
          </div>
          <div class="mt-6 text-sm text-gray-500 flex items-center gap-2">
            <span v-if="product.status === 'available'" class="text-green-600 font-semibold flex items-center gap-1">
               <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
               En stock et prêt à expédier
            </span>
            <span v-else class="text-red-500 font-semibold">• Victime de son succès (Rupture)</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const product = ref(null);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        const response = await axios.get(`/api/products/${route.params.slug}`);
        product.value = response.data;
    } catch (e) {
        error.value = "Produit introuvable ! Il a peut-être été supprimé.";
    } finally {
        loading.value = false;
    }
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
