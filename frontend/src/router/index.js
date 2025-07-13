import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/auth/Login.vue';
import UserDashboard from '../views/user/UserDashboard.vue';
import AdminDashboard from '../views/admin/AdminDashboard.vue';
import { useAuthStore } from '../stores/auth';

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/user-dashboard',
    name: 'UserDashboard',
    component: UserDashboard,
    meta: { requiresAuth: true, role: 'user' },
  },
  {
    path: '/admin-dashboard',
    name: 'AdminDashboard',
    component: AdminDashboard,
    meta: { requiresAuth: true, role: 'admin' },
  },
  {
    path: '/',
    redirect: '/login',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login');
  } else if (to.meta.requiresAuth && to.meta.role && authStore.user?.role !== to.meta.role) {
    next('/login'); // Redirect to login if role doesn't match
  } else {
    next();
  }
});

export default router;
