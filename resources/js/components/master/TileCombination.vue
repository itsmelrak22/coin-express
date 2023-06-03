<template>
    <div>
        <app-toolbar :toolbar="toolbar"></app-toolbar>
        <v-container fluid>
        <!-- mainTable Start -->
            <v-simple-table class="mainTable" fixed-header height="75vh">
                <thead>
                    <tr>
                        <th v-show="editMode" width="20">
                        </th>
                        <th v-show="editMode" width="20">EDIT</th>
                        <th> COLOR 1 </th>
                        <th> COLOR 2 </th>
                        <th v-show="viewMode"> CREATED </th>
                        <th v-show="viewMode"> UPDATED </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ITEM, i) in TILE_COLOR_COMBINATIONS" :key="i">
                         <td v-show="editMode">
                            <v-checkbox v-model="ITEM.selected" dense></v-checkbox>
                        </td>
                        <td v-show="editMode"> 
                            <v-btn
                                fab
                                x-small
                                @click="toggleUpdateDialog(ITEM)"
                            >
                                <v-icon >mdi-pencil</v-icon> 
                            </v-btn>
                        </td>
                        <td> {{ ITEM.tile_color_1 }} </td>
                        <td> {{ ITEM.tile_color_2 }} </td>
                        <td v-show="viewMode"> {{ formatDate(ITEM.created_at) }} </td>
                        <td v-show="viewMode"> {{ formatDate(ITEM.updated_at) }} </td>
                    </tr>
                </tbody>
            </v-simple-table>
        <!-- mainTable End -->

            
        </v-container>

        <!-- Dialogs -->
        <!-- dialogStore Start -->
        <v-dialog v-model="dialogStore" max-width="600" persistent>
            <v-form id="Store" ref="Store" @submit.prevent="Store">
                <v-card>
                    <v-card-title> <span class="overline">Create New Tile Color Combination</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="5">
                                    <v-autocomplete 
                                        v-model="tempData.tile_color_1"
                                        outlined 
                                        label="Tile Color 1"
                                        name="tile_color_1" 
                                        class="required"
                                        :items="TILES"
                                        item-value="id"
                                        item-text="color"
                                        :rules="rules.required"
                                        chips
                                        small-chips
                                    >
                                        <template v-slot:selection="data">
                                            <v-chip
                                                v-bind="data.attrs"
                                                :input-value="data.selected"
                                                close
                                                small
                                                @click:close="tempData.tile_color_1 = null"
                                            >
                                                {{ data.item.color }}
                                            </v-chip>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="1">
                                    <span >
                                        <v-icon class="mt-3">mdi-plus</v-icon>
                                    </span>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete 
                                            v-model="tempData.tile_color_2"
                                            outlined 
                                            multiple
                                            chips
                                            small-chips
                                            label="Tile Color 2"
                                            class="required"
                                            :items="TILES"
                                            item-value="id"
                                            item-text="color"
                                            :rules="rules.requireOnMultiple"
                                            >
                                            <template v-slot:selection="data">
                                                <v-chip
                                                    v-bind="data.attrs"
                                                    :input-value="data.selected"
                                                    close
                                                    small
                                                    @click:close="remove(data.item)"
                                                >
                                                    {{ data.item.color }}
                                                </v-chip>
                                            </template>
                                        </v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="dialogStore = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogStore End -->

        <!-- dialogUpdate Start -->
        <v-dialog v-model="dialogUpdate" max-width="600" persistent>
            <v-form id="Update" ref="Update" @submit.prevent="Update">
                <v-card>
                    <v-card-title> <span class="overline">Edit Sash Type</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="5">
                                    <v-autocomplete 
                                        v-model="tempData.tile_id_1"
                                        outlined 
                                        label="Tile Color 1"
                                        name="tile_id_1" 
                                        class="required"
                                        :items="TILES"
                                        item-value="id"
                                        item-text="color"
                                        :rules="rules.required"
                                        chips
                                        small-chips
                                    >
                                        <template v-slot:selection="data">
                                            <v-chip
                                                v-bind="data.attrs"
                                                :input-value="data.selected"
                                                close
                                                small
                                                @click:close="tempData.tile_id_1 = null"
                                            >
                                                {{ data.item.color }}
                                            </v-chip>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="1">
                                    <span >
                                        <v-icon class="mt-3">mdi-plus</v-icon>
                                    </span>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete 
                                            v-model="tempData.tile_id_2"
                                            outlined 
                                            chips
                                            name="tile_id_2" 
                                            small-chips
                                            label="Tile Color 2"
                                            class="required"
                                            :items="TILES"
                                            item-value="id"
                                            item-text="color"
                                            :rules="rules.required"
                                            >
                                            <template v-slot:selection="data">
                                                <v-chip
                                                    v-bind="data.attrs"
                                                    :input-value="data.selected"
                                                    close
                                                    small
                                                    @click:close="tempData.tile_id_2 = null"
                                                >
                                                    {{ data.item.color }}
                                                </v-chip>
                                            </template>
                                        </v-autocomplete>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="dialogUpdate = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogUpdate End -->

        <!-- dialogDelete Start -->
         <v-dialog v-model="dialogDelete" max-width="300" persistent>
            <v-form id="Delete" ref="Delete" @submit.prevent="Delete">
                <v-card>
                    <v-card-title> <span class="overline">delete</span> </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <span class="overline font-weight-black"> Delete Selected Items? </span>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="dialogDelete = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogDelete End -->

        <app-buttons  
            @toggleDialogDelete="toggleDialogDelete"
            @toggleDialogStore="toggleDialogStore" 
            :selectedData="selectedData"
            :floatButtons="floatButtons"
        > 
        </app-buttons>
        <app-footer :items="TILE_COLOR_COMBINATIONS.length"></app-footer>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import ToolbarMenu from '../../modules/ToolbarMenu.vue';
