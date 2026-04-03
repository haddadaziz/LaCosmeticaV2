<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-pink-50 selection:bg-pink-300 selection:text-pink-900 font-sans">
        <div>
            <Link href="/">
                <ApplicationLogo class="text-center" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-8 px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border-t-4 border-pink-500">
            <slot />
        </div>
    </div>
</template>
