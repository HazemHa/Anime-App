<template>
  <v-app id="inspire" dark>

    <v-navigation-drawer
      v-model="drawer"
      clipped
      fixed
      app
    >
       <nuser-menu v-show="this.$store.getters.menus.nuser"></nuser-menu>
       <guser-menu v-show="this.$store.getters.menus.guser"></guser-menu>
       <admin-menu v-show="this.$store.getters.menus.admin"></admin-menu>
    </v-navigation-drawer>
    <v-toolbar app fixed clipped-left>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title><router-link :to="{ name: 'home'}"  tag="button">Application</router-link></v-toolbar-title>
      <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-xs-and-down">
     <div v-if="!this.$store.getters.isAuth">
      <router-link :to="{ name: 'login'}"><v-btn flat >Login</v-btn></router-link>
     <router-link :to="{ name: 'register'}"> <v-btn flat>Register</v-btn></router-link>
      </div>
      <div v-else>
         <v-menu open-on-hover top offset-y>
         <v-avatar slot="activator">
      <img
        :src="imguser"
        :alt="name"
      >
    </v-avatar>
 <v-card v-if="this.$store.getters.isAuth"> 
     <v-list>
        <v-list-tile>
          <v-list-tile-title> 
            <router-link :to="{ name: 'profile'}"  tag="button">
       profile
       </router-link>
       </v-list-tile-title> 
        </v-list-tile>
         <v-list-tile>
         <v-list-tile-title  @click="logout">logout</v-list-tile-title>
        </v-list-tile>
      </v-list>
       </v-card>
     </v-menu>
    
      </div>
    </v-toolbar-items>
    </v-toolbar>

    <v-content>

        <div class="text-xs-center" v-if="this.$store.getters.isloading">

             <v-progress-circular
      :size="70"
      :width="7"
      color="purple"
      indeterminate
    ></v-progress-circular>
    </div>
    
          <router-view v-show="!this.$store.getters.isloading"></router-view>
    </v-content>
    <v-footer app fixed>
      <span>&copy; 2017</span>
    </v-footer>
  </v-app>
</template>
<script>
import AdminMenu from "../js/components/menu/admin.vue";
import GuserMenu from "../js/components/menu/goldenUser.vue";
import NuserMenu from "../js/components/menu/normalUser.vue";

export default {
  props: ["user_role"],
  components: {
    AdminMenu: AdminMenu,
    GuserMenu: GuserMenu,
    NuserMenu: NuserMenu
  },
  data: () => ({
    drawer: false,
   
  }),
  props: {
    source: String
  },
  created() {
    
    this.reloadUserInfo();
    this.loadingData();
    this.role_id = this.user_role;
    this.$store.dispatch('checkRole');

  },
  methods: {
    loadingData(){
      // loading episodes
      //loading gorups
      // loading likes
      // loding favorites
      //loading comments of user
      //loading gorup type
    },
    reloadUserInfo(){      
      this.$store.dispatch('userInfo')
      .then((res)=>{
         this.$store.dispatch('loading',false);
        //this.$router.push('/')
      })
      .catch((err)=>{
        this.$store.dispatch('loading',false);
        this.$router.push({name:'login'});
      });
    },
    logout(){
         this.$store.dispatch('logout')
         .then((res)=>{
           this.$store.dispatch('loading',false);
           this.$router.push({name:'home'})

         }).catch((err)=>{

         });
    },
    isAuth() {
      return this.role_id != 0;
    }
  },
  computed:{
    name:function (){
      return this.$store.getters.user.name;
    },
    imguser:function (){
      return this.$store.getters.avatarUser;
    }
  }
};
</script>
<style lang="stylus" scoped>
  .v-progress-circular
    margin: 1rem
</style>