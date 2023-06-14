<template>
    <v-container fluid>
        <div>
            <h1>Admin User</h1>
        </div>
        <v-card>
            <v-card-text>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    hide-details
                ></v-text-field>
            </v-card-text>
        </v-card>

        <v-card>
            <v-card-title>
                <div v-if="loggedInUser.never_admin === 2">
                    <v-btn
                        color="#34495E"
                        elevation="2"
                        raised
                        small
                        dark
                        @click="toggleStore(true)"
                    >Add User
                    </v-btn>
                </div>
            </v-card-title>
            <v-card-text>
                <h3>AGENTS</h3>
                <v-data-table
                    height="50vh"
                    class="mainTable"
                    :headers="headers"
                    :items="AGENTS"
                    :search="search"
                >
                <template v-slot:[`item.actions`]="{ item }">
                    <template v-if="loggedInUser.never_admin === 2">
                        <v-icon
                            small
                            class="mr-2"
                            @click="toggleUpdate(true , item)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            small
                            @click="toggleDelete(true , item)"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </template>

                <template v-slot:[`item.created_at`]="{ item }">
                    {{ formatDate(item) }}
                </template>

                <template v-slot:no-data>
                    <v-btn
                        color="primary"
                        @click="initialize"
                    >
                        Reset
                    </v-btn>
                </template>
                </v-data-table>
            </v-card-text>
            <v-card-text>
                <h3>AGENTS (ADMIN)</h3>
                <v-data-table
                    height="50vh"
                    class="mainTable"
                    :headers="headers"
                    :items="ADMIN_AGENTS"
                    :search="search"
                >
                <template v-slot:[`item.actions`]="{ item }">
                    <template v-if="loggedInUser.never_admin === 2">
                        <v-icon
                            small
                            class="mr-2"
                            @click="toggleUpdate(true , item)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            small
                            @click="toggleDelete(true , item)"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </template>
                    <template v-slot:no-data>
                    <v-btn
                        color="primary"
                        @click="initialize"
                    >
                        Reset
                    </v-btn>
                </template>
                </v-data-table>
            </v-card-text>
        </v-card>


<!-- ################################# DIALOGS #################################-->
        <!-- dialogStore Start -->
        <v-dialog v-model="dialogStore" max-width="300" persistent>
            <v-form id="Store" ref="Store" @submit.prevent="Store">
                <v-card>
                    <v-card-title> <span class="overline">Create New Admin User</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field 
                                        outlined 
                                        dense 
                                        label="Email"
                                        name="email" 
                                        class="required"
                                        type="email"
                                        :rules="rules.email"
                                    > </v-text-field>
                                    <v-text-field 
                                        outlined 
                                        autocomplete="off"
                                        :type="showPassword ? 'text' : 'password' "
                                        :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                                        @click:append="showPassword = !showPassword"
                                        @focus="$event.target.removeAttribute('readonly');"
                                        required
                                        readonly 
                                        dense 
                                        label="Password"
                                        name="password" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                    <v-autocomplete
                                        outlined
                                        label="Role"
                                        class="required"
                                        clearable
                                        dense
                                        :items="roles"
                                        item-text="text"
                                        item-value="value"
                                        name="role"
                                    ></v-autocomplete>
                                    <v-text-field 
                                        outlined 
                                        dense 
                                        label="Fullname"
                                        name="name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                    <v-text-field 
                                        outlined 
                                        dense 
                                        label="Phone Number"
                                        name="phone" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="dialogStore = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogStore End -->

        <!-- dialogUpdate Start -->
        <v-dialog v-model="dialogUpdate" max-width="300" persistent>
            <v-form id="Update" ref="Update" @submit.prevent="Update">
                <v-card>
                    <v-card-title> <span class="overline">Update Existing Admin User</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field 
                                        v-model="tempData.email"
                                        outlined 
                                        dense 
                                        label="Email"
                                        name="email" 
                                        class="required"
                                        type="email"
                                        :rules="rules.email"
                                    > </v-text-field>
                                    <!-- <v-text-field 
                                        v-model="tempData.password"
                                        outlined 
                                        autocomplete="off"
                                        :type="showPassword ? 'text' : 'password' "
                                        :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                                        @click:append="showPassword = !showPassword"
                                        @focus="$event.target.removeAttribute('readonly');"
                                        required
                                        readonly 
                                        dense 
                                        label="Password"
                                        name="password" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field> -->
                                    <v-autocomplete
                                        v-model="tempData.role"
                                        outlined
                                        label="Role"
                                        class="required"
                                        clearable
                                        dense
                                        :items="roles"
                                        item-text="text"
                                        item-value="value"
                                        name="role"
                                    ></v-autocomplete>
                                    <v-text-field 
                                        v-if="tempData.invitation_code"
                                        v-model="tempData.invitation_code"
                                        outlined 
                                        dense 
                                        disabled
                                        label="Invitation Code"
                                        name="name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                    <v-text-field 
                                        v-model="tempData.name"
                                        outlined 
                                        dense 
                                        label="Fullname"
                                        name="name" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                    <v-text-field 
                                        v-model="tempData.phone"
                                        outlined 
                                        dense 
                                        label="Phone Number"
                                        name="phone" 
                                        class="required"
                                        :rules="rules.required"
                                    > </v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="dialogUpdate = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogUpdate End -->

        <!-- dialogDelete Start -->
        <v-dialog v-model="dialogDelete" max-width="300" persistent>
            <v-form id="Delete" ref="Delete" @submit.prevent="Delete">
                <v-card>
                    <v-card-title> <span class="overline">Delete Permission</span> </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <p class="overline">CONFIRM DELETE AGENT?</p>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="dialogDelete = false">Cancel</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <!-- dialogDelete End -->

