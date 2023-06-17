<template>
  <div class="home">
    <div class="bg">
      <!-- User information -->
      <center>
        <img src="https://cryptobtc01.com/imgs/user.png" alt="" width="80px" height="80px">
        <br>
        <span style="font-weight: bold;">{{ Account.email }}</span>
        <br>
        <span class="user-id">ID:{{ Account.id }}</span>
      </center>

      <!-- Asset Center -->
      <v-card flat>
        <span>Asset Center</span>
        <br>
        <span style="color: #f09e23;">=</span>
        <span class="amount" style="font-size: 45px; font-weight: bold; color: #f09e23;">{{ Account.Asset }}.00</span>
        <v-row>
          <v-col cols="12" sm="6">
            <v-btn block color="success" class="ml-2" style="border-radius:10px" @click="GotoRecharge()">
              DEPOSIT
            </v-btn>
          </v-col>

          <v-col cols="12" sm="6">
            <v-btn block color="primary" class="mr-3 pr-3" style="border-radius:10px" @click="GotoWithdrawal()">
              WITHDRAW
            </v-btn>
          </v-col>
        </v-row>
      </v-card>
      <br>
      <v-card flat class="user-id">
        <v-simple-table>
          <tbody>
            <tr @click="RechargeHistory">
              <td>Recharge Record</td>
            </tr>
            <tr>
              <td>Withdrawal Record</td>
            </tr>
            <tr>
              <td>SGR Invite</td>
            </tr>
          </tbody>
        </v-simple-table>
        </v-card >
        <br>
        <v-card flat class="user-id"> 
          <v-simple-table>
            <tbody>
              <tr>
                <td @click="BankCard()">Bank Card</td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card>
        
        <br>
        <v-card flat class="user-id">
          <v-simple-table>
            <tbody>
              <tr>
                <td>My Promotion History</td>
              </tr>
              <tr>
                <td>Complaint Suggestion</td>
              </tr>
              <tr>
                
                <td>  
                  <v-form id="logOut" method="POST" action="logout" >
                  <input type="hidden" name="_token" :value="csrf">
                  <input type="submit" value="Logout" depressed class="amount" >
               </v-form>
              </td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card>
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
</template>

<script>
export default {
  data:()=>({
    Account : [],
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  }),

  created(){
       this.GetUser()
    },

    methods:{
      GetUser(){
        axios.get(`/api/AccountInfo`).then((res) => {
          for(let i = 0; i < res.data.length; i++){
            if(this.loggedInUser.id == res.data[i].id){
              console.log(res.data[i])
              this.Account = res.data[i]
            }
          }
        });
    },
    GotoRecharge(){
      this.$router.push("/DepositView");
    },
    GotoWithdrawal(){
      this.$router.push("/Withdrawal");
    },
    Home(){
      this.$router.push('/')
    },
    Center(){
      this.$router.push('/AccountInfo')
    },
    Order(){
      this.$router.push('/Order')
    },

    BankCard(){
      this.$router.push('/BankCard')
    },
    RechargeHistory(){
      this.$router.push("/RechargeHistory");
    }
    },
}
</script>

<style scoped>
.home {
    overflow: auto;
    height:800px !important;
    max-width: 100%;
    margin:auto;
    
}
.bg{
  background: url(https://cryptobtc01.com/assets/images/userbg.f932ed4.png) no-repeat 50%/100% 100%;
  height: 500px;
}
.user-id{
  color: #676767;
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
}
p {
  display: block;
  margin-block-start: 1em;
  margin-block-end: 1em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
}

.amount{
  font-family: -apple-system,BlinkMacSystemFont,PingFang SC,Helvetica Neue,STHeiti,Microsoft Yahei,Tahoma,Simsun,sans-serif;
  text-indent: 10px;
  line-height: 40px;
  text-align: left;
}
.footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  z-index: 999;
}


@media screen and (max-width: 767px) {
  /* Styles for phone devices */
  .bg {
    /* Adjust the styles for the background container */
    padding: 20px;
  }

  .user-id {
    /* Adjust the styles for the user ID container */
    margin-top: 20px;
  }

 
}

@media screen and (min-width: 768px) and (max-width: 1023px) {
  /* Styles for tablet devices */
  .bg {
    /* Adjust the styles for the background container */
    padding: 40px;
  }

  .user-id {
    /* Adjust the styles for the user ID container */
    margin-top: 40px;
  }

  
}
</style>