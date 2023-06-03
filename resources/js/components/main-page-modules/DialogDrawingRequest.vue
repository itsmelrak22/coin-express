<template>
  <div>
    <v-dialog v-model="dialog" persistent  max-width="400">
        <v-card>
            <v-card-title><span class="headline">着手図面依頼</span></v-card-title>
            <v-container>
                <v-card-text>
                    <v-container>
                        <v-radio-group v-model="final_plan_selection" dense>
                            <v-radio value="1" label="着手図面依頼" ></v-radio>
                            <v-radio value="2" label="着手図面依頼+⾒積チェック依頼１回目" ></v-radio>
                            <v-radio value="3" label="着手図面依頼+⾒積チェック依頼2回目" ></v-radio>
                            <v-radio label="依頼なし" ></v-radio>
                        </v-radio-group>
                    </v-container>
                </v-card-text>
            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" @click="closeconfirmDrawingRequest()">キャンセル</v-btn>
                <v-btn color="green" @click="confirmDrawingRequest()">保存</v-btn>
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
            final_plan_selection : null,
        }
    },

    methods: {
        closeconfirmDrawingRequest(){
            this.toggleDialogDrawingRequest(false)
        },
        toggleDialogDrawingRequest(value){
            this.$emit('toggleDialogDrawingRequest', value)
        },
        confirmDrawingRequest(){
            this.$emit('confirmDrawingRequest', this.final_plan_selection)
            this.toggleDialogDrawingRequest(false)
        },
    }
}
</script>

<style>

</style>