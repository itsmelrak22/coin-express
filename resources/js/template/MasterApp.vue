<template>
  <v-app app>
   <master-drawer :drawer="drawer" @toggleDrawer="toggleDrawer"></master-drawer>
   <app-header  :drawer="drawer" @toggleDrawer="toggleDrawer($event)"></app-header>
   <app-alert></app-alert>
   <app-loader></app-loader>
      <v-main >
         <router-view></router-view>
      </v-main>
  </v-app>
</template>

<script>
import { mapState } from 'vuex';
import Header from '../modules/MasterAppHeader.vue';
import Alert from '../modules/Alert.vue';
import Loader from '../modules/Loader.vue';
import MasterDrawer from '../modules/MasterAppDrawer.vue';

   export default {
      name: 'MasterSettingApp',
      
      components: {
         "app-header" : Header,
         "app-alert" : Alert,
         "app-loader" : Loader,
         "master-drawer" : MasterDrawer,
      },

      data: () => ({
         drawer: true,
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

      }),
      created(){
      },

      computed: {
         ...mapState([
            'loggedInUser'
         ])

      },

      methods: {
         toggleDrawer(toggle){
            this.drawer = toggle
         }
      }


   }
</script>