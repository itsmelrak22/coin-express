<template>
    <v-navigation-drawer v-model="drawerVal" app clipped @transitionend="toggleDrawer(drawerVal)">
        <v-list dense>
            <v-subheader> PAGES:</v-subheader>
               
                <v-list-item
                  v-for="(item, i) in items2"
                  :key="i + 'A'"
                  :to="item.to"
               >
                  <v-list-item-icon>
                     <v-icon v-text="item.icon"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                     <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
               </v-list-item>
               <v-divider></v-divider>

               <v-list-item
                  v-for="(item, i) in items"
                  :key="i"
                  :href="item.to"
                  link
               >
                  <v-list-item-icon>
                     <v-icon v-text="item.icon"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                     <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
               </v-list-item>
         </v-list>

    </v-navigation-drawer>
</template>
<script>
import { mapState ,  mapActions } from 'vuex'
export default {
    name: 'Drawer',
    props:{
        drawer:{
            type: Boolean
        }
    },
    data() {
        return {
            drawerVal: this.drawer,
            searchField: '',
            items:[
                // {text:'User Management', icon:'mdi-home', to:'/users'},
                // {text:'Role Management', icon:'mdi-home', to:'/roles'},
                // {text:'Permission Management', icon:'mdi-home', to:'/permissions'},
                {text:'Agent Management', icon:'mdi-home', to:'/admin_users'},
                {text:'My Clients', icon:'mdi-home', to:'/my_clients'},

            ],
            items2: [
                {text:'Dashboard', icon:'mdi-home', to:'/'},
                {text: 'Trade Order', icon: 'mdi-account', to : '/AdminSide'},
                // {text: 'Account', icon: 'mdi-account', to : '/Account'},
                {text: 'Admin Side Depo', icon: 'mdi-account', to : '/AdminSideDepo'},
            ]

        }
    },

    computed:{
        ...mapState([
            'searchItem',
        ]),
    },
    watch: {
        drawer(val){
            this.drawerVal = val
        }
    },
    methods: {
        ...mapActions(['setSearchItem']),

        toggleDrawer(val){
            this.$emit("toggleDrawer",val)
        },

    },

    
}
</script>
<style scoped>
    .search_field{
        min-height: 48px;
    }

    .v-navigation-drawer .v-list{
        padding: 0px !important
    }

    .v-navigation-drawer .v-list-item__content{
        padding: 0px !important;
    }

    .v-navigation-drawer .v-list-group__header .v-list-item--active{
        background-color: #1866d1;
        color:#1866d1;
    }

    .v-navigation-drawer .project_all.v-item--active.v-list-item--active{
        background-color:#e3eefa;
        color:#1866d1;
    }

    .v-navigation-drawer .v-list-group__header .v-list-item__title{
        font-size: 12px !important;
        font-weight: bold;
    }

    .v-navigation-drawer .v-list-group__header .v-list-item__icon .v-icon{
        font-size: 16px !important
    }

    .v-navigation-drawer .v-list-group__items .v-list-item__title {
        font-size: 12px !important;
    }

    .v-navigation-drawer .v-list-group__items .v-list-item__title > span{
        font-size: 8px !important;
    }

    .v-navigation-drawer .v-list-group__items .v-list-item{
        padding-left: 16px !important;
    }



    .v-input__slot{
        -webkit-box-align: stretch;
        align-items: stretch;
        min-height: 32px !important;
    }


</style>