<!-- ################################# OVERLAY #################################-->
        <v-overlay :value="overlay">
            <v-progress-circular
                indeterminate
                size="64"
            ></v-progress-circular>
        </v-overlay>
    </v-container>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    sockets: {

    },
    data(){
        return {
            dialogStore: false,
            dialogUpdate: false,
            dialogDelete: false,
            overlay: false,

            headers: [
                {
                    text: 'Email', align: 'start', value: 'email',
                },
                {
                    text: 'Name', align: 'start', value: 'name',
                },
                {
                    text: 'Invitation Code', align: 'start', value: 'invitation_code',
                },
                {
                    text: 'Date Registered', align: 'start', value: 'created_at',
                },
                { text: 'Actions', value: 'actions', sortable: false, width: "10%" },
            ],
            search: '',
            showPassword: false, 
            tempData: {},
            roles: [
                {text: 'Admin', value: 'admin'},
                {text: 'Agent', value: 'agent'},
            ]
        }
    },

    computed:{
        ...mapState([
            'AGENTS',
            'ADMIN_AGENTS',
            'rules',
            'loggedInUser'
        ]),

    },

    methods: {
        ...mapActions([
            '_getAgents',
            '_getAdminAgents',
        ]),
        async initialize(){
            this._getAgents();
            this._getAdminAgents();
        },
        toggleStore(isShow){
			this.dialogStore = isShow;
		},
        toggleUpdate(isShow, object = {}){
            if( ! isShow ) {
                this.dialogUpdate = false;
                this.tempData = {};
                return;
            }
            if( ! Object.keys(object).length > 0 ) {
                console.log( 'toggleUpdate', 'no data' );
                return;
            }

			this.dialogUpdate = isShow;
            this.tempData = {...object};
            this.tempData.role = this.tempData.never_admin ? 'agent' : 'admin';
		},
        toggleDelete(isShow, object = {}){
            if( ! isShow ) {
                this.dialogDelete = false;
                this.tempData = {};
                return;
            }
            if( ! Object.keys(object).length > 0 ) {
                console.log( 'toggleDelete', 'no data' );
                return;
            }

			this.dialogDelete = isShow;
            this.tempData = {...object};
		},
        Store(){
            if(this.$refs.Store.validate()){
                this.overlay = true;
                const myForm = document.getElementById('Store');
                const formdata = new FormData(myForm);

                axios({
                    method: 'POST',
                    url: '/api/master/admin/user/store',
                    data: formdata
                }).then(( { data } ) => {
                    if(data.exists){
                        alert(data.exists)
                        return;
                    }
                    
                    this.initialize();
                    this.$refs.Store.reset()
                    this.toggleStore(false);
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.overlay = false;
                })
            }
        },
        Update(){
            if(this.$refs.Update.validate()){
                this.overlay = true;
                const myForm = document.getElementById('Update');
                const formdata = new FormData(myForm);

                axios({
                    method: 'POST',
                    url: `/api/master/admin/user/update/${this.tempData.id}`,
                    data: formdata
                }).then(() => {
                    this.initialize();
                    this.$refs.Update.reset()
                    this.toggleUpdate(false);
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.overlay = false;
                })
            }
        },
        Delete(){
            if(this.$refs.Delete.validate()){
                this.overlay = true;
                const myForm = document.getElementById('Delete');
                const formdata = new FormData(myForm);

                axios({
                    method: 'POST',
                    url: `/api/master/admin/user/delete/${this.tempData.id}`,
                    data: formdata
                }).then(() => {
                    this.initialize();
                    this.$refs.Delete.reset()
                    this.toggleDelete(false);
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.overlay = false;
                })
            }
        },
        formatDate(item){
            const formattedTimestamp = new Date(item.created_at).toISOString().replace("T", " ").replace("Z", "");
            // console.log(formattedTimestamp);
            return formattedTimestamp
        }
    },

    async mounted(){
        this.overlay = true;
        await this.initialize().then(() => {
            this.overlay = false
        })
    }

}
</script>