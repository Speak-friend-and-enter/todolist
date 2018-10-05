import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import Welcome from './components/Welcome'
import TaskLists from './components/TaskLists'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: Welcome,
            props: { title: "This is the SPA home" }
        },
        {
            path: '/task-lists',
            name: 'task-lists',
            component: TaskLists,
            props: {
            }
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});