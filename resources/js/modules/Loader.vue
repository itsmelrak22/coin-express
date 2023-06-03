<template>
  <div class="text-center">
    <v-dialog
      v-model="loader"
      hide-overlay
      persistent
      width="300"
      z-index="205"
    >
      <v-card
      >
      <v-card-title>
          <span class="headline">Loading, please wait.</span>
      </v-card-title>
        <v-card-text>
            <div class="my-3">
                <div class="text-center"> test </div>
            </div>
            <v-progress-linear
                indeterminate
                color="#546e7a"
                class="mb-0"
            ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import { mapState } from 'vuex'
  export default {
    data () {
      return {
        dialog: false,
        loader: false
      }
    },

    computed: {
        //  ...mapState([
        //     'loader'
        // ])
    },

    watch: {
      
    },
  }
</script>