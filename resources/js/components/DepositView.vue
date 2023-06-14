<template>
    <div id="app">
        <div class="home">
            <v-container style="height: 100%;">
                <v-card flat>
                    <v-card-title>
                        <v-btn @click="backMain()" plain><v-icon>mdi-keyboard-backspace</v-icon></v-btn><b >Deposit</b> 
                    </v-card-title>
                    <center>
                        <span><b>Please select the following recharge</b></span>
                    </center>
                    <div style="height: 80px;">
                        <!-- style="border-radius:10px; background: radial-gradient(circle, #fff 0%, #8ecdf1 100%);" -->
                        <v-toolbar class="bg" dense flat style="font-weight: 600; color: #fff;" >

                        <img   src="https://cryptobtc01.com/assets/images/20210831021155589136.50f2a9a.jpg" style="height: 40px; margin-bottom:20px">
                        <span style="margin-bottom:20px">National legal tender</span> 
                        <v-spacer/>
                        <v-btn style="margin-bottom:20px" class="test" @click="GotoRecharge()">
                          <b>Buy</b><v-icon>mdi-arrow-right</v-icon>
                        </v-btn>
                        </v-toolbar>
                        </div>
                </v-card>
            </v-container>
        </div>
    </div>
</template>

<script>
export default {
    data:()=>({

    }),
    created(){

    },
    methods:{
        backMain(){
            this.$router.push("/");
        },

        GotoRecharge(){
            this.$router.push("/RechargePage")
        }
    }
}
</script>

<style scope>
.home {
    height: 100%;
    margin: auto;
    width: 60%;
    padding: 10px;
    display: flex;
    flex-direction: column;
}
.bg{
    background: url(https://cryptobtc01.com/assets/images/recharge%7C_bg1.3d743db.png) no-repeat 50%/100% 100%;
    padding: 80px 20px;
    padding-top: 60px;
}
.test{
    background: #fff;
    height: 36px;
    display: flex;
    padding: 0 19px;
    align-items: center;
    border-radius: 36px;
    position: relative;
    color: #191a2c;
    text-align: right;
}

</style>