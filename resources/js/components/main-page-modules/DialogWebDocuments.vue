<template>
  <div>
    <v-dialog persistent v-model="dialog" max-width="300">
        <v-card>
            <v-card-title>
                <span class="headline">WEB打ち合わせ用提案資料</span>
                <v-spacer></v-spacer>
                <v-icon dark @click="toggleDialogWebDocuments(false)">mdi-close</v-icon>
            </v-card-title>
            <v-container fluid>
                <v-card-text>
                   <v-container fluid>
                     <v-checkbox
                        class="mb-n2"
                        dense
                        v-for="(data, i) in webDocsData"
                        v-model="selected" 
                        :key="i" 
                        :label="data.text" 
                        :value="data"></v-checkbox>
                   </v-container>
                </v-card-text>
            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <!-- <v-btn @click="submitWebDocumentSelection">Submit</v-btn> -->
                    <v-btn color="red" @click="close">キャンセル</v-btn>
                    <v-btn color="green" @click="submitWebDocumentSelection">保存</v-btn>
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
            selected: [],
            webDocsData: [
                {value: 1, text: '①プラン提案資料'},
                {value: 2, text: '②収納提案資料'},
                {value: 3, text: '③住設提案資料'},
                {value: 4, text: '④サッシ提案資料'},
                {value: 5, text: '⑤内装資料'},
                {value: 6, text: '⑥電気提案資料'},
                {value: 7, text: '⑦照明提案資料'},
            ]
        }
    },

    methods: {
        close(){
            this.toggleDialogWebDocuments(false)
        },
        toggleDialogWebDocuments(val){
            this.$emit('toggleDialogWebDocuments', val)
        },

        submitWebDocumentSelection(){
            this.$emit('submitWebDocumentSelection', this.selected)
            this.toggleDialogWebDocuments(false)
        }
    }
}
</script>

<style>

</style>