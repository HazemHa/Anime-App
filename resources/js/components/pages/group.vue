<template>
<div>
  <v-container grid-list-md text-xs-center fluid>
    <v-layout f>

       <v-flex xs12>
            <v-card color="gray" class="white--text">
              <v-layout row>
                <v-flex xs7>
                  <v-card-title primary-title>
                    <div>
                      <div class="headline">{{this.infoGroup.groupTypeName.name}}</div>
                      <div class="headline">{{this.infoGroup.name}}</div>
                      <div>{{this.infoGroup.description}}</div>
                      <div>Views ({{this.infoGroup.views}})</div>
                    </div>
                  </v-card-title>
                </v-flex>
                <v-flex xs5>
                  <v-img
                    :src="this.$store.getters.baseurl+'storage/'+this.infoGroup.image"
                    height="175px"
                    contain
                  ></v-img>
                </v-flex>
              </v-layout>
              <v-divider light></v-divider>
              <v-card-actions class="pa-3">
                Rate this group
                <v-spacer></v-spacer>
                <span class="text-xs-center" v-on:click="sendRating(tmprating,this.infoGroup.id)" >
    <v-rating  v-model="tmprating"></v-rating>
  </span>
              </v-card-actions>
            </v-card>
          </v-flex>

    </v-layout>
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
    <v-rating  v-model="anime.meta.tmprating"></v-rating>
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
    last_page: 1,
    infoGroup: {
      id: 0,
      name: "",
      description: "",
      image: "default.png",
      views: 0,
      groupTypeName: {
        name: "",
        description: ""
      }
    },
    tmprating: 5,
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
        .dispatch("DetialGroup", this.$route.params.id)
        .then((res) => {
          this.episodes = this.$store.getters.detailGroup.data;
          this.infoGroup = this.episodes[0].group;
          

          this.pagination_links = this.$store.getters.detailGroup.links;
          this.pagination_meta = this.$store.getters.detailGroup.meta;

          this.current_page = this.pagination_meta.current_page;
          this.last_page = this.pagination_meta.last_page;
         
          this.$store.dispatch("loading", false);
        })
        .catch((err) => {
          this.$store.dispatch("loading", false);
          this.$toaster.error('something happened error try later.');
        });
    },
    sendRating(rating, idgroup) {
      let data = {
        id: idgroup,
        type: "gp",
        rating: rating
      };
      this.$store
        .dispatch("rating", data)
        .then((res) => {
          this.$toaster.success('rating done');

        })
        .catch((err) => {
          this.$toaster.error('something happened error try later.');

        //  console.log("err in rating :" + JSON.stringify(err));
        });
    },
    print(message) {
      alert(message);
    },
    detialEpisode(ep_id) {
      this.$router.push({ name: "watchEpisode", params: { id: ep_id } });
    },
    favoriate(value, idEpisode) {
      let data = {
        id: idEpisode,
        type: "ee"
      };

      if (value) {
        this.$store
          .dispatch("favorite", data)
          .then((res) => {
            
            this.$toaster.success('add to favorite done');
          })
          .catch((err) => {
            this.$toaster.error('something happened error try later.');
          });
      } else {
        this.$store
          .dispatch("unfovrite", data)
          .then((res) => {
           this.$toaster.success('unfovrite done');
          })
          .catch((err) => {
            this.$toaster.error('something happened error try later.');
          });
      }
    },
    print(value) {
      alert("value of episode :" + value);
    },
    like(value, idEpisode) {
      let data = {
        id: idEpisode,
        type: "ee"
      };
      if (value) {
        this.$store
          .dispatch("like", data)
          .then((res) => {
            this.$toaster.success('like done');
          })
          .catch((err) => {
            this.$toaster.error('something happened error try later.');
          });
      } else {
        this.$store
          .dispatch("unlike", data)
          .then((res) => {
            this.$toaster.success('unlike done');
          })
          .catch((err) => {
            this.$toaster.error('something happened error try later.');
          });
      }
    },
    fetchEpisode(page) {
      axios
        .get(
          this.$store.getters.baseurl +
            `api/detailGroup/${this.$route.params.id}?page=` +
            page
        )
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
    }
  }
};
</script>
<style>
.clickable {
  cursor: pointer;
}
</style>
