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
                        <th width="250px"> NAME </th>
                        <th width="250px"> 
                            <span v-if="filterMode">
                               <v-container>
                                    <v-autocomplete v-model="filteredHouseType" class="mt-4" dense outlined label="HOUSE TYPE"  dark  :items="HOUSE_TYPES" item-value="id" item-text="name"> </v-autocomplete> 
                               </v-container>
                            </span>
                            <span v-else>
                                HOUSE TYPE
                            </span>
                        </th>
                        <th> COLOR </th>
                        <th v-show="viewMode"> CREATED </th>
                        <th v-show="viewMode"> UPDATED </th>
                        <th v-show="viewMode"> CREATED BY </th>
                        <th v-show="viewMode"> UPDATED BY </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ITEM, i) in TABLE_DATA" :key="i">
                         <td v-show="editMode">
                            <v-checkbox v-model="ITEM.selected" dense></v-checkbox>
                        </td>
                        <td v-show="editMode"> 
                              <div class="custom-svg svg-edit_icon" @click="toggleUpdateDialog(ITEM)"></div>
                            <!-- <v-btn
                                fab
                                x-small
                                @click="toggleUpdateDialog(ITEM)"
                            >
                                <v-icon >mdi-pencil</v-icon> 
                            </v-btn> -->
                        </td>
                        <td> {{ ITEM.name }} </td>
                        <td> {{ ITEM.house_type }} </td>
                        <td>
                            <v-chip class="mx-2" small v-for="(SUBITEM, ii) in ITEM.colors" :key="`${i}-${ii}` ">
                                {{SUBITEM.color}}
                            </v-chip>
                        </td>
                        <td v-show="viewMode"> {{ formatDate(ITEM.created_at) }} </td>
                        <td v-show="viewMode"> {{ formatDate(ITEM.updated_at) }} </td>
                        <td v-show="viewMode"> {{ ITEM.created_by }} </td>
                        <td v-show="viewMode"> {{ ITEM.updated_by }} </td>
                    </tr>
                </tbody>
            </v-simple-table>
        <!-- mainTable End -->
        </v-container>

        <!-- Dialogs -->
        <!-- dialogStore Start -->
        <v-dialog v-model="dialogStore" max-width="300" persistent>
            <v-form id="Store" ref="Store" @submit.prevent="Store">
                <v-card>
                    <v-card-title> <span class="overline">Create New Sash Type</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field 
                                        outlined 
                                        dense 
                                        label="Porch Tile"
                                        name="name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete
                                        :items="HOUSE_TYPES"
                                        item-value="id"
                                        item-text="name"
                                        outlined 
                                        dense 
                                        label="House Type"
                                        name="house_type_id" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-autocomplete>
                                  
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete
                                        :items="PORCH_COLORS"
                                        item-value="id"
                                        item-text="name"
                                        outlined 
                                        multiple
                                        label="Porch Color"
                                        name="porch_color_id" 
                                        chips
                                        small-chips
                                    > </v-autocomplete>
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
        <v-dialog v-model="dialogUpdate" max-width="300" persistent>
            <v-form id="Update" ref="Update" @submit.prevent="Update">
                <v-card>
                    <v-card-title> <span class="overline">Edit Sash Type</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field 
                                        v-model="tempData.name"
                                        outlined 
                                        dense 
                                        label="Porch Tile"
                                        name="name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete
                                        v-model="tempData.house_type_id"
                                        :items="HOUSE_TYPES"
                                        item-value="id"
                                        item-text="name"
                                        outlined 
                                        dense 
                                        label="House Type"
                                        name="house_type_id" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-autocomplete>
                                  
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete
                                        v-model="tempData.porch_color_id"
                                        :items="PORCH_COLORS"
                                        item-value="id"
                                        item-text="name"
                                        outlined 
                                        multiple
                                        label="Porch Color"
                                        name="porch_color_id" 
                                        chips
                                        small-chips
                                    > </v-autocomplete>
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
        <app-footer :items="TABLE_DATA.length"></app-footer>
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
                title: 'PORCH TILES',
                view: true,
                back: true,
                filter: true,
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
            filteredHouseType: null


        }),

        computed : {
            ...mapState([
                'HOUSE_TYPES',
                'PORCH_COLORS',
                'PORCH_TILES',
                'rules',
                'viewMode',
                'editMode',
                'filterMode',
            ]),

            selectedData(){
                // this will return only the id of the selected data
                return this.PORCH_TILES.filter(res => res.selected).map(res => res.id); 
            },

            TABLE_DATA(){
                if(this.filterMode && this.filteredHouseType){
                    return this.PORCH_TILES.filter(res => res.house_type_id == this.filteredHouseType)
                }else{
                    return this.PORCH_TILES
                }
            }
        },

        methods: {
            ...mapActions([
                '_getPorchColors',
                '_getPorchTiles',
                '_getHouseTypes'
            ]),

            toggleDialogDelete(val){
                console.log(val)
                this.dialogDelete = val;
            },

            Delete(){
                axios({
                    method: 'POST',
                    url: '/api/porch_tiles/delete',
                    data: {ids : this.selectedData}
                }).then(() => {
                    this._getPorchTiles();
                    this.dialogDelete = false;
                })
            },

            toggleUpdateDialog(item){
                console.log(item)
                if(item){
                    this.tempData = {...item};
                    this.tempData.porch_color_id = this.tempData.colors.map(res => res.porch_color_id)
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
                        url: `/api/porch_tiles/update/${id}`,
                        data: formdata
                    }).then(() => {
                        this._getPorchTiles();
                        this.dialogUpdate = false;
                    })
                }
            },

            Store(){
                if(this.$refs.Store.validate()){
                    const myForm = document.getElementById('Store');
                    const formdata = new FormData(myForm);

                    axios({
                        method: 'POST',
                        url: '/api/porch_tiles/store',
                        data: formdata
                    }).then(() => {
                        this._getPorchTiles();
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
            this._getPorchTiles().then(() => {
                this._getPorchColors().then(() => {
                    this._getHouseTypes();

                })
            })
        },

        watch:{
            dialogStore(val){
                if( !val ){
                    this.$refs.Store.reset();
                }
            },

            dialogUpdate(val){
                if( !val ){
                    this.$refs.Update.reset();
                }
            }
        }
    }
</script>

<style scoped>


</style>