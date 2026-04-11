<template>
  <div class="min-h-screen bg-gray-50 font-sans pb-12">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
        <h1 class="text-3xl font-serif font-bold text-gray-900">👤 Mon Historique</h1>
        <div class="flex gap-4">
          <router-link to="/catalog" class="text-sm px-4 py-2 hover:bg-gray-100 rounded-lg transition">Catalogue</router-link>
          <button @click="logout" class="text-sm px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition">Déconnexion</button>
        </div>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
      <div v-if="loading" class="text-center py-20 text-gray-500 animate-pulse">Synchronisation avec l'API...</div>
      <div v-else-if="error" class="bg-red-100 text-red-700 p-6 rounded-2xl shadow mb-8 text-center">{{ error }}</div>
      <div v-else-if="orders.length === 0" class="text-center py-20 text-gray-500">
        Vous n'avez passé aucune commande. <router-link to="/cart" class="text-pink-600 underline">Remplissez vite votre panier !</router-link>
      </div>

      <div v-else class="space-y-6">
        <div v-for="order in orders" :key="order.id" class="bg-white rounded-2xl shadow p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
          <div class="mb-4 sm:mb-0">
            <h3 class="text-sm text-gray-500 font-bold tracking-widest uppercase mb-1">Commande #{{ order.id }}</h3>
            <p class="text-gray-400 text-xs mb-3">{{ new Date(order.created_at).toLocaleString() }}</p>
            <div class="flex items-center gap-3">
              <span class="text-2xl font-extrabold text-gray-900">{{ order.total_price }} €</span>
              <span :class="statusClass(order.status)" class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                {{ order.status }}
              </span>
            </div>
            
            <div class="mt-4 pl-4 border-l-2 border-gray-100 space-y-1">
               <p v-for="item in order.items" :key="item.id" class="text-sm text-gray-600">
                 {{ item.quantity }}x {{ item.product?.name }}
               </p>
            </div>
          </div>
          
          <div class="w-full sm:w-auto">
            <button v-if="order.status === 'pending'" @click="cancelOrder(order.id)" class="w-full sm:w-auto px-6 py-2 border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold rounded-full transition transform hover:scale-105 shadow-sm">
              Annuler
            </button>
            <span v-else class="text-gray-400 text-sm italic">Action indisponible</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const orders = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchOrders = async () => {
    loading.value = true;
    try {
        const token = localStorage.getItem('jwt_token');
        if (!token) throw new Error("JWT manquant. Connectez-vous !");

        const response = await axios.get('/api/orders', {
            headers: { Authorization: `Bearer ${token}` }
        });
        orders.value = response.data;
    } catch (e) {
        error.value = "Erreur 403 : Accès interdit ou session expirée.";
    } finally {
        loading.value = false;
    }
};

const cancelOrder = async (orderId) => {
    try {
        const token = localStorage.getItem('jwt_token');
        await axios.post(`/api/orders/${orderId}/cancel`, {}, {
            headers: { Authorization: `Bearer ${token}` }
        });
        fetchOrders(); // Rafraichir l'historique
    } catch (e) {
        alert("Impossible d'annuler la commande.");
    }
};

const logout = () => {
    localStorage.removeItem('jwt_token');
    router.push('/login');
};

const statusClass = (status) => {
    const map = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'prepared': 'bg-blue-100 text-blue-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800'
    };
    return map[status] || 'bg-gray-100 text-gray-800';
};

onMounted(() => {
    fetchOrders();
});
</script>
