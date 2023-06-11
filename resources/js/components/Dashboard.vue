<template>
  <div>
   <h4>Welcome Test</h4>
  
    <v-row>
          <v-col cols="4">
              <v-btn block
              @click="Forsix()"
              v-model="one">
              Time: 60S
                60%
              </v-btn>
          </v-col>

          <v-col cols="4">
            <v-btn block
              @click="For40()"
              v-model="two">
              Time: 120S
                40%
            </v-btn>
          </v-col>

        <v-col cols="4">
            <v-btn block
            @click="For30()"
            v-model="tree">
            Time: 180S
            30%
            </v-btn>
        </v-col>
    </v-row>
    
    <span>BALANCE:</span>
    <span>Expected Earnings: {{total + ".00"}}</span>
    <v-text-field
    v-model="temptotal"
    @keyup="tryfunction()"
    label="Investment Amount..."
    >
    </v-text-field>

    <v-btn 
    color="success" 
    @click="ProcessUp()"
    >
      Up
    </v-btn>

    <v-btn 
    color="error"
    @click="ProcessDown()"
    >
      Down
    </v-btn>
  </div>
</template>
<script>

import { mapActions, mapState } from 'vuex'
import axios from "axios";
   export default {
      data: () => ({
        one: false,
        value1 :0.60,
        value2 : 0.40,
        value3 : 0.30,
        two: false,
        tree: false,
        total: 0.00,
        temptotal: 0,
        str60: undefined,
        time : undefined,
        storeObj:{},
      }),

      methods: {
        
        tryfunction(){
          if(this.one == true){
            this.total = parseInt(this.temptotal)  + this.value1 * this.temptotal
          }
          else if(this.two == true){
            this.total = parseInt(this.temptotal)  + this.value2 * this.temptotal
          }
          else if(this.tree == true){
            this.total = parseInt(this.temptotal)  + this.value3 * this.temptotal
          }
            // if (this.total = undefined){
            //   this.total = 0
            // }
        },

        Forsix(){
          this.one = true
          this.two = false
          this.tree = false
          this.total = parseInt(this.temptotal)  + this.value1 * this.temptotal
          this.time = 60
          // if (this.total = undefined){
          //     this.total = 0
          //   }
          console.log( this.one,this.time)
        },
        For40(){
          this.two = true
          this.one = false
          this.tree = false
          this.total = parseInt(this.temptotal)  + this.value2 * this.temptotal
          this.time = 120
          // if (this.total = undefined){
          //     this.total = 0
          //   }
          console.log( this.two,this.time)
        },
        For30(){
          this.tree = true
          this.one = false
          this.two = false
          this.total = parseInt(this.temptotal)  + this.value3 * this.temptotal
          this.time = 180
          // if (this.total = undefined){
          //     this.total = 0
          //   }
          console.log( this.tree,this.time)
        },

        ProcessUp(){
          this.storeObj.total = this.total
          this.storeObj.time = this.time
          this.storeObj.qty = this.temptotal
          this.storeObj.userid = this.loggedInUser.id
          this.storeObj.contract = "BTC/USDT"
          this.storeObj.type = 0
          this.storeObj.trading = "trading"
          this.storeObj.useraccount = this.loggedInUser.email
          console.log(this.storeObj)
          if(this.temptotal){
            axios.post('api/Dashboard/store',this.storeObj).then((res)=>{
              if(res.data){
                alert('na process na')
                this.temptotal = ""
                this.total = ""
              }
            })
          }else{
            alert('please inpute')
          }
        },

        ProcessDown(){
          this.storeObj.total = this.total
          this.storeObj.time = this.time
          this.storeObj.qty = this.temptotal
          this.storeObj.userid = this.loggedInUser.id
          this.storeObj.contract = "BTC/USDT"
          this.storeObj.type = 1
          this.storeObj.trading = "trading"
          this.storeObj.useraccount = this.loggedInUser.email
          console.log(this.storeObj)
          if(this.temptotal){
            axios.post('api/Dashboard/store',this.storeObj).then((res)=>{
              if(res.data){
                alert('na process na')
                this.temptotal = ""
                this.total = ""
              }
            })
          }else{
            alert('please inpute')
          }
        }
        

      },
      computed: {
        ...mapState([
            'isLoggedin',
            'loggedInUser',
            'allUsers'
        ]),
      },
   }
</script>