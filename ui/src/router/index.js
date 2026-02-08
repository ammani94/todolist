import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import DetailsView from '../views/DetailsView.vue';
import ContactView from '../views/ContactView.vue';
import AuthenticationView from '../views/AuthenticationView.vue';
import SignupView from '@/views/SignupView.vue';

const routes = [
  { path: '/', name: 'authentification', component: AuthenticationView, meta: { hideHeader: true } },
  { path: '/home', name: 'home', component: HomeView },
  { path: '/details/:id', name: 'about', component: DetailsView },
  { path: '/contact', name: 'contact', component: ContactView },
  { path: '/signup', name: 'signup', component: SignupView, meta: { hideHeader: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
