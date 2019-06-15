import Vue from 'vue'
import Vuex from 'vuex'
import User from './User.js'
import Admin from './admin.js'
import TestUser from '../testUnit/TestUse.js'
import TestAdmin from '../testUnit/TestAdmin.js'
import Axios from 'axios';
Vue.use(Vuex);

const store = new Vuex.Store({

    plugins:[],
    modules: {
        authUser: User,
      //  testUser:TestUser,
    //    TestAdmin:TestAdmin,
        authAdmin:Admin,
    },
    state: {
        isLoading:false,
        lastItemAdded:null,
        lastEpisodes:[],
        comments: [],
        detailEpisode:null,
        detailGroup:null,

        },
        mutations: {
            changeLoading(state,payload){
                state.isLoading = payload;
            },
              setComments(state, payload) {
                  state.comments = payload;
              },
              popComment(state,payload){
                  state.comments.pop(payload);
              },
              updateComment(state,payload){
                  state.comments[payload.id] = payload.data;
              },
              setDetailEpisode(state,payload){
                state.detailEpisode = payload;
              },
              setDetailGroup(state,payload){
                  state.detailGroup = payload;
              }

    },
    actions:{
        loading({commit},payload){
            commit('changeLoading',payload);
        }
        ,
        lastItem({
                commit
            }, payload) {
                return new Promise((resolve, reject) => {
                    axios.get(this.getters.baseurl+'api/lasItemAdded').then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
                });
            },
            lastEpisodes({
                commit
            }, payload) {
                return new Promise((resolve, reject) => {
                    axios.get(this.getters.baseurl+'api/lastEpisodes').then((res) => {
                        resolve(res);
                    }).catch((err) => {
                        reject(err);
                    })
                })
            },
            comment({
                    commit
                }, data) {
                    return new Promise((resolve, reject) => {
                        axios.post(`${this.getters.baseurl+ 'api/comments'}`, data)
                            .then((res) => {
                           //     commit('setComments',res.data);
                                resolve(res);
                            }).catch((err) => {
                                reject(err);
                            });
                    });
                },
                uncomment({
                    commit
                }, data) {
                    return new Promise((resolve, reject) => {
                        axios.delete(`api/comments/${data.id}`)
                            .then((res) => {
                                commit('popComment', data.id);
                                resolve(res);
                            }).catch((err) => {
                                reject(err);
                            });
                    });
                },
                updateComment({
                    commit
                }, data) {
                    return new Promise((resolve, reject) => {
                        axios.put(`api/comments/${data.id}`, data)
                            .then((res) => {
                                 commit('updateComment', data);
                                resolve(res);
                            }).catch((err) => {
                                reject(err);

                            })
                    })
                },
                DetialEpisode({commit},payload){
                   return new Promise((resolve, reject) => {
                       axios.get(this.getters.baseurl + 'api/detailEpisode/' + payload)
                       .then((res)=>{
                        commit('setDetailEpisode',res.data);
                        resolve(res);
                       }).catch((err)=>{
                          reject(err);
                       })

                   });
                },
                DetialGroup({commit},payload){
                    return new Promise((resolve,reject)=>{
                              axios.get(this.getters.baseurl + 'api/detailGroup/' + payload)
                                  .then((res) => {
                                      commit('setDetailGroup', res.data);
                                      resolve(res);
                                  }).catch((err) => {
                                      reject(err);
                                  })

                    });
                }

        },
        getters: {
             baseurl(state) {
                 return window.axios.defaults.baseURL;
             },
       isloading(state){
           return state.isLoading;
       },
       lastItemAdded(state) {
           return state.lastItemAdded;
       },
       lastEpisodes(state) {
           return state.lastEpisodes;
       },
       detailEpisode(state){
           return state.detailEpisode;
       },
       detailGroup(state){
           return state.detailGroup;
       }
    }
});
export default store;
