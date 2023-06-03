<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="250">
        <v-card>
            <v-card-title><span class="headline">構造事前検討依頼(枠組)</span></v-card-title>
            <v-container>
                <v-card-text>
                    <v-row>
                        <!-- OPTION_ZEH -->
                        <v-col cols="12"><span class="caption">構造検討依頼</span></v-col>
                        <v-col cols="12"><v-checkbox dense label="ZEH" v-model="OPTION_ZEH"></v-checkbox></v-col>

                        <!-- OPTION_1 -->
                         <v-col cols="12">
                            <v-radio-group  dense row v-model="OPTION_1" >
                                <v-radio label="あり" value="あり"></v-radio>
                                <v-radio label="なし" value="なし"></v-radio>
                            </v-radio-group>
                        </v-col>

                        <!-- OPTION_2 -->
                        <v-col cols="12"><span class="caption">ダクト指示</span></v-col>
                         <v-col cols="12">
                            <v-radio-group  dense row v-model="OPTION_2" :disabled="isOption2Disabled">
                                <v-radio label="あり" value="あり"></v-radio>
                                <v-radio label="なし" value="なし"></v-radio>
                            </v-radio-group>
                        </v-col>

                        <!-- OPTION_W -->
                        <v-col cols="12"><span class="caption">等級</span></v-col>
                        <v-col cols="6">
                            <v-autocomplete v-model="OPTION_W" dense outlined label="耐風" :items="['W1', 'W2']" clearable></v-autocomplete>
                        </v-col>

                        <!-- OPTION_S -->
                        <v-col cols="6">
                            <v-autocomplete v-model="OPTION_S" dense outlined label="積雪" :items="['S1', 'S2']" clearable></v-autocomplete>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="confirmStructuralRequest()">Confirm</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
    props: {
        dialog: Boolean
    },

    data(){
        return {
            OPTION_ZEH: false,
            OPTION_1: null,
            OPTION_2: null,
            OPTION_W: null,
            OPTION_S: null,
            isOption2Disabled: true

        }
    },
    methods: {
        toggleDialogStructuralRequest(value){
            this.$emit('toggleDialogStructuralRequest', value)
        },

        confirmStructuralRequest(){
            this.$emit('confirmStructuralRequest', {
                OPTION_ZEH: this.OPTION_ZEH,
                OPTION_1: this.OPTION_1,
                OPTION_2: this.OPTION_2,
                OPTION_W: this.OPTION_W,
                OPTION_S: this.OPTION_S,
            })

            this. toggleDialogStructuralRequest(false)
        }
    },

    watch: {
        OPTION_1(val){
            if(val == 'なし'){
                this.OPTION_2 = null;
                this.isOption2Disabled = true;
            }else if(val == 'あり'){
                this.isOption2Disabled = false;

            }
        }
    }
}
</script>

<style>

</style>