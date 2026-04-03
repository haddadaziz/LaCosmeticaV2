<template>
    <div class="min-h-screen bg-pink-50 text-gray-800 font-sans">
        <header class="bg-white/80 backdrop-blur-md shadow-sm fixed w-full top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-serif text-pink-600 font-bold">✨ La Cosmetica</span>
                </div>
                <nav class="flex gap-6 items-center">
                    <router-link to="/login" class="font-medium text-gray-600 hover:text-pink-600 transition">
                        Connexion
                    </router-link>
                    <router-link to="/register" class="font-medium bg-pink-600 text-white px-5 py-2 rounded-full hover:bg-pink-700 transition shadow-md">
                        S'inscrire
                    </router-link>
                </nav>
            </div>
        </header>

        <main class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="text-center space-y-8 max-w-3xl mx-auto">
                <h1 class="text-5xl font-serif font-bold text-gray-900 leading-tight">
                    Révélez votre beauté naturelle.
                </h1>
                <p class="text-lg text-gray-600">
                    Notre future API te fournira ici tes produits cosmétiques bio, conçus pour sublimer ta peau au quotidien.
                </p>
                <div class="flex justify-center gap-4">
                    <router-link to="/catalog" class="px-8 py-3 bg-pink-600 text-white rounded-full font-semibold shadow-lg shadow-pink-200 hover:bg-pink-700 transition hover:-translate-y-1 transform">
                        Voir notre catalogue API
                    </router-link>
                </div>
            </div>
        </main>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
.font-serif { font-family: 'Playfair Display', serif; }
</style>
