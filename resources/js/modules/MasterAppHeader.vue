<template>
    <v-app-bar app clipped-left clipped-right dark color="blue-grey darken-4">

      <v-tooltip bottom>
        <template v-slot:activator="{ on }">
        <v-btn class="ml-3" v-on="on" icon @click="toggleDrawer(!drawer)">
            <v-icon >mdi-menu</v-icon> 
        </v-btn>
        </template>
        <span>ホームに戻る</span>
    </v-tooltip>
    <v-tooltip bottom>
        <template v-slot:activator="{ on }">
        <v-btn class="ml-3" href="/" v-on="on" icon>
            <v-icon >mdi-home</v-icon> 
        </v-btn>
        </template>
        <span>ホームに戻る</span>
    </v-tooltip>
    <v-tooltip bottom >
        <template v-slot:activator="{ on : tooltip }">
        <v-menu offset-y>
        <template v-slot:activator="{ on : menu, attrs }">
            <v-btn
            icon
            dark
            v-bind="attrs"
            v-on="{ ...tooltip, ...menu }"
            >
            <v-icon>mdi-apps</v-icon>
            </v-btn>
        </template>
        <v-list dense min-width="300" elevation="5">
            <v-container fluid>
                    <v-list-item-group  v-model="menu">
                    <v-row>
                        <v-col cols="12" md="12" sm="12" xs="12">
                        <v-subheader>PAGES</v-subheader>
                        <v-divider></v-divider>
                          <v-list-item
                            v-for="(item, i) in items"
                            :key="i"
                            :href="`/${item.to}`"
                          >
                            <v-list-item-icon>
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.text"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                    </v-row>
                    </v-list-item-group>
            </v-container>
        </v-list>
        </v-menu>
        </template>
        <span>Menu</span>
    </v-tooltip>

    <v-toolbar-title> <span class="overline">CAD REQUEST V2.0.0 - MASTER SETTINGS </span> </v-toolbar-title>
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
  props: {
      drawer:{
          type: Boolean
      },
  },

  data: () => ({ 
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    menu: null,
    items:[
            {text:'Home', icon:'mdi-home', to:'home'},
            {text:'Hello', icon:'mdi-hand-wave', to:'hello'},
            {text: 'Test', icon: 'mdi-account', to : 'test'},
            {text: 'Planners Table', icon: 'mdi-account-details', to : 'planners_table'},
         ],
  }),

  computed: {
    ...mapState([
      ]),

      authUser(){
        return this.$store.state.loggedInUser;
      },

      canViewMaintenance(){
        if(this.authUser.role.name === 'Admin') return true
        if(typeof _.find(this.authUser.permissions,{ name : 'maintenance-page'}) === 'object' ) return true;
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
  }
}
</script>

<style scoped>
  .btn-active{
    background-color: #546e7a !important;
    color: whitesmoke !important;
  }
</style>
