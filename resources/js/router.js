import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Home from './components/Home'
import Hello from './components/Hello'
import User from './components/User'
import PermissionPage from './components/Permission'
import RolePage from './components/Role'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello
        },
        {
            path: '/users',
            name: 'users',
            component: User
        },
        {
            path: '/master/permissions',
            name: 'permission',
            component: PermissionPage
        },
        {
            path: '/master/roles',
            name: 'role',
            component: RolePage
        },
    ],
});