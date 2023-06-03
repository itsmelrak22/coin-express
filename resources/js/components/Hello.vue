<template>
    <v-card>
        <v-card-title style="background-color:#B2DFDB">Home</v-card-title>
        <v-card-text>
            <p>HOME</p>
            <p>some transcations & logics here....</p>
            <v-btn color="success" @click="test">tex</v-btn>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    sockets: {
        // NOTE : SOCKET 
        updateReceived: function(socket) {
            if (socket && socket.dispatchType == 'response' ) {
                console.log('outputData', socket.data.outputData)
            }
        }
    },
    methods: {
        test(){
            this.$socket.emit('newUpdate', { dispatchType: 'request', data: {
                customerCode: '0008888-2609',
                loginUserID: this.$store.state.loggedInUser.id,
            } })
        }
    }

}
</script>