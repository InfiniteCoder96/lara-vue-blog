import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

//admin routes
import home from './admin/pages/home.vue';
import tags from './admin/pages/tags.vue';
import category from './admin/pages/category.vue';

// customer routes
import aboutPage from './components/pages/about';

// basics
import hooks from './components/pages/basic/hooks.vue';
import methods from './components/pages/basic/methods.vue';
import usecom from './vuex/useComp.vue';

const routes = [
    // projects routes
    {
        path: '/',
        component: home
    },
    {
        path: '/tags',
        component: tags
    },
    {
        path: '/categories',
        component: category
    },
    {
        path: '/about',
        component: aboutPage
    },






    /* basic routes */
    // vue hooks
    {
        path: '/hooks',
        component: hooks
    },

    // methods
    {
        path: '/methods',
        component: methods
    },

    // vuex
    {
        path: '/testvuex',
        component: usecom
    }
]

export default new Router({
    mode: 'history',
    routes
})