<template>
  <div>
        <v-dialog v-model="dialog" max-width="400" persistent>
            <v-card>
                <v-card-title>
                    <span class="headline"> 図面番号入力 </span>
                    <v-spacer></v-spacer>
                    <v-icon dark @click="toggleDialogRevision(false)">mdi-close</v-icon>
                </v-card-title>
                <v-container>
                    <v-card-text>
                        <v-radio-group v-model="radio" dense > 
                            <v-radio :label="`新規CAD依頼(図面番号︓${possibleRevision})`" value="1"></v-radio>
                            <v-expand-transition>
                                <div class="pl-8" v-if="radio == 1">
                                    <form ref="APlan">
                                        <v-radio-group v-model="radio2" dense>
                                            <v-radio label="施工面積58坪未満" value="1A" name="more_than_58_tsubo"></v-radio>
                                            <v-radio label="施工面積58坪以上" value="1B" name="less_than_58_tsubo"></v-radio>
                                        </v-radio-group>
                                    </form>
                                </div>
                            </v-expand-transition>
                            
                            <v-radio label="大きな変更あり(前回依頼分より)" value="2"></v-radio>
                            <v-expand-transition>
                                <div class="pl-8" v-if="radio == 2">
                                    <p class="caption font-weight-black" >約30箇所以上の変更平面図の反転または回転ゾーニングの変更あり</p>
                                </div>
                            </v-expand-transition>
                            
                            <v-radio label="通常な変更あり(前回依頼分より)" value="3"></v-radio>
                            <v-expand-transition>
                                <div class="pl-8" v-if="radio == 3">
                                    <p class="caption font-weight-black"> 約30箇所以内の変更箇所ゾーニングの変更あり </p>
                                </div>
                            </v-expand-transition>

                            <v-radio label="小さな変更あり(前回依頼分より)" value="4"></v-radio>
                            <v-expand-transition>
                                <div class="pl-8" v-if="radio == 4">
                                    <p class="caption font-weight-black"> 約10箇所以下の内部の変更 約５箇所以下の外部の変更 屋根伏せ図の変更 </p>
                                </div>
                            </v-expand-transition>

                            <v-radio label="旧CAD依頼書からの切り替え" value="5"></v-radio>
                            <v-expand-transition>
                                <div class="pl-8" v-if="radio == 5">
									<span class="caption font-weight-black">図面番号入力:</span>
                                        <span>
                                            <form ref="CustomRevision">
                                                <v-row no-gutters>
                                                    <v-col cols="5">
                                                        <v-text-field
                                                        v-model="firstDigit"
                                                        outlined
                                                        dense
                                                        type="text"
                                                        name="firstDigit"
                                                        :rules="rules.positiveNumber"
                                                        ></v-text-field>   
                                                    </v-col>
                                                    <v-col cols="2" class="text-center">
                                                        <span> <v-icon class="pt-2">mdi-minus</v-icon> </span>
                                                    </v-col>
                                                    <v-col cols="5">
                                                        <v-text-field
                                                        v-model="secondDigit"
                                                        outlined
                                                        dense
                                                        type="text"
                                                        name="secondDigit"
                                                        :rules="rules.positiveNumber"
                                                        ></v-text-field>   
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-radio-group v-model="radio3" dense :disabled="checkRadio3Disabled" name="radio3">
                                                             <v-radio label="大きな変更あり(前回依頼分より)" value="5A"></v-radio>
                                                                <v-expand-transition>
                                                                    <div class="pl-8" v-show="radio3 == '5A'">
                                                                        <p class="caption font-weight-black" >約30箇所以上の変更平面図の反転または回転ゾーニングの変更あり</p>
                                                                    </div>
                                                                </v-expand-transition>
                                                                
                                                                <v-radio label="通常な変更あり(前回依頼分より)" value="5B"></v-radio>
                                                                <v-expand-transition>
                                                                    <div class="pl-8" v-show="radio3 == '5B'">
                                                                        <p class="caption font-weight-black"> 約30箇所以内の変更箇所ゾーニングの変更あり </p>
                                                                    </div>
                                                                </v-expand-transition>

                                                                <v-radio label="小さな変更あり(前回依頼分より)" value="5C"></v-radio>
                                                                <v-expand-transition>
                                                                    <div class="pl-8" v-show="radio3 == '5C'">
                                                                        <p class="caption font-weight-black"> 約10箇所以下の内部の変更 約５箇所以下の外部の変更 屋根伏せ図の変更 </p>
                                                                    </div>
                                                                </v-expand-transition>
                                                        </v-radio-group>
                                                    </v-col>
                                                </v-row>
                                            </form>  
                                            <!-- <span class="overline font-weight-black">
                                                -
                                            </span>
                                            <v-otp-input
                                            length="1"
                                            type="number"
                                            ></v-otp-input>  -->
                                        </span>  
                                </div>
                            </v-expand-transition>

                            <v-radio label="CAD図面番号の変更なし" value="6"></v-radio>
                        </v-radio-group>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn  small text  @click="sendDialogRevisionData" :disabled="checkRadioDisabled"> Save </v-btn>
                    </v-card-actions>
                </v-container>
            </v-card>
        </v-dialog>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
    props: {
        dialog : Boolean
    },

    data() {
        return {
            radio: null,
            radio2: null,
            radio3: null,
            revisionDetails: null,
            revision: '',
            firstDigit: null,
            secondDigit: null,
            currentRevision: '1-0'
        }
    },

    computed: {
        ...mapState([
            'rules',
            'existingRevisions'
        ]),

        checkRadio3Disabled(){
               return !this.firstDigit || !this.secondDigit
        },

        checkRadioDisabled(){
            if(!this.radio) return true
            
            if(this.radio == 1 && this.radio2){
                return false
            }else if(this.radio == 5 && (this.firstDigit && this.secondDigit) && this.radio3){
                return false;
            }else if(this.radio != 5 && this.radio != 1){
                return false;
            }else{
                return true;
            }
        },

        possibleRevision(){
            const revisionContent = this.currentRevision.split('-');
            return `${+revisionContent[0] + 1}-0`
        },

        addOneInSecondDigit(){
            const revisionContent = this.currentRevision.split('-');
            return `${revisionContent[0]}-${+revisionContent[1] + 1}`
        }
    },

    methods: {
        toggleDialogRevision(value){
            this.$emit('toggleDialogRevision', value);
        },

        sendDialogRevisionData(){
            switch (this.radio) {
                case '1':
                    this.revision = this.possibleRevision;
                    break;
                case '2':
                    this.revision = this.addOneInSecondDigit;
                    break;
                case '3':
                    this.revision = this.addOneInSecondDigit;
                    break;
                case '4':
                    this.revision = this.addOneInSecondDigit;
                    break;
                case '5':
                    this.revision = `${this.firstDigit}-${this.secondDigit}`;
                    break;
                case '6':
                    let index = this.existingRevisions.length-1;
                    this.revision = this.existingRevisions[index].revision_number;
                    break;
            }

            this.$emit('sendDialogRevisionData', this.revision)
            this.$emit('toggleDialogRevision', false);

        }
    },

    
    watch: {
        radio(val){
            if(!val) return 

            this.firstDigit = null
            this.secondDigit = null
            this.$nextTick(() => {
                if (this.$refs.CustomRevision) {
                    this.radio3 = null
                    this.$refs.CustomRevision.reset();
                }

                if (this.$refs.APlan) {
                    this.radio2 = null
                    this.$refs.APlan.reset();
                }
            })
        },

        dialog(val){
            if( !val ){
                this.radio = null;
                this.radio2 = null;
                this.radio3 = null;
            }
        }
    }
}
</script>

<style>

</style>