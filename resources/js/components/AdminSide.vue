<template>
    <div class="table-container">

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
  
<v-data-table height="60vh"  class="mainTable" :headers="headers" :items="tradeorders" :fixed-header="true">
<template v-slot:item="{ item }">
            
        <!-- <v-simple-table flat style="overflow-y: auto"  dense    :height="$vuetify.breakpoint.height - 200">
            <template v-slot:default>
            <thead>
                <tr>
                    <th  style="font-size:10px">ODER ID</th>
                    <th  style="font-size:10px">USER ID</th>
                    <th  style="font-size:10px">USER ACCOUNT</th>
                    <th  style="font-size:10px">CONTRACT</th>
                    <th  style="font-size:10px">TYPE</th>
                    <th  style="font-size:10px">TIME</th>
                    <th  style="font-size:10px">TRADING</th>
                    <th  style="font-size:10px">QUANTITY</th>
                    <th  style="font-size:10px">PRESET</th>
                    <th  style="font-size:10px">RESULT</th>
                    <th  style="font-size:10px">PROFIT</th>
                    <th  style="font-size:10px">OPENING PRICE</th>
                    <th  style="font-size:10px">CLOSE PRICE</th>
                    <th  style="font-size:10px">ORDER TIME</th>
                    <th  style="font-size:10px">CLOSE TIME</th>
                    <th  style="font-size:10px">UPDATED</th>
                    <th  style="font-size:10px">COMPLETE TIME</th>
                    <th  style="font-size:10px">ACTIONS</th>
                </tr>
            </thead>
            <tbody> -->

                <tr>
                    <td style="font-size:12px">{{ item.id }}</td>
                    <td style="font-size:12px">{{ item.User_code }}</td>
                    <td style="font-size:12px">{{ item.user_account }}</td>
                    <td style="font-size:12px">{{ item.contract }}</td>
                    <td style="font-size:12px">
            <span>{{ item.type == 'sell' ? 'Down' : 'Up' }}</span>
           <!-- <v-icon small>mdi-arrow-down</v-icon> <span>{{ item.type == 'buy' ? 'Up' : 'Down' }}</span> -->
                        <v-chip outlined color="success" dense x-small  v-if="item.type == 'sell'">
                            Set Up
                        </v-chip>
                        
                        <v-chip color="error" dense x-small outlined  v-else>
                            Set Down
                        </v-chip>


                    </td>
                    <td style="font-size:12px">{{ item.seconds }}</td>
                    <td style="font-size:12px">{{ item.trading }}</td>
                    <td style="font-size:12px">{{ item.quantity }}</td>
                    <td style="font-size:12px">{{ item.preset }}</td>
                    <td style="font-size:12px">{{ item.result }}</td>
                    <td style="font-size:12px">{{ item.profit }}</td>
                    <td style="font-size:12px">{{ item.opening_price }}</td>
                    <td style="font-size:12px">{{ item.closing_price }}</td>
                    <td style="font-size:12px">{{ item.order_time }}</td>
                    <td style="font-size:12px">{{ item.closing_time }}</td>
                    <td style="font-size:12px">{{ item.complete_time }}</td>
                    <td style="font-size:12px">{{ item.complete_time }}</td>
                    <!-- <td>{{item.order_time}}</td>
                <td>{{(item.created_at).slice(0, 10)}}</td> -->
                <td class="sticky-last-column"  >
              <v-btn
                x-small
                color="success"
                style="font-weight: bold"
                @click="winBtn(item)"
                v-if="item.complete_time == null"
              >
                Win
              </v-btn>
              <v-btn
                color="error"
                style="font-weight: bold"
                x-small
                @click="loseBtn(item)"
                v-if="item.complete_time == null"
              >
                Lose
              </v-btn>
                      </td>
                </tr>
                </template>
                </v-data-table>
            <!-- </tbody>
            </template>
        </v-simple-table> -->
        <!--end of simple table-->
    </div>
</template>

<script>
import moment from "moment";
import axios from "axios";
import Swal from "sweetalert2";

