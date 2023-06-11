<template>
    <div class="home">
        <div>
                <v-card flat>
                    <v-card-title style="background-color: #ECEFF1">
                        <v-btn  @click="backMain()" plain > 
                            <v-icon>mdi-keyboard-backspace</v-icon>
                        </v-btn>
                        <b>Withdraw</b>
                        </v-card-title>
                </v-card>
                <center>My Credit Score: 100.00</center>
                <v-card flat >
                    <v-card-text>
                        <span>Extractable Quantity:</span>
                        <v-text-field 
                        outlined
                        dense
                        ></v-text-field>

                        <span>Please Select a BankCard:</span>
                        <v-autocomplete
                        outlined
                        dense
                        ></v-autocomplete>
                        <span>Amount of Coin Withdraw:</span>
                        <v-text-field 
                        outlined
                        dense
                        hint="Fee 0.0000 National Legal Tender"
                        ></v-text-field>
                        <span>Arived Ammount National Tender</span>
                        <v-card-actions>
                            <v-btn color="primary" block>
                                Withdrwa
                            </v-btn>
                        </v-card-actions>
                       
                    </v-card-text>
                </v-card>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>
.home {
    overflow: auto;
    height: 750px;
    padding: 20px;
    margin: auto;
    width: 80%;
  }
</style>