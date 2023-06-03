<template>
  <v-snackbar
    timeout="-1"
    top
    right
    v-model="alert"
    color="blue-grey darken-2"
  >
  test
    <template v-slot:action="{ attrs }">
      <v-btn
        color="white"
        text
        v-bind="attrs"
        @click="close()"
        >Close</v-btn
      >
    </template>
  </v-snackbar>
</template>
<script>
export default {
  data() {
    return {
      alert: false
    };
  },
  computed: {
    alertDialog(){
      // return this.$store.state.alert.dialog
      return false;
    },

    alertMsg(){
      // return this.$store.state.alert.title
      return 'test'
    },

    toggleLoading(){
      this.disableBtn = true;
    }
  },
  methods: {
    close(){
      // this.$store.commit('hideAlert')
          this.alert = false

    }
  },
  watch: {
    alertDialog(val) {
      if(val){
        setTimeout(() => {
          this.alert = false
        }, 2000);
      }
    }
  },
};
</script>
