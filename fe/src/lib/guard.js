import { getToken } from './token'

export default function setupGuard(router) {
  router.beforeEach((to, from, next) => {
    const token = getToken()

    if (to.meta.requiresAuth && !token) {
      return next('/login')
    }

    if (to.path === '/login' && token) {
      return next('/inventory')
    }

    next()
  })
}
