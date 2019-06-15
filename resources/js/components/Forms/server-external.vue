<template>
<div>
  <ul id="example-1">
 
     <li v-for="item in items">
   
    <v-text-field
      v-validate="'required'"
      v-model="item.name"
      :error-messages="errors.collect('server_name')"
      label="server_name"
      data-vv-name="server_name"
      required
    ></v-text-field>
    <v-text-field
      v-validate="'required'"
      v-model="item.link"
      :error-messages="errors.collect('episode_link')"
      label="episode_link"
      data-vv-name="episode_link"
      required
    ></v-text-field>
   
  </li>
</ul>
    <v-btn @click="submit">save</v-btn>
    <v-btn @click="AddNewServer">Add Server</v-btn>
    <v-btn @click="clear">Remove last one</v-btn>
    </div>
</template>
<script>
import Vue from 'vue'
  import VeeValidate from 'vee-validate'

  Vue.use(VeeValidate)

  export default {
    props:['episode_id','props_step','server_type'],
    $_veeValidate: {
      validator: 'new'
    },

    data: () => ({
      items:[{name:'',link:'',server_type:''}],
      server_name: '',
      episode_link: '',
      step:'',
    }),
    created() {
      this.step = this.props_step;
      this.items[0].server_type = this.server_type;
    },

    mounted () {
      this.$validator.localize('en', this.dictionary)
    },

    methods: {
      submit () {
        this.$validator.validateAll()
  .then(() => {
    if(this.errors.items.length > 0);
      else{this.$emit('stepDone', this.step,this.items,this.server_type);}
      })
      },
      clear () {
        this.items.pop();
        this.checkbox = null
        this.$validator.reset()
      },
      AddNewServer(){
         this.items.push({name:'',link:'',server_type:this.server_type});
      }
    }
  }
  
</script>