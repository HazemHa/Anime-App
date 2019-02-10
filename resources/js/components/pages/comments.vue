<template>
<div>



  
<v-layout row wrap>
   <v-list>
          <template v-for="(item, index) in comments">
            <v-subheader
              v-if="item.header"
              :key="item.header"
            >
              {{ item.header }}
            </v-subheader>

            <v-divider
              v-else-if="item.divider"
              :inset="item.inset"
              :key="index"
            ></v-divider>

            <v-list-tile
              v-else
              :key="item.id"
              avatar
              @click=""
            >
              <v-list-tile-avatar>
                <img :src="imageUser()">
              </v-list-tile-avatar>

              <v-list-tile-content>
                <v-list-tile-title v-html="$store.getters.isAuth?item.user.name:item.name"></v-list-tile-title>
                <v-list-tile-sub-title v-html="item.body"></v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>
        </v-list>
</v-layout>
 <v-divider></v-divider>
<v-layout justify-end row wrap>
   <v-avatar>
               <img
               :src="imageUser()"
               :alt="this.name"
             >
         </v-avatar>
<v-flex xs-4 align-self-end>
      <v-textarea
          name="input-7-1"
          label="Comment"
          v-model="comment"
        ></v-textarea>
        <v-btn depressed small color="primary" @click="Addomment">comment</v-btn>
 </v-flex>
         <v-flex align-self-center align-self-end xs-2>
     
 </v-flex>
</v-layout>
</div>

</template>
<script>
export default {
    props:['comments','Comment_type'],
    created() {
      this.item_id = this.$route.params.id;
      this.name = this.$store.getters.isAuth?this.$store.getters.user.name:'Anonymous';
    },
   
    methods:{
      Addomment(){
     let data = this.commentData();
     this.comment = '';
       this.$store.dispatch('comment',data)
       .then((res)=>{
        
       }).catch((err)=>{
      this.$toaster.error('something happened error try later.');
       })
      },
       updateComment(){
         let data = this.commentData();
       this.$store.dispatch('updateComment',data)
       .then((res)=>{
       }).catch((err)=>{
         this.$toaster.error('something happened error try later.');
       })
      }
      , removeComment(){
        let data = this.commentData();
       this.$store.dispatch('uncomment',data)
       .then((res)=>{
       }).catch((err)=>{
          this.$toaster.error('something happened error try later.');
       })
      },
      commentData(){
        return {id:this.item_id,body:this.comment,type:this.Comment_type,name:this.name};
      },
      imageUser(){
        if(this.$store.getters.isAuth){
        return this.$store.getters.avatarUser;

        }else{
        return this.$store.getters.avatarPublic;

        }
      }
    },
    data(){
      return {
        comment:'',
        item_id:0,
        name:'Anonymous',
        
      }
    },
 
}
</script>
