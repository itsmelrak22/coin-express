<template>
    <v-container fluid>
        <v-card>
            <v-card-text>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    hide-details
                ></v-text-field>
            </v-card-text>
        </v-card>

        <v-card>
            <v-card-text>
                <v-data-table
                    height="60vh"
                    class="mainTable"
                    :headers="headers"
                    :search="search"
                    :items="histories"
                >
                <template v-slot:[`item.exchange`]="{ item }">
          
                    <v-btn
                        x-small
                        class="mr-2"
                        @click="toggleExchange(selectedExchange='Withdraw', item)"
                    >
                        Withdraw
                    </v-btn>
                    <v-btn
                        x-small
                        @click="toggleExchange(selectedExchange='Deposit' , item)"
                    >
                        Deposit
                    </v-btn>
                </template>
                <template v-slot:[`item.actions`]="{  }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="toggleUpdate(true , item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="toggleDelete(true , item)"
                    >
                        mdi-delete
                    </v-icon>
                   
                </template>
                    <template v-slot:no-data>
                    <v-btn
                        
                        color="primary"
                        @click="initialize"
                    >
                        Reset
                    </v-btn>
                </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        
<!-- ################################# DIALOGS #################################-->
        <!-- dialogStore Start -->
        <v-dialog v-model="dialogExchange" max-width="300" persistent>
            <v-form id="Store" ref="Store" @submit.prevent="Store">
                <v-card>
                    <v-card-title> <span class="overline">{{selectedExchange}}</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field 
                                        outlined 
                                        dense 
                                        label="Amount"
                                        name="name" 
                                        class="required"
                                        v-model="tempData.amount"
                                    > </v-text-field>
                                    <!-- :rules="rules.uniqueData(ROLES)" -->
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col class="text-right" style="color:red;font-size:10px"  cols="12">
                                    <span>Name:{{tempData.email}}</span>
                        
                                    <br>
                                    <span
                                       

                                       >Asset:{{tempData.Asset}} </span>
                                    <br>
                                    <span
                                       

                                       >Balance:{{parseFloat(tempData.Asset) - parseFloat(tempData.amount)}} </span>

                                    <!-- :rules="rules.uniqueData(ROLES)" -->
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="submit()">Submit</v-btn>
                        <v-btn text @click="dialogStore = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogStore End -->

        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </v-container>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import moment from "moment";

export default {
    sockets: {

    },
    data(){
        return {
            dialogStore: false,
            dialogUpdate: false,
            dialogDelete: false,
            dialogExchange: false,
            overlay: false,
            histories: [],
            headers: [
            {
                    text: 'Exchange Name', align: 'start', value: 'exchange_name',
                },
                {
                    text: 'Client Name', align: 'start', value: 'client_name',
                },
                {
                    text: 'Email', align: 'start', value: 'email',
                },
                {
                    text: 'Invitation Code', align: 'start', value: 'invitation_code',
                },
                {
                    text: 'Inviter Email', align: 'start', value: 'inviter_email',
                },
                {
                    text: 'Asset', align: 'start', value: 'Asset',
                },
                {
                    text: 'Previous Asset', align: 'start', value: 'prev_Asset',
                },
                {
                    text: 'Amount', align: 'start', value: 'Amount',
                },
                {
                    text: 'Asset', align: 'start', value: 'Asset',
                },
                
            ],
            search: '',
            selectedExchange:'',
            tempData: {}
        }
    },
    // created:{

    // },

    computed:{
        ...mapState([
            'rules',
            'loggedInUser',
        ]),

    },


    methods: {
        ...mapActions([
        ]),
        async initialize(){
            await axios({
                method: "GET",
                url: `/api/history`
            }).then(( { data } ) => {
                this.histories = [...data]
            })
        },
        toggleExchange(isShow,obj = {}){
         this.tempData = {...obj}
         this.dialogExchange = true;
            console.log(this.tempData)

        },
        submit(){

          this.tempData.Asset =  this.tempData.Asset - parseFloat(this.tempData.amount)
console.log(this.tempData.Asset,'this.tempData.Asset')

          this.tempData.updated_at = moment().format("YYYY-MM-DD HH:mm:ss");
          this.tempData.created_at = moment().format("YYYY-MM-DD HH:mm:ss");
        //   this.addHistory(this.tempData)
            axios.post(`/api/user/update3/${this.tempData.client_id}`,{Amount:this.tempData.Asset})
                .then((res) => {
                    this.tempData = {};
                    this.dialogExchange = false;

                });
        },

        getExchangeHistory() {
            axios.get(`api/history`).then((res) => {
                this.getmarket_arr = res.data;
                // console.log(this.getmarket_arr);
            });
       
        },

  

    },

    async mounted(){
        this.overlay = true;
        await this.initialize().then(() => {
            this.overlay = false
        })
    }

}
</script>