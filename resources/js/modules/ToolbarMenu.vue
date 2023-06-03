<template>
    <div>
        <v-list-item class="title-page mx-2">
            <v-list-item-content>
                <v-list-item-title>
                    <span > {{ toolbar.title }} </span>
                </v-list-item-title>
            </v-list-item-content>

            <template id="back" v-if="toolbar.back">
                <v-tooltip left >
                    <template v-slot:activator="{ on }"> 
                        <v-btn icon v-on="on"  @click="goBack">
                            <v-icon>mdi-arrow-left-circle</v-icon>
                        </v-btn>
                    </template>
                    <span>Back</span>
                </v-tooltip>
            </template>

            <template id="master" v-if="toolbar.master">
                <v-tooltip left >
                    <template v-slot:activator="{ on }"> 
                        <v-btn icon v-on="on" href="master_settings/tile_colors">
                            <v-icon>mdi-cog</v-icon>
                        </v-btn>
                    </template>
                    <span>Master Settings</span>
                </v-tooltip>
            </template>

            <template id="filter" v-if="toolbar.filter">
                <v-tooltip left >
                    <template v-slot:activator="{ on }"> 
                        <v-btn icon v-on="on" @click="toggleFilterMode()">
                            <v-icon>{{ filterMode ? 'mdi-filter-off' : 'mdi-filter' }}</v-icon>
                        </v-btn>
                    </template>
                    <span>Filter</span>
                </v-tooltip>
    
            </template>

            <template id="view" v-if="toolbar.view">
                <v-tooltip left >
                    <template v-slot:activator="{ on }"> 
                        <v-btn icon v-on="on" @click="toggleViewMode()">
                            <v-icon> {{ viewMode ? 'mdi-eye-off' : 'mdi-eye' }} </v-icon>
                        </v-btn>
                    </template>
                    <span>  {{ viewMode ? 'Hide Columns' : 'Show Columns' }} </span>
                </v-tooltip>
            </template>
        </v-list-item>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
export default {
    props : {
        toolbar: {
            type: Object
        }
    },

    data(){
        return {
            
        }
    },

    computed: {
        ...mapState([
            'viewMode',
            'filterMode'
        ])
    },

    methods: {
       ...mapActions([
            'toggleViewMode',
            'toggleFilterMode',
       ]),

        goBack(){
            //if it was the first page
            window.location = "/"

            // if(history.length === 1){
            //     window.location = "/"
            // } else {
            //     history.back();
            // }
        }
    }
}
</script>