<template>
  <div>
        <v-dialog v-model="dialog" persistent max-width="900">
            <v-card>
                <v-container>
                    <v-card-title>
                        <span class="overline">ハウスプレゼンテーション依頼内容</span>
                        <v-spacer></v-spacer>
                    </v-card-title>
                    <v-container>
                        <v-stepper v-model="step" vertical >
                            <v-container>
                                <!-- Step 1 -->
                                <template>
                                    <v-stepper-step :complete="step > 1" step="1" color="#455a64">
                                        <span class="caption font-weight-black">色を選択してください</span>
                                        <small class="caption">{{radio}}</small>
                                    </v-stepper-step>

                                    <v-stepper-content step="1">
                                        <v-radio-group v-model="radio" dense>
                                            <template v-for="(requestContent, i) in requestContents">
                                                <v-radio 
                                                    :key="i"
                                                    :label="requestContent.text" 
                                                    :value="requestContent.text"
                                                    class="mb-n1"
                                                ></v-radio>
                                                <p :key="i+'A'" class="caption pl-8 red--text mb-3">
                                                    {{ requestContent.desc }}
                                                </p>
                                            </template>
                                        </v-radio-group>
                                        <template>
                                            <v-spacer></v-spacer>
                                            <v-btn color="#455a64" small class="white--text" @click="step++" :disabled="!radio"> 継続する </v-btn>
                                        </template> 
                                    
                                    </v-stepper-content>
                                </template>

                                <!-- Step 2 -->
                                <template>
                                    <v-stepper-step :complete="step > 2" step="2" color="#455a64">
                                        <span class="caption font-weight-black">依頼パターン数を入力してください</span>
                                        <small class="caption">{{requestPattern}}</small>
                                    </v-stepper-step>
                                    <v-stepper-content step="2">
                                        <v-container>
                                            <v-autocomplete
                                                v-model="requestPattern" dense
                                                outlined :items="[1, 2, 3, 4]"
                                                clearable
                                            >

                                            </v-autocomplete>
                                        </v-container>
                                        <template>
                                            <v-spacer></v-spacer>
                                            <v-btn text small @click="step--">
                                                Cancel
                                            </v-btn>
                                            <v-btn
                                                color="#455a64" small class="white--text"
                                                @click="step++; radio == '色情報を指示して依頼' ? dialogHpRequestForm = true : ''" :disabled="!requestPattern"
                                            >
                                                継続する
                                            </v-btn>
                                        </template>                                            
                                    </v-stepper-content>
                                </template>

                                <template >
                                    <v-stepper-step :complete="step > 3" step="3" color="#455a64">
                                        <span class="caption font-weight-black">カラーパース依頼書 </span>
                                    </v-stepper-step>
                                    <v-stepper-content step="3">
                                        <template v-if="radio == '仕様書に従って作成'">
                                            <v-row>
                                                <v-col cols="8">
                                                    <v-simple-table class="mainTable colorView">
                                                        <thead>
                                                        <tr>
                                                                <th style="width: 50px !important; text-align: left !important">  </th>
                                                                <th v-for="(count, i ) in requestPattern" :key="i">
                                                                    {{ `パ一タン - ${count}` }}
                                                                </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th style="width: 50px !important; text-align: left !important">視点方向: </th>
                                                            <td v-for="(count, i ) in requestPattern" :key="i"> 
                                                                <v-edit-dialog 
                                                                    :return-value.sync="patterns[count]"
                                                                    large
                                                                    persistent
                                                                    
                                                                >
                                                                <!-- @open="clickIt(item)"
                                                                    @save="UpdateDataIndi('details',toEdit.details, item)"
                                                                    @close="closeIT()" -->
                                                                    <v-tooltip bottom>
                                                                            <template v-slot:activator="{ on }">
                                                                                <span v-on="on"> {{ patterns[count].direction }} </span>
                                                                            </template>
                                                                            <span> {{patterns[count].direction}} </span>
                                                                        </v-tooltip>
                                                                    <template v-slot:input >
                                                                    <small class="overline" > 視点方向  </small>
                                                                        <v-autocomplete
                                                                            v-model="patterns[count].direction"
                                                                            name="details"
                                                                            outlined
                                                                            dense
                                                                            rows="2"
                                                                            :items="viewDirectionSelections"
                                                                        ></v-autocomplete>
                                                                    </template>
                                                                </v-edit-dialog>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                                <th style="width: 50px !important; text-align: left !important">視点高さ: : </th>
                                                                <td v-for="(count, i ) in requestPattern" :key="i">
                                                                    <v-edit-dialog persistent large >
                                                                        <v-tooltip bottom>
                                                                                <template v-slot:activator="{ on }">
                                                                                    <span v-on="on"> {{ patterns[count].height }} </span>
                                                                                </template>
                                                                                <span> {{ patterns[count].height }} </span>
                                                                            </v-tooltip>
                                                                        <template v-slot:input >
                                                                        <small class="overline" > 視点高さ </small>
                                                                            <v-autocomplete
                                                                                v-model="patterns[count].height"
                                                                                name="details"
                                                                                outlined
                                                                                dense
                                                                                rows="2"
                                                                                :items="viewHeightSelections"
                                                                            ></v-autocomplete>
                                                                        </template>
                                                                    </v-edit-dialog>
                                                                </td>
                                                        </tr>
                                                        </tbody>
                                                    </v-simple-table>
                                                    <div class="pt-8">
                                                        <v-spacer></v-spacer>
                                                        <v-btn text small @click="step--">
                                                            Cancel
                                                        </v-btn>
                                                        <v-btn
                                                            color="#455a64" small class="white--text"
                                                            @click="step++"
                                                        >
                                                            継続する
                                                        </v-btn>
                                                    </div>
                                                </v-col>
                                                <v-col cols="4">
                                                    <v-img
                                                    lazy-src
                                                    contain
                                                    src="img/view.png"
                                                    alt="view.png"
                                                    ></v-img>
                                                </v-col>
                                            </v-row>
                                        </template>

                                        <template v-else> 
                                            <span class="caption"> Work In Progress </span> 
                                            <v-btn text small @click="step--">
                                                Cancel
                                            </v-btn>
                                            <v-btn
                                                color="#455a64" small class="white--text"
                                                @click="step++"
                                            >
                                                継続する
                                            </v-btn>
                                        </template>
                                    </v-stepper-content>
                                </template>

                                <template>
                                    <v-stepper-step step="4" color="#455a64">
                                        Lorem Ipsum
                                    </v-stepper-step>
                                    <v-stepper-content step="4">
                                        <v-card
                                            color="grey lighten-1"
                                            class="mb-12"
                                            height="200px"
                                        ></v-card>
                                        <template>
                                            <v-spacer></v-spacer>
                                            <v-btn text small @click="step--">
                                                Cancel
                                            </v-btn>
                                            <v-btn
                                                color="#455a64" small class="white--text"
                                                @click="step = 1" 
                                            >
                                                継続する
                                            </v-btn>
                                        </template>
                                    </v-stepper-content>
                                </template>
                            </v-container>
                        </v-stepper>
                    </v-container>
                    <v-card-actions>
                         <v-spacer></v-spacer>
                        <v-btn text type="submit">Submit</v-btn>
                        <v-btn text @click="toggleDialogHousePresentation(false)">Cancel</v-btn>
                    </v-card-actions>
                </v-container>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogHpRequestForm"
            persistent
            max-width="2000"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">ハウスプレゼンテーション依頼書</span>
                    <v-spacer></v-spacer>
                    <v-icon @click="dialogHpRequestForm = false" dark>mdi-close</v-icon>
                </v-card-title>
                <v-container fluid>
                    <v-card-text>
                        <v-container fluid>
                            <v-simple-table class="mainTable requestView "  fixed-header height="75vh">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(header, i) in hpRequestHeaders" :key="i" class="text-center">
                                        
                                        <th colspan="2" class="left-sticky" style="height: 100px !important" v-if="header == '依頼日'">
                                            <p class="h1 font-weight-black mx-2">{{ header }}</p> 
                                        </th>
                                        
                                        <template  v-else-if="header == '視点方向' || header == '視点高さ' ">
                                            <th colspan="1" class="left-sticky" style="height: 50px !important">
                                                <p class="h1 font-weight-black mx-2">{{ header }}</p> 
                                            </th>

                                            <th colspan="1" rowspan="2" class="image-header-sticky"  v-if="header == '視点方向' ">
                                                <v-img
                                                    height="150"
                                                    width="150"
                                                    lazy-src
                                                    contain
                                                    src="img/view.png"
                                                    alt="view.png"
                                                ></v-img>
                                            </th>
                                        </template>

                                        <th v-else-if="header == 'N/A'" colspan="2" class="left-sticky" style="height: 50px !important">

                                        </th>

                                        <th colspan="2" class="left-sticky" style="height: 50px !important" v-else>
                                            <p class="h1 font-weight-black mx-2">{{ header }}</p> 
                                        </th>
                                        <template v-for="count in 3">
                                            <td :key="count" class="existing-request" v-if="header == 'N/A'">
                                                <p class="overline mx-2">パターン1 <br> 09/29</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '図面番号'">
                                                <p class="overline mx-2">4-9</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '建物タイプ'">
                                                <p class="overline mx-2">i-smile</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '造作色'">
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '建具色'">
                                                <p class="overline mx-2">SOLAR</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'フローリング(1F)'">
                                                <p class="overline mx-2">IZ-510</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'フローリング(2F)'">
                                                <p class="overline mx-2"></p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'フローリング(3F)'">
                                                <p class="overline mx-2"></p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '階段色'">
                                                <p class="overline mx-2">ﾎﾜｲﾄ(TE-1),ﾌﾞﾗｯｸ(TD1)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'キッチンセット'">
                                                <p class="overline mx-2">透明ｶﾞﾗｽ (ｱｰﾊﾞﾝｸﾞﾚｰ)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'キッチンカウンター'">
                                            
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'スリットスライダー'">
                                                <p class="overline mx-2">ﾎﾜｲﾄ (WH)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '石目柄フロア'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '吊押入ユニット'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '格子引き戸'">
                                                
                                            </td>
                                        </template>
                                        <template>
                                            <td class="req-divider"></td>
                                        </template>
                                        
                                        <!-- New Request -->
                                        <template v-for="(pattern, ii) in requestPattern">
                                            <td :key="ii + header" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == 'N/A'">
                                                <v-btn >コピー</v-btn>
                                            </td>
                                            <td :key="ii + header" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == '図面番号'">
                                                {{pattern}}
                                            </td>
                                            <td :key="ii + header" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == '建物タイプ'">
                                                i-smile
                                            </td>

                                            <!--td 建具色 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '造作色'">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td :key="ii + header" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == '造作色'">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="featureColorSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">建具色</span>
                                            </v-tooltip>
                                            

                                            <!--td 建具色 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '建具色'">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on"  :class="`pattern-${requestPattern}-${pattern}`" style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="joineryColorSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">建具色</span>
                                            </v-tooltip>

                                            <!--td フローリング(1F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'フローリング(1F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="grandFlooringSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">フローリング(1F)</span>
                                            </v-tooltip>

                                            <!--td フローリング(2F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'フローリング(2F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td   v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="grandFlooringSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">フローリング(2F)</span>
                                            </v-tooltip>

                                            <!--td フローリング(3F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'フローリング(3F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td   v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="grandFlooringSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">フローリング(3F)</span>
                                            </v-tooltip>

                                            <!--td 階段色 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '階段色'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="smartGrandStairSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">階段色</span>
                                            </v-tooltip>

                                            <!--td キッチンセット -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'キッチンセット'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="joineryColorSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">キッチンセット</span>
                                            </v-tooltip>
                                            
                                            <!--td キッチンカウンター -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'キッチンカウンター'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="grandKitchenCounterSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">キッチンカウンター</span>
                                            </v-tooltip>

                                            <!--td スリットスライダー -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'スリットスライダー'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">スリットスライダー</span>
                                            </v-tooltip>

                                            <!--td 石目柄フロア -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '石目柄フロア'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="stonePatternSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">石目柄フロア</span>
                                            </v-tooltip>

                                            <!--td 吊押入ユニット -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '吊押入ユニット'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="hangingClosetLatticeSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">吊押入ユニット</span>
                                            </v-tooltip>

                                            <!--td 格子引き戸 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '格子引き戸'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="hangingClosetLatticeSelection" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">格子引き戸</span>
                                            </v-tooltip>
                                        </template>
                                    </tr>
                                </tbody>
                            </v-simple-table>
                        </v-container>
                    </v-card-text>
                </v-container>
                <v-card-actions></v-card-actions>
            </v-card>   
        </v-dialog>
  </div>
</template>

<script>
export default {
    props: {
        dialog : Boolean
    }, 

    data(){
        return {
            radio: null,
            step: 1,
            requestContents: [
                {text: "仕様書に従って作成", desc: "※仕様書指示がない場合はおまかせで作成"},
                {text: "色情報を指示して依頼", desc: "※着⼿図⾯依頼以降は選択不可"},
                {text: "依頼なし", desc: ""},
            ],
            viewDirectionSelections: [
                "1",
                "1-2",
                "2",
                "2-3",
                "3",
                "3-4",
                "4",
                "4-5",
                "5",
                "5-6",
                "6",
                "6-7",
                "7",
                "7-8",
                "8",
                "8-9",
                "9",
                "9-10",
                "10",
                "10-11",
                "11",
                "11-12",
                "12",
                "12-1",
            ],
            viewHeightSelections: [
                "LU",
                "1600",
                "1800",
                "2000",
                "2500",
                "3000",
                "3500",
                "4000",
                "4500",
                "5000",
                "5500",
                "6000",
                "6500",
                "7000",
                "7500",
                "8000",
                "8500", 
                "9000", 
                "9500", 
                "10000",
                "10500", 
                "11000",
                "11500",
                "12000",
            ],
            requestPattern: 1,
            patterns : {
                1: { direction: null, height: null },
                2: { direction: null, height: null },
                3: { direction: null, height: null },
                4: { direction: null, height: null },
            },
            dialogHpRequestForm: false,
            hpRequestHeaders: [
                'N/A',
                '図面番号',
                '建物タイプ',
                '造作色',
                '建具色',
                'フローリング(1F)',
                'フローリング(2F)',
                'フローリング(3F)',
                '階段色',
                'キッチンセット',
                'キッチンカウンター',
                'スリットスライダー',
                '石目柄フロア',
                '吊押入ユニット',
                '格子引き戸',
            ],

            featureColorSelection: [
                "",
                { text: "ｼｮｺﾗﾌﾞﾗｳﾝ (CB)", value: "CB" },
                { text: "ﾋﾟｭｱﾒｲﾌﾟﾙ (PM)", value: "PM" },
            ],

            joineryColorSelection: [
                "",
                { text: "ホワイト (WH)", value: "WH" },
                { text: "ライト (LT)", value: "LT" },
                { text: "グレー (G)", value: "G" },
                { text: "ダーク (D)", value: "D" },
            ],

            smartFlooringSelection: [
                "",
                { text: "ﾌﾟﾚｰﾝ (P)", value: "P" },
                { text: "ﾅﾁｭﾗﾙ (N)", value: "N" },
                { text: "ｼｮｺﾗﾌﾞﾗｳﾝ (CB)", value: "CB" },
                { text: "ﾐﾃﾞｨｱﾑ (M)", value: "M" },
                { text: "ﾎﾜｲﾄ・ｳｫｰﾙﾅｯﾄ (WW)", value: "WW" },
                { text: "ﾗｲﾄ・ｳｫｰﾙﾅｯﾄ (LW)", value: "LW" },
                { text: "ｸﾞﾚｰ・ｳｫｰﾙﾅｯﾄ (GW)", value: "GW" },
                { text: "ﾚｯﾄﾞ・ﾁｪﾘｰ (RC)", value: "RC" },
                { text: "ﾋﾞﾀｰ・ｳｫｰﾙﾅｯﾄ (BW)", value: "BW" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BKW)", value: "BKW" },
                { text: "ﾁｰｸ (CH)", value: "CH" },
                { text: "ｻﾍﾟﾘ (SP)", value: "SP" },
                { text: "ｶﾘﾝ (KR)", value: "KR" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BWP)", value: "BWP" },
                { text: "ﾊｰﾄﾞﾒｲﾌﾟﾙ (HM)", value: "HM" },
                { text: "ｵｰｸ (OK)", value: "OK" },
            ],

            smileFlooringSelection: [
                "",
                { text: "ﾗｲﾄ・ｳｫｰﾙﾅｯﾄ (LW)", value: "LW" },
                { text: "ｸﾞﾚｰ・ｳｫｰﾙﾅｯﾄ (GW)", value: "GW" },
                { text: "ﾋﾞﾀｰ・ｳｫｰﾙﾅｯﾄ (BW)", value: "BW" },
            ],

            cubeFlooringSelection: [
                "",
                { text: "ﾌﾟﾚｰﾝ (P)", value: "P" },
                { text: "ﾅﾁｭﾗﾙ (N)", value: "N" },
                { text: "ｼｮｺﾗﾌﾞﾗｳﾝ (CB)", value: "CB" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BKW)", value: "BKW" },
                { text: "ﾁｰｸ (CH)", value: "CH" },
                { text: "ｻﾍﾟﾘ (SP)", value: "SP" },
                { text: "ｶﾘﾝ (KR)", value: "KR" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BWP)", value: "BWP" },
                { text: "ﾊｰﾄﾞﾒｲﾌﾟﾙ (HM)", value: "HM" },
                { text: "ｵｰｸ (OK)", value: "OK" },
            ],

            jikuFlooringSelection: [
                "",
                { text: "ﾅﾁｭﾗﾙ (N)", value: "N" },
                { text: "ﾐﾃﾞｨｱﾑ (M)", value: "M" },
                { text: "ﾀﾞｰｸ (LD)", value: "LD" },
                { text: "ﾌﾟﾚｰﾝ (P)", value: "P" },
                { text: "ｼｮｺﾗﾌﾞﾗｳﾝ (CB)", value: "CB" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BKW)", value: "BKW" },
                { text: "ﾁｰｸ (CH)", value: "CH" },
                { text: "ｻﾍﾟﾘ (SP)", value: "SP" },
                { text: "ｶﾘﾝ (KR)", value: "KR" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BWP)", value: "BWP" },
                { text: "ﾊｰﾄﾞﾒｲﾌﾟﾙ (HM)", value: "HM" },
                { text: "ｵｰｸ (OK)", value: "OK" },
            ],

            grandFlooringSelection: [
                "",
                { text: "ﾎﾜｲﾄ・ｳｫｰﾙﾅｯﾄ (WWT)", value: "WWT" },
                { text: "ﾗｲﾄ・ｳｫｰﾙﾅｯﾄ (LWT)", value: "LWT" },
                { text: "ﾋﾞﾀｰ・ｳｫｰﾙﾅｯﾄ (BWT)", value: "BWT" },
                { text: "ｸﾞﾚｰ・ｳｫｰﾙﾅｯﾄ (GWT)", value: "GWT" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BKW)", value: "BKW" },
                { text: "ﾁｰｸ (CH)", value: "CH" },
                { text: "ｻﾍﾟﾘ (SP)", value: "SP" },
                { text: "ｶﾘﾝ (KR)", value: "KR" },
                { text: "ﾌﾞﾗｯｸｳｫｰﾙﾅｯﾄ (BWP)", value: "BWP" },
                { text: "ﾊｰﾄﾞﾒｲﾌﾟﾙ (HM)", value: "HM" },
                { text: "ｵｰｸ (OK)", value: "OK" },
            ],

            smartGrandStairSelection: [
                "",
                { text: "ﾗｲﾄ (LIT)", value: "LIT" },
                { text: "ﾋﾞﾀｰ (BTR)", value: "BTR" },
                { text: "ﾚｯﾄﾞ (RED)", value: "RED" },
            ],

            smileCubeStairSelection: [
                "",
                { text: "ﾗｲﾄ (LIT)", value: "LIT" },
                { text: "ﾋﾞﾀｰ (BTR)", value: "BTR" },
            ],
            jikuStairSelection: [
                "",
                { text: "ﾅﾁｭﾗﾙ (N)", value: "N" },
                { text: "ﾐﾃﾞｨｱﾑ (M)", value: "M" },
                { text: "ﾀﾞｰｸ (LD)", value: "LD" },
                { text: "ﾗｲﾄ (LT)", value: "LT" },
                { text: "ﾋﾞﾀｰ (BT)", value: "BT" },
            ],

            kitchenSetSelection: [
                "",
                { text: "ﾀﾞｰｸ (D)", value: "D" },
                { text: "ﾃﾞｨｱﾑ (M)", value: "M" },
                { text: "ﾅﾁｭﾗﾙ (N)", value: "N" },
                { text: "ﾎﾜｲﾄ・ｳｫｰﾙﾅｯﾄ (WWT)", value: "WWT" },
                { text: "ﾗｲﾄ・ｳｫｰﾙﾅｯﾄ (LWT)", value: "LWT" },
                { text: "ﾋﾞﾀｰ・ｳｫｰﾙﾅｯﾄ (BWT)", value: "BWT" },
                { text: "ﾌﾟﾚﾐｱﾑ･ﾌﾞﾗｳﾝ (RBW)", value: "RBW" },
                { text: "ﾌﾟﾚﾐｱﾑ･ﾚｯﾄﾞ (RRD)", value: "RRD" },
                { text: "ﾌﾟﾚﾐｱﾑ･ﾌﾞﾗｯｸ (RBK)", value: "RBK" },
                { text: "ﾌﾟﾚﾐｱﾑ･ﾎﾜｲﾄ (RWH)", value: "RWH" },
                { text: "ﾋﾟｱﾉ･ﾌﾞﾗｳﾝ (PBW)", value: "PBW" },
                { text: "ﾋﾟｱﾉ･ﾚｯﾄﾞ (PRE)", value: "PRE" },
                { text: "ﾋﾟｱﾉ･ｱｲﾎﾞﾘｰ (PIV)", value: "PIV" },
                { text: "ﾋﾟｱﾉ･ﾋﾟｰﾁ (PPE)", value: "PPE" },
                { text: "ﾋﾟｱﾉ･ﾎﾜｲﾄ (PWH)", value: "PWH" },
            ],
            smileKitchenSetSelection: [
                "",
                { text: "ﾎﾜｲﾄ・ｳｫｰﾙﾅｯﾄ (WWT)", value: "WWT" },
                { text: "ﾗｲﾄ・ｳｫｰﾙﾅｯﾄ (LWT)", value: "LWT" },
                { text: "ﾋﾞﾀｰ・ｳｫｰﾙﾅｯﾄ (BWT)", value: "BWT" },
            ],
            grandKitchenSetSelection: [
                "",
                { text: "ホワイト (WH)", value: "WH" },
                { text: "サンド (SA)", value: "SA" },
                { text: "グレージュ (GJ)", value: "GJ" },
                { text: "ダーク (D)", value: "D" },
            ],

            smartKitchenCounterSelection: [
                "",
                { text: "純白 (PRW)", value: "PRW" },
                { text: "御影石ｸﾞﾚｰ (GRY)", value: "GRY" },
                { text: "御影石ｱｲﾎﾞﾘｰ (MIV)", value: "MIV" },
                { text: "御影石ﾌﾞﾗｯｸ (MBK)", value: "MBK" },
            ],

            grandKitchenCounterSelection: [
                "",
                { text: "ホワイト (WH)", value: "WH" },
                { text: "ベージュ (BE)", value: "BE" },
                { text: "ブラック (BK)", value: "BK" },
                { text: "御影石アフリカンブラック (ABK)", value: "ABK" },
                { text: "御影石グレー (G)", value: "G" },
            ],

            slitSliderSelection: [
                "",
                { text: "ﾋﾟｭｱ・ﾎﾜｲﾄ (PW)", value: "PW" },
                { text: "スギ・ﾅﾁｭﾗﾙﾄ (SN)", value: "SN" },
            ],

            stonePatternSelection: [
                "",
                { text: "ホワイト (WH)", value: "WH" },
                { text: "ベージュ (BE)", value: "BE" },
                { text: "グレー (G)", value: "G" },
                { text: "ブレック (BK)", value: "BK" },
            ],
            hangingClosetLatticeSelection: [
                "",
                { text: "ヒノキ (LH)", value: "LH" },
                { text: "ブラックパイン (BP)", value: "BP" },
            ],

        }
    },

    methods: {
        toggleDialogHousePresentation(value){
            this.$emit('toggleDialogHousePresentation', value)
        }
    }
}
</script>

<style scoped>
    .v-data-table.colorView th {
        border: 1px solid black;
        border-left: 1px solid black !important;
        border-right: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

     .v-data-table.colorView td {
        border-bottom: 1px solid white !important;
    }

     .v-data-table.requestView td {
        border-top: 1px solid black ;
        border-right: 1px solid black !important;
        border-left: 1px solid black !important;
    }
    
    .left-sticky {
        position: sticky;
        left: 0;
        z-index: 1;
        border-top: 1px solid black !important;
        border-left: 1px solid black !important;
        border-right: 1px solid black !important;
    }

    .existing-request{
        background: #d1d4d1!important;
        color: black!important;
        border-top: 1px solid black !important;
        border-right: 1px solid black !important;
    }
    .req-divider{
        border-top: 1px solid black !important;
        background: #34495e!important;
    }

    /* CASE WHEN REQUEST PATTERN == 4 */
    .pattern-4-1{
        min-width: 200px !important;
        position: sticky;
        right: 600px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;

    }
    .pattern-4-2{
        min-width: 200px !important;
        position: sticky;
        right: 400px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }
    .pattern-4-3{
        min-width: 200px !important;
        position: sticky;
        right: 200px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }
    .pattern-4-4{
        min-width: 200px !important;
        position: sticky;
        right: 0px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }

    /* CASE WHEN REQUEST PATTERN == 3 */
    .pattern-3-1{
        min-width: 200px !important;
        position: sticky;
        right: 400px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }
    .pattern-3-2{
        min-width: 200px !important;
        position: sticky;
        right: 200px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }
    .pattern-3-3{
        min-width: 200px !important;
        position: sticky;
        right: 0;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }

    /* CASE WHEN REQUEST PATTERN == 2 */
    .pattern-2-1{
        min-width: 200px !important;
        position: sticky;
        right: 200px;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }
    .pattern-2-2{
        min-width: 200px !important;
        position: sticky;
        right: 0;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }

    /* CASE WHEN REQUEST PATTERN == 1 */
    .pattern-1-1{
        min-width: 200px !important;
        position: sticky;
        right: 0;
        z-index: 1;
        background: whitesmoke;
        color: black!important;
        border-bottom-color: black !important;
    }

    .top-sticky {
        position: sticky;
        top: 0;
        z-index: 1;
    }



    /*  */

    .image-header-sticky{
        position: sticky;
        top: 1px !important;
        left: 98px !important;
        z-index: 2 !important;
        background: #d1d4d1;
        border-left-color: black !important;
        border-right-color: black !important;
    }
</style>