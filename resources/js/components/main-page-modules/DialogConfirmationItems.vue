<template>
<div>
    <v-dialog v-model="dialog" max-width="300" persistent>
        <v-card>
            <v-card-title>
                <span class="headline">確認事項</span>
            </v-card-title>
            <v-container>
                <v-card-text>
                    <v-container>
                        地盤調査報告書がアップロードされていないと、配置図（測定点入）を作成することができません
                    </v-container>
                </v-card-text>
            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="confirmJibanPlan()">OK</v-btn>
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

        }
    },

    methods: {
        toggleDialogConfirmationItems(val){
            this.$emit('toggleDialogConfirmationItems', val)
        },

        confirmJibanPlan(){
            this.$emit('confirmJibanPlan', true)
            this.toggleDialogConfirmationItems(false)
        }
    }


}
</script>

<style>

</style>