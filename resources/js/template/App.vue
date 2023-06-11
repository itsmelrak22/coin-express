<template>
  <v-app app >
   <app-drawer :drawer="drawer" @toggleDrawer="toggleDrawer"></app-drawer>
   <app-header :drawer="drawer" @toggleDrawer="toggleDrawer($event)"></app-header>
   <app-alert></app-alert>
   <app-loader></app-loader>
      <v-main  class="ma-2">
         <router-view ></router-view>
      </v-main>
  </v-app>
</template>

<script>
import {mapState} from 'vuex';
import Header from '../modules/Header.vue';
import Alert from '../modules/Alert.vue';
import Loader from '../modules/Loader.vue';
import Drawer from '../modules/Drawer.vue';
   export default {
      components: {
         "app-header" : Header,
         "app-alert" : Alert,
         "app-loader" : Loader,
         "app-drawer" : Drawer,
      },

      data: () => ({
         drawer: true,
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      }),
      created(){
      },

      methods: {
         toggleDrawer(toggle){
            this.drawer = toggle
         }
      },

      computed: {
         ...mapState([
            'loggedInUser'
         ])

      },
      
   }
</script>