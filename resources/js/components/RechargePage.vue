<template>
    <v-container>
        <div class="main">
            <div class="sticky">
                <v-toolbar flat dense>
                    <v-icon @click="goback()">
                        mdi-arrow-left
                    </v-icon>
                    <span class="ml-3" style="font-weight: bold ;">
                        Deposit
                    </span>
                </v-toolbar>
                <div>
                    <v-row>
                        <v-col cols="6">
                            <v-card flat color="#ECEFF1" class="text-center">
                                <span>Certified Seller</span>
                                <br>
                                <span style="font-weight:bold">Official</span>
                            </v-card>
                            
                        </v-col>

                        <v-col cols="6">
                            <v-card flat color="#ECEFF1" class="text-center">
                                <span>Arrival Rate</span>
                                <br>
                                <span style="font-weight:bold">100%</span>
                            </v-card>
                            
                        </v-col>
                    </v-row>
                </div>
            </div>

            <div>
                <div>
                    <v-text-field
                        v-model="rechargeAmount"
                        label="Recharge amount"
                        hint="The amount of a single transaction is 1-1000000000"
                    />
                </div>

                <div>
                    <v-row>
                        <v-col cols="4">
                                <v-btn
                                    @click="Selectedbtn1"
                                    v-model="FirstSelect"
                                    outlined
                                    dense
                                    width="100%"
                                    :color="FirstSelect == true ? 'primary' : ''"
                                    value="true"
                                >
                                1000
                                </v-btn>
                        </v-col>

                        <v-col cols="4">
                            <v-btn
                                @click="Selectedbtn2"
                                v-model="SecondSelect"
                                :color="SecondSelect == true ? 'primary' : ''"
                                outlined
                                dense
                                width="100%"
                            >
                            3000
                            </v-btn>
                        </v-col>

                        <v-col cols="4">
                            <v-btn
                                @click="Selectedbtn3"
                                v-model="thirdSelect"
                                :color="thirdSelect == true ? 'primary' : ''"
                                outlined
                                dense
                                width="100%"
                            >
                            5000
                            </v-btn>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="4">
                            <v-btn
                                @click="Selectedbtn4"
                                v-model="fourthSelect"
                                :color="fourthSelect == true ? 'primary' : ''"
                                outlined
                                dense
                                width="100%"
                            >
                            25000
                            </v-btn>
                        </v-col>

                        <v-col cols="4">
                            <v-btn
                                @click="Selectedbtn5"
                                v-model="fifthSelect"
                                :color="fifthSelect == true ? 'primary' : ''"
                                outlined
                                dense
                                width="100%"
                            >
                            50000
                            </v-btn>
                        </v-col>
                    </v-row>
                </div>
                
                <div>
                    <v-text-field
                        v-model="rechargeAmount"
                        label="Arrival amount"
                        value="0.00"
                    />
                </div>

                <div>
                    <span>Payment Method</span> <br> <br>

                    <v-btn
                        @click="selectedpay13"
                        v-model="s1pay"
                        :color="s1pay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>S1pay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay12"
                        v-model="fastpay"
                        :color="fastpay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>FastPay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay11"
                        v-model="inrpay"
                        :color="inrpay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>INRpay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay10"
                        v-model="masterpay"
                        :color="masterpay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>Masterpay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay9"
                        v-model="uzpay122"
                        :color="uzpay122 == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>UZpay122</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay8"
                        v-model="wowpay"
                        :color="wowpay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>wowpay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay7"
                        v-model="axpay"
                        :color="axpay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>Axpay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay6"
                        v-model="htpay"
                        :color="htpay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>htpay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay5"
                        v-model="UZpay102"
                        :color="UZpay102 == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>UZpay102</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay4"
                        v-model="wepay"
                        :color="wepay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>wepay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay3"
                        v-model="lepay"
                        :color="lepay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>LEpay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay2"
                        v-model="nicepay"
                        :color="nicepay == true ? 'error' : ''"
                        class="mb-4"
                        width="100%"
                        style="border-radius:10px"
                    >
                        <span>nicepay</span>
                        <v-spacer/>
                    </v-btn>

                    <v-btn
                        @click="selectedpay1"
                        v-model="bct"
                        :color="bct == true ? 'error' : ''"
                        width="100%"
                        style="border-radius:10px"
                    >toorder
                        <span>Bank card transfer</span>
                        <v-spacer/>
                    </v-btn>
                </div>
                <div>
                    <v-btn
                        @click="SAVE()"
                        class="mt-4"
                        color="primary"
                        width="100%"
                    >
                        <span>Confirm Recharge</span>
                        <v-spacer/>
                    </v-btn>
                </div>
            </div>
        </div>
    </v-container>
</template>

