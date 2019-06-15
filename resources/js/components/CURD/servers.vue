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
        <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
      
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md4>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.episodeName" label="Episode Name"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.episodeNumber" label="Episode Number"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                   <v-select
          :items="serverTypeItem"
          label="Standard"
        ></v-select>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.serverName" label="Server Name"></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.serverLink" label="Server Link"></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md4>
                     <v-checkbox label="Valid" required></v-checkbox>

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
        <td class="text-xs-right">
             <v-avatar
          color="grey lighten-4"
        >
          <img :src="props.item.Image" alt="avatar">
        </v-avatar>

          </td>
        <td class="text-xs-right">{{ props.item.episodeName }}</td>
        <td class="text-xs-right">{{ props.item.episodeNumber }}</td>
        <td class="text-xs-right">{{ props.item.serverType }}</td>
        <td class="text-xs-right">{{ props.item.serverName }}</td>
        <td class="text-xs-right">{{ props.item.serverLink }}</td>
        <td class="text-xs-right">{{ props.item.Views }}</td>
        <td class="text-xs-right">{{ props.item.serverValid }}</td>
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

       <v-alert slot="no-results" :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>

      <template slot="no-data">
      <v-alert :value="true" color="error" icon="warning">
        Sorry, nothing to display here :(
      </v-alert>
    </template>
    </v-data-table>
  </div>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    search: "",
    serverTypeItem: ["upload", "download"],
    headers: [
      {
        text: "Episode",
        align: "left",
        sortable: false,
        value: "name"
      },
      { text: "Image", value: "image", sortable: false },
      { text: "Number", value: "number" },
      { text: "Server Type", value: "servertype", sortable: false },
      { text: "Server Name", value: "servername" },
      { text: "Episode Link", value: "episodelink", sortable: false },
      { text: "Views", value: "views" },
      { text: "Valid", value: "valid" },
      { text: "Actions", value: "name", sortable: false }
    ],
    desserts: [],
    editedIndex: -1,

    editedItem: {
      Image: "",
      episodeName: 159,
      episodeNumber: 5,
      serverType: "uploaded",
      serverName: "RU.OK",
      serverLink: "ru.ok/episdoe_id/episode_name",
      serverValid: true
    },
    defaultItem: {
      Image: "",
      episodeName: 159,
      episodeNumber: 5,
      serverType: "uploaded",
      serverName: "RU.OK",
      serverLink: "ru.ok/episdoe_id/episode_name",
      serverValid: true
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  methods: {
    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.desserts.indexOf(item);
      if (confirm("Are you sure you want to delete this item?")) {
        this.desserts.splice(index, 1);
        let data = {
          id: this.desserts[index].id
        };
        this.$store
          .dispatch("deleteGroup", data)
          .then((res) => {
             if (res.data.success) {
            this.$toaster.success(res.data.success);
          } else if (res.data.error) {
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
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
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
          } else
            this.$toaster.error(
              "Something happened error, try again or contact the support"
            );
        });
    }
  }
};
</script>