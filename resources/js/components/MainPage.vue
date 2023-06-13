<template>
  <v-container fluid>
    <div class="home">
      <div style="margin-bottom: 10px;">
        <div>
          <img style="width: 100%; border-radius: 5px; height: 100%;" src="https://omicomadswork.com/upload/1667207779419729.jpeg" alt="no img">
          <v-row no-gutters>
            <v-col cols="12" md="2" style="margin-bottom: 20px;">
              <v-card height="150px" flat>
                <v-card-title>
                  <b>{{ CoinDataBTC.name }}</b>
                </v-card-title>
                <v-card-text>
                  <h3 :style="CoinDataBTC.change > 0 ? 'color:green;' : 'color:red;'"><b>{{CoinDataBTC.now_price}}</b></h3>
                  <h3 :style="CoinDataBTC.change > 0 ? 'color:green;' : 'color:red;'"><b><v-icon color="red" v-if="CoinDataBTC.change <= 0">mdi-menu-down</v-icon> <v-icon color="green" v-if="CoinDataBTC.change >= 0">mdi-menu-up</v-icon>
                    {{CoinDataBTC.change}}%</b></h3>
                </v-card-text>
                <v-card flat max-height="220px">
                </v-card>
              </v-card>
            </v-col>

            <v-col cols="12" md="2" style="margin-bottom: 20px;">
              <v-card height="150px" flat>
                <v-card-title>
                  <b>{{ CoinDataETH.name }}</b>
                </v-card-title>
                <v-card-text>
                  <h3 :style="CoinDataETH.change > 0 ? 'color:green;' : 'color:red;'"><b>{{CoinDataETH.now_price}}</b></h3>
                  <h3 :style="CoinDataETH.change > 0 ? 'color:green;' : 'color:red;'"><b><v-icon color="red" v-if="CoinDataETH.change <= 0">mdi-menu-down</v-icon> <v-icon color="green" v-if="CoinDataETH.change >= 0">mdi-menu-up</v-icon>
                    {{CoinDataETH.change}}%</b></h3>
                </v-card-text>
                <v-card flat max-height="220px">

                </v-card>
              </v-card>
            </v-col>

            <v-col cols="12" md="2" style="margin-bottom: 20px;">
              <v-card height="150px" flat>
                <v-card-title>
                  <b>{{ CoinDataLTC.name }}</b>
                </v-card-title>
                <v-card-text>
                  <h3 :style="CoinDataLTC.change > 0 ? 'color:green;' : 'color:red;'"><b>{{CoinDataLTC.now_price}}</b></h3>
                  <h3 :style="CoinDataLTC.change > 0 ? 'color:green;' : 'color:red;'"><b><v-icon color="red" v-if="CoinDataLTC.change <= 0">mdi-menu-down</v-icon> <v-icon color="green" v-if="CoinDataLTC.change >= 0">mdi-menu-up</v-icon>
                    {{CoinDataLTC.change}}%</b></h3>
                </v-card-text>
                <v-card flat max-height="220px">

                </v-card>
              </v-card>
            </v-col>
          </v-row>
          <br>
          <div>
            <v-toolbar dense flat style="border-radius:10px; background: radial-gradient(circle, #fff 0%, #8ecdf1 100%);">
              <img src="https://cryptobtc01.com/assets/images/icon_quick_recharge.22f59be.png" style="height: 40px;">
              <b> Quick recharge </b>
              <v-spacer></v-spacer>
              <v-btn @click="GotoRecharge()" color="primary" width="60px">
                <b>Go</b>
              </v-btn>
            </v-toolbar>
          </div>
          <br>
          <v-simple-table flat style="min-width: 50px !important;">
            <thead>
              <tr>
                <th><center>Name</center></th>
                <th><center>Latest Price</center></th>
                <th><center>24H Up and Down</center></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, i) in cryptoTable" :key="i" class="text-center" @click="toView(item)">
                <td>
                  <v-avatar size="30">
                    <img
                      alt="no image found"
                      :src="`${item.icon}`"
                      width="40"
                      height="40px"
                    />
                  </v-avatar>
                  {{item.name}}
                </td>
                <td>
                  <center>
                    {{item.now_price}}
                  </center>
                </td>
                <td>
                  <center>
                    <!-- red -->
                    <v-chip v-if="item.change <= 0" :color="item.change < 0 ? 'error' : 'success'">
                      {{item.change}}%
                    </v-chip>
                    <!-- green -->
                    <v-chip v-if="item.change > 0" :color="item.change > 0 ? 'success' : 'error'">
                      {{item.change}}%
                    </v-chip>
                  </center>
                </td>
              </tr>
            </tbody>
          </v-simple-table><!--end of simple table-->

          <template>
            <v-footer plain padless class="footer">
              <v-bottom-navigation  color="primary" fixed>
                <v-row no-gutters>
                  <v-col class="text-center" cols="4">
                    <v-btn @click="Home" block>
                      <v-icon>
                        mdi-home-analytics
                      </v-icon>
                      Home
                    </v-btn>
                  </v-col>
                  <v-col class="text-center" cols="4">
                    <v-btn block @click="Order">
                      <v-icon>
                        mdi-chart-line-stacked
                      </v-icon>
                      Order
                    </v-btn>
                  </v-col>
                  <v-col class="text-center" cols="4">
                    <v-btn @click="Center" block>
                      <v-icon>
                        mdi-account
                      </v-icon>
                      My Center
                    </v-btn>
                  </v-col>
                </v-row>
              </v-bottom-navigation>
            </v-footer>
          </template>
        </div>
      </div>
    </div>
  </v-container>
</template>

<script>
import Sparkline from './Sparkline.vue'
export default {
    
    data:()=>({
        CoinDataETH : {},
        CoinDataBTC : {},
        CoinDataLTC : {},
        img: {},
        ticker : {},
        btc : '',
        currentcy : '',
        last_value: '',
        showDropDown: false,
        percent : 0,
        volume : '',
        php : 0,
        cryptoTable: [],
    }),

    created(){
        
      this.GetTradeDetails();
      setInterval(() => { this.GetTradeDetails();}, 5000);
        
    },

    methods:{

      Home(){
            this.$router.push('/')
         },
         Center(){
            this.$router.push('/AccountInfo')
         },
         Order(){
            this.$router.push('/Order')
         },

        GetTradeDetails(){
            axios.get(`https://omicomadswork.com/api/currency/getSymbol`).then((res)=>{
              this.cryptoTable = res.data.result
              console.log('call', this.cryptoTable)
              this.CoinDataBTC = this.cryptoTable[0]
              this.CoinDataETH = this.cryptoTable[1]
              this.CoinDataLTC = this.cryptoTable[3]
            })
        },
        toView(value){
          
          value.interval = '1d'
          value.symbol = value.currency_name + value.legal_name
          console.log('value',value)
          this.$store.commit("STORE_TRADING", value);
          this.$router.push("/ViewTrade");
          // const url = `hello/ViewTrade`;
          // open(url);
          // window.open(`hello/ViewTrade`)

        },
     
        closeDropDown() {
        this.showDropDown = false;
        },

        GotoRecharge(){
          this.$router.push("/DepositView");
        }
    },

    components: {
      Sparkline
    }
        
    
}



</script>
<style scoped>

.home {
  overflow: auto;
  height: 750px;
  padding: 20px;
  margin: auto;
  width: 80%;
}

@media (max-width: 768px) {
  .home {
    height: auto;
    width: 100%;
  }
}

.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  z-index: 999;
}

@media (max-width: 600px) {
  .footer {
    padding: 10px;
  }
}
</style>