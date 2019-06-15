const TestUser = {
    state: {

         user: localStorage.getItem('user') || {},
    },
    mutations: {
    },
    actions: {
        testlogin({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                axios.post('api/login', user).then((res) => {
                    console.log("login res :" + JSON.stringify(res));
             //       let remeberToken = res.data.authUser.remember_token;
             //       localStorage.setItem('remember_token', remeberToken);
             //       axios.defaults.headers.common['Authorization'] = remeberToken;
                    resolve(res)
                }).catch((err) => {
                    console.log("login error:" + JSON.stringify(err));
                    localStorage.removeItem('remember_token')
                    reject(err)
                });

            })
        },
        testlogout({
            commit
        }) {
            return new Promise((resolve, reject) => {
                axios.post('api/logout')
                    .then((res) => {
                        console.log("logout res :"+JSON.stringify(res));

                        localStorage.removeItem('remember_token')
                        delete window.axios.defaults.headers.common['Authorization']

                        resolve(res);
                    }).catch((err) => {
                        console.log("logout err :"+JSON.stringify(err));

                        reject(err);
                    })
            });

        },
        testupdateProfile({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                axios.put('api/user/2', user)
                    .then((res) => {
                        console.log("update profile  res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("err in update profile :" + JSON.stringify(err));
                        reject(err);
                    })
            });
        },
        testregister({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                axios.post('api/register', user)
                    .then((res) => {
                        console.log("register user res:" + JSON.stringify(res));
                        resolve(res);

                    }).catch((err) => {
                        console.log("error in register user :" + JSON.stringify(err));
                        reject(err);
                    });
            })
        },
        testlike({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/likes', data)
                    .then((res) => {
                        console.log("like added  res:" + JSON.stringify(res));
                        resolve(res);

                    }).catch((err) => {
                        console.log("like added err :" + JSON.stringify(err));
                        reject(err);
                    })
            });
        },
        testunlike({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/likes/${data.id}`)
                    .then((res) => {
                        console.log("  in unlike  res:" + JSON.stringify(res));

                        resolve(res);

                    }).catch((err) => {
                        console.log(" in unlike error:" + JSON.stringify(err));
                        reject(err);
                    })
            })
        },
        testfavorite({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/favorites', data)
                    .then((res) => {
                        console.log("add favorite res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add favorite  error in:" + JSON.stringify(err));
                        reject(err);
                    })
            });
        },
        testunfovrite({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/favorites/${data.id}`)
                    .then((res) => {
                        console.log("res in unFavorites :" + JSON.stringify(res));
                        resolve(res);

                    }).catch((err) => {
                        console.log("error in unFavorite :" + JSON.stringify(err));
                        reject(err);
                    })
            })
        },
        comment({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/comments', data)
                    .then((res) => {
                     //   console.log("add comment res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add comment error :" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testuncomment({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/comments/${data.id}`)
                    .then((res) => {
                        console.log("res in un comment :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("error in un comment :" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testupdateComment({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/comments/${data.id}`, data)
                    .then((res) => {
                        console.log("update comment res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("update comment err:" + JSON.stringify(err));
                        reject(err);

                    })
            })
        },
        testrating({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/rating', data)
                    .then((res) => {
                        console.log("rating res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("rating err :" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testupdateRating({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/rating/${data.id}`, data)
                    .then((res) => {
                        console.log("updae rating res :" + JSON.stringify(res));
                        resolve(res);

                    }).catch((err) => {
                        console.log("update rating err:" + JSON.stringify(err));

                        reject(err);
                    });
            });
        }
    },
    testdeleteRating({
        commit
    }, data) {
        return new Promise((resolve, reject) => {
            axios.delete(`api/rating/${data.id}`)
                .then((res) => {
                    console.log("delete rating res :" + JSON.stringify(res));
                    resolve(res);
                }).catch((err) => {
                    console.log("delete rating err :" + JSON.stringify(err));
                    reject(err);
                });
        });
    },
    testnotifyUser({
        commit
    }, data) {
        return new Promise((resolve, reject) => {
            axios.post('api/notify', data)
                .then((res) => {
                    console.log("notify post res :" + JSON.stringify(res));
                    resolve(res);
                }).catch((err) => {
                    console.log("notify post error :" + JSON.stringify(err));
                    reject(err);
                });
        })
    },
    testupdateNotify({
        commit
    }, data) {
        return new Promise((resolve, reject) => {
            axios.put(`api/notify/${data.id}`)
                .then((res) => {
                    console.log("notify Upate  res:" + JSON.stringify(res));
                    resolve(res);
                }).catch((err) => {
                    console.log(" notify update error :" + JSON.stringify(err));
                    reject(err);
                });
        })
    },
    getters: {

    }

}
export default TestUser
