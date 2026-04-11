import { createRouter, createWebHistory } from 'vue-router';

import Welcome from './Pages/Welcome.vue';
import Dashboard from './Pages/Dashboard.vue';
import Login from './Pages/Auth/Login.vue';
import Register from './Pages/Auth/Register.vue';
import Catalog from './Pages/Catalog.vue';
import ProductDetail from './Pages/ProductDetail.vue';
import Cart from './Pages/Cart.vue';
import MyOrders from './Pages/MyOrders.vue';
import StaffDashboard from './Pages/StaffDashboard.vue';
import AdminDashboard from './Pages/AdminDashboard.vue';

const routes = [
    { path: '/', name: 'home', component: Welcome },
    { path: '/dashboard', name: 'dashboard', component: Dashboard },
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/catalog', name: 'catalog', component: Catalog },
    { path: '/products/:slug', name: 'product.show', component: ProductDetail },
    { path: '/cart', name: 'cart', component: Cart },
    { path: '/my-orders', name: 'my-orders', component: MyOrders },
    { path: '/staff-dashboard', name: 'staff-dashboard', component: StaffDashboard },
    { path: '/admin-dashboard', name: 'admin-dashboard', component: AdminDashboard }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
