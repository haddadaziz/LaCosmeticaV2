<template>
  <div class="min-h-screen bg-pink-50 font-sans pb-12">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center text-pink-600">
        <h1 class="text-3xl font-serif font-bold">🛒 Mon Panier</h1>
        <router-link to="/catalog" class="text-sm px-4 py-2 hover:bg-pink-50 rounded-lg transition">&larr; Retour Catalogue</router-link>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
      <div v-if="success" class="bg-green-100 text-green-800 p-6 rounded-2xl shadow mb-8 text-lg font-semibold flex flex-col gap-4">
        <p>🎉 Félicitations ! Votre commande a été envoyée à l'API avec succès (Token JWT valide).</p>
        <router-link to="/my-orders" class="text-green-900 underline text-sm">Voir mon historique de commandes</router-link>
      </div>
      <div v-if="error" class="bg-red-100 text-red-700 p-6 rounded-2xl shadow mb-8">
        🚨 {{ error }}
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
          <h2 class="text-2xl font-bold mb-4">Vos articles (Mock Test)</h2>
          <p class="text-gray-500 mb-6 italic text-sm">Pour valider le flux API sans base SQL lourde, ce panier est pré-rempli avec les cosmétiques générés dans le Seeder :</p>
          
          <div v-for="item in cartItems" :key="item.product_id" class="flex justify-between items-center border-b border-gray-100 py-4">
            <div>
              <h3 class="font-bold text-lg text-gray-900">{{ item.name }}</h3>
              <p class="text-pink-600 font-semibold mt-1">{{ item.unit_price }} € <span class="text-gray-400 text-sm">x {{ item.quantity }}</span></p>
            </div>
            <div class="font-extrabold text-xl text-gray-900">{{ (item.unit_price * item.quantity).toFixed(2) }} €</div>
          </div>
          <div v-if="cartItems.length === 0" class="text-center text-gray-400 py-10">Votre panier a été consommé.</div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 h-fit border-t-4 border-pink-500">
          <h2 class="text-xl font-bold mb-6 text-gray-900">Résumé Commande</h2>
          <div class="flex justify-between text-3xl font-extrabold text-pink-600 mb-8 pb-6 border-b border-gray-100">
            <span>Total</span>
            <span>{{ totalPrice.toFixed(2) }} €</span>
          </div>
          <button @click="placeOrder" :disabled="loading || success || cartItems.length === 0" class="w-full py-4 bg-gray-900 text-white font-bold rounded-full hover:bg-black transition shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:transform-none">
            {{ loading ? 'Transaction SSL...' : 'Valider Payer' }}
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

// Mock du panier branché sur les produits du backend
const cartItems = ref([
    { product_id: 1, name: "Crème Hydratante à l'Aloé Vera", quantity: 2, unit_price: 24.50 },
    { product_id: 3, name: "Huile de Massage Relaxante", quantity: 1, unit_price: 19.90 },
]);

const loading = ref(false);
const success = ref(false);
const error = ref(null);

const totalPrice = computed(() => {
    return cartItems.value.reduce((acc, item) => acc + (item.unit_price * item.quantity), 0);
});

const placeOrder = async () => {
    loading.value = true;
    error.value = null;
    try {
        const token = localStorage.getItem('jwt_token');
        if (!token) throw new Error("Accès refusé. Vous devez vous connecter sur la page d'accueil pour générer votre JWT !");

        // Ciblage de la route protégée avec la signature Token Header
        await axios.post('/api/orders', {
            items: cartItems.value,
            total_price: totalPrice.value
        }, {
            headers: { Authorization: `Bearer ${token}` }
        });
        
        success.value = true;
        cartItems.value = [];
    } catch (e) {
        if (e.response?.status === 401) {
            error.value = "Votre session a expiré ou le Token JWT est manquant. Reconnectez-vous.";
        } else {
            error.value = e.response?.data?.error || e.message || "Erreur de connexion API.";
        }
    } finally {
        loading.value = false;
    }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
