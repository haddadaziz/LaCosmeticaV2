<template>
    <div class="min-h-screen bg-pink-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <h2 class="mt-6 text-center text-3xl font-extrabold font-serif text-pink-600">
                ✨ Connexion
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Ou
                <router-link to="/register" class="font-medium text-pink-600 hover:text-pink-500 underline underline-offset-2">
                    créer un compte La Cosmetica
                </router-link>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-2xl sm:px-10 border-t-4 border-pink-500">
                <form class="space-y-6" @submit.prevent="submit">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                        <div class="mt-1">
                            <input id="email" type="email" placeholder="belle@exemple.com" required
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

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" type="checkbox" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Se souvenir de moi </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                            Se connecter (Simulation)
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

const router = useRouter();

// Cette fonction sera reliée plus tard à l'API via Axios !
const submit = () => {
    // Pour l'instant, c'est purement visuel, on se redirige directement.
    router.push('/dashboard');
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
