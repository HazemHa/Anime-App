<template>
<div>
          <section>
          <v-parallax
    dark
    :src="`${$store.getters.baseurl}storage/`+lastItem.image"
    height="500"

  >
          <v-layout
            column
            align-center
            justify-center
            class="white--text"
          >
            <h1 class="white--text mb-2 display-1 text-xs-center">{{lastItem.group.name}}</h1>
            <div class="subheading mb-3 text-xs-center">{{lastItem.description}}<hr>{{lastItem.number}}</div>
            <v-btn
              class="blue lighten-2 mt-5"
              dark
              large
              href="/pre-made-themes"
            >
              Get Started
            </v-btn>
          </v-layout>
        </v-parallax>
      </section>



  <v-container grid-list-md text-xs-center>
    <div class="text-xs-center">
    <v-pagination
      v-model="this.current_page"
      :length="this.last_page"
      total-visible = "7"
      @input="this.onPageChange"
      circle
    ></v-pagination>
  </div>
    <v-layout row wrap>
      
<v-flex v-for="anime in episodes" :key="anime.id" xs3>
        <v-card dark color="secondary">
          <div  class="clickable" @click="detialEpisode(anime.id)">
                <v-img
          :src="`${$store.getters.baseurl}storage/`+anime.image"
          height="200px"
        >
        </v-img>
        <v-card-title primary-title>
          <div>
            <div class="headline">{{anime.group.name}}<hr>({{anime.number}})</div>
            <span class="grey--text">{{anime.views}} views</span>
          </div>
        </v-card-title>
        </div>
        <span class="text-xs-center" v-on:click="sendRating(anime.meta.tmprating,anime.id)" >
    <v-rating  v-model="anime.meta.tmprating" @click="alert('hello world')">
    </v-rating>
      </span>

        <v-card-actions>
          <v-flex xs12 sm3 v-on:click="favoriate(anime.meta.favorite,anime.id); anime.meta.favorite = !anime.meta.favorite">
            <v-btn flat icon :color="!anime.meta.favorite?'pink':'gray'">
              <v-icon>favorite</v-icon>
            </v-btn>
             </v-flex>
          <v-flex xs12 sm3  v-on:click="like(anime.meta.like,anime.id);anime.meta.like  = !anime.meta.like">
             <v-btn flat icon  :color="!anime.meta.like?'deep-orange':'gray'">
              <v-icon>thumb_up</v-icon>
            </v-btn>
             </v-flex>
           
      <v-btn flat>Share</v-btn>
          <v-btn flat color="purple" v-on:click="anime.meta.tmpshow = !anime.meta.tmpshow ">Explore</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>

        <v-slide-y-transition>
          <v-card-text v-show="anime.meta.tmpshow ">
              {{anime.description}}
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
    current_page: 1,
    vmRating: null,
    last_page: 1,
    episodes: [],
    lastItem: {
      image: "default.png",
      name: "",
      description: "",
      group: { name: "" }
    },
    rating: 5,
    desserts: [],
    pagination_links: {
      first: "",
      last: "",
      prev: null,
      next: ""
    },
    pagination_meta: {
      current_page: 1,
      from: 1,
      last_page: 1,
      path: "",
      per_page: 1,
      to: 1,
      total: 1
    }
  }),
  created() {
    this.vmRating = this;
    this.loadingData();
  },
  methods: {
    onPageChange(page) {
      this.$store.dispatch("loading", true);
      this.current_page = page;
      this.fetchEpisode(this.current_page);
    },
    loadingData() {
      this.$store
        .dispatch("getEpisodes")
        .then((res) => {
          this.episodes = this.$store.getters.episodes.data;
          this.pagination_links = this.$store.getters.episodes.links;
          this.pagination_meta = this.$store.getters.episodes.meta;

          this.current_page = this.pagination_meta.current_page;
          this.last_page = this.pagination_meta.last_page;
          this.$store.dispatch("loading", false);
        })
        .catch((err) => {
          this.$store.dispatch("loading", false);
        });

      this.$store
        .dispatch("getGroups")
        .then((res) => {
          this.$store.getters.groups = res.data;
        })
        .catch((err) => {});

      this.$store
        .dispatch("getGroupTypes")
        .then((res) => {
          this.$store.getters.groupstype = res.data;
        })
        .catch((err) => {});
    },
    sendRating(rating, idEpisode) {
       if(this.havePermession()){
      setTimeout(() => {
        let data = {
          id: idEpisode,
          type: "ee",
          rating: rating
        };
        this.$store
          .dispatch("rating", data)
          .then((res) => {
            if (res.data.success) {
              this.$toaster.success(res.data.success);
            } else if (res.data.error) {
              this.$toaster.error(res.data.error);
            }
          })
          .catch((err) => {
            this.showErrorMessage("rating");
          });
      }, 500);
       }
    },
    print(message) {
      alert(message);
    },
    detialEpisode(ep_id) {
      this.$router.push({ name: "watchEpisode", params: { id: ep_id } });
    },
    favoriate(value, idEpisode) {
       if(this.havePermession()){
      let data = {
        id: idEpisode,
        type: "ee"
      };

      if (value) {
        this.$store
          .dispatch("favorite", data)
          .then((res) => {
            if (res.data.success) {
              this.$toaster.success(res.data.success);
            } else if (res.data.error) {
              this.$toaster.error(res.data.error);
            }
          })
          .catch((err) => {
            this.showErrorMessage("favorite");
          });
      } else {
        this.$store
          .dispatch("unfovrite", data)
          .then((res) => {
            if (res.data.success) {
              this.$toaster.success(res.data.success);
            } else if (res.data.error) {
              this.$toaster.error(res.data.error);
            }
          })
          .catch((err) => {
            this.showErrorMessage("unfovrite");
          });
      }
       }
    },
    print(value) {
      alert("value of episode :" + value);
    },
    like(value, idEpisode) {
      if(this.havePermession()){
      let data = {
        id: idEpisode,
        type: "ee"
      };
      if (value) {
        this.$store
          .dispatch("like", data)
          .then((res) => {
            if (res.data.success) {
              this.$toaster.success(res.data.success);
            } else if (res.data.error) {
              this.$toaster.error(res.data.error);
            }
          })
          .catch((err) => {
            this.showErrorMessage("like");
          });
      } else {
        this.$store
          .dispatch("unlike", data)
          .then((res) => {
            if (res.data.success) {
              this.$toaster.success(res.data.success);
            } else if (res.data.error) {
              this.$toaster.error(res.data.error);
            }
          })
          .catch((err) => {
            this.showErrorMessage("unlike");
          });
      }
      }
    },
    fetchEpisode(page) {
      axios
        .get(this.$store.getters.baseurl + "api/episode?page=" + page)
        .then((response) => {
          this.episodes = response.data.data;
          this.pagination_links = response.data.links;
          this.pagination_meta = response.data.meta;

          this.current_page = this.pagination_meta.current_page;
          this.last_page = this.pagination_meta.last_page;
          this.$store.dispatch("loading", false);
        })
        .catch((error) => {
          this.$store.dispatch("loading", false);
        });
    },
    havePermession() {
      if (this.$store.getters.isAuth) {
        return true;
      }
      this.$toaster.info("You must register to do this action");
      return false;
    },
    showErrorMessage(content) {
      this.$toaster.error(
        "(" + content + ") something happened error try later."
      );
    }
  },
  mounted() {
    //get last episode
    this.$store
      .dispatch("lastItem")
      .then((res) => {
        this.lastItem = res.data.data;
      })
      .catch((err) => {});

    this.$store
      .dispatch("lastEpisodes")
      .then((res) => {
        //  console.log("last episodes  :" + JSON.stringify(res));
        //     this.episodes = res.data;
      })
      .catch((err) => {});
  }
};
</script>
<style>
.clickable {
  cursor: pointer;
}
</style>
