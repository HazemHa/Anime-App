<template>
    <v-list dense>
      <v-spacer></v-spacer>
          <v-list-tile
            v-for="(guser, i) in gUsers"
            :key="i"
            @click="LinkTo(guser[2])"
          >
            <v-list-tile-title v-text="guser[0]"></v-list-tile-title>
            <v-list-tile-action>
              <v-icon v-text="guser[1]"></v-icon>
            </v-list-tile-action>
          </v-list-tile>
    </v-list>
</template>
<script>
export default {
  data: () => ({
    gUsers: [
      ["Create Group", "add", "addgroup"],
      ["Create Episode", "add", "addepisode"],
      ["Update Groups", "update", "curdgroup"],
      ["Servers Episodes", "update", "curdservers"],
      ["Update Episodes", "update", "curdepisode"]
      
    ]
  }),
  methods:{
      LinkTo(route){
          this.$router.push({name:route});
      }
  }
};
</script>