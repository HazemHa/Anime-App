<template>
 <v-layout>
    <v-flex xs12 sm10 offset-sm1>
      <v-card>
          <form>

    <v-stepper v-model="e13" vertical>
    <v-stepper-step step="0" :rules="[()=>step[0]]" :complete="step[0]">
     Episode Info
     <small>public inforamtion aobut episode</small>
    </v-stepper-step>

    <v-stepper-content step="0">
      <v-card  class="mb-5" raised>
        <image-input v-model="avatar" @input="ReceiveImage">
        <div slot="activator">
          <v-avatar size="150px" v-ripple v-if="!avatar" class="grey lighten-3 mb-3">
             <span class="headline" style="color:#000000">Click to add avatar</span>
          </v-avatar>
          <v-avatar size="150px" v-ripple v-else class="mb-3">
            <img :src="avatar.imageURL" alt="avatar">
          </v-avatar>
        </div>
      </image-input>
      <v-slide-x-transition>
        <div v-if="avatar && saved == false">
          <v-btn class="primary" @click="uploadImage" :loading="saving">Save Avatar</v-btn>
        </div>
      </v-slide-x-transition>


     <v-text-field
      v-validate="'required'"
      v-model="number"
      :error-messages="errors.collect('number')"
      label="Number"
      data-vv-name="number"
      required
    ></v-text-field>
    <v-textarea
      v-validate="'required'"
      v-model="description"
      :error-messages="errors.collect('description')"
      label="Description"
      data-vv-name="description"
      required
    ></v-textarea>
    <v-select
      v-validate="'required'"
      :items="groups"
       item-text="name"
        item-value="id"
      v-model="group_id"
      :error-messages="errors.collect('group_id')"
      label="Group"
      data-vv-name="group_id"
      return-object
      required
    ></v-select>
    <v-btn @click="submit(1,false)">Save</v-btn>
    <v-btn @click="clear">clear</v-btn>
      </v-card>
    </v-stepper-content>

    <v-stepper-step step="1"  :rules="[()=>step[1]]" :complete="step[1]">
      Downloads Server
      <small>links for episode user can download it </small>

      </v-stepper-step>

    <v-stepper-content step="1">
      <v-card color="grey lighten-1" class="mb-5" raised>
        <dwonloads-server props_step="2" server_type="download" v-on:stepDone="AcceptServer"></dwonloads-server>
        <!-- return array of objects -->
      </v-card>
    </v-stepper-content>

    <v-stepper-step  step="2"  :rules="[()=>step[2]]" :complete="step[2]">
      Online Watch
      <small>links for episode user can watch online</small>
    </v-stepper-step>

    <v-stepper-content step="2">
      <v-card color="grey lighten-1" class="mb-5" raised>
         <upload-server props_step="3" server_type="upload" v-on:stepDone="AcceptServer"></upload-server>
          <!-- return array of objects -->
      </v-card>
    </v-stepper-content>

    <v-stepper-step step="3"  :rules="[()=>step[3]]" :complete="step[3]">Done</v-stepper-step>

    <v-stepper-content step="3" >
          <v-btn @click="submit(3,true)">Save All</v-btn>
          <v-btn @click="clear">clear</v-btn>
           <v-btn @click="submit(0,false)">Back</v-btn>
    </v-stepper-content>
  </v-stepper>
 
  </form>

        </v-card>
    </v-flex>
  </v-layout>
</template>
<script>
import Vue from "vue";
import VeeValidate from "vee-validate";
import ImageInput from "../Image/ImageInput.vue";
import DwonloadsServer from "./server-external.vue";
import UploadServer from "./server-external.vue";

Vue.use(VeeValidate);

