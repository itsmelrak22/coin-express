<template>
    <v-app-bar app clipped-left clipped-right dark color="blue-grey darken-4">
    <v-app-bar-nav-icon  icon @click="toggleDrawer(!drawerVal)"></v-app-bar-nav-icon>
    <v-toolbar-title> <span class="overline">COINEXPRESS.COM </span> </v-toolbar-title>
    <v-spacer></v-spacer>
    
    <span class="caption">{{ authUser.email }}</span>

    <v-tooltip bottom>
        <template v-slot:activator="{ on : tooltip }">
        <v-menu offset-y max-width="300">
        <template v-slot:activator="{ on : menu, attrs }">
            <v-btn
            icon
            dark
            v-bind="attrs"
            v-on="{ ...tooltip, ...menu }"
            >
            <v-icon>mdi-account-circle</v-icon>
            </v-btn>
        </template>
        <v-list dense>
            <v-subheader>ACCOUNT</v-subheader>
            <v-list-item-group>
                <v-list-item >
                <v-list-item-content>
                    <v-form id="logOut" method="POST" action="/logout">
                        <input type="hidden" name="_token" :value="csrf">
                        <input  class="caption" text type="submit" value="Logout" depressed @click="logOut()">
                    </v-form>
                </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        </v-menu>
        </template>
        <span>Menu</span>
    </v-tooltip>
    </v-app-bar>
</template>
<script>
import { mapState , mapActions } from 'vuex'

export default {

  data: () => ({ 
    drawerVal: false,
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    menu: null,
  }),

  computed: {
    ...mapState([
      ]),

      authUser(){
        return this.$store.state.loggedInUser;
      },


      getCurrentRoute(){
          let route = this.$route.name
          return route.toLowerCase();
      }

  },
  created() {
    this.menu = this.selectedMenu
    
  },

  mounted() {
  },

  methods: {

    emitDialogValue(value){
      this.$emit('emitDialogValue', value);
    },

    toggleDrawer(val){
        this.$emit("toggleDrawer",val)
    },
    
    goToPage(page){
      if(this.onMasterConfiguration){
        location.href = page
      }
      this.$router.push(page, () => {});
    },
    
    logOut(){
      this.$store.commit('loggedOut');
    },



  },

  mounted() {
  },

    watch: {
        drawer(val){
            console.log(val)
            this.drawerVal = val
        }
    },
}
</script>

<style scoped>
  .btn-active{
    background-color: #546e7a !important;
    color: whitesmoke !important;
  }
</style>
