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
                        <th> CODE </th>
                        <th> NAME </th>
                        <th v-show="viewMode"> CREATED </th>
                        <th v-show="viewMode"> UPDATED </th>
                        <th v-show="viewMode"> CREATED BY </th>
                        <th v-show="viewMode"> UPDATED BY </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(pronova, i) in PRONOVA" :key="i">
                         <td v-show="editMode">
                            <v-checkbox v-model="pronova.selected" dense></v-checkbox>
                        </td>
                        <td v-show="editMode"> 
                            <v-btn
                                fab
                                x-small
                                @click="toggleUpdateDialog(pronova)"
                            >
                                <v-icon >mdi-pencil</v-icon> 
                            </v-btn>
                        </td>
                        <td> {{ pronova.pronova_value }} </td>
                        <td> {{ pronova.pronova_name }} </td>
                        <td v-show="viewMode"> {{ formatDate(pronova.created_at) }} </td>
                        <td v-show="viewMode"> {{ formatDate(pronova.updated_at) }} </td>
                        <td v-show="viewMode"> {{ pronova.created_by }} </td>
                        <td v-show="viewMode"> {{ pronova.updated_by }} </td>
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
                                        label="Pronova Code"
                                        name="pronova_value" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field 
                                        outlined 
                                        dense 
                                        label="Pronova Name"
                                        name="pronova_name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
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
                                        v-model="tempData.pronova_value"
                                        outlined 
                                        dense 
                                        label="Pronova Code"
                                        name="pronova_value" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                               <v-col cols="12">
                                    <v-text-field 
                                        v-model="tempData.pronova_name"
                                        outlined 
                                        dense 
                                        label="Pronova Name"
                                        name="pronova_name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
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
                title: 'PRONOVA ENTRANCE DOOR',
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
                'PRONOVA',
                'rules',
                'viewMode',
                'editMode'
            ]),

            selectedData(){
                // this will return only the id of the selected data
                return this.PRONOVA.filter(res => res.selected).map(res => res.id); 
            }
        },

        methods: {
            ...mapActions([
                '_getPronova'
            ]),

            toggleDialogDelete(val){
                console.log(val)
                this.dialogDelete = val;
            },

            Delete(){
                axios({
                    method: 'POST',
                    url: '/api/pronova/delete',
                    data: {ids : this.selectedData}
                }).then(() => {
                    this._getPronova();
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
                        url: `/api/pronova/update/${id}`,
                        data: formdata
                    }).then(() => {
                        this._getPronova();
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
                        url: '/api/pronova/store',
                        data: formdata
                    }).then(() => {
                        this._getPronova();
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
            this._getPronova();
        },

        watch:{
            
        }
    }
</script>

<style scoped>


</style>