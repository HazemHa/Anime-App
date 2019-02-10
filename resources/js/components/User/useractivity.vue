<template>
    
    <div>

      <v-alert v-if="episodes.length == 0 && groups.length == 0" :value="true" color="error" icon="warning">
        Sorry, nothing to display here :(
      </v-alert>  
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
       <v-flex v-for="anime in episodes" :key="anime.episode.id" xs3>
        <v-card dark color="secondary">
                <v-img
          :src="`${$store.getters.baseurl}storage/`+anime.episode.image"
          height="200px"
        >
        </v-img>
        <v-card-title primary-title>
          <div>
            <div class="headline">{{anime.episode.group.name}}<hr>({{anime.episode.number}})</div>
            <span class="grey--text">{{anime.episode.views}} views</span>
          </div>
        </v-card-title>
  <div class="text-xs-center" v-on:click="sendRating(anime.episode.meta.tmprating,anime.id)">
    <v-rating v-model="anime.episode.meta.tmprating"></v-rating>
  </div>
        <v-card-actions>
      <v-btn flat>Share</v-btn>
          <v-btn flat color="purple">Explore</v-btn>
          <v-spacer></v-spacer>
          <v-btn icon v-on:click="anime.episode.meta.tmpshow = !anime.episode.meta.tmpshow ">
            <v-icon>{{ anime.episode.meta.tmpshow  ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
          </v-btn>
        </v-card-actions>
        <v-slide-y-transition>
          <v-card-text v-show="anime.episode.meta.tmpshow ">
            {{anime.episode.description}}
          </v-card-text>
        </v-slide-y-transition>
        </v-card>
      </v-flex>



             <v-flex v-for="anime in groups" :key="anime.group.id" xs3>
        <v-card dark color="secondary">
                <v-img
          :src="`${$store.getters.baseurl}storage/`+anime.group.image"
          height="200px"
        >
        </v-img>
        <v-card-title primary-title>
          <div>
            <div class="headline">{{anime.group.groupTypeName.name}}</div>
            <span class="grey--text">{{anime.group.views}} views</span>
          </div>
        </v-card-title>
  <div class="text-xs-center" v-on:click="sendRating(anime.group.meta.tmprating,anime.id)">
    <v-rating v-model="anime.group.meta.tmprating"></v-rating>
  </div>
        <v-card-actions>
      <v-btn flat>Share</v-btn>
          <v-btn flat color="purple">Explore</v-btn>
          <v-spacer></v-spacer>
          <v-btn icon v-on:click="anime.group.meta.tmpshow = !anime.group.meta.tmpshow ">
            <v-icon>{{ anime.group.meta.tmpshow  ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
          </v-btn>
        </v-card-actions>
        <v-slide-y-transition>
          <v-card-text v-show="anime.group.meta.tmpshow ">
            {{anime.group.description}}
          </v-card-text>
        </v-slide-y-transition>
        </v-card>
      </v-flex>


  </v-layout>
        </v-container>
         </div>
</template>
<script>
export default {
  data: () => ({
    show: false,
    rating: 3,
    episodes: [],
    groups: []
  }),
  created() {
    this.$store.dispatch("loading", true);
  },
  mounted() {
    this.$store
      .dispatch("userActivity", this.$route.params)
      .then((res) => {
        this.$store.dispatch("loading", false);
        if (res.data.favorites) {
          res.data.favorites.forEach((element) => {
            if (element.episode) {
              //this is episodes data
              console.log("episode :" + JSON.stringify(element.episode.meta));
              this.episodes.push(element);
            } else if (element.group) {
              // this is groups data
              this.groups.push(element);
              //      console.log("Group :"+JSON.stringify(element.group))
            }
          });
        }




         if (res.data.likes) {
          res.data.likes.forEach((element) => {
            if (element.episode) {
              //this is episodes data
              console.log("episode :" + JSON.stringify(element.episode.meta));
              this.episodes.push(element);
            } else if (element.group) {
              // this is groups data
              this.groups.push(element);
              //      console.log("Group :"+JSON.stringify(element.group))
            }
          });
        }



         if (res.data.comments) {
          res.data.comments.forEach((element) => {
            if (element.episode) {
              //this is episodes data
              console.log("episode :" + JSON.stringify(element.episode.meta));
              this.episodes.push(element);
            } else if (element.group) {
              // this is groups data
              this.groups.push(element);
              //      console.log("Group :"+JSON.stringify(element.group))
            }
          });
        }

        console.log("episodes :" + JSON.stringify(res));
      })
      .catch((err) => {
        this.$toaster.error(
          "Something happened error, try again or contact the support"
        );

        this.$store.dispatch("loading", false);
      });
  },
  watch: {
    $route(to, from) {
      this.$store.dispatch("loading", true);
      this.episodes = [];
      this.groups = [];
      this.$store.dispatch("userActivity", to.params).then((res) => {
        this.$store.dispatch("loading", false);
        if (res.data.favorites) {
          res.data.favorites.forEach((element) => {
            if (element.episode) {
              this.episodes.push(element);
            } else if (element.group) {
              this.groups.push(element);
            }
          });
        }



         if (res.data.likes) {
          res.data.likes.forEach((element) => {
            if (element.episode) {
              this.episodes.push(element);
            } else if (element.group) {
              this.groups.push(element);
            }
          });
        }



         if (res.data.comments) {
          res.data.comments.forEach((element) => {
            if (element.episode) {
              this.episodes.push(element);
            } else if (element.group) {
              this.groups.push(element);
            }
          });
        }

      });
      /*  .catch((err) => {
          console.log("err it is :" + JSON.stringify(err));

          this.$toaster.error(
            "Something happened error, try again or contact the support"
          );

          this.$store.dispatch("loading", false);
        });*/
    }
  },
};
</script>

