<template>
  <form>
    <v-textarea
      v-validate="'required'"
      v-model="body"
      :error-messages="errors.collect('body')"
      label="Content"
      data-vv-name="body"
      required
    ></v-textarea>
    
    <v-btn @click="submit" @keydown.enter="submit">Notify</v-btn>
  </form>
</template>
<script>
import VeeValidate from "vee-validate";

Vue.use(VeeValidate);

export default {
  props: ["receiver_id"],
  $_veeValidate: {
    validator: "new"
  },

  data: () => ({
    body: "",
    dictionary: {
      custom: {
        body: {
          required: () => "body can not be empty",
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