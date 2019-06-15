<template>
  <div>
    <v-toolbar flat color="black">
      <v-toolbar-title>My CRUD</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md4>
                
                
                <image-input v-model="avatar"  @input="ReceiveImage">
        <div slot="activator">
          <v-avatar v-validate="'required'"
      :error-messages="errors.collect('image')"
      label="Image"
      data-vv-name="image"
      required
      size="150px" v-ripple v-if="!avatar" class="grey lighten-3 mb-3">
             <span class="headline" style="color:#000000">Click to add avatar</span>
          </v-avatar>
          <v-avatar size="150px" v-ripple v-else class="mb-3">
            <img :src="avatar.imageURL" alt="avatar">
          </v-avatar>
        </div>
      </image-input>


                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-select
      v-validate="'required'"
      :items="groups"
       item-text="name"
      item-value="id"
      return-object
      v-model="editedItem.grouptype"
      :error-messages="errors.collect('select')"
      label="Select"
      data-vv-name="group_type_id"
      required
    ></v-select>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.writtenBy" label="Written By"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-textarea v-model="editedItem.description" label="Description"></v-textarea>
                </v-flex>

              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
            <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="desserts"
       :search="search"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td class="text-xs-right">{{ props.item.grouptype }}</td>
        <td>
          <v-avatar
          color="grey lighten-4"
        >
          <img :src="props.item.image.imageURL" alt="avatar">
        </v-avatar>

          </td>
        <td class="text-xs-right">{{ props.item.writtenBy }}</td>
        <td class="text-xs-right">{{ props.item.description }}</td>
        <td class="text-xs-right">{{ props.item.name }}</td>
         <td class="text-xs-right">  <v-rating small v-model="props.item.rating"></v-rating></td>
        <td class="justify-center layout px-0">
          <v-icon
            small
            class="mr-2"
            @click="editItem(props.item)"
          >
            edit
          </v-icon>
          <v-icon
            small
            @click="deleteItem(props.item)"
          >
            delete
          </v-icon>
        </td>
      </template>
     <template slot="no-data">
      <v-alert :value="true" color="error" icon="warning">
        Sorry, nothing to display here :(
      </v-alert>

      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </template>
    </v-data-table>
  </div>
</template>
<script>
import Vue from "vue";
import VeeValidate from "vee-validate";
import ImageInput from "../Image/ImageInput.vue";

Vue.use(VeeValidate);

export default {
  $_veeValidate: {
    validator: "new"
  },

  components: {
    ImageInput: ImageInput
  },
  data: () => ({
    dialog: false,
    avatar: null,
    tempImageAsFile: null,
    tempImageEdited: null,
    saving: false,
    search: "",

    groups: [
      { name: "Item 1", id: 1 },
      { name: "Item 2", id: 2 },
      { name: "Item 3", id: 3 }
    ],
    headers: [
      {
        text: "Group Type",
        align: "left",
        sortable: false,
        value: "name"
      },
      { text: "Image", value: "image", sortable: false },
      { text: "Written By", value: "writtenBy", sortable: false },
      { text: "Description", value: "description", sortable: false },
      { text: "Name", value: "name", sortable: false },
      { text: "Rating", value: "rating" },
      { text: "Actions", value: "name", sortable: false }
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      id: 2,
      image: { imageURL: "" },
      description: "",
      name: 0,
      grouptype: 2,
      writtenBy: ""
    },
    defaultItem: {
      id: 2,
      image: { imageURL: "" },
      description: "",
      name: 0,
      grouptype: 4,
      writtenBy: ""
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },
  mounted() {
    this.$validator.localize("en", this.dictionary);
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    avatar: {
      handler: function() {
        this.saved = false;
      },
      deep: true
    }
  },

  created() {
  },

  methods: {
    uploadImage() {
      this.saving = true;
      setTimeout(() => this.savedAvatar(), 1000);
    },
    savedAvatar() {
      this.saving = false;
      this.saved = true;
    },
    editItem(item) {
      this.avatar = item.image;
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.desserts.indexOf(item);
      if (confirm("Are you sure you want to delete this item?")) {
        this.desserts.splice(index, 1);
        console.log("delete this item :" + this.desserts[index].id);
        let data = {
          id: this.desserts[index].id
        };
        this.$store
          .dispatch("deleteGroup", data)
          .then((res) => {
            if(res.data.success){
          this.$toaster.success(res.data.success)
        }else if(res.data.error){
         this.$toaster.error(res.data.error);
      
        }
          })
          .catch((err) => {
            this.$toaster.error(
              "Something happened error, try again or contact the support"
            );
          });
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      this.$validator.validateAll().then(() => {
        if (this.errors.items.length > 0) {
          this.errors.items.forEach((element) => {});
        } else {
          this.editedItem.image.imageURL = this.tempImageEdited;
          let groupEdit = {
            id: this.editedItem.id,
            name: this.editedItem.name,
            description: this.editedItem.description,
            tempImageAsFile: this.tempImageAsFile,
            group_type_id: this.editedItem.grouptype.id
          };
          this.saveData(groupEdit);
        }
      });

      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },
    ReceiveImage(file) {
      this.tempImageAsFile = file.file;
      this.tempImageEdited = file.imageURL;
      console.log("tempImageEdited :" + this.tempImageEdited);
    },
    saveData(data) {
      this.$store
        .dispatch("updateGroup", data)
        .then((res) => {
          if (res.data.success) {
            this.$toaster.success(res.data.success);
          } else if (res.data.error) {
            this.$toaster.error(res.data.error);
          }
        })
        .catch((err) => {
         if (err.response.data.errors) {
             Object.values(err.response.data.errors).forEach((element) => {
                for (let index = 0; index < element.length; index++) {
                  this.$toaster.error(element[index]);
                }
              });
          }  else
            this.$toaster.error(
              "Something happened error, try again or contact the support"
            );
        });
    }
  }
};
</script>