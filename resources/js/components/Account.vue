<template>
   <div style="background-color:#D7D3D3">
    <br>
    <v-row>
        <v-col cols="12">
            <v-card flat>
                <v-row>
                    
                    <!-- <v-col >
                        <br>
                        <span style="margin-left:50px!important;"> UserName</span>
                    </v-col>
                    <v-col cols="5">
                        <br>
                        <v-text-field style="width:400px;" outlined dense label="USER"></v-text-field>
                    </v-col>
                    <v-col>
                        <br>
                        <span> Phone Nmuber</span>
                    </v-col>
                    <v-col cols="5">
                        <br>
                        <v-text-field style="width:400px;" outlined dense label="Phone Number"></v-text-field>
                    </v-col> -->
                </v-row>
            </v-card>
        </v-col>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Account List
                    <v-spacer/>
                    <v-btn @click="Add()" color="primary">Add Account</v-btn>
                    <v-icon @click="Refresh()">mdi-refresh</v-icon>
                </v-card-title>
                <v-simple-table>
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>UserName</th>
                            <th>Actual Name</th>
                            <th>Phone Number</th>
                            <th>Created Date</th>
                            <th>Role</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(accounts,index) in accounts" :key="index">
                            <td>{{accounts.id}}</td>
                            <td>{{accounts.UserName}}</td>
                            <td>{{accounts.ActualName}}</td>
                            <td>{{accounts.PhoneNumber}}</td>
                            <td>{{(accounts.created_at).slice(0, 19)}}</td>
                            <td>
                                <span v-if="accounts.Role == 0">To Promote</span>
                                <span v-if="accounts.Role == 1">Deposit and Withdrawal</span>
                                <span v-if="accounts.Role == 2">System Administrator</span>
                            </td>
                            <td>{{accounts.Remarks}}</td>
                            <td>
                                <v-icon @click="HandleEdit(accounts)">mdi-pencil</v-icon>
                                <v-icon>mdi-trash-can</v-icon>
                            </td>

                        </tr>
                    </tbody>
                </v-simple-table>
            </v-card>
        </v-col>
    </v-row>

    <v-dialog v-model="AddDialog" width="600px" persistent>
        <v-card flat>
            <v-card-title >{{title}} Account 
                <v-spacer/>
                <v-icon @click="Handleclose()">mdi-close-circle</v-icon>
            </v-card-title>
            <v-card-text>
                <v-row no-gutters>
                    <v-col class="pt-3" cols="2">
                        <span>*</span><label>UserName</label>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field 
                        v-model="AddData.UserName" 
                        outlined dense label="Username"
                        ></v-text-field>
                    </v-col>
                    
                    <v-col class="pt-3" cols="2">
                        <span>*</span><label>Password</label>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field 
                        v-model="AddData.Password" 
                        outlined dense label="Password"
                        ></v-text-field>
                    </v-col>

                    <v-col class="pt-3" cols="2">
                        <span>*</span><span>Role</span>
                    </v-col>
                    <v-col cols="10">
                        <v-autocomplete 
                        :items="Role" 
                        item-text="Name"
                        item-value="value"
                        v-model="AddData.Role" 
                        outlined dense label="Role"
                        ></v-autocomplete>
                    </v-col>

                    <v-col class="pt-3" cols="2">
                        <span>*</span><span>Department</span>
                    </v-col>
                    <v-col cols="10">
                        <v-autocomplete
                        :items="Department" 
                        v-model="AddData.Department" 
                        outlined dense label="Department"
                        ></v-autocomplete>
                    </v-col>

                    <v-col class="pt-3" cols="2">
                        <span>*</span><span>Actual Name</span>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field 
                        v-model="AddData.ActualName" 
                        outlined dense label="Actual Name"
                        ></v-text-field>
                    </v-col>

                    <v-col class="pt-3" cols="2">
                        <span>Phone Number</span>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field 
                        @keypress="onlyNumber"
                        v-model="AddData.PhoneNumber" 
                        outlined dense label="Phone Number"
                        ></v-text-field>
                    </v-col>

                    <v-col class="pt-3" cols="2">
                        <span>Super Administrator</span>
                    </v-col>
                    <v-col cols="10">
                        <v-btn-toggle
                        v-model="AddData.toggle_exclusive"
                        mandatory
                        >
                        <v-btn dark color="primary" value="0">
                            No
                        </v-btn>
                        <v-btn dark color="primary" value="1">
                            Yes
                        </v-btn>
                        </v-btn-toggle>
                    </v-col>

                    <v-col class="pt-3" cols="2">
                        <span>*</span><span>Remarks</span>
                    </v-col>
                    <v-col cols="10">
                        <v-text-field 
                        v-model="AddData.Remarks" 
                        outlined dense label="Remarks"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn >Cancel</v-btn>
                <v-btn @click="SAVE()" color="primary">Confirm</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
   </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    data:()=>({
    
    title: '',
    AddDialog: false,
    AddData : {},
    Role : [
        { Name :'To Promote', value: 0} ,
        { Name :'Deposit and Withdrawal',value : 1} ,
        { Name :'System Administrator', value : 2} ,
    ],
    Department : [
        'L1 Department',
        'Technology Department'
    ]
    }),

    created(){
        console.log(this.accounts)
    },

    computed:{

        ...mapState
            ([
                'accounts'
            ])
        
    },

    mounted(){
                this.GetAccounts()
    },
    

    methods:{
        ...mapActions
            ([
                'GetAccounts'
            ]),


        Add(){
            this.title = "Add"
            this.AddDialog = true
        },

        HandleEdit(item){
            
            this.AddData = {...item}
            this.title = "Edit"
            this.AddDialog = true
            console.log(this.AddData)
        },

        SAVE(){
            if(this.title == 'Add'){
                axios.post('api/account/store',this.AddData).then((res)=>{
                if(res.data){
                    this.AddData = {}
                    this.AddDialog = false
                    alert('pasok')
                    this.GetAccounts()
                }
            })
            }else{
                axios.post(`api/account/update/${this.AddData.id}`,this.AddData).then((res)=>{
                if(res.data){
                    this.AddData = {}
                    this.AddDialog = false
                    alert('pasok')
                    this.GetAccounts()
                }
            })
            }
            
        },

        onlyNumber($event) {
            let keyCode = $event.keyCode ? $event.keyCode : $event.which;
            if (keyCode < 48 || keyCode > 57) {
                // 46 is dot
                $event.preventDefault();
            }
        }, //END FOR ONLY NUMBER FUNCTION

        Handleclose(){
            this.AddDialog = false;
            this.AddData = {};
        },

        Refresh(){
            location.reload();
        }
    }
}
</script>

<style scoped>
tbody,
th,
thead,
tr,
td {
    border: 1px solid black;
    border-collapse: collapse;
    font-weight: bold;
    
}
th {
    background-color: #cfd8dc !important;
    font-weight: bold !important;
    text-align: center !important;
    color: black!important;
}

</style>