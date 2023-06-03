<template>
    <div>
        <app-toolbar :toolbar="toolbar"></app-toolbar>
        <v-container fluid>
        <!-- mainTable Start -->
            <v-simple-table class="mainTable" fixed-header height="75vh">
                <thead>
                    <tr>
                        <th> NAME </th>
                        <th v-show="editMode" width="20">
                        </th>
                        <th v-show="editMode" width="20">EDIT</th>
                        <th> REMARKS </th>
                        <th v-show="viewMode"> CREATED </th>
                        <th v-show="viewMode"> UPDATED </th>
                        <th v-show="viewMode"> CREATED BY </th>
                        <th v-show="viewMode"> UPDATED BY </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(house_type, i) in HOUSE_TYPE_REMARKS" :key="i">
                         
                        <td> {{ house_type.name }} </td>
                        <td v-show="editMode">
                            <v-checkbox v-model="house_type.selected" dense></v-checkbox>
                        </td>
                        <td v-show="editMode"> 
                            <v-btn
                                fab
                                x-small
                                @click="toggleUpdateDialog(house_type)"
                            >
                                <v-icon >mdi-pencil</v-icon> 
                            </v-btn>
                        </td>
                         <td> 
                            <v-chip small class="mr-1" v-for="(remarks, ii) in house_type.remarks" :key="ii+i+'REMARKS'">
                                <span class="caption font-weight-black">
                                {{ remarks.remark }}
                                </span> 
                            </v-chip>
                        </td>
                        <td v-show="viewMode"> {{ formatDate(house_type.created_at) }} </td>
                        <td v-show="viewMode"> {{ formatDate(house_type.updated_at) }} </td>
                        <td v-show="viewMode"> {{ house_type.created_by }} </td>
                        <td v-show="viewMode"> {{ house_type.updated_by }} </td>
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
                    <v-card-title> <span class="overline">Create Remark</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-autocomplete 
                                        v-model="tempData.house_type_id" 
                                        outlined 
                                        dense 
                                        label="House Type"
                                        name="house_type_id" 
                                        :items="HOUSE_TYPES"
                                        item-text="name"
                                        item-value="id"
                                        class="required"
                                        :rules="rules.required"
                                    > </v-autocomplete>
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete
                                        v-model="tempData.remarks" 
                                        multiple
                                        outlined 
                                        :items="REMARKS"
                                        item-text="name"
                                        item-value="id"
                                        label="Remarks"
                                        class="required"
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
                                                @click:close="remove(data.item)"
                                            >
                                                {{ data.item.name }}
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
                    <v-card-title> <span class="overline">Edit Remark</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                               <v-col cols="12">
                                    <v-autocomplete 
                                        v-model="tempData.house_type_id" 
                                        outlined 
                                        dense 
                                        label="House Type"
                                        name="house_type_id" 
                                        :items="HOUSE_TYPES"
                                        item-text="name"
                                        item-value="id"
                                        class="required"
                                        :rules="rules.required"
                                    > </v-autocomplete>
                                </v-col>
                                <v-col cols="12">
                                    <v-autocomplete
                                        v-model="tempData.remarks" 
                                        multiple
                                        outlined 
                                        :items="REMARKS"
                                        item-text="name"
                                        item-value="id"
                                        label="Remarks"
                                        class="required"
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
                                                @click:close="remove(data.item)"
                                            >
                                                {{ data.item.name }}
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
        <app-footer :items="HOUSE_TYPE_REMARKS.length"></app-footer>
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
                title: 'HOUSE TYPE REMARKS',
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
                'HOUSE_TYPE_REMARKS',
                'REMARKS',
                'HOUSE_TYPES',
                'rules',
                'viewMode',
                'editMode'
            ]),

            selectedData(){
                // this will return only the id of the selected data
                return this.HOUSE_TYPE_REMARKS.filter(res => res.selected).map(res => res.id); 
            }
        },

        methods: {
            ...mapActions([
                '_getRemarks',
                '_getHouseTypes',
                '_getHouseTypeRemarks'
            ]),

            remove(item) {
                this.$nextTick(() => {
                    const index = this.tempData.remarks.findIndex(res => res == item.id)
                    if (index >= 0) this.tempData.remarks.splice(index, 1)
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

                    this.tempData.remarks.map( res => formdata.append('remarks[]', res));

                    axios({
                        method: 'POST',
                        url: '/api/house_type_remarks/store',
                        data: formdata
                    }).then(() => {
                        this._getHouseTypeRemarks();
                        this.dialogStore = false;
                    })
                }
            },

            toggleUpdateDialog(item){
                console.log(item)
                if(item){
                    this.tempData = {...item};
                    this.tempData.house_type_id = item.id;
                    this.tempData.old_remarks = [...this.tempData.remarks.map(res => res.remark_id)];
                    this.tempData.remarks = [...this.tempData.remarks.map(res => res.remark_id)];
                    console.log(this.tempData)
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
                    this.tempData.old_remarks.map( res => formdata.append('old_remarks[]', res));
                    this.tempData.remarks.map( res => formdata.append('remarks[]', res));

                    axios({
                        method: 'POST',
                        url: `/api/house_type_remarks/update/${id}`,
                        data: formdata
                    }).then(() => {
                        this._getHouseTypeRemarks();
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
                    url: '/api/house_type_remarks/delete',
                    data: {ids : this.selectedData}
                }).then(() => {
                    this._getHouseTypeRemarks();
                    this.dialogDelete = false;
                })
            }
        },

        mounted() {
            this._getRemarks();
            this._getHouseTypes();
            this._getHouseTypeRemarks();
        },

        watch:{
            dialogStore(value){
                if( ! value ) this.$refs.Store.reset();
            },

            dialogUpdate(value){
                if( ! value ) this.$refs.Update.reset();
            },

        }
    }
</script>

<style scoped>


</style>