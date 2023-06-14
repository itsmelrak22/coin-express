<template>
    <v-app>
      <v-main>
        <v-container class="fill-height"  fluid>
          <v-row align="center" justify="center" >
            <v-card class="mx-6 mt-5" elevation="5" :loading="loading" width="450">
              <template slot="progress">
                <v-progress-linear
                  color="black"
                  height="5"
                  indeterminate
                ></v-progress-linear>
              </template>
              <v-card-title class="justify-left">
                  ADMIN SIDE
              </v-card-title>
              <v-divider></v-divider>
              <v-card-text>
              <v-tabs v-model="tab" centered grow>
                <v-tab @click="resetForm()"> Login </v-tab>
                <!-- <v-tab @click="resetForm()"> Register </v-tab> -->
              </v-tabs>
              <v-tabs-items v-model="tab">
                <!-- Login -->
                <v-tab-item >
                  <v-card-text>
                    <p>Sign in with your Email and Password:</p>
                    <v-form id="LoginForm" ref="LoginForm" v-on:submit.prevent="handleLogin">

                      <v-text-field
                        type="email"
                        label="Email"
                        name="email"
                        v-model="employee.email"
                        prepend-icon="mdi-account-circle"
                        required
                        readonly 
                        autocomplete="off"
                        @focus="$event.target.removeAttribute('readonly');"
                        outlined
                        dense
                        :rules="[...rules.email, ...rules.required]"
                      ></v-text-field>

                      <v-text-field
                        v-model="employee.password"
                        id="hiddenPassword"
                        label="Password"
                        autocomplete="off"
                        prepend-icon="mdi-lock" 
                        :type="showPassword ? 'text' : 'password' "
                        :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        @focus="$event.target.removeAttribute('readonly');"
                        required
                        readonly
                        outlined
                        dense
                        name="password"
                        :rules="rules.password"
                      ></v-text-field>

                      <v-divider></v-divider>

                      <v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
                        <v-spacer></v-spacer>
                        <v-btn small color="info" type="submit" :disabled="disableBtn">
                          <v-icon left>mdi-lock</v-icon>
                          Login
                        </v-btn>
                      </v-card-actions>

                    </v-form>
                  </v-card-text>
                </v-tab-item>
                <!-- Register -->
                <!-- <v-tab-item >
                  <v-card-text>
                    <p>Register with your employee :</p>
                    <v-form id="RegisterForm" ref="RegisterForm" v-on:submit.prevent="handleRegistration">
                      <v-text-field
                        type="text"
                        label="Name"
                        name="name"
                        v-model="employee.name"
                        prepend-icon="mdi-account-circle"
                        required
                        readonly 
                        autocomplete="off"
                        @focus="$event.target.removeAttribute('readonly');"
                        outlined
                        dense
                        :rules="rules.required"
                      ></v-text-field>
                      <v-text-field
                        type="email"
                        label="Email"
                        name="email"
                        v-model="employee.email"
                        prepend-icon="mdi-account-circle"
                        required
                        readonly 
                        autocomplete="off"
                        @focus="$event.target.removeAttribute('readonly');"
                        outlined
                        :rules="[...rules.email, ...rules.required]"
                        dense
                      ></v-text-field>
                      <v-text-field
                        v-model="employee.password"
                        id="hiddenPassword"
                        label="Password"
                        autocomplete="off"
                        prepend-icon="mdi-lock" 
                        :type="showPassword ? 'text' : 'password' "
                        :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        @focus="$event.target.removeAttribute('readonly');"
                        required
                        readonly
                        outlined
                        dense
                        name="password"
                        :rules="rules.password"
                      ></v-text-field>
                      <v-text-field
                        v-model="employee.password_confirmation"
                        id="hiddenPasswordConfirmation"
                        label="Confirm Password"
                        autocomplete="off"
                        prepend-icon="mdi-lock" 
                        :type="showPassword ? 'text' : 'password' "
                        :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        @focus="$event.target.removeAttribute('readonly');"
                        required
                        readonly
                        outlined
                        dense
                        name="password_confirmation"
                        :rules="rules.confirmpassword(employee.password_confirmation,employee.password)"
                      ></v-text-field>
                     
                      <v-divider></v-divider>
                      <v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
                        <v-spacer></v-spacer>
                        <v-btn small color="info" type="submit" :disabled="disableBtn ">
                          <v-icon left>mdi-lock</v-icon>
                          Register
                        </v-btn>
                      </v-card-actions>

                    </v-form>
                  </v-card-text>
                </v-tab-item> -->
              </v-tabs-items>

              </v-card-text>
            </v-card>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
</template>
<script>
import { mapActions, mapState } from 'vuex'
import md5 from 'js-md5'
export default {
    name : 'LoginPage',
    data() {
        return {
            showPassword: false, 
            disableBtn: false,
            loading: false,
            employee : {},
            tab : null,
        };
    },
    computed: {
      ...mapState([
        'rules'
      ])
    },

    methods: {
      ...mapActions([
          'login',
          'saveToken'
      ]),
      
      resetForm(){
        if(this.$refs.LoginForm){
          this.$refs.LoginForm.reset();
        }

        if(this.$refs.RegisterForm){
          this.$refs.RegisterForm.reset();
        }
      },

      async _requestToken(formdata){

        formdata.append('grant_type', process.env.MIX_PASSPORT_ACCESS_CLIENT_GRANT_TYPE);
        formdata.append('client_id', process.env.MIX_PASSPORT_ACCESS_CLIENT_ID);
        formdata.append('client_secret', process.env.MIX_PASSPORT_ACCESS_CLIENT_SECRET);
        formdata.append('username', formdata.get('email'));
        formdata.set('password', formdata.get('password'))

        await axios({
              method: 'POST',
              url: 'oauth/token',
              data: formdata,
              config: {
                  headers: { "Content-Type": "multipart/form-data" },
              },
            })
            .then(({ data }) => {
              this.login().then(() => {
                this.saveToken(data)

              })
            })
      },

      handleLogin() {
         if(this.$refs.LoginForm.validate()){
          this.disableBtn = true

          const myForm = document.getElementById('LoginForm');
          const formdata = new FormData(myForm)


          axios({
              method: "POST",
              url: `login`,
              data: formdata,
              config: {
                  headers: { "Content-Type": "multipart/form-data" },
              },
          })   
          .then(({data})=>{
            
            if(data.type == 'error'){
              alert(data.message)
              this.disableBtn = false

              return;
            }

            this._requestToken(formdata)

          })
          .catch(err =>{
          this.disableBtn = false
            console.log(err)
           alert('Something went wrong!')
          })
         
        }
            
      },

      handleRegistration(){
        this.disableBtn = true
        if(this.$refs.RegisterForm.validate()){
          const myForm = document.getElementById('RegisterForm');
          const formdata = new FormData(myForm);

          axios({
            method : "POST",
            url : 'register',
            data: formdata,
            config: {
                  headers: { "Content-Type": "multipart/form-data" },
              },
          })
          .then(() => {
             this.handleLogin()
          })
          .catch(err =>{
            this.disableBtn = false
            console.log(err)
            alert('Something Went Wrong')
          })
        }
      },
         
    },

    mounted() {
      
    },
    watch: {
    },
};
</script>
