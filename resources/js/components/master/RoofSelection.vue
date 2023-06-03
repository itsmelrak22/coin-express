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
                        <th> ROOF MATERIAL </th>
                        <th> HOUSE TYPE </th>
                        <th> ROOF COLOR </th>
                        <th v-show="viewMode"> CREATED </th>
                        <th v-show="viewMode"> UPDATED </th>
                        <th v-show="viewMode"> CREATED BY </th>
                        <th v-show="viewMode"> UPDATED BY </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(roof, i) in ROOF_SELECTION" :key="i">
                         <td v-show="editMode">
                            <v-checkbox v-model="roof.selected" dense></v-checkbox>
                        </td>
                        <td v-show="editMode"> 
                            <v-btn
                                fab
                                x-small
                                @click="toggleUpdateDialog(roof)"
                            >
                                <v-icon >mdi-pencil</v-icon> 
                            </v-btn>
                        </td>
                        <td> {{ roof.material }} </td>
                        <td> {{ roof.house_type }} </td>
                        <td> 
                            <div v-for="(combi, ii) in roof.selections_combi" :key="i + ii + 'A'">
                               <div>
                                 <p class="my-1 caption"> {{ combi.color }} </p>
                               </div>
                            </div> 
                        </td>
                        <td v-show="viewMode"> {{ formatDate(roof.created_at) }} </td>
                        <td v-show="viewMode"> {{ formatDate(roof.updated_at) }} </td>
                        <td v-show="viewMode"> {{ roof.created_by }} </td>
                        <td v-show="viewMode"> {{ roof.updated_by }} </td>
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
                    <v-card-title> <span class="overline">Create Roof Selection</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field 
                                        v-model="tempRoof.material"
                                        outlined 
                                        dense 
                                        label="Roof Material"
                                        name="material" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete
                                        v-model="tempRoof.house_type_id"
                                        :items="HOUSE_TYPES"
                                        @change="resetListedRoof"
                                        item-value="id"
                                        item-text="name" 
                                        outlined 
                                        dense 
                                        label="House Type"
                                        name="house_type)id" 
                                    > </v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field 
                                        v-model="tempRoof.color"
                                        outlined 
                                        dense 
                                        label="Roof Color"
                                        name="color" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field 
                                        v-model="tempRoof.value"
                                        outlined 
                                        dense 
                                        label="Roof Value"
                                        name="value" 
                                        class="required"
                                        :rules="rules.required"
                                        suffix="e.g. GBR"
                                    > </v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-btn block @click="addRoof(tempRoof, 'Store')"> Enlist </v-btn>
                                </v-col>
                                <v-col cols="12" class="my-4">
                                    <v-divider></v-divider>
                                </v-col>
                                <v-col cols="12">
                                  <v-simple-table class="mainTable">
                                    <thead>
                                       <tr>
                                            <th>Roof Color</th>
                                            <th>Roof Value</th>
                                            <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(roof, i) in listedRoof" :key="i">
                                            <td> {{ roof.color }} </td>
                                            <td> {{ roof.value }} </td>
                                            <td> <v-btn text @click="removeRoof(i)"> REMOVE </v-btn> </td>
                                        </tr>
                                    </tbody>
                                  </v-simple-table>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit" :disabled="listedRoof.length == 0">Submit</v-btn>
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
                    <v-card-title> <span class="overline">Edit Roof Selection</span> </v-card-title>
                       <v-card-text>
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field 
                                        v-model="tempRoof.material"
                                        outlined 
                                        dense 
                                        label="Roof Material"
                                        name="material" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete
                                        v-model="tempRoof.house_type_id"
                                        :items="HOUSE_TYPES"
                                        @change="resetListedRoof"
                                        item-value="id"
                                        item-text="name" 
                                        outlined 
                                        dense 
                                        label="House Type"
                                        name="house_type_id" 
                                    > </v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field 
                                        v-model="tempRoof.color"
                                        outlined 
                                        dense 
                                        label="Roof Color"
                                        name="color" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field 
                                        v-model="tempRoof.value"
                                        outlined 
                                        dense 
                                        label="Roof Value"
                                        name="value" 
                                        class="required"
                                        :rules="rules.required"
                                        suffix="e.g. GBR"
                                    > </v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-btn block @click="addRoof(tempRoof, 'Update')"> Enlist </v-btn>
                                </v-col>
                                <v-col cols="12" class="my-4">
                                    <v-divider></v-divider>
                                </v-col>
                                <v-col cols="12">
                                  <v-simple-table class="mainTable">
                                    <thead>
                                       <tr>
                                            <th>Roof Color</th>
                                            <th>Roof Value</th>
                                            <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(roof, i) in listedRoof" :key="i">
                                            <td> {{ roof.color }} </td>
                                            <td> {{ roof.value }} </td>
                                            <td> <v-btn text @click="removeRoof(i)"> REMOVE </v-btn> </td>
                                        </tr>
                                    </tbody>
                                  </v-simple-table>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text :disabled="listedRoof.length == 0" type="submit">UPDATE</v-btn>
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
        <app-footer></app-footer>
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
                title: 'ROOF SELECTIONS',
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
            listedRoof: [],
            tempRoof: {}


        }),

        computed : {
            ...mapState([
                'ROOF_SELECTION',
                'HOUSE_TYPES',
                'rules',
                'viewMode',
                'editMode'
            ]),

            selectedData(){
                // this will return only the id of the selected data
                return this.ROOF_SELECTION.filter(res => res.selected).map(res => res.id); 
            }
        },

        methods: {
            ...mapActions([
                '_getRoofSelection',
                '_getHouseTypes'
            ]),

            resetListedRoof(){
                if(this.listedRoof.length > 0){
                    this.listedRoof.splice(0);
                }
            },

            addRoof(tempRoof, ref){
                if(this.$refs[ref].validate()){
                    const data = {...tempRoof}
                    this.listedRoof.push({color: data.color, value: data.value});

                    this.$nextTick(() => {
                        this.$refs[ref].resetValidation()
                        this.tempRoof.color = null;
                        this.tempRoof.value = null;
                    })
                }
            },

            removeRoof(index){
                this.listedRoof.splice(index, 1);
            },

            toggleDialogDelete(val){
                console.log(val)
                this.dialogDelete = val;
            },

            Delete(){
                axios({
                    method: 'POST',
                    url: '/api/roof_selections/delete',
                    data: {ids : this.selectedData}
                }).then((res) => {
                    console.log(res.data)
                    this._getRoofSelection();
                    this.dialogDelete = false;
                })
            },

            toggleUpdateDialog(item){
                if(item){
                    this.tempRoof = {...item}
                    this.listedRoof = [...item.selections_combi]
                    this.dialogUpdate = true;
                    this.$nextTick(() => this.$refs.Update.resetValidation())
                }else{
                    this.dialogUpdate = false;
                }
            },

            Update(){
                const id = this.tempRoof.id
                axios({
                    method: 'POST',
                    url: `/api/roof_selections/update/${id}`,
                    data: {
                        house_type_id: this.tempRoof.house_type_id,
                        material: this.tempRoof.material,
                        combinations: this.listedRoof,
                    }
                }).then((res) => {
                    console.log(res.data)
                    this._getRoofSelection();
                    this.dialogUpdate = false;
                })
            },

            Store(){
                if(this.listedRoof.length > 0){
                    axios({
                        method: 'POST',
                        url: '/api/roof_selections/store',
                        data: {
                            house_type_id: this.tempRoof.house_type_id,
                            material: this.tempRoof.material,
                            combinations: this.listedRoof
                        }
                    }).then(() => {
                        this._getRoofSelection();
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
            this._getRoofSelection();
            this._getHouseTypes();
        },

        watch:{
            dialogStore(val){
                if(!val){
                    this.$refs.Store.reset();
                    this.listedRoof.splice(0);
                }
            },

            dialogUpdate(val){
                if(!val){
                    this.listedRoof.splice(0);
                    this.$refs.Update.reset();
                }
            }
        }
    }
</script>

<style scoped>


</style>