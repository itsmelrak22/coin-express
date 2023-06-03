<template>
    <div>
        <app-toolbar :toolbar="toolbar"></app-toolbar>
        <v-container fluid>

            <!-- mainTable Start -->
                <v-simple-table class="mainTable" fixed-header height="80vh">
                    <thead>
                            <tr>
                                <th v-show="editMode" width="20">
                                </th>
                                <th v-show="editMode" width="20">EDIT</th>
                                <th width="80"> COLOR </th>
                                <th> HOUSE TYPES </th>
                                <th v-show="viewMode"> CREATED </th>
                                <th v-show="viewMode"> UPDATED </th>
                                <th v-show="viewMode"> CREATED BY </th>
                                <th v-show="viewMode"> UPDATED BY </th>
                            </tr>
                            <template v-if="filterMode"> <!-- // NOTE Additional <th></th> for search text fields, if filterMode == true -->
                                <tr>
                                    <th v-show="editMode" width="20">
                                    </th>
                                    <th v-show="editMode" width="20"></th>
                                    <th width="80"> 
                                        <v-text-field  
                                            solo 
                                            placeholder="Search" 
                                            @keyup="toggleSearchColumn({
                                                        selector: $event.target, 
                                                        column: 'tiles.color', 
                                                        action: '_getTiles',
                                                        search: 'TILES_SEARCH',
                                                        })"
                                        ></v-text-field>
                                    </th>
                                    <th> 
                                        <!-- // NOTE Custom Search for houseType -->
                                        <v-text-field   
                                            solo 
                                            placeholder="Search" 
                                            @keyup="toggleSearchColumn({
                                                        selector: $event.target, 
                                                        column: 'house_types.name', 
                                                        action: '_getTiles',
                                                        search: 'TILES_SEARCH',
                                                        })"
                                        >
                                           
                                        </v-text-field> 
                                    </th>
                                    <th v-show="viewMode">  </th>
                                    <th v-show="viewMode">  </th>
                                    <th v-show="viewMode">  </th>
                                    <th v-show="viewMode">  </th>
                                </tr>
                            </template>
                    </thead>
                    <tbody>
                        <tr v-for="(ITEM, i) in TILES" :key="i">
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
                            <td> {{ ITEM.color }} </td>
                            <td> 
                                <v-chip small class="mr-1" v-for="(HOUSE_TYPE, ii) in ITEM.house_types" :key="ii+i+'HOUSE_TYPE'">
                                    <span class="caption font-weight-black">
                                    {{ HOUSE_TYPE.name }}
                                    </span> 
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

            <!-- Dialogs -->
            <!-- dialogStore Start -->
            <v-dialog v-model="dialogStore" max-width="300" persistent>
                <v-form id="Store" ref="Store" @submit.prevent="Store">
                    <v-card>
                        <v-card-title> <span class="overline">ADD TILE COLOR</span> </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12">
                                        <v-radio-group v-model="colorTone" row mandatory>
                                              <v-radio
                                                label="1"
                                                value="1"
                                            ></v-radio>
                                            <v-radio
                                                label="2"
                                                value="2"
                                            ></v-radio>
                                        </v-radio-group>
                                        <v-divider class="pb-3"></v-divider>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-autocomplete 
                                            v-model="tempData.house_types"
                                            outlined 
                                            multiple
                                            chips
                                            small-chips
                                            label="House Type"
                                            class="required"
                                            :items="HOUSE_TYPES"
                                            item-text="name"
                                            item-value="id"
                                            :rules="rules.requireOnMultiple"
                                        >
                                            <template v-slot:selection="data">
                                                <v-chip
                                                    v-bind="data.attrs"
                                                    :input-value="data.selected"
                                                    close
                                                    small
                                                    @click:close="removeHouseTypesSelected(data.item)"
                                                >
                                                    {{ data.item.name }}
                                                </v-chip>
                                            </template>
                                        </v-autocomplete>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-combobox 
                                            v-model="tempData.color"
                                            item-text="color"
                                            item-value="color"
                                            :return-object="false"
                                            name="color"
                                            outlined 
                                            dense 
                                            :label="colorTone == 2 ? 'Color 1' : 'Color'"
                                            :items="TILES"
                                            class="required"
                                            :rules="rules.required"
                                        > </v-combobox>
                                    </v-col>
                                    <v-col cols="12" v-if="colorTone == 2">
                                        <v-autocomplete 
                                            v-model="tempData.color_2"
                                            outlined 
                                            label="Color 2"
                                            :items="filteredTiles"
                                            item-text="tile_color_2"
                                            item-value="tile_color_2"
                                            class="required"
                                            :rules="rules.required"
                                            multiple
                                        >
                                            <template v-slot:selection="data">
                                                <v-chip
                                                    v-bind="data.attrs"
                                                    :input-value="data.selected"
                                                    close
                                                    small
                                                    @click:close="removeColorSelected(data.item)"
                                                >
                                                    {{ data.item.tile_color_2 }}
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
            <v-dialog v-model="dialogUpdate" max-width="300" persistent>
                <v-form id="Update" ref="Update" @submit.prevent="Update">
                    <v-card>
                        <v-card-title> <span class="overline">Edit House Type Category</span> </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12">
                                        <v-autocomplete 
                                            v-model="tempData.house_types"
                                            outlined 
                                            multiple
                                            chips
                                            small-chips
                                            label="House Type"
                                            class="required"
                                            :items="HOUSE_TYPES"
                                            item-text="name"
                                            item-value="id"
                                            :rules="rules.requireOnMultiple"
                                        >
                                            <template v-slot:selection="data">
                                                <v-chip
                                                    v-bind="data.attrs"
                                                    :input-value="data.selected"
                                                    close
                                                    small
                                                    @click:close="removeHouseTypesSelected(data.item)"
                                                >
                                                    {{ data.item.name }}
                                                </v-chip>
                                            </template>
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-autocomplete 
                                            v-model="tempData.color"
                                            outlined 
                                            dense 
                                            label="Tile"
                                            :items="TILES"
                                            item-text="color"
                                            item-value="color"
                                            name="color" 
                                            class="required"
                                            :rules="rules.required"
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
        </v-container>

        <app-buttons  
            @toggleDialogDelete="toggleDialogDelete"
            @toggleDialogStore="toggleDialogStore" 
            :selectedData="selectedData"
            :floatButtons="floatButtons"
        > 
        </app-buttons>
        <app-footer :items="TILES.length"></app-footer>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
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
                title: 'TILE COLORS',
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

            colorTone: 1

        }),

        computed : {
            ...mapState([
                'TILE_COLOR_COMBINATIONS',
                'HOUSE_TYPES',
                'TILES',
                'viewMode',
                'editMode',
                'rules',
                'filterMode'
            ]),

            selectedData(){
                return this.TILES.filter(res => res.selected).map(res => res.id); 
            },

            filteredTiles(){
                if(this.colorTone != 2) return;
                return this.TILE_COLOR_COMBINATIONS.filter(res => res.tile_color_1 == this.tempData.color)
            }
        },

        methods: {
            ...mapActions([
                '_getTiles',
                '_getHouseTypes',
                '_getTileColorCombinations',
                'toggleSearchColumn'
            ]),

            removeHouseTypesSelected(item) {
                this.$nextTick(() => {
                    const index = this.tempData.house_types.findIndex(res => res == item.id)
                    if (index >= 0) this.tempData.house_types.splice(index, 1)
                })
            },

            removeColorSelected(item) {
                this.$nextTick(() => {
                    const index = this.tempData.color_2.findIndex(res => res == item.color)
                    if (index >= 0) this.tempData.color_2.splice(index, 1)
                })
            },

            formatDate(val){
                return new Date(val).toLocaleString('en-US', { timeZone: 'Asia/Manila', hour12: false })
            },

            toggleDialogStore(val){
                this.dialogStore = val;
            },

            Store(){
                if(this.$refs.Store.validate()){
                    const myForm = document.getElementById('Store');
                    const formdata = new FormData(myForm);

                    this.tempData.house_types.map(res => formdata.append('house_type_ids[]', res));
                    if(this.tempData.color_2) this.tempData.color_2.map(res => formdata.append('color_2[]', res));
                    
                    axios({
                        method: 'POST',
                        url: '/api/tile_colors/store',
                        data: formdata
                    }).then(() => {
                        this._getTiles();
                        this.dialogStore = false;
                    })
                }
            },

            toggleUpdateDialog(item){
                if(item){
                    this.tempData = {...item};
                    this.tempData.house_types = [...item.house_types.map(res => res.house_type_id)]
                    this.tempData.old_house_types_data = [...item.house_types.map(res => res.house_type_id)]
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

                    formdata.append('id', this.tempData.id)
                    this.tempData.house_types.map(res => formdata.append('house_type_ids[]', res));
                    this.tempData.old_house_types_data.map(res => formdata.append('old_house_types_data[]', res));

                    axios({
                        method: 'POST',
                        url: `/api/tile_colors/update/${id}`,
                        data: formdata
                    }).then(() => {
                        this._getTiles();
                        this.dialogUpdate = false;
                    })
                }
            },

            
            toggleDialogDelete(val){
                this.dialogDelete = val;
            },

            Delete(){
                axios({
                    method: 'POST',
                    url: '/api/tile_colors/delete',
                    data: {ids : this.selectedData}
                }).then(() => {
                    this._getTiles();
                    this.dialogDelete = false;
                })
            },

        },

        mounted() {
            this._getTiles();
            this._getHouseTypes();
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