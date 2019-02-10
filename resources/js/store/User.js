const User = {
    
    state: {
        user: JSON.parse(localStorage.getItem('user') !== "undefined" ? localStorage.getItem('user') : null) || null,
        role: '',
        isLogin: false,
        useractivity:[],
        episodes:{},
        gorups:[],
        groupstype:[],
        menus: {
                 admin: false,
                 guser: false,
                 nuser: false
             },
        role_id: 0,
        // remeber token
    },
    mutations: {
        isLogin(state, data) {
            state.isLogin = data;
        },
        auth_success(state,payload) {
            state.user = payload.user;
            localStorage.setItem('user', JSON.stringify(state.user));
            
        },
        logout_success(state) {
            state.user = null,
                localStorage.removeItem('user');
        },
        setUserActivity(state,payload){
            state.useractivity = payload;
        },
        setEpisodes(state,payload){
            state.episodes = payload;
        }
        ,
        setGorups(state, payload) {
            state.gorups = payload;
        }
        ,
        setGroupstype(state, payload) {
            state.groupstype = payload;
        },
        checkRole(state,payload){
            state.role_id = payload.role_id;
            window.axios.defaults.headers.common['Authorization'] = "Bearer " + payload.token;
            switch (state.role_id) {
                case 1:
                    state.menus.nuser = true;
                    state.menus.guser = true;
                    state.menus.admin = true;
                    break;

                case 2:
                    state.menus.nuser = true;
                    break;

                case 3:
                    state.menus.nuser = true;
                    state.menus.guser = true;
                    break;

                default:
                    break;
            }
        }
      

    },
    actions: {
        checkRole({commit},payload){
            if (this.getters.isAuth) {
                let data = {
                    role_id: this.getters.user.role_id,
                    token: this.getters.user.remember_token
                };
                commit('checkRole', data);
            }
        },
        userInfo({commit},paylaod){
              return new Promise((resolve, reject) => {
                  try{
                  if (this.getters.isAuth) {
                      commit('changeLoading', true);
                      axios.defaults.headers.common['Authorization'] = this.getters.user.remember_token;
                      axios.get(this.getters.baseurl + 'api/user')
                          .then((res) => {
                              console.log("reload uer info it is work");
                              let user = res.data.user;
                              user.remember_token = res.data.token;
                              commit('auth_success', {
                                  user: user
                              });
                              resolve(res);
                          }).catch((err) => {
                              reject(err)
                              this.$router.push({
                                  name: 'login'
                              });
                          });
                  }
                  else{
                       commit('changeLoading', false);
                  }
                }catch(e){
                    reject();
                    commit('changeLoading', false);
                }

            })
        },
        login({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                commit('isLogin', true);
                commit('changeLoading', true);
                axios.post(this.getters.baseurl +'api/login', user).then((res) => {
                    if(!res.data.error){
                    axios.defaults.headers.common['Authorization'] =res.data.token;
                    let user = {};
                    user = res.data.authUser;

                    user.remember_token = res.data.token;
                    commit('auth_success', {user:res.data.authUser});
                   
                    resolve(res)
                    }else{
                         reject(res)
                          commit('changeLoading', false);
                    }
                }).catch((err) => {
                    console.log("error it is :" + JSON.stringify(err));
                    commit('isLogin', false)
                    localStorage.removeItem('user')
                    reject(err)
                    commit('changeLoading', false);
                });

            })
        },
        logout({
            commit
        }) {
            return new Promise((resolve, reject) => {
                commit('changeLoading', true);
                axios.post(this.getters.baseurl +'api/logout')
                    .then((res) => {
                        commit('logout_success');
                        localStorage.removeItem('user')

                        delete window.axios.defaults.headers.common['Authorization']

                        resolve(res);
                        commit('changeLoading', false);
                    }).catch((err) => {
                        reject(err);
                        commit('changeLoading', false);
                    })
            });

        },
        updateProfile({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                      let data = new FormData();
                      if (dataObj.tempImageAsFile != null) {
                      data.append('avater', dataObj.tempImageAsFile, dataObj.tempImageAsFile.name)
                      }
                      data.append('name', dataObj.name)
                      data.append('email', dataObj.email)
                      data.append('password', dataObj.password)
                      data.append('password_confirmation', dataObj.password_confirmation)
                      commit('changeLoading', true);
                axios.post(`api/user/${dataObj.user_id}`, data, {
                    headers: {
                        'accept': 'application/json',
                        'Content-Type': `multipart/form-data;`,
                    }
                })
                    .then((res) => {
                        resolve(res);
                        commit('changeLoading', false);
                    }).catch((err) => {
                        reject(err);
                        commit('changeLoading', false);
                    })
                    
            });
        },
        register({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                 commit('changeLoading', true);
                axios.post(this.getters.baseurl +'api/register', user)
                    .then((res) => {
                        console.log("register user res:" + JSON.stringify(res));
                        resolve(res);
                        commit('changeLoading', false);
                    }).catch((err) => {
                        console.log("error in register user :" + JSON.stringify(err));
                        reject(err);
                         commit('changeLoading', false);
                    });
            })
        },
        like({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                let data = new FormData();
                data.append("likestable_id", dataObj.id);
                data.append("likestable_type", dataObj.type);
                axios.post(this.getters.baseurl +'api/likes', data)
                    .then((res) => {
                        console.log("like added :" + JSON.stringify(res));
                        resolve(res);

                    }).catch((err) => {
                        console.log("error in like :" + JSON.stringify(err));
                        reject(err);
                    })
            });
        },
        unlike({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/likes/${data.id}`)
                    .then((res) => {
                        console.log(" res in unlike :" + JSON.stringify(res));

                        resolve(res);

                    }).catch((err) => {
                        console.log("error in unlike :" + JSON.stringify(err));
                        reject(err);
                    })
            })
        },
        favorite({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                let data = new FormData();
                data.append("favoritetable_id",dataObj.id );
                data.append("favoritetable_type", dataObj.type);
                axios.post(this.getters.baseurl +'api/favorites', data)
                    .then((res) => {
                        console.log("favorite res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("error in favorite :" + JSON.stringify(err));
                        reject(err);
                    })
            });
        },
        unfovrite({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/favorites/${dataObj.id}`)
                    .then((res) => {
                        console.log("res in unFavorites :" + JSON.stringify(res));
                        resolve(res);

                    }).catch((err) => {
                        console.log("error in unFavorite :" + JSON.stringify(err));
                        reject(err);
                    })
            })
        },
        rating({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                let data = new FormData();
                data.append('rating_id', dataObj.id);
                data.append('count', dataObj.rating);
                data.append('rating_type', dataObj.type);

                axios.post(this.getters.baseurl +'api/rating', data)
                    .then((res) => {
                        console.log("rating res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("rating err :" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
    notifyUser({
        commit
    }, data) {
        return new Promise((resolve, reject) => {
            axios.post(this.getters.baseurl+this.getters.baseurl+'api/notify', data)
                .then((res) => {
                    console.log("notify post res :" + JSON.stringify(res));
                    resolve(res);
                }).catch((err) => {
                    console.log("notify error :" + JSON.stringify(err));
                    reject(err);
                });
        })
    },
    updateNotify({
        commit
    }, data) {
        return new Promise((resolve, reject) => {
            axios.put(`api/notify/${data.id}`)
                .then((res) => {
                    console.log("response Upate notify :" + JSON.stringify(res));
                    resolve(res);
                }).catch((err) => {
                    console.log("update notify error :" + JSON.stringify(err));
                    reject(err);
                });
        })
    },

    userActivity({
        commit
    }, data) {
        return new Promise((resolve, reject) => {
            //  { headers: { Authorization: AuthStr } }
            axios.get(`api/userAcitivty/${data.type}`)
                .then((res) => {
                //    console.log("response userActivity :" + JSON.stringify(res));
                    resolve(res);
                })
                .catch((err) => {
                    console.log("update userActivity :" + JSON.stringify(err));
                    reject(err);
                });
                
        })
    },
    getEpisodes({commit},payload) {
        return new Promise((resolve, reject) => {
             commit('changeLoading', true);
            axios.get(this.getters.baseurl+'api/episode').then((res) => {
                console.log("======>"+JSON.stringify(res.data.links));
                
                commit('setEpisodes',res.data);
                resolve(res);
                 commit('changeLoading', false);
            }).catch((err) => {
                reject(err);
                 commit('changeLoading', false);
            });
        })
    },
    getGroups({
            commit
        }, payload) {
        return new Promise((resolve, reject) => {
            commit('changeLoading', true);
            axios.get(this.getters.baseurl+'api/group').then((res) => {
                resolve(res);
                commit('changeLoading', false);
            }).catch((err) => {
                reject(err);
                commit('changeLoading', false);
            });
        })
    },
    getGroupTypes({
            commit
        }, payload) {
        return new Promise((resolve, reject) => {
            commit('changeLoading', true);
            axios.get(this.getters.baseurl+'api/groupType')
                .then((res) => {
                    resolve(res);
                    commit('changeLoading', false);
                }).catch((err) => {
                    reject(err);
                    commit('changeLoading', false);
                });
        })
    },
    getCommentsEpisode({commit},payload){
        return new Promise((resolve,reject)=>{
            axios.get(this.getters.baseurl + 'api/comments' + payload.params)
            .then((res)=>{
             resolve(res);
            }).catch((err)=>{
                reject(err);
                
            });
        });
    }
    },

    getters: {
        avatarUser(state){
return window.axios.defaults.baseURL + "storage/" + state.user.avatar;
        
        },
        avatarPublic(state){
            return window.axios.defaults.baseURL + "storage/default.png";
        },
       
        user(state) {
            return state.user
        },
        episodes(state){
            return state.episodes;
        },
        groups(state){
            return state.groups;
        },
        groupstype(state) {
            return state.groupstype;
        },
        isAuth(state){
            return (state.user && typeof (state.user.remember_token) !== "undefined");
        },
        comments(state){
            return state.comments;
        },
        menus(state) {
            return state.menus;
        }
    }

}
export default User
