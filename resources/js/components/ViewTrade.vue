<template>
    <div class="main">
        <div>
            <center>
                <v-card flat max-width="80%">
                    <v-card-title style="background-color: #d7d3d3">
                        <v-btn  @click="backMain()" plain
                            ><v-icon>mdi-keyboard-backspace</v-icon></v-btn
                        >
                        <b>{{ details.symbolDisplayName }}</b>
                        <b>{{ obj.counting }}</b> </v-card-title
                        
                    >
                </v-card>

                <v-card flat max-width="80%" max-height="55%">
                    <v-card-title>
                        <h1
                            :style="
                                details.change > 0
                                    ? 'color:Green;'
                                    : 'color:red;'
                            "
                        >
                            {{ details.now_price }}000
                        </h1>
                        <v-chip color="error">{{ details.change }}%</v-chip>
                    </v-card-title>
                    <v-divider />
                    <v-card-text>
                        <v-simple-table>
                            <thead>
                                <tr>
                                    <th>
                                        <center>High</center>
                                    </th>
                                    <th>
                                        <center>Low</center>
                                    </th>
                                    <th>
                                        <center>24H Quantiry</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <center>
                                            {{ ticker.high }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ ticker.low }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ ticker.vol }}
                                        </center>
                                    </td>
                                </tr>
                            </tbody>
                        </v-simple-table>

                        <div class="container-fluid">
                            <div class="row flex-xl-nowrap">
                                <div class="col">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <coin-charts
                                                :symbol="symbol"
                                            ></coin-charts>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <v-divider> </v-divider>
                        <v-simple-table
                            fixed-header
                            dense
                            style="overflow-y: auto; min-width: 80%"
                            :height="$vuetify.breakpoint.height - 220"
                        >
                            <template v-slot:default>
                                <!-- the row will go here -->

                                <thead>
                                    <tr>
                                        <th class="text-center">Time</th>
                                        <th class="text-center">Direction</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Number</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, i) in getmarket_arr"
                                        :key="i"
                                    >
                                        <td style="font-size: 12px">
                                            {{ item.updated_at.substring(0,10) }}
                                            {{ item.updated_at.substring(11,19) }}
                                        </td>

                                        <td style="font-size: 12px">
                                            {{ item.Direction == 'sell'?'Outsell':'Inbuy' }}
                                        </td>
                                        <td :style="{'font-size': '12px', 'color': item.Direction === 'sell' ? 'red' : 'green'}">
                                            {{ item.Price }}
                                        </td>

                                   
                                        <td :style="{'font-size': '12px', 'color': item.Direction === 'sell' ? 'red' : 'green'}">
                                            {{ item.Number }}
                                        </td>
                                      
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
            </center>
        </div>

        <v-footer fixed>
            <v-container fluid>
                <v-row>
                    <v-col
                        ><v-btn
                            block
                            dark
                            style="background-color: #12a36e"
                            @click="upbtn(cryptos)"
                            >Up</v-btn
                        ></v-col
                    >
                    <v-col
                        ><v-btn dark style="background-color: #d72015" block
                            >Down</v-btn
                        ></v-col
                    >
                </v-row>
                <!-- Your footer content goes here -->
            </v-container>
        </v-footer>

        <v-bottom-sheet v-model="sheet">
            <v-card style="overflow-y: auto"  :height="$vuetify.breakpoint.height - 400">
                <v-card-text>
                    <v-row>
                    <v-col>
                        <span style="font-size: 14px">Product Name</span><br />
                        <span>Direction</span><br />
                        <span>Current Price</span><br />
                    </v-col>
                    <v-col class="text-right">
                        <span class="text-right"> {{ obj.symbolDisplayName }}</span><br />
                        <span> {{ obj.direction }}</span><br />
                        <span class="text-right"> {{ obj.close }}</span><br />
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col>
                        <h3
                        style="
                            color: black;
                            font-weight: bold;
                            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                        "
                        >
                        Trading Time
                        </h3>
                        <br />
                        <v-row>
                        <v-sheet
                            rounded="lg"
                            class="text-center pt-1 px-1 mr-1"
                            @click="discount = 0.6"
                            :style="{
                            width: '120px',
                            'background-color': discount === 0.6 ? '#178BF6' : '#F8F8F9',
                            }"
                        >
                            <v-sheet
                            rounded="lg"
                            class="text-center mb-5"
                            :style="{
                                color: discount === 0.6 ? 'white' : '#676767',
                                'background-color': discount === 0.6 ? '#2492f8fa' : '#F2F2F2',
                            }"
                            >
                            <span>Time</span>
                            </v-sheet>
                            <span style="color: #feba3f; font-weight: bold; font-size: 18px"
                            >60S</span
                            >
        
                            <span :style="{ color: discount === 0.6 ? 'white' : '#676767' }"
                            >Scale:60.00%</span
                            >
                        </v-sheet>
                        <v-sheet
                            rounded="lg"
                            class="text-center pt-1 px-1 mr-1"
                            @click="discount = 0.4"
                            :style="{
                            width: '120px',
                            'background-color': discount === 0.4 ? '#178BF6' : '#F8F8F9',
                            }"
                        >
                            <v-sheet
                            rounded="lg"
                            class="text-center mb-5"
                            :style="{
                                color: discount === 0.4 ? 'white' : '#676767',
                                'background-color': discount === 0.4 ? '#2492f8fa' : '#F2F2F2',
                            }"
                            >
                            <span>Time</span>
                            </v-sheet>
                            <span style="color: #feba3f; font-weight: bold; font-size: 18px"
                            >120S</span
                            >
        
                            <span :style="{ color: discount === 0.4 ? 'white' : '#676767' }"
                            >Scale:40.00%</span
                            >
                        </v-sheet>
                        <v-sheet
                            rounded="lg"
                            class="text-center pt-1 px-1 mr-1"
                            @click="discount = 0.3"
                            :style="{
                            width: '120px',
                            'background-color': discount === 0.3 ? '#178BF6' : '#F8F8F9',
                            }"
                        >
                            <v-sheet
                            rounded="lg"
                            class="text-center mb-5"
                            :style="{
                                color: discount === 0.3 ? 'white' : '#676767',
                                'background-color': discount === 0.3 ? '#2492f8fa' : '#F2F2F2',
                            }"
                            >
                            <span>Time</span>
                            </v-sheet>
                            <span style="color: #feba3f; font-weight: bold; font-size: 18px"
                            >180S</span
                            >
        
                            <span :style="{ color: discount === 0.3 ? 'white' : '#676767' }"
                            >Scale:30.00%</span
                            >
                        </v-sheet>
                        </v-row>
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col>
                        <p>Investment Amount</p><br />
                        <v-text-field
                        placeholder="Minimun Purchase Limit 100"
                        outlined
                        dense
        
                        v-model="obj.recharge"
                        ></v-text-field>
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col>
                        <span>Available Balance</span><br />
                        <span>Expected Earnings</span><br />
                    </v-col>
                    <v-col class="text-right">
                        <span> {{ loggedInUser.profit }}</span
                        ><br />
                        <span class="text-right">
                        {{obj.recharge == null ? 0 : 
                            (obj.profit = parseFloat(obj.recharge)
                             * parseFloat(discount) + 
                            parseFloat(obj.recharge))
                        }} </span
                        ><br
                    /></v-col>
                    </v-row>
                    <v-row>
                    <v-col>
                        <v-btn block color="primary" @click="submitbtn()">Submit</v-btn></v-col
                    >
                    </v-row>
                </v-card-text>
            </v-card>
        </v-bottom-sheet>
    </div>
