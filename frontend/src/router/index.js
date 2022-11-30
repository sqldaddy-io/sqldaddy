import { createRouter, createWebHistory } from 'vue-router'
const routes = [
  {
    path: '/',
    name: 'home:index',
    component: () => import('../views/IndexView.vue'),
  },
  {
    path: '/:path?',
    name: 'page:index',
    component: () => import('../views/SandBox/index.vue'),
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
  }
})
router.beforeEach((to,from, next) => {

  if(to.name === 'home:index' && to.query?.database !== undefined){
    return next({ name: 'page:index', query: to.query});
  }
  return next();
})
export default router
