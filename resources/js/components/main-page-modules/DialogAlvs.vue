<template>
  <div>
    <v-dialog v-model="dialog" persistent max-width="250">
        <v-card>
            <v-card-title><span class="headline">ALVS検討依頼内容</span></v-card-title>
            <v-container>
                <v-card-text>
                    <v-container>
                        <v-row no-gutters>
                            <v-col cols="6">
                                <v-checkbox dense :indeterminate="checkLvs" v-model="alvs" label="ALVS" ></v-checkbox>
                            </v-col>
                            <v-col cols="6">
                                <v-checkbox dense :disabled="checkAlvs" v-model="lvs" label="L"  value="L"></v-checkbox>
                            </v-col>
                            <v-col cols="6">
                                <v-checkbox dense :disabled="checkAlvs" v-model="lvs" label="V"  value="V"></v-checkbox>
                            </v-col>
                            <v-col cols="6">
                                <v-checkbox dense :disabled="checkAlvs"  v-model="lvs" label="S"  value="S"></v-checkbox>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="confirmAlvs()" :disabled="isDisabled">Confirm</v-btn>
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
            alvs: false,
            lvs: []
        }
    },

    computed: {
        checkLvs(){
            return this.lvs.length > 0 && this.lvs.length <= 2
        },

        checkAlvs(){
            return this.alvs == true
        },

        selected(){
            if(this.alvs) return this.alvs
            else return this.lvs


        },

        isDisabled(){
            if(this.lvs.length > 0 || this.alvs) return false
            return true
        }
    },
    

    methods: {
        toggleDialogAlvs(value){
            this.$emit('toggleDialogAlvs', value)
        },

        confirmAlvs(){
            this.$emit('confirmAlvs', this.selected)
            this.toggleDialogAlvs(false)
        }
    },

    watch: {
        alvs(v){
            if(v)  this.$nextTick(() => this.lvs = ['L', 'V', 'S'])
            if(v == false && this.lvs.length === 3)  this.$nextTick(() => this.lvs.splice(0))
        },

        lvs(v){
            if(v.length === 3) this.$nextTick(() => this.alvs = true)
            else this.$nextTick(() => this.alvs = false)
        }
    }
}
</script>

<style>

</style>