export default {
  $_veeValidate: {
    validator: "new"
  },
  components: {
    ImageInput: ImageInput,
    DwonloadsServer: DwonloadsServer,
    UploadServer: UploadServer,
  },
  watch: {
    avatar: {
      handler: function() {
        this.saved = false;
      },
      deep: true
    },
    step: {
      handler: function() {},
      deep: true
    }
  },

  data: () => ({
    avatar: null,
    saving: false,
    saved: false,
    tempImageAsFile: null,
    e13: 0,
    number: "",
    description: "",
    group_id: null,
    groups: [{ name: "name", id: 1 }, { name: "name2", id: 2 }],
    step: [false, false, false, false],
    downlondsServer: [],
    uploadsServer: [],
    episode_added: 0
  }),

  mounted() {
    this.$validator.localize("en", this.dictionary);
  },

  methods: {
    CheckFormStepisDone(num_step, last_one) {
      if (!last_one) {
        this.step[num_step - 1] = true;
        this.e13 = num_step;
      }
    },
    AcceptServer: function(step, obj, type) {
      if (type == "upload") {
        this.uploadsServer = obj;
      } else if (type == "download") {
        this.downlondsServer = obj;
      }
      if (step == this.step.length - 1) {
        this.step[step] = true;
      }
      this.CheckFormStepisDone(step, false);
    },
    submit(num_step, last_one) {
      // tempImageAsFile
      if (last_one) {
        this.$validator.validateAll().then(() => {
          if (this.errors.items.length > 0) {
          } else {
            let data = {
              number: this.number,
              description: this.description,
              group_id: this.group_id.id,
              tempImageAsFile: this.tempImageAsFile
            };
            this.saveEpisode(data);
          }
        });
      } else {
        this.CheckFormStepisDone(num_step, last_one);
      }
    },
    saveEpisodeOnly() {
      let data = {
        number: this.number,
        description: this.description,
        group_id: this.group_id.id,
        tempImageAsFile: this.tempImageAsFile
      };
      this.saveEpisode(data);
    },
    clear() {
      this.name = "";
      this.email = "";
      this.select = null;
      this.checkbox = null;
      this.$validator.reset();
    },
    saveEpisode(data) {
      this.$store
        .dispatch("addepisode", data)
        .then((res) => {
           if (res.data.success) {
            this.$toaster.info(
            "basic info for episode added waiting to add servers",
            { timeout: 8000 }
          );
          } else if (res.data.error) {
            this.$toaster.error(res.data.error);
          }
          let episodeID = res.data.episode_id;

          if (episodeID != null) {
            this.downlondsServer.forEach((server) => {
              server.episode_id = episodeID;
              this.$store
                .dispatch("addServer", server)
                .then((res) => {
                  this.$toaster.info("download server added :" + server.name, {
                    timeout: 5000
                  });
                })
                .catch((err) => {
                  if (err.response.data.errors) {
                    Object.values(err.response.data.errors).forEach(
                      (element) => {
                        for (let index = 0; index < element.length; index++) {
                          this.$toaster.error(element[index]);
                        }
                      }
                    );
                  } else
                    this.$toaster.error(
                      "Something happened error, try again or contact the support"
                    );
                });
            });

            this.uploadsServer.forEach((server) => {
              server.episode_id = episodeID;
              this.$store
                .dispatch("addServer", server)
                .then((res) => {
                  this.$toaster.info(
                    "Upload server(Online Watch) added :" + server.name,
                    { timeout: 5000 }
                  );
                })
                .catch((err) => {
                  if (err.response.data.errors) {
                    Object.values(err.response.data.errors).forEach(
                      (element) => {
                        for (let index = 0; index < element.length; index++) {
                          this.$toaster.error(element[index]);
                        }
                      }
                    );
                  } else
                    this.$toaster.error(
                      "Something happened error, try again or contact the support"
                    );
                });
            });
          }else{
            this.$toaster.error(
              "Episode not added"
            );
          }
        })
        .catch((err) => {
          if (err.response.data.errors) {

            Object.values(err.response.data.errors).forEach((element) => {
              for (let index = 0; index < element.length; index++) {
                this.$toaster.error(element[index]);
              }
            });
          } else
            this.$toaster.error(
              "Something happened error, try again or contact the support"
            );
        });
    },
    uploadImage() {
      this.saving = true;
      setTimeout(() => this.savedAvatar(), 1000);
    },
    savedAvatar() {
      this.saving = false;
      this.saved = true;
    },
    ReceiveImage(file) {
      this.tempImageAsFile = file.file;
    }
  }
};
</script>