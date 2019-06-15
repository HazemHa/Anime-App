<template>
  <v-container grid-list-md text-xs-center fluid>
    <v-layout row wrap>
      <v-flex xs12>
        <v-layout row wrap>
          <v-flex xs3 :key="index" v-for="(item, index) in this.episodeInfo.servers.upload">
            <v-card>
              <v-card-actions>
                <v-btn flat dark>{{item.server_name}}</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
        <v-divider></v-divider>

        <v-parallax height="550" src="https://cdn.vuetifyjs.com/images/parallax/material2.jpg"></v-parallax>
      </v-flex>
    </v-layout>

    <v-divider></v-divider>

    <v-layout row wrap>
      <v-flex xs2 :key="index" v-for="(item, index) in  this.episodeInfo.servers.download">
        <v-card>
          <v-card-actions>
            <v-btn flat dark>{{item.server_name}}</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>

    <v-divider></v-divider>
    <comments :comments="comments" Comment_type="ee"></comments>
  </v-container>
</template>
<script>
import comments from "./comments.vue";
export default {
  created() {
    Echo.channel("episode." + this.$route.params.id).listen(
      "CommentEvent",
      e => {
        let comment = {
          avatar: this.avatar(),
          name: e.data.name,
          body: e.data.content
        };
        //  this.comments.push( { divider: true, inset: true });
        this.comments.push(comment);
      }
    );

    this.$store
      .dispatch("DetialEpisode", this.$route.params.id)
      .then(res => {
        this.episodeInfo = this.$store.getters.detailEpisode.data;
      })
      .catch(err => {
        this.$toaster.error("something happened error try later.");
      });

    this.$store
      .dispatch("getCommentsEpisode", {
        params: "?id=" + this.$route.params.id + "&type=ee"
      })
      .then(res => {
        this.comments = res.data;
      })
      .catch(err => {
        this.$toaster.error("something happened error try later.");
      });
  },
  components: {
    comments: comments
  },
  methods: {
    avatar() {
      return this.$store.getters.user != "undifned"
        ? this.$store.getters.avatarUser
        : this.$store.getters.avatarPublic;
    }
  },
  data() {
    return {
      episodeInfo: { servers: { download: [], upload: [] } },
      items: [
        {
          action: "15 min",
          headline: "Brunch this weekend?",
          title: "Ali Connors",
          subtitle:
            "I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
        },
        {
          action: "2 hr",
          headline: "Summer BBQ",
          title: "me, Scrott, Jennifer",
          subtitle: "Wish I could come, but I'm out of town this weekend."
        },
        {
          action: "6 hr",
          headline: "Oui oui",
          title: "Sandra Adams",
          subtitle: "Do you have Paris recommendations? Have you ever been?"
        },
        {
          action: "12 hr",
          headline: "Birthday gift",
          title: "Trevor Hansen",
          subtitle:
            "Have any ideas about what we should get Heidi for her birthday?"
        },
        {
          action: "18hr",
          headline: "Recipe to try",
          title: "Britta Holt",
          subtitle:
            "We should eat this: Grate, Squash, Corn, and tomatillo Tacos."
        }
      ],
      comments: []
    };
  }
};
</script>
<style>
.scroll {
  overflow-y: auto;
}
</style>

