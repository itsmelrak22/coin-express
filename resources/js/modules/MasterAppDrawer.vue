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
                {text:'Tile Colors', icon:'mdi-home', to:'tile_colors'},
                {text:'Tile Colors Combinations', icon:'mdi-home', to:'tile_combinations'},
                {text:'House Types', icon:'mdi-home', to:'house_types'},
                {text:'House Types Categories', icon:'mdi-home', to:'house_type_categories'},
                {text:'Balcony Belt Makeup Tiles Faces', icon:'mdi-balcony', to:'balcony_belt_makeup_tiles'},
                {text:'ColorPers Eaves', icon:'mdi-home-roof', to:'eaves_selections'},
                {text:'ColorPers Gables', icon:'mdi-home-roof', to:'gable_selections'},
                {text:'ColorPers View Directions', icon:'mdi-directions', to:'view_direction_selections'},
                {text:'ColorPers View Heights', icon: 'mdi-ruler', to:'view_height_selections'},
                {text:'Louver Items', icon: 'mdi-window-shutter', to: 'louver_items'},
                {text:'Louver Woods', icon: 'mdi-solar-panel-large', to: 'louver_woods'},
                {text:'Louver Paints', icon: 'mdi-brush-variant', to: 'louver_paints'},
                {text:'Spray Comb Designs', icon: 'mdi-vector-combine', to: 'comb_designs'},
                {text:'Spray Siporoks', icon:'mdi-sprinkler', to:'siporoks'},
                {text:'Roof Selection', icon:'mdi-home', to:'roof_selection'},
                {text:'Color Selection Layout', icon:'mdi-home', to:'color_selection_layout'},
                {text:'Sash Type', icon:'mdi-home', to:'sash_type'},
                {text:'Sash Reinforcement', icon:'mdi-home', to:'sash_reinforcement'},
                {text:'Sash Accessories', icon:'mdi-home', to:'sash_accessories'},
                {text:'Sash Selection', icon:'mdi-home', to:'sash_selection'},
                {text:'Spray Items', icon:'mdi-home', to:'spray_items'},
                {text:'Spray Lena Rack I', icon:'mdi-home', to:'spray_lena'},
                {text:'Spray Shipo Stone Atsushi', icon:'mdi-home', to:'spray_shipo'},
                {text:'Synagio I', icon:'mdi-home', to:'synagio'},
                {text:'HP Smile Cube Stairs', icon: 'mdi-cube-unfolded', to: 'smile_cube_stairs'},
                {text:'HP Jiku Stairs', icon: 'mdi-cube-unfolded', to: 'jiku_stairs'},
                {text:'HP Kitchen Sets', icon: 'mdi-countertop', to: 'kitchen_sets'},
                {text:'HP Smile Kitchen Sets', icon: 'mdi-countertop', to: 'smile_kitchen_sets'},
                {text:'HP Grand Kitchen Sets', icon: 'mdi-countertop', to: 'grand_kitchen_sets'},
                {text:'HP Smart Kitchen Counters', icon: 'mdi-countertop', to: 'smart_kitchen_counters'},
                {text:'HP Grand Kitchen Counters', icon: 'mdi-countertop', to: 'grand_kitchen_counters'},
                {text:'HP Slitsliders', icon: 'mdi-countertop', to: 'slit_sliders'},
                {text:'HP Stone Pattern', icon: 'mdi-countertop', to: 'stone_patterns'},
                {text:'HP Hanging Closet Lattices', icon: 'mdi-countertop', to: 'hanging_closet_lattices'},
                {text:'ColorPers Base Drainers', icon: 'mdi-countertop', to: 'base_drainers'},
                {text:'Molding Selection', icon:'mdi-form-select', to:'molding_selection'},
                {text:'Fanova Entrance Door', icon:'mdi-door-sliding', to:'fanova_entrance'},
                {text:'Fire Proof Fanova', icon:'mdi-door-sliding', to:'fireproof_fanovas'},
                {text:'Pronova', icon:'mdi-door-sliding', to:'pronova_door'},
                {text:'Feature Color Selection', icon:'mdi-format-color-fill', to:'feature_color'},
                {text:'Joinery Color Selection', icon:'mdi-format-color-fill', to:'joinery_color_selection'},
                {text:'Smart Flooring Selection', icon:'mdi-floor-plan', to:'smart_flooring_selection'},
                {text:'Smile Flooring Selection', icon:'mdi-floor-plan', to:'smile_flooring_selection'},
                {text:'Cube Flooring Selection', icon:'mdi-floor-plan', to:'cube_flooring_selection'},
                {text:'Jiku Flooring Selection', icon:'mdi-floor-plan', to:'jiku_flooring_selection'},
                {text:'Grand Flooring Selection', icon:'mdi-floor-plan', to:'grand_flooring_selection'},
                {text:'Smart Grand Stair', icon:'mdi-stairs', to:'smart_grand_stair'},
                {text:'Ari/Nashi', icon:'mdi-home', to:'ari_nashi'},
                {text:'Remarks', icon:'mdi-home', to:'remarks'},
                {text:'House Type Remarks', icon:'mdi-home', to:'house_type_remarks'},
                {text:'Entrace Door', icon:'mdi-home', to:'entrance_door'},
                {text:'Porch Color', icon:'mdi-home', to:'porch_colors'},
                {text:'Porch Tiles', icon:'mdi-home', to:'porch_tiles'},
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
    // updated: debounce(function () {
    //     this.$nextTick(() => {
    //         if(this.firstLoad){
    //             var activeElem = document.querySelector(".active-item")
    //             if(typeof(activeElem) != 'undefined' && activeElem != null){
    //                 var elem = document.querySelector(".v-navigation-drawer__content")
    //                 var elemHeight = elem.clientHeight
    //                 var activeElemHeight = activeElem.clientHeight
    //                 elem.scrollTo(0, ((activeElem.offsetTop + activeElemHeight/2) - elemHeight/2 ))
    //             }
    //             this.firstLoad = false
    //         }
    //     })
    // }, 250),

    
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