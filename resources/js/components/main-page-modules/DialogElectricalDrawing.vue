<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="250">
            <v-card>
                <v-card-title><span class="headline">電気図面依頼</span></v-card-title>
                <v-container>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <!-- OPTION_1 -->
                                <v-col cols="12"><span class="caption">電気図面依頼</span></v-col>
                                <v-col cols="12">
                                    <v-radio-group  dense row v-model="OPTION_1">
                                        <v-radio label="あり" value="あり"></v-radio>
                                        <v-radio label="なし" value="なし"></v-radio>
                                    </v-radio-group>
                                </v-col>

                                <!-- OPTION_2 -->
                                <v-col cols="12"><span class="caption">E更新</span></v-col>
                                <v-col cols="12">
                                    <v-radio-group  dense row v-model="OPTION_2" :disabled="isOption2Disabled">
                                        <v-radio label="あり" value="あり"></v-radio>
                                        <v-radio label="なし" value="なし"></v-radio>
                                    </v-radio-group>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                        <v-btn color="red" @click="closetoggleDialogElectricalDrawing()">キャンセル</v-btn>
                        <v-btn color="green" @click="confirmElectricalDrawing()">保存</v-btn>
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
            OPTION_1: null,
            OPTION_2: null,
            isOption2Disabled: true
        }
    },

    methods: {
        closetoggleDialogElectricalDrawing(){
            this.toggleDialogElectricalDrawing(false);
        },
        toggleDialogElectricalDrawing(value){
            this.$emit('toggleDialogElectricalDrawing', value);
        },


        confirmElectricalDrawing(){
            this.$emit('confirmElectricalDrawing', {
                OPTION_1: this.OPTION_1,
                OPTION_2: this.OPTION_2,
            });

            this.toggleDialogElectricalDrawing(false);
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