export default {
    sockets: {
        // NOTE : SOCKET 
        updateReceived: function(socket) {
            console.log(socket)
            if( socket.updateType && socket.updateType == 'GetTrade'){
                console.log('getData')
                this.GetTradeorders()
            }
        }
    },
    data() {
        return {
            settimes: '',
            obj: {},
            
      search: "",
  
            tradeorders :[
                
            ],
            headers:[
                { text: "Order ID",  value: "id", class: 'sticky-header' },
          { text: "User ID",  value: "User_code", class: 'sticky-header' },
          { text: "User Account",  value: "user_account", class: 'sticky-header' },
          { text: "Contract",  value: "contract", class: 'sticky-header' },
          { text: "Type",  value: "type", class: 'sticky-header' },
          { text: "Time",  value: "seconds", class: 'sticky-header' },
          { text: "Trading",  value: "trading", class: 'sticky-header' },
          { text: "Quantity",  value: "quantity", class: 'sticky-header' },
          { text: "Preset",  value: "preset", class: 'sticky-header' },
          { text: "Result",  value: "result", class: 'sticky-header' },
          { text: "Profit",  value: "profit", class: 'sticky-header' },
          { text: "opening Price",  value: "opening_price", class: 'sticky-header' },
          { text: "Close Price",  value: "closing_price", class: 'sticky-header' },
          { text: "Order Time",  value: "order_time", class: 'sticky-header' },
          { text: "Close Time",  value: "closing_time", class: 'sticky-header' },
          { text: "Updated",  value: "complete_time", class: 'sticky-header' },
          { text: "Completed Time",  value: "complete_time",  class: 'sticky-header' },
          { text: "Actions", value: "action", sortable: false, width: "10%", class: 'sticky-header sticky-last-column'},

            ]

            // oras:moment().format('MMMM Do YYYY, h:mm:ss a')
        }
    },

    created() {
        this.GetTradeorders()
        // setInterval(() => { this.settimes = moment().format("YYYY-MM-DD HH:mm:ss a"); }, 1000);
    },

    computed:
    {

    },//end of amputed
    methods: {


  

        winBtn(val) {
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation : false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar : true,
                dibOpen : (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            console.log(val)
            this.obj = { ...val }
            this.obj.preset = 'Win'
            console.log(  this.obj, 'obj');
            axios
                .put("api/Dashboard/update", this.obj)
                .then((res) => {
                    this.obj = {}
                    this.GetTradeorders()
                    toastMixin.fire({
                        icon: 'success',
                        title : 'Success!',
                        animation:true,
                        text: 'Sucessfully Set Win on PRESET updated',
                        })
                });
        },
        loseBtn(val){
            var toastMixin = Swal.mixin({
                toast: true,
                icon: 'success',
                title: 'General Title',
                animation : false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar : true,
                dibOpen : (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            console.log(val)
            this.obj = { ...val }
            this.obj.preset = 'Lose'
            console.log(  this.obj, 'obj');
            axios
                .put("api/Dashboard/update", this.obj)
                .then((res) => {
                    this.obj = {}
                    this.GetTradeorders()
                    toastMixin.fire({
                        icon: 'success',
                        title : 'Success!',
                        animation:true,
                        text: 'Sucessfully Set Lose on PRESET updated',
                        })
                });
        },
        GetTradeorders(){
            axios.get(`api/TradeOrders`).then((res)=>{
                this.tradeorders = res.data
                console.log('gettrade',this.tradeorders)
            })
        },

    },
}
</script>

<style >
  .table-container {
    position: relative;
  }
  
  .sticky-header {
    position: sticky;
    top: 0;
    background-color: #fff; /* Optional: Set the desired background color */
    z-index: 1; /* Optional: Adjust the stacking order if needed */
  }
  
  .sticky-last-column {
    position: sticky;
    right: 0;
    background-color: #fff; /* Optional: Set the desired background color */
    z-index: 1; /* Optional: Adjust the stacking order if needed */
  }
</style>