</template>

<script>
import axios from "axios";
import CoinCharts from "../components/CoinCharts.vue";
import moment from "moment";
import { mapActions, mapState } from "vuex";

export default {
    components: {
        CoinCharts,
    },
    props: ["symbol"],
    data: () => ({
        TIDArr: [],
        SelectedCrpyto: {},
        details: {},
        ticker: {},
        cryptos: [],
        cryptos1: [],
        getmarket_arr: [],
        getamount: [],
        obj: {},
        recharge: 0,
        discount: 0.6,
        now: "",
        sheet: false,
        errors: [],
    }),

    created() {
        this.getTickers();

        this.getMarketTable();

        this.GetDetails();

        this.loadLastID();

        // this.calculateCount();

        setInterval(() => {
            this.GetDetails();
        }, 4000);

        // this.GetTrade();
        // setInterval(() => {
        // this.GetTrade();}, 4000);

        setInterval(() => {
            this.getTickers();
            let lastElement = this.getmarket_arr[this.getmarket_arr.length - 1];
            let countValue = lastElement.Count;
            if (String(this.cryptos1[0].ticker.count) != countValue) {
                this.addMarketTable();
            }
        }, 10000);
        this.getAmount();
    },
    computed: {
        ...mapState(["loggedInUser"]),
    },

    methods: {

        backMain(){
            this.$router.push("/");
        } ,
        ...mapActions(["GetAccounts"]),
        GetDetails() {
            axios
                .get(`https://omicomadswork.com/api/currency/getTradeDetail`)
                .then((res) => {
                    this.SelectedCrpyto = res.data.result.detail;
                    for (let i = 0; i < this.SelectedCrpyto.length; i++) {
                        if (
                            this.toTrading.match_id ==
                            this.SelectedCrpyto[i].match_id
                        ) {
                            this.details = this.SelectedCrpyto[i];
                            this.ticker = this.SelectedCrpyto[i].ticker;
                            // console.log("detail", this.details);
                            // console.log("ticker", this.ticker);
                        }
                    }
                });
        },

        // calculateCount() {
        //     let daycut = moment().format("YYYY-MM-DD HH:mm:ss");
        //     let string = daycut;
        //     let targetMoment1 = moment(`${string}`);

        //     let targetMoment2 = moment("2023-06-05 23:18:00");

        //     let diffInSeconds = targetMoment2.diff(targetMoment1, "seconds");
        //     let count1 = diffInSeconds - 1;
        //     let interval = setInterval(() => {
        //         // console.log(count1);

        //         if (count1 === 0) {
        //             clearInterval(interval);
        //         }

        //         count1--;
        //     }, 1000);
        // },

        getTickers() {
            const url1 =
                "https://omicomadswork.com/api/currency/getTradeDetail";

            axios
                .get(url1)
                .then((response) => {
                    this.cryptos1 = response.data.result.detail.filter((r)=>{return r.symbolDisplayName == this.toTrading.symbolDisplayName})
                    // this.cryptos1= response.data.result.trade
                 
                    // console.log(   this.cryptos  )

                    // Handle the API response here
                    let array=[];

                    array =response.data.result.trade.filter((r)=>{return r.symbol == this.toTrading.symbolDisplayName})
                    this.obj.direction = array[0].ticker.data[0].direction
                   
                    // console.log(this.obj.direction)
                    

                    // console.log(this.obj.direction,'1');
                })
                .catch((error) => {
                    // Handle any errors that occur during the API request
                    console.error(error);
                });

            const url =
                `https://api-testnet.bybit.com/v5/market/tickers?category=spot&symbol=${this.toTrading.symbol}`;

            axios
                .get(url)
                .then((response) => {
                    this.cryptos = response.data.result.list[0];
                    // Handle the API response here

                    console.log(this.cryptos,'s');
                })
                .catch((error) => {

                    // Handle any errors that occur during the API request
                    console.error(error);
                });
        },
        getMarketTable() {
            axios.get(`api/market`).then((res) => {
                this.getmarket_arr = res.data;
                // console.log(this.getmarket_arr);
            });
            //     setInterval(() => {
            //     location.reload();
            // }, 40000);
        },

        getAmount() {
            axios.get(`api/userright`).then((res) => {
                this.amount_arr = res.data;
                // console.log(this.getmarket_arr);
            });
        },
        addMarketTable() {
            // this.obj.change = this.cryptos1[0].ticker.change
// console.log( this.getmarket_arr)
console.log(this.cryptos1[0].ticker.count,'sss  ')

            this.obj.lastPrice = this.cryptos.lastPrice;
            this.obj.price24hPcnt = this.cryptos.price24hPcnt;
            this.obj.updated_at = moment().format("YYYY-MM-DD HH:mm:ss");
            this.obj.Count = this.cryptos1[0].ticker.count;
            this.obj.No = this.getmarket_arr.length + 1;
// console.log( this.obj)

            axios
                .put("api/market/update", this.obj)
                .then((res) => {
                    this.getMarketTable();
                });
        },
        upbtn() {
            this.discount == 0.6
                ? (this.obj.discountResult = "60")
                : this.discount == 0.4
                ? (this.obj.discountResult = "40")
                : (this.obj.discountResult = "30");
            this.obj.userId = this.loggedInUser.id;
            this.obj.email = this.loggedInUser.email;
            this.obj.profit = this.loggedInUser.remember_token;
            this.obj.name = this.loggedInUser.name;
            this.obj.symbolDisplayName = this.details.symbolDisplayName;
            this.sheet = true;
            this.obj.close = this.cryptos1[0].ticker.close;
            this.obj.open = this.cryptos1[0].ticker.open;
        },

        submitbtn() {

            this.obj.trading = "pending";
            this.obj.T_id = `T${moment().format("YYYYMMDD")}-${this.GenerateTID(this.LastTID)}`
            this.obj.order_time = moment().format("YYYY-MM-DD HH:mm:ss");
            this.obj.complete_time = moment().format("YYYY-MM-DD HH:mm:ss");
            this.obj.profit = this.obj.profit - this.obj.recharge;
            
            
            let d = moment().format("YYYY-MM-DD HH:mm:ss");
            let a = d.substring(0, 14);
            let b = parseFloat(d.substring(14, 16)) + 1;
            let c = d.substring(16, 19);
            let combine = a + b + c;
            this.obj.closing_time = moment().format(`${combine}`);

            console.log('obj',this.obj)
            console.log('combine',combine);
            axios.post("api/Dashboard/store", this.obj)
                .then((res) => {
                    this.obj = {};
                });
        },

        GenerateTID(Last_TID) {
            let id = Last_TID;
            let split = id.split("-");
            console.log('split',split)
            let newId = +split[1] + 1;
            console.log('newid',newId )
            return newId.toString().padStart(7, "0");
            
        }, //GENERATE VAMID FOR EMPLOYEE APPLICATION

        loadLastID() {
            // LOAD VAM ID FOR EMPLOYEE APPLICATION
            console.log('load')
            axios
                .get(`api/GetTID`).then((res) => {
                    console.log('resdto',res.data)
                    this.LastTID = "";
                    if (res.data[0] != null) {
                        this.TIDArr = res.data[0];
                        console.log('last1',this.TIDArr)
                        this.LastTID = this.TIDArr; // Last VAMID for current date
                        console.log('last2',this.LastUserID)
                    } else {
                        this.LastTID = "XXXXXXXXXX-000000";
                        console.log('Employee',this.LastTID)
                    }
                })
        }, //end of load vehicleID/VAMSID
    },
    components: {
        CoinCharts,
    },
};
</script>

<style scoped>
tbody,
th,
thead,
tr,
td {
    border: 0px solid white;
    border-collapse: collapse;
    text-align: center !important;

}

th {
    font-weight: bold !important;
    text-align: center !important;
    color: black !important;
}

.main{
    overflow: auto;
    height:700px;
    padding: 20px;
    width: 70%;
    margin: auto;
}
</style>
