<template>
    <v-container fluid>
        <v-card flat>
            <v-card-title class="mt-5 text-h4">ENTRANCE DOOR
                <v-toolbar flat dense><v-spacer/>  
                    <v-btn 
                        dense 
                        color="#0277BD"
                        @click="addEntranceDialog=true"
                        align-center
                        width="170px"
                        class="white--text"
                        style="font-weight:bold;font-size:16px;">
                        <v-icon color="white">mdi-plus-circle
                        </v-icon>ADD</v-btn>
                </v-toolbar>
            </v-card-title>
            <v-card-text class="pb-0">
                <v-row>
                    <v-col cols="2">
                        <v-text-field
                            v-model="search"
                            label="Search..."
                            name="search"
                            prepend-inner-icon="mdi-magnify"
                            id="searchHouse"
                            dense
                            outlined
                            hide-details>
                        </v-text-field>
                    </v-col>
                    <v-col cols="2">
                        <v-select 
                            v-model="houseTypeFilter"
                            @change="filter()"
                            :items="houseTypeList"
                            label="House Type"
                            item-text="HouseType"
                            item-value="HouseType"
                            dense
                            outlined
                            hide-details>
                        </v-select>
                    </v-col>
                </v-row>
                <!-- TABLE OF ENTRANCE DOOR MASTER -->
                <v-simple-table height="600px" fixed-header class="mt-5" style="overflow:hidden;border:1px solid #757575;">
                    <thead>
                        <tr>
                            <th style="background-color: #263238; color: white; text-align:center;">Door Type</th>
                            <th style="background-color: #263238; color: white; text-align:center;">Door Type Name</th>
                            <th style="background-color: #263238; color: white; text-align:center;">House Type</th>
                            <th style="background-color: #263238; color: white; text-align:center;">Door Item</th>
                            <th style="background-color: #263238; color: white; text-align:center;">Door Color</th>
                            <th style="background-color: #263238; color: white; text-align:center;">Abbrv Name</th>
                            <th style="background-color: #263238; color: white; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="(item,index) in searchHouse" :key="index">
                            <td style="text-align:center;">{{item.DoorType}}</td>
                            <td style="border-left:1px solid #757575;text-align:center;">{{item.DoorTypeName}}</td>
                            <td style="border-left:1px solid #757575;text-align:center;">{{item.HouseType}}</td>
                            <td style="border-left:1px solid #757575;text-align:center;">{{item.DoorItem}}</td>
                            <td style="border-left:1px solid #757575;text-align:center;">{{item.DoorColor}}</td>
                            <td style="border-left:1px solid #757575;text-align:center;">{{item.DoorColorAbbreviationName}}</td>
                            <td style="border-left:1px solid #757575;text-align:center;">
                                <v-tooltip bottom color="green">
                                    <template v-slot:activator="{on}">
                                        <v-btn
                                            @click="editEntrance(item)"
                                            icon
                                            v-on="on">
                                            <v-icon color="green">mdi-pencil</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>アップデート</span>
                                </v-tooltip> 

                                <v-tooltip bottom color="red">
                                    <template v-slot:activator="{on}">
                                        <v-btn 
                                            @click="deleteEntrance(item)"
                                            icon 
                                            v-on="on">
                                            <v-icon color="red">mdi-trash-can</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>デリート</span>
                                </v-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </v-simple-table>
            </v-card-text>
        </v-card>
        <span style="margin-left:18px;">Total record(s) of <b>{{Number(entranceMaster.length).toLocaleString()}}</b></span>

        <!-- ADD ENTRANCE DOOR -->
        <v-dialog v-model="addEntranceDialog" width="20%" persistent>
            <v-form id="StoreEntrance" ref="StoreEntrance" @submit.prevent="StoreEntrance">
                <v-card>
                    <v-card-title>Add Item</v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-text-field
                                v-model="addEntranceObj.DoorType"
                                dense
                                outlined
                                block
                                label="Door Type"
                                name="DoorType"
                                class="mt-5"
                                :rules="rules.required">
                            </v-text-field>
                            <v-text-field
                                v-model="addEntranceObj.DoorTypeName"
                                dense
                                outlined
                                block
                                label="Door Type Name"
                                name="DoorTypeName"
                                class="mt-0"
                                :rules="rules.required">
                            </v-text-field>
                            <v-autocomplete
                                v-model="addEntranceObj.HouseType"
                                dense
                                outlined
                                multiple
                                :items="houseTypeList"
                                label="House Type"
                                name="HouseType"
                                item-text="HouseType"
                                item-value="HouseType"
                                class="mt-0"
                                :rules="rules.required">
                            </v-autocomplete>
                            <v-text-field
                                v-model="addEntranceObj.DoorItem"
                                dense
                                outlined
                                block
                                label="Door Item"
                                name="DoorItem"
                                class="mt-0"
                                :rules="rules.required">
                            </v-text-field>
                            <v-text-field
                                v-model="addEntranceObj.DoorColor"
                                dense
                                outlined
                                block
                                label="Door Color"
                                name="DoorColor"
                                class="mt-0"
                                :rules="rules.required">
                            </v-text-field>
                            <v-text-field
                                v-model="addEntranceObj.DoorColorAbbreviationName"
                                dense
                                outlined
                                block
                                label="Door Color Abbreviation Name"
                                name="DoorColorAbbreviationName"
                                class="mt-0"
                                :rules="rules.required">
                            </v-text-field>
                        </v-container>
                    </v-card-text>
                    <v-divider class="mt-0"></v-divider>
                    <v-card-actions><v-spacer/>
                        <v-btn outlined class="ml-2 mb-2" color="red" @click="closeAddEntrance()" dark>キャンセル</v-btn>
                        <v-btn type="submit" outlined class="ml-2 mb-2" color="blue" dark>修正</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>

        <!-- EDIT ENTRANCE -->
        <v-dialog v-model="editEntranceDialog" width="20%" persistent>
            <v-form id="UpdateEntrance" ref="UpdateEntrance" @submit.prevent="UpdateEntrance">
                <v-card>
                    <v-card-title>Update Item</v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-text-field
                                v-model="addEntranceObj.DoorType"
                                dense
                                outlined
                                block
                                hide-details
                                label="Door Type"
                                name="DoorType"
                                class="mt-5">
                            </v-text-field>
                            <v-text-field
                                v-model="addEntranceObj.DoorTypeName"
                                dense
                                outlined
                                block
                                hide-details
                                label="Door Type Name"
                                name="DoorTypeName"
                                class="mt-5">
                            </v-text-field>
                            <v-autocomplete
                                v-model="addEntranceObj.HouseType"
                                dense
                                outlined
                                multiple
                                hide-details
                                :items="houseTypeList"
                                label="House Type"
                                name="HouseType"
                                item-text="HouseType"
                                item-value="HouseType"
                                class="mt-5">
                            </v-autocomplete>
                            <v-text-field
                                v-model="addEntranceObj.DoorItem"
                                dense
                                outlined
                                block
                                hide-details
                                label="Door Item"
                                name="DoorItem"
                                class="mt-5">
                            </v-text-field>
                            <v-text-field
                                v-model="addEntranceObj.DoorColor"
                                dense
                                outlined
                                block
                                hide-details
                                label="Door Color"
                                name="DoorColor"
                                class="mt-5">
                            </v-text-field>
                            <v-text-field
                                v-model="addEntranceObj.DoorColorAbbreviationName"
                                dense
                                outlined
                                block
                                hide-details
                                label="Door Color Abbreviation Name"
                                name="DoorColorAbbreviationName"
                                class="mt-5">
                            </v-text-field>
                            <input type="hidden" :value="entranceID" name="id">
                        </v-container>
                    </v-card-text>
                    <v-card-actions><v-spacer/>
                        <v-btn outlined class="ml-2 mb-2" color="red" @click="closeEditEntrance()" dark>キャンセル</v-btn>
                        <v-btn type="submit" outlined class="ml-2 mb-2 mr-3" color="blue" dark>アップデート</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>

        <!-- DELETE ENTRANCE -->
        <v-dialog v-model="deleteEntranceDialog" width="18%" persistent>
            <v-form id="DeleteEntrance" ref="DeleteEntrance" @submit.prevent="DeleteEntrance">
                <v-card>
                    <v-card-title>確認内容</v-card-title>
                    <v-card-text>
                        <v-container>
                            <span :v-model="doorName">Are you sure you want to delete Door Type <strong>{{doorName}}</strong> ?</span>
                        <v-card-text>    
                            <input type="hidden" :value="entranceID" name="id">
                        </v-card-text>    
                        </v-container>
                    </v-card-text>
                    <v-card-actions><v-spacer/>
                        <v-btn dense flat @click="closeDeleteEntrance()">キャンセル</v-btn>
                        <v-btn dense flat @click="DeleteEntrance()" color="success">Yes</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
    </v-container>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data: () => ({
        addEntranceObj: {},
        entranceMaster: [],
        houseTypeList : [],
        search: '',
        houseTypeFilter: '',
        doorName: '',


        //Dialog
        addEntranceDialog: false,
        editEntranceDialog: false,
        deleteEntranceDialog: false,

        entranceID: null,
    }),

    methods: {
        entranceDoor(){
            axios({
                method : "get",
                url : "api/entranceDoorSetting",
            }).then((res) => {
                this.entranceMaster = res.data
                
                // console.log(res.data)
            })
        },

        houseTypes(){
            axios({
                method: "get",
                url : "api/getHouseTypes"
            }).then((res) => {
                this.houseTypeList = res.data;
                
                // console.log(res.data)
            })
        },

        filter(){
            axios({
                method : "post",
                url : "api/filterByHouseType",
                data : {
                    HouseType : this.houseTypeFilter
                }
            }).then((res) => {
                this.entranceMaster = res.data;
            })
        },

        closeAddEntrance(){
            this.addEntranceDialog = false;
            this.$refs.StoreEntrance.reset();
        },

        closeEditEntrance(){
            this.editEntranceDialog = false;
            this.$refs.UpdateEntrance.reset();
        },

        closeDeleteEntrance(){
            this.deleteEntranceDialog = false;
            this.$refs.DeleteEntrance.reset();
        },

        editEntrance(item){
            if(item.HouseType.includes('/')){
                item.HouseType = item.HouseType.split('/')
            }
            this.entranceID = item.id;
            this.addEntranceObj.HouseType = item.HouseType;
            this.addEntranceObj.DoorType = item.DoorType;
            this.addEntranceObj.DoorTypeName = item.DoorTypeName;
            this.addEntranceObj.HouseType = item.HouseType;
            this.addEntranceObj.DoorItem = item.DoorItem;
            this.addEntranceObj.DoorColor = item.DoorColor;
            this.addEntranceObj.DoorColorAbbreviationName = item.DoorColorAbbreviationName;
            this.editEntranceDialog = true;
        },

        deleteEntrance(item){
            console.log(item);
            this.entranceID = item.id;
            this.doorName = item.DoorType;
            this.deleteEntranceDialog = true;
        },

        StoreEntrance(){
            if(this.$refs.StoreEntrance.validate()){
                const myForm = document.getElementById('StoreEntrance')
                const formdata = new FormData(myForm)

                axios({
                    method: 'post',
                    url: 'api/entranceDoorSetting/addEntranceRecord',
                    data: formdata
                }).then( () => {
                    this.entranceDoor();
                    this.closeAddEntrance();
                })
            }
        },

        UpdateEntrance(){
            if(this.$refs.UpdateEntrance.validate()){
                const myForm = document.getElementById('UpdateEntrance')
                const formdata = new FormData(myForm)

                axios({
                    method: 'post',
                    url: 'api/entranceDoorSetting/updateEntranceRecord',
                    data: formdata
                }).then( () => {
                    this.entranceDoor();
                    this.closeEditEntrance();
                })
            }
        },

        DeleteEntrance(){
            if(this.$refs.DeleteEntrance.validate()){
                const myForm = document.getElementById('DeleteEntrance')
                const formdata = new FormData(myForm)

                axios({
                    method: 'post',
                    url: 'api/entranceDoorSetting/deleteEntranceRecord',
                    data: formdata
                }).then( () => {
                    this.entranceDoor();
                    this.closeDeleteEntrance();
                })
            }
        },

        

    },

    mounted() {
        this.entranceDoor()
        this.houseTypes()
    },

    computed: {
        ...mapState([
            'rules'
        ]),

        searchHouse(){
            return this.entranceMaster.filter((data) => {
                let searchData = new RegExp(this.search.toUpperCase(), "g");
                return JSON.stringify(Object.values(data)).toUpperCase().match(searchData);
                
            });
        }
    },
}
</script>

<style scoped>

</style>