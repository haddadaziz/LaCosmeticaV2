import { createRouter, createWebHistory } from 'vue-router';

import Welcome from './Pages/Welcome.vue';
import Dashboard from './Pages/Dashboard.vue';
import Login from './Pages/Auth/Login.vue';
import Register from './Pages/Auth/Register.vue';
import Catalog from './Pages/Catalog.vue';
import ProductDetail from './Pages/ProductDetail.vue';

const routes = [
    { path: '/', name: 'home', component: Welcome },
    { path: '/dashboard', name: 'dashboard', component: Dashboard },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/catalog', name: 'catalog', component: Catalog },
    { path: '/products/:slug', name: 'product.show', component: ProductDetail }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
