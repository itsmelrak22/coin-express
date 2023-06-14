import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
// import Home from './components/Home'
// import Hello from './components/Hello'
import User from './components/User'
import PermissionPage from './components/Permission'
import RolePage from './components/Role'

import FrontDashboard from './components/FrontDashboardView'
// import ClientSide from './components/ClientSide'
// import Dashboard from './components/Dashboard'
import AdminSide from './components/AdminSide'
// import Account from './components/Account'
// import Order from './components/Order'

// import MainPage from './components/MainPage'
import ViewTrade from './components/ViewTrade'
import DepositView from './components/DepositView'
import RechargePage from './components/RechargePage'
import RechargeDetails from './components/RechargeDetails'
import AdminSideDepo from './components/AdminSideDepo'
import AccountInfo from './components/AccountInfo'

// import Withdrawal from './components/Withdrawal'
import AdminUser from './components/AdminUser'
import MyClient from './components/MyClient'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/users',
            name: 'users',
            component: User
        },
        {
            path: '/permissions',
            name: 'permission',
            component: PermissionPage
        },
        {
            path: '/roles',
            name: 'role',
            component: RolePage
        },
        {
            path: '/admin_users',
            name: 'admin_user',
            component: AdminUser
        },
        {
            path: '/AdminSide',
            name: 'AdminSide',
            component : AdminSide
        },
        // {
        //     path: '/Account',
        //     name: 'Account',
        //     component: Account
        // },

        {
            path: '/',
            name: 'FrontDashboard',
            component: FrontDashboard
        },

        {
            path: '/ViewTrade',
            name: 'ViewTrade',
            component: ViewTrade
        },

        {
            path: '/DepositView',
            name: 'DepositView',
            component: DepositView
        },

        {
            path: '/RechargePage',
            name: 'RechargePage',
            component: RechargePage
        },

        {
            path: '/RechargeDetails',
            name: 'RechargeDetails',
            component: RechargeDetails
        },

        {
            path: '/AccountInfo',
            name: 'AccountInfo',
            component: AccountInfo
        },

        {
            path: '/AdminSideDepo',
            name: 'AdminSideDepo',
            component: AdminSideDepo
        },
        {
            path: '/my_clients',
            name: 'MyClient',
            component: MyClient
        },
    ],
});