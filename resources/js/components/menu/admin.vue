<template>
    <v-list dense>
     <v-spacer></v-spacer>
          <v-list-tile
            v-for="(admin, i) in admins"
            :key="i"
            @click="LinkTo(admin[2])"
          >
         
            <v-list-tile-title v-text="admin[0]"></v-list-tile-title>
       
            <v-list-tile-action>
              <v-icon v-text="admin[1]"></v-icon>
            </v-list-tile-action>
          
          </v-list-tile>
    </v-list>
</template>
<script>
export default {
  data: () => ({
    admins: [
      ["Create Group Type", "add","addgoruptype"],
      ["Update Group Types", "update","curdgoruptype"],
      ["Management", "people_outline","management"],
      ["Settings", "settings","curdsetting"],
    ]
  }),
  methods:{
      LinkTo(route){         
          this.$router.push({name:route});
      }
  }
};
</script>