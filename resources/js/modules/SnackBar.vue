<template>
  <div class="text-center">
    <v-snackbar  v-model="snackbar.show" >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue"
          text
          v-bind="attrs"
          @click="toggleSnackBar()"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>
<script>
export default {
    props: {
        snackbar: Object,
    },
    data: () => ({
        text: 'My timeout is set to 2000.',
        timeout: 2000
    }),

    computed:{
       
    },


    methods: {
        toggleSnackBar(){
            this.$emit('toggleSnackBar', false)
        }
    },

    watch:{
       
    }

    
  }
</script>