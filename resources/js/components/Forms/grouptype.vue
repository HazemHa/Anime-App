<template>
 <v-layout>
    <v-flex xs12 sm10 offset-sm1>
      <v-card>
          <form>

  <v-stepper v-model="e13" vertical>

    <v-stepper-step step="0" :rules="[()=>stepsValidation.get('name')]" :complete="step[0]">Name Group Type</v-stepper-step>

    <v-stepper-content step="0">
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
      <v-btn color="primary" @click="submit(1,false)">save</v-btn>
      <v-btn flat  @click="submit(0,false)">Cancel</v-btn>
    </v-stepper-content>
<!-- ()=>stepsValidation.get('description') |  -->
    <v-stepper-step :rules="[()=>stepsValidation.get('description')]" :complete="step[1]" step="1">
     Description
    </v-stepper-step>

    <v-stepper-content step="1">
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
      <v-btn color="primary" @click="submit(2,false)">save</v-btn>
      <v-btn flat @click="submit(0,false)">Cancel</v-btn>
    </v-stepper-content>

    <v-stepper-step step="2" :rules="[()=> true]" :complete="step[2]" >Done</v-stepper-step>

    <v-stepper-content step="2">
      <v-card color="grey lighten-1" class="mb-5" raised>
 <v-btn color="primary" @click="submit(0,true)">save</v-btn>
      <v-btn flat @click="submit(1,false)">Cancel</v-btn>
      </v-card>
     
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
    name: "",
    description: "",
    group_id: null,
    e13: "",
    stepsValidation: new Map([
      ["name", true],
      ["description", true],
    ]),
    step: [false, false],
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
          }else{
            this.stepsValidation.set('name', true);
            this.stepsValidation.set('description', true);
            let data = {
              name:this.name,
              description:this.description,
            };
            this.saveData(data);
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
      this.name = "";
      this.description = "";
      this.select = null;
      this.$validator.reset();
    },
    saveData(data){
       this.$store.dispatch('addGroupType',data).then((res)=>{
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
  }
};
</script>