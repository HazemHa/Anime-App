<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>My CRUD</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
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
                  <v-text-field v-model="editedItem.key" label="Setting name"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.value" label="Setting Value"></v-text-field>
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
      hide-actions
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.id }}</td>
        <td class="text-xs-right">{{ props.item.key }}</td>
        <td class="text-xs-right">{{ props.item.value }}</td>
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
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "id",
        align: "left",
        sortable: true
      },
      { text: "Key", value: "key" },
      { text: "Value", value: "value" }
    ],
    settings: [],
    editedIndex: -1,
    editedItem: {
      id: 0,
      key: null,
      value: ""
    },
    defaultItem: {
      id: 0,
      key: "",
      value: ""
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Setting" : "Edit Setting";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
    this.desserts = this.$store.getters.settings;
  },

  methods: {
    initialize() {
      this.desserts = [
        {
          id: 1,
          key: "appName",
          value: "ANime App"
        },
        {
          id: 2,
          key: "Debug_Mode",
          value: true
        }
      ];

    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.desserts.indexOf(item);
      if (confirm("Are you sure you want to delete this item?")) {
          let payload = {
             id:item.id,
             key:item.key,
             value:item.value,
          };
          this.$store.dispatch('deleteSetting',payload)
          .then((res)=>{            
            if(res.data.success){
          this.$toaster.success(res.data.success)
           this.desserts.splice(index, 1);
        }else if(res.data.error){
         this.$toaster.error(res.data.error);
      
        }
             
          }).catch((err)=>{
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

           let payload = {
             id:this.editedItem.id,
             key:this.editedItem.key,
             value:this.editedItem.value,
          };
          this.$store.dispatch('addSettign',payload)
          .then((res)=>{
            
             if(res.data.result.original.success){
          this.$toaster.success(res.data.result.original.success)
        }else if(res.data.error){
         this.$toaster.error(res.data.error);
      
        } 
       //  this.desserts.push(this.editedItem);

          }).catch((err)=>{
 this.$toaster.error(
              "Something happened error, try again or contact the support"
            );
          });
          
      }
      this.close();
    }
  }
};
</script>