import store from '../store'

export default (to, from, next) => {
    if (typeof(store.getters.user.remember_token) !== "undefined") {
        next()
    }else {
        next('/login')
    }
}
