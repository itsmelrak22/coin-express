<template>
    <div>
        <h4>Welcome admin side trade order</h4>
            
        <v-simple-table flat style="overflow-y: auto"  dense    :height="$vuetify.breakpoint.height - 200">
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
            <tbody>

                <tr v-for="(tradeorders, index) in tradeorders" :key="index">
                    <td style="font-size:12px">{{ tradeorders.id }}</td>
                    <td style="font-size:12px">{{ tradeorders.User_code }}</td>
                    <td style="font-size:12px">{{ tradeorders.user_account }}</td>
                    <td style="font-size:12px">{{ tradeorders.contract }}</td>
                    <td style="font-size:12px">
           <v-icon small>mdi-arrow-up</v-icon> <span>{{ tradeorders.direction == 'sell' ? 'Down' : 'Up' }}</span>

                        <v-chip outlined color="success" dense x-small  v-if="tradeorders.direction == 'sell'">
                            Set Up
                        </v-chip>
                        <v-chip color="error" dense x-small outlined      v-else>
                            Set Down
                        </v-chip>


                    </td>
                    <td style="font-size:12px">{{ tradeorders.seconds }}</td>
                    <td style="font-size:12px">{{ tradeorders.trading }}</td>
                    <td style="font-size:12px">{{ tradeorders.quantity }}</td>
                    <td style="font-size:12px">{{ tradeorders.preset }}</td>
                    <td style="font-size:12px">{{ tradeorders.result }}</td>
                    <td style="font-size:12px">{{ tradeorders.profit }}</td>
                    <td style="font-size:12px">{{ tradeorders.opening_price }}</td>
                    <td style="font-size:12px">{{ tradeorders.closing_price }}</td>
                    <td style="font-size:12px">{{ tradeorders.order_time }}</td>
                    <td style="font-size:12px">{{ tradeorders.closing_time }}</td>
                    <td style="font-size:12px">{{ tradeorders.complete_time }}</td>
                    <td style="font-size:12px">{{ tradeorders.complete_time }}</td>
                    <!-- <td>{{tradeorders.order_time}}</td>
                <td>{{(tradeorders.created_at).slice(0, 10)}}</td> -->
                    <td v-if="tradeorders.complete_time == null ">
                        <v-btn class="elevation-5" x-small dark @click="winBtn(tradeorders)">Win</v-btn>
                        <v-btn class="elevation-5" x-small dark @click="loseBtn(tradeorders)">Lost</v-btn>
                    </td>
                </tr>
            </tbody>
            </template>
        </v-simple-table><!--end of simple table-->
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import moment from "moment";
import axios from "axios";

export default {
    data() {
        return {
            settimes: '',
            obj: {},

            // oras:moment().format('MMMM Do YYYY, h:mm:ss a')
        }
    },

    created() {

        setInterval(() => { this.settimes = moment().format("YYYY-MM-DD HH:mm:ss a"); }, 1000);
    },

    computed:
    {
        ...mapState
            ([
                'tradeorders',
            ])
    },//end of amputed
    methods: {


        ...mapActions
            ([
                'GetTradeorders'
            ]),

        // function : update() {
        //     $('#clock').html(moment().format('D. MMMM YYYY H:mm:ss'));
        // }

        // setInterval(update, 1000);

        winBtn(val) {
            console.log(val)
            this.obj = { ...val }
            this.obj.preset = 'Win'
            this.obj.result = parseFloat(this.obj.quantity) + parseFloat(this.obj.profit);
            console.log(this.obj.result)

         
            this.obj.closing_time = moment().format(`${combine}`);
            this.obj.complete_time =  moment().format("YYYY-MM-DD HH:mm:ss");
            this.obj.updated = moment().format("YYYY-MM-DD HH:mm:ss");

            console.log(  this.obj.closing_time, 'ordertime');

            axios
                .put("api/Dashboard/update", this.obj)
                .then((res) => {
                    this.obj = {}
                });
  
        }
    },

    mounted() {
        this.GetTradeorders()
    }
}
</script>

<style scoped>
table {
  border-collapse: collapse;
}

th {



  font-size: 8px;

}

td {
 

font-size: 8px;
  text-align: center;
}
</style>