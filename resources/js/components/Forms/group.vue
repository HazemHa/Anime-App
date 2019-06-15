<template>
 <v-layout>
    <v-flex xs12 sm10 offset-sm1>
      <v-card>
          <form>

  <v-stepper v-model="e13" vertical>
    <!-- ()=>stepsValidation.get('image') |  -->
    <v-stepper-step step="1" :rules="[()=>stepsValidation.get('image')]" :complete="step[1]">
      Upload Image
    </v-stepper-step>

    <v-stepper-content step="1">
      <v-card color="grey lighten-1" class="mb-5" raised>
        <image-input v-model="avatar" @input="ReceiveImage">
        <div slot="activator">
          <v-avatar v-validate="'required'"
      :error-messages="errors.collect('image')"
      label="Image"
      data-vv-name="image"
      required
      size="150px" v-ripple v-if="!avatar" class="grey lighten-3 mb-3">
             <span class="headline" style="color:#000000">Click to add avatar</span>
          </v-avatar>
          <v-avatar size="150px" v-ripple v-else class="mb-3">
            <img :src="avatar.imageURL" alt="avatar">
          </v-avatar>
        </div>
      </image-input>
      </v-card>
      <v-btn color="primary" @click="submit(2,false)">save</v-btn>
      <v-btn flat>Cancel</v-btn>
    </v-stepper-content>
<!-- ()=> |   -->

    <v-stepper-step step="2" :rules="[()=>stepsValidation.get('name')]" :complete="step[2]">Name Group</v-stepper-step>

    <v-stepper-content step="2">
      <v-card color="grey lighten-1" class="mb-5" raised>
           <v-text-field
      v-validate="'required|max:50'"
      v-model="name"
      :counter="50"
      :error-messages="errors.collect('name')"
      label="Name"
      data-vv-name="name"
      required
    ></v-text-field>
      </v-card>
      <v-btn color="primary" @click="submit(3,false)">save</v-btn>
      <v-btn flat  @click="submit(1,false)">Cancel</v-btn>
    </v-stepper-content>
<!-- ()=>stepsValidation.get('description') |  -->
    <v-stepper-step :rules="[()=>stepsValidation.get('description')]" :complete="step[3]" step="3">
      Group Description
      <small>Alert message</small>
    </v-stepper-step>

    <v-stepper-content step="3">
      <v-card color="grey lighten-1" class="mb-5" raised>
          <v-textarea
      v-validate="'required'"
      v-model="description"
      :error-messages="errors.collect('description')"
      label="Description"
      data-vv-name="description"
      required
    ></v-textarea>
      </v-card>
      <v-btn color="primary" @click="submit(4,false)">save</v-btn>
      <v-btn flat @click="submit(2,false)">Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step step="4" :rules="[()=>stepsValidation.get('group_type_id')]" :complete="step[4]" >
      Group Type</v-stepper-step>

    <v-stepper-content step="4">
      <v-card color="grey lighten-1" class="mb-5" raised>
         <v-select
      v-validate="'required'"
      :items="groups"
      v-model="group_id"
      item-text="name"
      item-value="id"
      return-object
      :error-messages="errors.collect('select')"
      label="Select"
      data-vv-name="group_type_id"
      required
    ></v-select>
   
      </v-card>
      <v-btn @click="submit(1,true)">Save All</v-btn>
      <v-btn flat @click="submit(3,false)">Back</v-btn>
          <v-btn @click="clear">Clear</v-btn>

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

Vue.use(VeeValidate);

export default {
  $_veeValidate: {
    validator: "new"
  },

  components: {
    ImageInput: ImageInput
  },

  data: () => ({
    avatar: null,
    saving: false,
    tempImageAsFile: null,
    name: "",
    description: "",
    group_id: null,
    e13: "",
    stepsValidation: new Map([
      ["image", true],
      ["name", true],
      ["description", true],
      ["group_type_id", true]
    ]),
    step: [false, false, false, false, false],
    groups: [{name:"Item 1",id:1}, {name:"Item 2",id:2}, {name:"Item 3",id:3}
    ,{name:"Item 4",id:4}]
  }),
  watch: {
    avatar: {
      handler: function() {
        this.saved = false;
      },
      deep: true
    },
    
  },

  mounted() {
    this.$validator.localize("en", this.dictionary);
  },

  methods: {
    submit(num_step, last_one) {
      if (last_one) {
        this.$validator.validateAll().then(() => {
          if (this.errors.items.length > 0) {
            this.errors.items.forEach((element) => {
              this.stepsValidation.set(element.field, false);
            });
          }
          else{
            let Group = {
              name:this.name,
              description:this.description,
              group_id:this.group_id.id,
              tempImageAsFile:this.tempImageAsFile
            }
            this.saveData(Group);
          }
        });
      } else {
        this.CheckFormStepisDone(num_step, last_one);
      }
    },
    CheckFormStepisDone(num_step, last_one) {
      if (!last_one) {
        this.step[num_step - 1] = true;
        this.e13 = num_step;
      }
    },
    clear() {
      this.avatar = null;
      this.name = "";
      this.description = "";
      this.group_id = null;
      this.$validator.reset();
    },
    uploadImage() {
      this.saving = true;
      setTimeout(() => this.savedAvatar(), 1000);
    },
    savedAvatar() {
      this.saving = false;
      this.saved = true;
    },
    saveData(dataObj){

  this.$store.dispatch('addGroup',dataObj).then((res)=>{
            if (res.data.success) {
            this.$toaster.success(res.data.success);
          } else if (res.data.error) {
            this.$toaster.error(res.data.error);
          }
            }) .catch((err) => {
         if (err.response.data.errors) {
             Object.values(err.response.data.errors).forEach((element) => {
                for (let index = 0; index < element.length; index++) {
                  this.$toaster.error(element[index]);
                }
              });
          }  else
            this.$toaster.error(
              "Something happened error, try again or contact the support"
            );
        });
    },
    ReceiveImage(file) {
      this.tempImageAsFile = file.file;
    },
  }
};
</script>