<script>
import moment from "moment";
export default {
    data() {
        return {
            toorder : {},
            UserIDArr : [],
            FirstSelect : undefined,
            SecondSelect : undefined,
            thirdSelect : undefined,
            fourthSelect : undefined,
            fifthSelect : undefined,
            rechargeAmount : null,

            bct : undefined,
            nicepay : undefined,
            lepay : undefined,
            wepay : undefined,
            UZpay102 : undefined,
            htpay : undefined,
            axpay : undefined,
            wowpay : undefined,
            uzpay122 : undefined,
            masterpay : undefined,
            inrpay : undefined,
            fastpay : undefined,
            s1pay : undefined,
            strlabel : ''
            // sixthSelect : undefined,
            // seventhSelect : undefined,
            // eightSelect : undefined,
        }
    },

    methods: {
        goback(){
            this.$router.push('/DepositView')
        },

        Selectedbtn1(){
            this.rechargeAmount = 1000
            this.FirstSelect = true
            this.SecondSelect = false
            this.thirdSelect = false
            this.fourthSelect = false
            this.fifthSelect = false
            
        },
        Selectedbtn2(){
            this.rechargeAmount = 3000
            this.SecondSelect = true
            this.FirstSelect = false
            this.thirdSelect = false
            this.fourthSelect = false
            this.fifthSelect = false
            
        },
        Selectedbtn3(){
            this.rechargeAmount = 5000
            this.thirdSelect = true
            this.FirstSelect = false
            this.SecondSelect = false
            this.fourthSelect = false
            this.fifthSelect = false
            
        },
        Selectedbtn4(){
            this.rechargeAmount = 25000
            this.fourthSelect = true
            this.FirstSelect = false
            this.SecondSelect = false
            this.thirdSelect = false
            this.fifthSelect = false
        },
        Selectedbtn5(){
            this.rechargeAmount = 50000
            this.fifthSelect = true
            this.FirstSelect = false
            this.SecondSelect = false
            this.thirdSelect = false
            this.fourthSelect = false
        },

        selectedpay1(){
            this.bct = true
            this.strlabel = 'Bank Card Transaction'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay2(){
            this.bct = false
            this.strlabel = 'NICEPAY'
            this.nicepay = true
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay3(){
            this.bct = false
            this.strlabel = 'LEPAY'
            this.nicepay = false
            this.lepay = true
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay4(){
            this.bct = false
            this.strlabel = 'WEPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = true
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay5(){
            this.bct = false
            this.strlabel = 'UZPAY102'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = true
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay6(){
            this.bct = false
            this.strlabel = 'HTPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = true
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay7(){
            this.bct = false
            this.strlabel = 'AXPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = true
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay8(){
            this.bct = false
            this.strlabel = 'WOWPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = true
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay9(){
            this.bct = false
            this.strlabel = 'UZPAY122'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = true
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay10(){
            this.bct = false
            this.strlabel = 'MASTERPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = true
            this.inrpay = false
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay11(){
            this.bct = false
            this.strlabel = 'INRPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = true
            this.fastpay = false
            this.s1pay = false
        },
        selectedpay12(){
            this.bct = false
            this.strlabel = 'FASTPAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = true
            this.s1pay = false
        },
        selectedpay13(){
            this.bct = false
            this.strlabel = 'S1PAY'
            this.nicepay = false
            this.lepay = false
            this.wepay = false
            this.UZpay102 = false
            this.htpay = false
            this.axpay = false
            this.wowpay = false
            this.uzpay122 = false
            this.masterpay = false
            this.inrpay = false
            this.fastpay = false
            this.s1pay = true
        },

        SAVE(){
            if(this.rechargeAmount){
                if(this.strlabel){
                    this.toorder.ordernumber = `EE${moment().format("YYYYMMDD")}-${this.GenerateORDERID(this.LastUserID)}`
                    this.toorder.amount = this.rechargeAmount
                    this.toorder.methods = this.strlabel
                    this.toorder.userid = this.loggedInUser.id
                    this.toorder.useraccount = this.loggedInUser.email
                    this.toorder.state  = 'PENDING'

                    axios.post('api/RechargeDetails/store',this.toorder).then((res)=>{
                        if(res.data){
                            alert('pasok')
                        }
                    })
                    this.$store.commit("STORE_USERDEPOSIT",  this.toorder);
                    console.log(this.toorder)
                    this.$router.push('/DepositView/RechargePage/RechargeDetails')
                }else{
                    alert('Please Select')
                }
            }else{
                alert('Please enter')
            }
            
        },

        GenerateORDERID(Last_userid) {
            let id = Last_userid;
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
                .get(`/api/RechargeDetails`).then((res) => {
                    this.LastUserID = "";
                    if (res.data[0] != null) {
                        this.UserIDArr = res.data[0];
                        // console.log('last1',this.UserIDArr)
                        this.LastUserID = this.UserIDArr; // Last VAMID for current date
                        // console.log('last2',this.LastUserID)
                    } else {
                        this.LastUserID = "XXXXXXXXXX-000000";
                        console.log('Employee',this.LastUserID)
                    }
                })
        }, //end of load vehicleID/VAMSID
    },

    created(){
        this.loadLastID()
    }
    
}
</script>

<style>
    /*.sticky{
        position: -webkit-sticky;
        position: sticky;
        top: 0;
    }*/

    .main{
        overflow: auto;
        height:700px;
        padding: 20px;
        width: 70%;
        margin: auto;
    }
</style>