import Footer from '../../modules/Footer.vue';
import FloatingButtons from '../../modules/FloatingButtons.vue';
    export default {
        components: {
            'app-toolbar': ToolbarMenu,
            'app-buttons': FloatingButtons,
            'app-footer': Footer
        },
        data: () => ({
            toolbar: {
                title: 'TILE COMBINATIONS',
                view: true,
                back: true,
                filter: false,
                master: false,
            },

            floatButtons:{
                add: true,
                update: true,
                delete: true
            },

            tempData: {},
            
            dialogStore: false,
            dialogUpdate: false,
            dialogDelete: false,


        }),

        computed : {
            ...mapState([
                'TILE_COLOR_COMBINATIONS',
                'TILES',
                'rules',
                'viewMode',
                'editMode'
            ]),

            selectedData(){
                // this will return only the id of the selected data
                return this.TILE_COLOR_COMBINATIONS.filter(res => res.selected).map(res => res.id); 
            }
        },

        methods: {
            ...mapActions([
                '_getTiles',
                '_getTileColorCombinations'
            ]),

            remove(item) {
                this.$nextTick(() => {
                    const index = this.tempData.tile_color_2.findIndex(res => res == item.id)
                    if (index >= 0) this.tempData.tile_color_2.splice(index, 1)
                })
            },

            toggleDialogDelete(val){
                console.log(val)
                this.dialogDelete = val;
            },

            Delete(){
                axios({
                    method: 'POST',
                    url: '/api/tile_combinations/delete',
                    data: {ids : this.selectedData}
                }).then(() => {
                    this._getTileColorCombinations();
                    this.dialogDelete = false;
                })
            },

            toggleUpdateDialog(item){
                console.log(item)
                if(item){
                    this.tempData = {...item};
                    this.dialogUpdate = true;
                }else{
                    this.dialogUpdate = false;
                }
            },

            Update(){
                if(this.$refs.Update.validate()){
                    const myForm = document.getElementById('Update');
                    const formdata = new FormData(myForm);
                    const id = this.tempData.id

                    axios({
                        method: 'POST',
                        url: `/api/tile_combinations/update/${id}`,
                        data: formdata
                    }).then(() => {
                        this._getTileColorCombinations();
                        this.dialogUpdate = false;
                    })
                }
            },

            Store(){
                if(this.$refs.Store.validate()){
                    const myForm = document.getElementById('Store');
                    const formdata = new FormData(myForm);
                    this.tempData.tile_color_2.map( res => formdata.append('tile_colors_2[]', res));

                    axios({
                        method: 'POST',
                        url: '/api/tile_combinations/store',
                        data: formdata
                    }).then(() => {
                        this._getTileColorCombinations();
                        this.dialogStore = false;
                    })
                }
            },

            formatDate(val){
                return new Date(val).toLocaleString('en-US', { timeZone: 'Asia/Manila', hour12: false })
            },

            toggleDialogDelete(val){
                this.dialogDelete = val;
            },

            toggleDialogStore(val){
                this.dialogStore = val;
            },

            
        },

        mounted() {
            this._getTiles();
            this._getTileColorCombinations();
        },

        watch:{
            dialogStore(value){
                if( ! value ) this.$refs.Store.reset();
            },

            dialogUpdate(value){
                if( ! value ) {
                    for (var member in this.tempData) delete this.tempData[member];
                    this.$refs.Update.reset();
                }
            },

        }
    }
</script>

<style scoped>


</style>