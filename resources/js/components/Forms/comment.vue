<template>
 <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
     
      <v-flex xs10>
  <form>
   
    <v-textarea
      v-validate="'required'"
      v-model="comment"
      :error-messages="errors.collect('comment')"
      label="comment"
      data-vv-name="comment"
      required
    ></v-textarea>
    
    <v-btn @click="submit" @keydown.enter="submit">Comment</v-btn>
  </form>
      </v-flex>
        <v-flex xs2>
          <v-avatar color="red">
      <span class="white--text headline">J</span>
    </v-avatar>
       </v-flex>
        </v-layout>
  </v-container>
</template>
<script>
import Vue from 'vue';
import VeeValidate from "vee-validate";

Vue.use(VeeValidate);

export default {
  props: ["comments","comment_id", "comment_type"],
  $_veeValidate: {
    validator: "new"
  },

  data: () => ({
    comment: "",
    dictionary: {
      custom: {
        comment: {
          required: () => "comment can not be empty",
        }
      }
    }
  }),

  mounted() {
    this.$validator.localize("en", this.dictionary);
  },

  methods: {
    submit() {
      this.$validator.validateAll();
    },
    clear() {
      this.name = "";
      this.$validator.reset();
    }
  }
};
</script>