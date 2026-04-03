<template>
    <div class="min-h-screen bg-pink-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <h2 class="mt-6 text-center text-3xl font-extrabold font-serif text-pink-600">
                ✨ S'inscrire
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ou
                <router-link to="/login" class="font-medium text-pink-600 hover:text-pink-500 underline underline-offset-2">
                    se connecter à un compte existant
                </router-link>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border-t-4 border-pink-500">
                <form class="space-y-6" @submit.prevent="submit">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <div class="mt-1">
                            <input id="name" type="text" placeholder="Rose Dupont" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                        <div class="mt-1">
                            <input id="email" type="email" placeholder="rose@exemple.com" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <div class="mt-1">
                            <input id="password" type="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                            Créer mon compte (Simulation)
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-4 text-center">
                <router-link to="/" class="text-sm text-gray-500 hover:text-gray-700">
                    &larr; Retourner à l'accueil
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

// Initialisation de la navigation interne
const router = useRouter();

const submit = () => {
    // Provisoire : Simule le fait que ta future API a marché.
    router.push('/dashboard');
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
