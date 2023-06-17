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
                    :items="clients"
                >
                <template v-slot:[`item.exchange`]="{ item }">
          
                    <v-btn
                        :disabled="item.Asset == 0?true:false"
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
                                       

                                       >Balance:{{tempData.amount == null? 0 :parseFloat(tempData.Asset) - parseFloat(tempData.amount)}} </span>

                                    <!-- :rules="rules.uniqueData(ROLES)" -->
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="submit()">Submit</v-btn>
                        <v-btn text @click="dialogExchange = false">Cancel</v-btn>
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
            clients: [],
            prev:null,
            headers: [
                {
                    text: 'Name', align: 'start', value: 'name',
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
                { text: 'Exchange', value: 'exchange', sortable: false, width: "10%" },

                { text: 'Actions', value: 'actions', sortable: false, width: "10%" },
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
                url: `/api/admin/${this.loggedInUser.id}/clients`
            }).then(( { data } ) => {
                this.clients = [...data]
            })
        },
        toggleExchange(isShow,obj = {}){
         this.tempData = {...obj}
         this.dialogExchange = true;
            console.log(this.tempData)
        },
        submit(){
            if(this.tempData.Asset == null ){
                this.tempData.Asset = 0
            }else{
                this.tempData.Asset
            }
if(this.selectedExchange == 'Withdraw'){
    this.tempData.Asset =  this.tempData.Asset - parseFloat(this.tempData.amount)

}
else{
    this.tempData.Asset =  this.tempData.Asset + parseFloat(this.tempData.amount)

}
    console.log(this.tempData.Asset,'this.tempData.Asset')
            // this.addHistory(this.te);
          this.tempData.updated_at = moment().format("YYYY-MM-DD HH:mm:ss");
        //   this.tempData.created_at = moment().format("YYYY-MM-DD HH:mm:ss");
          this.tempData.client_name = this.tempData.name;
          this.tempData.Amount = this.tempData.amount;
          this.addHistory(this.tempData)

            axios.post(`/api/user/update3/${this.tempData.client_id}`,{Amount:this.tempData.Asset})
                .then((res) => {
                    this.tempData = {};
                    this.dialogExchange = false;

                });
        },

        // getExchangeHistory() {
        //     axios.get(`api/history`).then((res) => {
        //         this.getmarket_arr = res.data;
        //         // console.log(this.getmarket_arr);
        //     });
       
        // },
        addHistory(obj){
            console.log(obj)
            if(this.selectedExchange == 'Withdraw'){
                obj.prev_Asset = this.tempData.Asset + parseFloat(this.tempData.amount) ;


            }else{
                obj.prev_Asset = this.tempData.Asset - parseFloat(this.tempData.amount) ;

            }
obj.exchange_name = this.selectedExchange
            axios.post("api/history/store", obj)
                .then((res) => {
                    this.initialize();
                    this.tempData = {};
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