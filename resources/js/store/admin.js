import Axios from "axios";

const admin = {
    state: {
        configFile: {
            headers: {
                'Accept': 'application/json',
                'Content-Type': `multipart/form-data;`,
            }
        },
        settings:[],

    },
    mutations: {
        setSetting(state,payload){
            state.settings[data.id] = data.payload;
            for (var i = 0; i < state.settings.length; i++) {
                if (state.settings[i].id === payload.id) {
                   state.settings[i] = data.payload;
                    break;
                }
            }
        },
        removeSetting(state, payload) {
           for (var i = 0; i < state.settings.length; i++){
               if (state.settings[i].id === payload.id) {
                   state.settings.splice(i, 1);
                   break;
               }
            }
        },
        addSetting(state,payload){
            state.settings.push(payload);
            console.log("data "+JSON.stringify(state.settings));
        }

    },
    actions: {
        addSettign({commit},payload){
            return new Promise((resolve,reject)=>{
                axios.post(this.getters.baseurl+'api/setting',payload)
                .then((res)=>{
                    payload.id = res.data.response.IDItemAdded;
                    commit('addSetting',payload);
                    console.log("setting added :"+JSON.stringify(res));
                      resolve(res);
                }).catch((err)=>{
                     console.log("setting added :" + JSON.stringify(err));
                reject(err);
                })

            });

        },
        editSetting({
            commit
        }, payload) {
            return new Promise((resolve, reject) => {
                axios.put(`api/setting/${payload.id}`, payload)
                    .then((res) => {
                        commit('setSetting',payload);
                         console.log("setting added :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                          console.log("setting added :" + JSON.stringify(err));
                        reject(err);
                    })
            })

        },
        deleteSetting({commit},payload){
            return new Promise((resolve, reject) => {
                 
                axios.delete(`api/setting/${payload.id}`)
                    .then((res) => {
                 console.log("setting added :" + JSON.stringify(res));
                 commit('removeSetting',payload);
                         resolve(res);
                    }).catch((err) => {
                console.log("setting added :" + JSON.stringify(err));
                        reject(err);
                    })
            })
        },
        addGroup({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
           console.log(JSON.stringify(dataObj))
                  let data = new FormData();
                  if (dataObj.tempImageAsFile != null) {
                      data.append('image', dataObj.tempImageAsFile, dataObj.tempImageAsFile.name)
               }
                  data.append('name', dataObj.name)
                  data.append('description', dataObj.description)
                  data.append('group_type_id', dataObj.group_id)

                axios.post(this.getters.baseurl+'api/group', data, this.getters.configFile)
                    .then((res) => {
                        console.log("add group res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add group err:" + JSON.stringify(err));
                        reject(err);
                    });
            });

        },
        updateGroup({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                  let data = new FormData();
                  if (dataObj.tempImageAsFile != null) {
                      data.append('image', dataObj.tempImageAsFile, dataObj.tempImageAsFile.name)
                  }
                  data.append('name', dataObj.name)
                  data.append('description', dataObj.description)
                  data.append('group_type_id', dataObj.group_type_id)

                axios.post(`api/group/${dataObj.id}`, data, this.getters.configFile)
                    .then((res) => {
                        console.log("updateGroup res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("updateGroup err:" + JSON.stringify(err));
                        reject(err);
                    });
            });

        },
        deleteGroup({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/group/${dataObj.id}`)
                    .then((res) => {
                        console.log("delete group res :" + JSON.stringify(res));
                        resolve(err);
                    }).catch((err) => {
                        console.log("delete group err :" + JSON.stringify(err));
                        reject(err);

                    });
            });

        },
        addepisode({
            commit
        }, dataObj) {

            return new Promise((resolve, reject) => {

      console.log("addepisode Promise:" + JSON.stringify(dataObj));

                  let data = new FormData();
                  if (dataObj.tempImageAsFile != null) {
                      data.append('image', dataObj.tempImageAsFile, dataObj.tempImageAsFile.name)
                  }
                  data.append('number', dataObj.number)
                  data.append('description', dataObj.description)
                  data.append('group_id', dataObj.group_id)
      console.log("data form:" + JSON.stringify(data));

                axios.post(this.getters.baseurl+'api/episode', data, this.getters.configFile)
                    .then((res) => {
                        console.log("add Episode res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add Episode err:" + JSON.stringify(err));
                        reject(err);
                    });
            });

        },
        updatepisode({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                  let data = new FormData();
                  if (dataObj.tempImageAsFile != null) {
                 data.append('image', dataObj.tempImageAsFile, dataObj.tempImageAsFile.name)
                  }
                 data.append('group_id', dataObj.group_id)
                 data.append('number', dataObj.number)
                 data.append('description', dataObj.description)


                axios.post(`api/episode/${dataObj.id}`, data, this.getters.configFile)
                    .then((res) => {
                        console.log("update episode res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("update episode err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        deletepisode({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/episode/${data.id}`)
                    .then((res) => {
                        console.log("delete episode res :" + JSON.stringify(res));
                        resolve(err);
                    }).catch((err) => {
                        console.log("delete episode err :" + JSON.stringify(err));
                        reject(err);

                    });
            });
        },

        addServer({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                 let data = new FormData();
                 data.append("episode_id", dataObj.episode_id);
                 data.append("server_name", dataObj.name);
                 data.append("episode_link", dataObj.link);
                 data.append("server_type", dataObj.server_type);
                axios.post(this.getters.baseurl+'api/servers', data)
                    .then((res) => {
                        console.log("addD Server res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add Server err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        updateServer({
            commit
        }, dataObj) {
            return new Promise((resolve, reject) => {
                 let data = new FormData();
                 data.append("episode_id", dataObj.episode_id);
                 data.append("server_name", dataObj.server_name);
                 data.append("episode_link", dataObj.episode_link);
                 data.append("server_type", dataObj.server_type);
                axios.put(`api/servers/${data.id}`, data)
                    .then((res) => {
                        console.log("update servers res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("update servers err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        deleteServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/servers/${data.id}`)
                    .then((res) => {
                        console.log("servers res :" + JSON.stringify(res));
                        resolve(err);
                    }).catch((err) => {
                        console.log("servers err :" + JSON.stringify(err));
                        reject(err);

                    });
            });
        },
     addGroupType({
             commit
         }, dataObj) {
             return new Promise((resolve, reject) => {
                 let data = new FormData();
                 data.append('name', dataObj.name);
                 data.append('description', dataObj.description);
                 axios.post(this.getters.baseurl+'api/groupType', data)
                     .then((res) => {
                         console.log("addGroupType res :" + JSON.stringify(res));
                         resolve(res);
                     }).catch((err) => {
                         console.log("addGroupType err:" + JSON.stringify(err));
                         reject(err);
                     });
             });
         },
         updateGroupType({
             commit
         }, dataObj) {
             return new Promise((resolve, reject) => {
                 console.log("updateGroupType :" + JSON.stringify(dataObj));
           //      let data = new FormData();
            //     data.append('name', dataObj.name);
            //     data.append('description', dataObj.description);
                 axios.put(`api/groupType/${dataObj.id}`, dataObj)
                     .then((res) => {
                         console.log("updateGroupType res :" + JSON.stringify(res));
                         resolve(res);
                     }).catch((err) => {
                         console.log("updateGroupType err:" + JSON.stringify(err));
                         reject(err);
                     });
             });
         },
         deleteGroupType({
             commit
         }, data) {
             return new Promise((resolve, reject) => {
                 axios.delete(`api/groupType/${data.id}`)
                     .then((res) => {
                         console.log("deleteGroupType res :" + JSON.stringify(res));
                         resolve(err);
                     }).catch((err) => {
                         console.log("deleteGroupType err :" + JSON.stringify(err));
                         reject(err);

                     });
             });
         }
    },

     
    getters: {
       configFile(state){
           return state.configFile;
       },
       settings(state){
           return state.settings;
       }
    }
}
export default admin