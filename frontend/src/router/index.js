import { createRouter, createWebHistory } from 'vue-router'
// import store from "@/store";
const routes = [
  {
    path: '/',
    name: 'home:index',
    component: () => import('../views/IndexView.vue'),
  },
  {
    path: '/:path',
    name: 'page:index',
    component: () => import('../views/IndexView.vue'),
  },
  {
    path: '/about',
    name: 'about:index',
    component: () => import('../views/AboutView.vue')
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to) {
    if (to.hash) {
      return {
        el: to.hash,
      };
    }
  },
})

export default router
