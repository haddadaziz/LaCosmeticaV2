<template>
    <div class="min-h-screen bg-gray-50 font-sans">
        <header class="bg-white shadow border-b border-pink-100">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mon Espace Personnel 🌸
                </h2>
                <router-link to="/" class="text-sm px-4 py-2 bg-pink-50 text-pink-600 rounded-lg hover:bg-pink-100 font-medium transition-colors">
                    &larr; Retour à l'accueil
                </router-link>
            </div>
        </header>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-pink-100 p-8">
                    <h3 class="text-2xl font-serif text-pink-600 mb-4 font-bold">Bienvenue sur La Cosmetica !</h3>
                    <div class="text-gray-600 space-y-4">
                        <p>Tu es bien sur ton Dashboard (Single Page Application gérée par Vue-Router).</p>
                        <p>Bientôt, ton <strong>API REST</strong> nous dira avec **Axios** qui est connecté ici via un Token JWT sécurisé !</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
