import Vue from 'vue'
import Router from 'vue-router';
import home from '../components/Home.vue'
import login from '../components/User/singin.vue'
import register from '../components/User/singup.vue'
import profile from '../components/User/profile.vue'
import episode from '../components/Forms/episode.vue'
import group from '../components/Forms/group.vue'
import groupType from '../components/Forms/groupType.vue'
import episodeCURD from '../components/CURD/episodes.vue'
import grouptypeCURD from '../components/CURD/grouptype.vue'
import serversCURD from '../components/CURD/servers.vue'
import groupCURD from '../components/CURD/groups.vue'
import settingCURD from '../components/CURD/setting.vue'
import useractivity from '../components/User/useractivity.vue'
import watchEpisode from '../components/pages/episode.vue'
import comment from '../components/pages/comments.vue'
import watchGroup from '../components/pages/group.vue'
import AuthGuard from './Auth.js'

Vue.use(Router);
const app = new Router({
    routes: [{
            path: '/',
            name: 'home',
            component: home
        },
        {
          path:'/comment',
          name:'comment',
          component:comment

        },
        {
            path: '/login',
            name: 'login',
            component: login
        },
        {
            path: '/register',
            name: 'register',
            component: register
        },

        {
            path: '/profile',
            name: 'profile',
            component: profile,
        }, // when /profile/:id/likes is matched
       
        {
            path: '/useractivity/:type',
            name: 'useractivity',
            component: useractivity
        },
        ,
        {
            path: '/addepisode',
            name: 'addepisode',
            component: episode,
        },
         {
            path: '/episode/curd',
            name: 'curdepisode',
            component: episodeCURD,
            beforeEnter: AuthGuard
        },{
            path: '/episode/watch/:id',
            name: 'watchEpisode',
            component: watchEpisode,
        },
        {
            path: '/gorupType/add',
            name: 'addgoruptype',
            component: groupType,
            beforeEnter: AuthGuard
        },
        {
            path: '/gorupType/curd',
            name: 'curdgoruptype',
            component: grouptypeCURD,
            beforeEnter: AuthGuard
        },
         {
            path: '/group/curd',
            name: 'curdgroup',
            component: groupCURD,
            beforeEnter: AuthGuard
        }, {
            path: '/group/add',
            name: 'addgroup',
            component: group,
            beforeEnter: AuthGuard
        },
        {
            path: '/group/watch/:id',
            name: 'watchGroup',
            component: watchGroup,
        },
        {
            path: '/servers/curd',
            name: 'curdservers',
            component: serversCURD,
            beforeEnter: AuthGuard
        },
        {
            path: '/setting/curd',
            name: 'curdsetting',
            component: settingCURD,
            beforeEnter: AuthGuard
        }
    ],
     mode: 'history',


});

export default app;