<template>
    <v-navigation-drawer v-model="drawerVal" app clipped @transitionend="toggleDrawer(drawerVal)">
        <v-list dense>
            <v-subheader>LIST COMPONENTS:</v-subheader>
               <v-list-item class="search_field">
                    <v-list-item-content class="pt-0 pb-0 mb-0 mt-0">
                        <v-list-item-title class="title">
                            <v-text-field
                                :value="searchItem"
                                class="mt-1 project_search"
                                label="SEARCH MASTER"
                                hide-details
                                clearable
                                outlined
                                dense
                                append-icon="mdi-magnify"
                                @keyup="setSearchItem($event.target.value)"
                                @click:clear="setSearchItem(null)"
                            ></v-text-field>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

               <v-list-item
                  v-for="(item, i) in masterList"
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
    name: 'MasterAppDrawer',
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
                {text:'User Management', icon:'mdi-home', to:'tile_colors'},
                {text:'Role Management', icon:'mdi-home', to:'tile_combinations'},
                {text:'Permission Management', icon:'mdi-home', to:'house_types'},
            ],


        }
    },

    computed:{
        ...mapState([
            'searchItem',
        ]),


        masterList(){
            if(this.searchItem){
                return _.sortBy(this.items.filter(res => res.text.toLowerCase().includes(this.searchItem.toLowerCase())), [res => res.text]);
            }
            return _.sortBy(this.items, [res => res.text]);
        }
    },
    watch: {
        drawer(val){
            console.log(val)
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