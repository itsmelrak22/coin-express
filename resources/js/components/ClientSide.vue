<template>
    <div id="app">
        <v-app id="inspire">
            <v-app id="inspire" >
                <v-main class="d-flex align-center justify-center">
                    <v-row>
                        <v-col>
                            <v-card
                                class="mx-auto pr-2"
                                color="teal"
                                width="300px"
                                height="400px"
                            >
                            
                                <!-- <div>
                                    <v-row>
                                        <v-col> -->
                                            <!-- <v-autocomplete
                                                :items="items" 
                                                class="ml-3" 
                                                v-model="strCompany" 
                                                label="Company" 
                                                placeholder="Company"  
                                                dense outlined
                                                style="width:100px;  margin-left:250px !important; margin-top:170px;"
                                            >
                                            </v-autocomplete>
                                            <a class="wait" style="margin-left:250px" @click="GuestLogin()">Login as Guest ?</a>
                                             -->
                                        <!-- </v-col>

                                        <v-col style="margin-top:162px">
                                            <v-text-field
                                                style="width:200px;"
                                                color="success"
                                                prepend-icon="mdi-account"
                                                v-model="strUsername"
                                                outlined
                                                label="Username"
                                                dense
                                                hide-details
                                                class="mb-8  mt-2"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                            <v-text-field
                                            style="width:px!important; margin-left:375px!important; "
                                            prepend-icon="mdi-lock"
                                            v-model="strPassword"
                                            color="success"
                                            outlined
                                            @keypress.enter="logInFunction()"
                                            label="Password"
                                            dense
                                            class="mb-8"
                                            :type="showPassword? 'text': 'password'"
                                            :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                            @click:append="showPassword = !showPassword"
                                        ></v-text-field>
                                        
                                        <v-btn
                                        @click="logInFunction()"
                                        small
                                        width="150px"
                                        style="margin-left:415px!important; margin-top: -100px!important"
                                        :color="systemColor">
                                        <v-icon>mdi-login</v-icon>
                                        Login
                                    </v-btn>
                                </div>  -->
                            
                            <!-- pecture -->
                                <v-row> 
                                    <!-- <v-col cols="6">
                                        <img
                                        :src="url + '/Vams/images/VAMVAM.jpg'"
                                            alt="Vams"
                                            width="300px"
                                            height="400px"
                                        />
                                    </v-col>
                                     -->
                                    <v-col>
                                        <v-row style="padding-top: 80px">
                                            <v-col
                                                align="center"
                                                justify="center"
                                            >
                                            </v-col>
                                        </v-row>
                                        <v-form align="center" justify="center">
                                            <v-row class="mt-5">
                                                
                                                <v-row no-gutters>
                                                    <!-- <v-col cols="4">
                                                        <v-autocomplete :items="items" class="ml-3" v-model="strCompany" label="Company" placeholder="Company"  dense outlined></v-autocomplete>
                                                    </v-col> -->
                                                    <v-col cols="12">
                                                        <v-col
                                                            cols="12"
                                                            style="
                                                                margin-top: -20px;
                                                            "
                                                        >

                                                            <v-text-field
                                                                color="success"
                                                                prepend-icon="mdi-account"
                                                                v-model="
                                                                    strUsername
                                                                "
                                                                outlined
                                                                label="Username"
                                                                dense
                                                                hide-details
                                                                class="mb-8  mt-2"
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-col>
                                                </v-row>

                                                
                                                <v-col
                                                    cols="12"
                                                    style="margin-top: -20px"
                                                >
                                                    <v-text-field
                                                        prepend-icon="mdi-lock"
                                                        v-model="strPassword"
                                                        color="success"
                                                        outlined
                                                        @keypress.enter="
                                                            logInFunction()
                                                        "
                                                        label="Password"
                                                        dense
                                                        class="mb-8"
                                                        :type="showPassword? 'text': 'password'"
                                                        :append-icon="
                                                            showPassword
                                                                ? 'mdi-eye-off'
                                                                : 'mdi-eye'
                                                        "
                                                        @click:append="
                                                            showPassword =
                                                                !showPassword
                                                        "
                                                    ></v-text-field>

                                                    <a @click="GuestLogin()"
                                                        >Not Yet Register ??
                                                    </a>
                                                </v-col>

                                                
                                                <v-col
                                                    cols="12"
                                                    style="margin-top: -20px"
                                                >
                                                    <v-btn
                                                        @click="logInFunction()"
                                                        block
                                                        color="success"
                                                    >
                                                        <v-icon
                                                            >mdi-login</v-icon
                                                        >
                                                        Login
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-main>
            </v-app>
        </v-app>
        <v-overlay :value="overlay">
            <v-progress-circular
            color="blue-grey"
            indeterminate
            :size="150"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
    data() {
        return {
            text : '',
            snackbar : false,
            overlay : false,
            url: window.location.origin,
            strUsername: "",
            strPassword: "",
            strCompany: "",
            showPassword: "",
            
            NULL: null,
            Guest: "Guest",
        };
    },

    computed: 
        {
            ...mapState
            ([
                'UserAccounts',
            ])
        },//end of amputed

        methods:{
            ...mapActions
            ([
                'GetUsers'
            ]),

            logInFunction() {
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }
            this.overlay = true
            if (!this.strUsername || !this.strPassword ) {
                this.text = 'Please Input Username/Password'
                this.snackbar = true;
                sleep(1000).then(()=>{this.overlay = false})
                return false;
            }
            axios.get(`api/UserAccounts?Email=${this.strUsername}&Password=${this.strPassword}`)
                .then((res) => {
                    console.log(res.data)
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //                                                                                                     //
                    //                                    FOR ADMIN FILTERING                                              //
                    //                                                                                                     //
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////
                    let admin = res.data.filter((res) => {
                        return (
                            this.strUsername.toUpperCase() == res.Email.toUpperCase() &&
                            this.strPassword.toUpperCase() == res.Password.toUpperCase() &&
                            res.userLevel == "0"  && res.deleted_at === this.NULL

                        );
                    });
                    console.log(admin[0])
                    if (admin.length > 0) {
                        
                        this.$store.commit("STORE_USERINFO", admin[0]);
                        this.$store.commit("STORE_USERDATA", admin[0]);
                        this.$store.commit("STORE_ISLOGGEDIN", true);
                        this.text = 'Logging-In'
                        this.snackbar = true;
                        sleep(1000).then(()=>{this.overlay = false})
                        sleep(1300).then(()=>{this.$router.push("/Dashboard")})
                        
                        return false;
                    }

                
                });
        },

        },//end of methods

        mounted()
            {
                this.GetUsers()
            }

        
}
</script>