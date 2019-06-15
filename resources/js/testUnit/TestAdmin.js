import Axios from "axios";

const TestAdmin = {
    state: {

    },
    mutations: {

    },
    actions: {
        testaddGroup({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/gorup', data)
                    .then((res) => {
                        console.log("add gorup res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add group err:" + JSON.stringify(err));
                        reject(err);
                    });
            });

        },
        testupdateGroup({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/gorup/${data.id}`, data)
                    .then((res) => {
                        console.log("updateGroup res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("updateGroup err:" + JSON.stringify(err));
                        reject(err);
                    });
            });

        },
        testdeleteGroup({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/group/${data.id}`)
                    .then((res) => {
                        console.log("delete group res :" + JSON.stringify(res));
                        resolve(err);
                    }).catch((err) => {
                        console.log("delete group err :" + JSON.stringify(err));
                        reject(err);

                    });
            });

        },
        testaddepisode({
            commit
        }, data) {

            return new Promise((resolve, reject) => {
                axios.post('api/episode', data)
                    .then((res) => {
                        console.log("add Episode res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add Episode err:" + JSON.stringify(err));
                        reject(err);
                    });
            });

        },
        testupdatepisode({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/episode/${data.id}`, data)
                    .then((res) => {
                        console.log("update episode res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("update episode err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testdeletepisode({
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
        testaddUploadServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/uploadServer', data)
                    .then((res) => {
                        console.log("add UploadServer res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("add UploadServer err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testupdateUploadServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/uploadServer/${data.id}`, data)
                    .then((res) => {
                        console.log("updateUploadServer res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("updateUploadServer err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testdeleteUploadServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/uploadServer/${data.id}`)
                    .then((res) => {
                        console.log("deleteUploadServer res :" + JSON.stringify(res));
                        resolve(err);
                    }).catch((err) => {
                        console.log("deleteUploadServer err :" + JSON.stringify(err));
                        reject(err);

                    });
            });
        },
        testaddDownloadServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/downloadsServer', data)
                    .then((res) => {
                        console.log("addDownloadServer res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("addDownloadServer err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testupdateDownloadServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/downloadsServer/${data.id}`, data)
                    .then((res) => {
                        console.log("updateDownloadServer res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("updateDownloadServer err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testdeleteDownloadServer({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.delete(`api/downloadsServer/${data.id}`)
                    .then((res) => {
                        console.log("deleteDownloadServer res :" + JSON.stringify(res));
                        resolve(err);
                    }).catch((err) => {
                        console.log("deleteDownloadServer err :" + JSON.stringify(err));
                        reject(err);

                    });
            });
        },
        testaddGroupType({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.post('api/groupType', data)
                    .then((res) => {
                        console.log("addGroupType res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("addGroupType err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testupdateGroupType({
            commit
        }, data) {
            return new Promise((resolve, reject) => {
                axios.put(`api/groupType/${data.id}`, data)
                    .then((res) => {
                        console.log("updateGroupType res :" + JSON.stringify(res));
                        resolve(res);
                    }).catch((err) => {
                        console.log("updateGroupType err:" + JSON.stringify(err));
                        reject(err);
                    });
            });
        },
        testdeleteGroupType({
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

    }
}
export default TestAdmin