<template>
    <v-container fluid>
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
            <v-card-text>
                <v-data-table
                    height="60vh"
                    class="mainTable"
                    :headers="headers"
                    :search="search"
                    :items="clients"
                >
                <template v-slot:[`item.actions`]="{  }">
                    <!-- <v-icon
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
                    </v-icon> -->
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
            clients: [],
            headers: [
                {
                    text: 'Name', align: 'start', value: 'name',
                },
                {
                    text: 'Email', align: 'start', value: 'email',
                },
                {
                    text: 'Invitation Code', align: 'start', value: 'invitation_code',
                },
                {
                    text: 'Inviter Email', align: 'start', value: 'inviter_email',
                },
                { text: 'Actions', value: 'actions', sortable: false, width: "10%" },
            ],
            search: '',
            tempData: {}
        }
    },

    computed:{
        ...mapState([
            'rules',
            'loggedInUser',
        ]),

    },

    methods: {
        ...mapActions([
        ]),
        async initialize(){
            await axios({
                method: "GET",
                url: `/api/admin/${this.loggedInUser.id}/clients`
            }).then(( { data } ) => {
                this.clients = [...data]
            })
        },

    },

    async mounted(){
        this.overlay = true;
        await this.initialize().then(() => {
            this.overlay = false
        })
    }

}
</script>