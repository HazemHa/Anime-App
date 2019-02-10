<template>

    <v-list dense>
      <v-list-tile>
        <v-list-tile-action>
          <v-icon>home</v-icon>
        </v-list-tile-action>
        <v-list-tile-title>Home</v-list-tile-title>
      </v-list-tile>
      
          <v-list-tile
            v-for="(guser, i) in gUsers"
            :key="i"
             @click="LinkTo(guser[2],guser[3])"
          >
            <v-list-tile-title v-text="guser[0]"></v-list-tile-title>
            <v-list-tile-action>
              <v-icon v-text="guser[1]"></v-icon>
            </v-list-tile-action>
          </v-list-tile>
    </v-list>
</template>
<script>
import store from '../../store'
export default {
    props:['user_role'],
  data: () => ({
    gUsers: [
      ["Likes", "thumb_up","useractivity",{type:"likes"}],
      ["Fovrites", "favorite","useractivity",{type:"favorites"}],
      ["Comments", "comment","useractivity",{type:"comments"}],
      ["Notifications", "notifications","useractivity",{type:"notifications"}],
    ]
  }),
  methods:{
      LinkTo(route,params){
          this.$router.push({name:route,params: params});
      },

  }
};
</script>