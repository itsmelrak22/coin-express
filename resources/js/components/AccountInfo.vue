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
            <v-btn block color="success" class="ml-2" style="border-radius:10px">
              DEPOSIT
            </v-btn>
          </v-col>

          <v-col cols="12" sm="6">
            <v-btn block color="primary" class="mr-3 pr-3" style="border-radius:10px">
              WITHDRAW
            </v-btn>
          </v-col>
        </v-row>
      </v-card>
      <br>
      <v-card flat class="user-id">
        <v-simple-table>
          <tbody>
            <tr>
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
                <td>Bank Card</td>
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
            // this.Account = res.data[0];
            // console.log(this.Account);
        });
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

</style>