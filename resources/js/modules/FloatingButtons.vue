<template>
  <div>
    <template id="Add" v-if="floatButtons.add"> 
      <v-btn
          v-show="NOT_EDIT_MODE()"
          color="primary"
          :class="UPDATE_BUTTON_IS_TRUE()"
          elevation="2"
          fab
          fixed
          right
          @click="toggleDialogStore"
      >
      <v-icon>mdi-plus</v-icon>
      </v-btn>
    </template>

    <template id="Delete" v-if="floatButtons.delete">
      <v-btn
          v-show="EDIT_MODE_AND_HAS_SELECTED_DATA()"
          color="primary"
          class="float-delete"
          elevation="2"
          fab
          fixed
          right
          @click="toggleDialogDelete"
      >
      <v-icon>mdi-trash-can</v-icon>
      </v-btn>
    </template>

    <template id="cad-pdf" v-if="floatButtons.cadPdf && cadRequestRevisionContent.status == 'SAVED'">
      <v-btn
          v-show="CAD_PDF()"
          color="primary"
          elevation="2"
          fab
          absolute
          fixed
          class="float-cad-pdf"
          right
          @click="generatePDF"
      >
      <v-icon>mdi-file-pdf-box</v-icon>
      </v-btn>
    </template>

    <!-- <template id="pira-pdf" v-if="floatButtons.piraPdf">
      <v-btn
          v-show="PIRA_PDF()"
          color="primary"
          elevation="2"
          fab
          absolute
          fixed
          class="float-pira-pdf"
          right
          @click="generatePiraPDF"
      >
      <v-icon>mdi-format-color-fill</v-icon>
      </v-btn>
    </template> -->

    <template id="update" v-if="floatButtons.update">
      <v-btn
          v-show="NOT_EDIT_MODE()"
          color="primary"
          elevation="2"
          fab
          absolute
          fixed
          class="float-edit"
          right
          @click="toggleEditMode"
      >
      <v-icon>mdi-pencil</v-icon>
      </v-btn>
    </template>

    <template id="return-to-add" >
      <v-btn
          v-show="EDIT_MODE()"
          color="primary"
          elevation="2"
          fab
          absolute
          fixed
          class="float-edit"
          right
          @click="toggleEditMode"
      >
      <v-icon>mdi-close</v-icon>
      </v-btn>
    </template>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
  props: {
    floatButtons: {
      type: Object
    },
    selectedData: {
      type: Array
    }
  },

  computed:{
    ...mapState([
        'editMode',
        'cadRequestRevisionContent'
    ])
  },

  methods: {
    ...mapActions([
        'toggleEditMode',
    ]),
    toggleDialogStore(){
      this.$emit('toggleDialogStore', true);
    },

    toggleDialogDelete(){
      this.$emit('toggleDialogDelete', true);
    },

    NOT_EDIT_MODE(){
      if(!this.editMode) return true
      else return false
    },

    EDIT_MODE_AND_HAS_SELECTED_DATA(){
      if(this.editMode && this.selectedData.length > 0) return true
      else return false
    },

    EDIT_MODE(){
      if(this.editMode) return true;
      else return false;
    },

    UPDATE_BUTTON_IS_TRUE(){
      if(this.floatButtons.update) return 'float-add'
      else return ''
    },

    CAD_PDF(){
      if(this.floatButtons.cadPdf) return true
      else return false
    },

    PIRA_PDF(){
      if(this.floatButtons.piraPdf) return true
      else return false
    },

    generatePDF(){
      this.$emit('generatePDF', true)
    },

    generatePiraPDF(){
      this.$emit('generatePiraPDF', true)
    }
  }

}
</script>

<style scoped>
.v-btn--fab{
    bottom: 12px;
}

/*
.v-btn--fab.float-add,.v-btn--fab.float-delete{
    right:100px;
}
*/

/* .v-btn--fab.float-edit,.v-btn--fab.float-close,.v-btn--fab.settings{
    right:24px;
} */

.v-btn--fab.float-cad-pdf{
    /* right:24px; */
    right:80px;
}

.v-btn--fab.float-pira-pdf{
    /* right:24px; */
    right:145px;
}

.v-btn--fab.float-add{
    /* right:24px; */
    right:80px;
}

.v-btn--fab.float-delete{
    /* right:24px; */
    right:80px;
}


/* .v-btn--floating {
    position: relative;
    float:right !important;
  } */
</style>