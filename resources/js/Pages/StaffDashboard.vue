<template>
  <div class="min-h-screen bg-gray-900 font-sans pb-12 text-white">
    <header class="bg-black shadow border-b border-gray-800">
      <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
        <h1 class="text-3xl font-serif font-bold text-pink-500">👔 Staff Dashboard</h1>
        <router-link to="/" class="text-sm px-4 py-2 hover:bg-gray-800 rounded-lg transition text-gray-400">Quitter</router-link>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
      <div v-if="loading" class="text-center py-20 text-gray-500 animate-pulse">Récupération des commandes en attente via API...</div>
      <div v-else-if="error" class="bg-red-900 text-red-200 p-6 rounded-2xl shadow mb-8 text-center border border-red-700">
        🚨 STOP : {{ error }}
      </div>
      <div v-else-if="orders.length === 0" class="text-center py-32 text-gray-500 text-2xl font-light">
        Aucune commande en attente de préparation. Beau travail ! ☕
      </div>

      <div v-else class="grid gap-6 lg:grid-cols-2">
        <div v-for="order in orders" :key="order.id" class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-2xl">
          <div class="flex justify-between items-start mb-6">
            <div>
              <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs font-bold uppercase">{{ order.status }}</span>
              <h3 class="text-xl font-bold mt-2">Commande #{{ order.id }}</h3>
              <p class="text-gray-400 text-sm">Client ID: {{ order.user_id }}</p>
            </div>
            <div class="text-2xl font-extrabold text-pink-500">{{ order.total_price }} €</div>
          </div>
          
          <div class="bg-gray-900 p-4 rounded-xl mb-6">
             <div v-for="item in order.items" :key="item.id" class="flex justify-between text-sm py-1 border-b border-gray-800 last:border-0">
               <span class="text-gray-300">{{ item.quantity }}x {{ item.product?.name }}</span>
               <span class="text-gray-500">{{ item.unit_price }} €</span>
             </div>
          </div>

          <button @click="markAsPrepared(order.id)" class="w-full py-3 bg-pink-600 hover:bg-pink-700 text-white font-bold rounded-lg transition shadow-lg">
            Valider la "Préparation" ✓
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const orders = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchPending = async () => {
    loading.value = true;
    try {
        const token = localStorage.getItem('jwt_token');
        if (!token) throw new Error("Non connecté");

        const response = await axios.get('/api/staff/orders/pending', {
            headers: { Authorization: `Bearer ${token}` }
        });
        orders.value = response.data;
    } catch (e) {
        error.value = "Accès Interdit. Gérer les rôles dans la BDD pour obtenir l'accès 'Employé'.";
    } finally {
        loading.value = false;
    }
};

const markAsPrepared = async (orderId) => {
    try {
        const token = localStorage.getItem('jwt_token');
        await axios.put(`/api/staff/orders/${orderId}/status`, { status: 'prepared' }, {
            headers: { Authorization: `Bearer ${token}` }
        });
        fetchPending();
    } catch (e) {
        alert("Action interdite !");
    }
};

onMounted(() => {
    fetchPending();
});
</script>
