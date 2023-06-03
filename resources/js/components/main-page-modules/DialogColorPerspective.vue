<template>
  <div>
        <v-dialog v-model="dialog" max-width="900" persistent>
            <v-card>
                <v-container>
                    <v-card-title> <span class="overline font-weight-black">カラーパース依頼内容</span> </v-card-title>
                        <v-container>
                            <v-stepper v-model="e6" vertical >
                                <v-container>
                                    <!-- Step 1 -->
                                    <template>
                                        <v-stepper-step :complete="e6 > 1" step="1" color="#455a64">
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
                                                <v-btn color="#455a64" small class="white--text" @click="e6++" :disabled="!radio"> 継続する </v-btn>
                                            </template> 
                                        </v-stepper-content>
                                    </template>

                                    <!-- Step 2 -->
                                    <template>
                                        <v-stepper-step :complete="e6 > 2" step="2" color="#455a64">
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
                                                <v-btn text small @click="e6--">
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    color="#455a64" small class="white--text"
                                                    @click="e6++; radio == '色情報を指示して依頼' ? dialogColorPers = true : ''" :disabled="!requestPattern"
                                                >
                                                    継続する
                                                </v-btn>
                                            </template>                                            
                                        </v-stepper-content>
                                    </template>

                                    <template >
                                        <v-stepper-step :complete="e6 > 3" step="3" color="#455a64">
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
                                                            <v-btn text small @click="e6--">
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn
                                                                color="#455a64" small class="white--text"
                                                                @click="e6++"
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
                                                <v-btn text small @click="e6--">
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    color="#455a64" small class="white--text"
                                                    @click="e6++"
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
                                                <v-btn text small @click="e6--">
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    color="#455a64" small class="white--text"
                                                    @click="e6 = 1" 
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
                        <v-btn text type="submit" @click="testing">Submit</v-btn>
                        <v-btn text @click="toggleDialogColorPerspective(false)">Cancel</v-btn>
                    </v-card-actions>
                </v-container>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogColorPers"
            persistent
            max-width="2000"
        >
            <v-card>
                <v-card-title>
                    <span class="headline">カラーパース依頼書</span>
                    <v-spacer></v-spacer>
                    <v-icon @click="dialogColorPers = false" dark>mdi-close</v-icon>
                </v-card-title>
                <v-container fluid>
                    <v-card-text>
                        <v-container fluid>
                            <v-simple-table class="mainTable requestView "  fixed-header height="75vh">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(header, i) in colorPersRequestHeaders" :key="i" class="text-center">
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

                                        <th colspan="2" class="left-sticky" style="height: 50px !important" v-else>
                                            <p class="h1 font-weight-black mx-2">{{ header }}</p> 
                                        </th>
                                        <!-- SECTION RECENT -->
                                        <template v-for="count in 0">
                                            <td :key="count" class="existing-request" v-if="header == '依頼日'">
                                                <p class="overline mx-2">パターン1 <br> 09/29</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '図面番号'">
                                                <p class="overline mx-2">4-9</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '建物タイプ'">
                                                <p class="overline mx-2">i-smile</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '屋根'">
                                                <p class="overline mx-2">SOLAR</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '吹付け(1F)'">
                                                <p class="overline mx-2">IZ-510</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '吹付け(2F)'">
                                                <p class="overline mx-2"></p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '吹付け(3F)'">
                                                <p class="overline mx-2"></p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '外壁タイル'">
                                                <p class="overline mx-2">ﾎﾜｲﾄ(TE-1),ﾌﾞﾗｯｸ(TD1)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'バルコニーガラス'">
                                                <p class="overline mx-2">透明ｶﾞﾗｽ (ｱｰﾊﾞﾝｸﾞﾚｰ)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'デザインルーバー'">
                                            
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'サッシ'">
                                                <p class="overline mx-2">ﾎﾜｲﾄ (WH)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '玄関ドア'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'モール・矢切飾り'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'バルコニー帯'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'タイル面帯'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '化粧帯(1F)'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '化粧帯(2F)'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '軒天'">
                                                
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '破風'">
                                                <p class="overline mx-2">ｸﾞﾘｰﾝ (GGR)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '土台水切り'">
                                                <p class="overline mx-2">ｱｰﾊﾞﾝｸﾞﾚｰ (UG)</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'ポーチタイル'">
                                                <p class="overline mx-2">T2107</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '視点方向'">
                                                <p class="overline mx-2">1-2</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == '視点高さ'">
                                                <p class="overline mx-2">1800</p>
                                            </td>
                                            <td :key="count" class="existing-request" v-if="header == 'ガーデン番号'">
                                                <p class="overline mx-2">img</p>
                                            </td>
                                        </template>
                                        <!-- !SECTION RECENT -->
                                        <template>
                                            <td class="req-divider"></td>
                                        </template>
                                        
                                        <!-- New Request -->
                                        <template v-for="(pattern, ii) in requestPattern">
                                            <td :key="ii + header" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == '依頼日'">
                                                <v-btn >コピー</v-btn>
                                            </td>
                                            <td :key="ii + header" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == '図面番号'">
                                                    {{ cadRequestLatestRevision }}
                                            </td>
                                            <td :key="ii + header" :class="`pattern-${requestPattern}-${pattern}`" v-if="header == '建物タイプ'">
                                                <v-autocomplete
                                                    v-model="cadRequestBasicInformation.house_type_id"
                                                    :items="HOUSE_TYPES"
                                                    item-text="name"
                                                    item-value="id"
                                                    readonly
                                                >
                                                </v-autocomplete>
                                            </td>

                                            <!--td 屋根 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '屋根'">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  @click="toggleRoofDialog()" v-bind="attrs"  v-on="on"  :class="`pattern-${requestPattern}-${pattern}`" style="cursor: pointer">
                                            
                                                    </td>
                                                </template>
                                                <span class="overline">屋根</span>
                                            </v-tooltip>

                                            <!--td 吹付け(1F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '吹付け(1F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  @click="toggleOpenSidingDialog('dialogSiding1F')" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        
                                                    </td>
                                                </template>
                                                <span class="overline">吹付け(1F)</span>
                                            </v-tooltip>

                                            <!--td 吹付け(2F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '吹付け(2F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  @click="toggleOpenSidingDialog('dialogSiding2F')" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        
                                                    </td>
                                                </template>
                                                <span class="overline">吹付け(2F)</span>
                                            </v-tooltip>

                                            <!--td 吹付け(3F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '吹付け(3F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  @click="toggleOpenSidingDialog('dialogSiding3F')" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        
                                                    </td>
                                                </template>
                                                <span class="overline">吹付け(3F)</span>
                                            </v-tooltip>

                                            <!--td 外壁タイル -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '外壁タイル'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td @click="toggleDialogExteriorWallTiles()" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        
                                                    </td>
                                                </template>
                                                <span class="overline">外壁タイル</span>
                                            </v-tooltip>

                                            <!--td バルコニーガラス -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'バルコニーガラス'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="balconyGlass" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">バルコニーガラス</span>
                                            </v-tooltip>
                                            
                                            <!--td デザインルーバー -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'デザインルーバー'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td @click="toggleDialogDesignLouvers()" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        
                                                    </td>
                                                </template>
                                                <span class="overline">デザインルーバー</span>
                                            </v-tooltip>

                                            <!--td サッシ -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'サッシ'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="sash" item-text="text" item-value="value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">サッシ</span>
                                            </v-tooltip>

                                            <!--td 玄関ドア -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '玄関ドア'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td @click="toggleDialogEntranceDoor()" v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                    </td>
                                                </template>
                                                <span class="overline">玄関ドア</span>
                                            </v-tooltip>

                                            <!--td モール・矢切飾り -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'モール・矢切飾り'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">モール・矢切飾り</span>
                                            </v-tooltip>

                                            <!--td バルコニー帯 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'バルコニー帯'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">バルコニー帯</span>
                                            </v-tooltip>

                                            <!--td タイル面帯 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'タイル面帯'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">タイル面帯</span>
                                            </v-tooltip>

                                            <!--td 化粧帯(1F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '化粧帯(1F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">化粧帯(1F)</span>
                                            </v-tooltip>

                                            <!--td 化粧帯(2F) -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '化粧帯(2F)'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">化粧帯(2F)</span>
                                            </v-tooltip>

                                            <!--td 軒天 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '軒天'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="EAVES_SELECTIONS" item-text="eaves_name" item-value="eaves_value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">軒天</span>
                                            </v-tooltip>

                                            <!--td 破風 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '破風'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="GABLE_SELECTIONS" item-text="gable_name" item-value="gable_value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">破風</span>
                                            </v-tooltip>

                                            <!--td 土台水切り -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '土台水切り'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="BASE_DRAINERS" item-text="base_drainer_name" item-value="base_drainer_value"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">土台水切り</span>
                                            </v-tooltip>

                                            <!--td ポーチタイル -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'ポーチタイル'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  @click="togglePorchTilesDialog()"  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                       
                                                    </td>
                                                </template>
                                                <span class="overline">ポーチタイル</span>
                                            </v-tooltip>

                                            <!--td 視点方向 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '視点方向'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="VIEW_DIRECTION_SELECTIONS" item-text="direction" item-value="id"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">視点方向</span>
                                            </v-tooltip>

                                            <!--td 視点高さ -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == '視点高さ'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense :items="VIEW_HEIGHT_SELECTIONS" item-text="view_height_name" item-value="id"> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">視点高さ</span>
                                            </v-tooltip>

                                            <!--td ガーデン番号 -->
                                            <v-tooltip top color="#34495e" style="opacity: 1 !important"  :key="ii + header"  v-if="header == 'ガーデン番号'" >
                                                <template v-slot:activator="{ on, attrs }">
                                                    <td  v-bind="attrs"  v-on="on" :class="`pattern-${requestPattern}-${pattern}`"  style="cursor: pointer">
                                                        <v-container>
                                                            <v-autocomplete  dense> </v-autocomplete>
                                                        </v-container>
                                                    </td>
                                                </template>
                                                <span class="overline">ガーデン番号</span>
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

        <v-dialog  v-model="dialogRoof" persistent max-width="300">
            <v-form id="StoreRoof" ref="StoreRoof" @submit.prevent="StoreRoof">
                <v-card>
                    <v-card-title> 
                        <span class="overline">屋根</span> 
                        <v-spacer></v-spacer>
                        <v-icon @click="dialogRoof = false" dark>mdi-close</v-icon>
                    </v-card-title>
                        <v-container>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12">
                                        <v-autocomplete 
                                            v-model="selectedRoof"
                                            outlined dense 
                                            label="屋根材" :items="filteredRoof" 
                                            item-text="material" item-value="id"
                                            :rules="rules.required" class="required"
                                            >
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" outlined dense label="屋根の色">
                                        <v-autocomplete 
                                            outlined dense 
                                            label="屋根材" :items="roofSelectionsCombi" 
                                            item-text="color" item-value="id"
                                            :rules="rules.required" class="required"
                                            >
                                        </v-autocomplete>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn type="submit" >保存</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>

        <v-dialog  v-model="dialogSiding1F" persistent max-width="400">
            <form id="StoreSiding1f" ref="StoreSiding1f" @submit.prevent="StoreSiding1f">
                <v-card>
                    <v-card-title> 
                        <span class="overline">吹付け (1F) </span>
                        <v-spacer></v-spacer>
                        <v-icon @click="dialogSiding1F = false" dark>mdi-close</v-icon>
                    </v-card-title>
                    <v-container>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-radio-group
                                    v-model="siding1F"
                                    dense
                                    >
                                        <v-radio
                                            label="なし"
                                            value="0"
                                            @click="toggleDialogExteriorRequestContent('siding1F')"
                                        ></v-radio>
                                        <v-radio
                                            label="レナラックⅠ吹付"
                                            value="LENA_RACK"
                                            @click="toggleDialogExteriorRequestContent('siding1F')"
                                        ></v-radio>
                                        <v-radio
                                            label="シポストーン厚吹"
                                            value="SPRAY_SHIPO"
                                            @click="toggleDialogExteriorRequestContent('siding1F')"
                                        ></v-radio>
                                        <v-radio
                                            label="シナジオ・ｉ (超高耐久・低汚染)"
                                            value="SPRAY_SYNAGIO"
                                            @click="toggleDialogExteriorRequestContent('siding1F')"
                                        ></v-radio>
                                        <v-radio
                                            label="櫛引き調横貼防火サイディング＋シポロックリシンNEO厚吹（防カビ・防藻）"
                                            value="SIPOROKS"
                                            @click="toggleDialogExteriorRequestContent('siding1F')"
                                        ></v-radio>
                                        <v-radio
                                            label="櫛引柄デザインサイディング"
                                            value="COMB_DESIGNS"
                                            @click="toggleDialogExteriorRequestContent('siding1F')"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn type="submit">保存</v-btn>
                    </v-card-actions>
                </v-card>
            </form>
        </v-dialog>

        <v-dialog  v-model="dialogSiding2F" persistent max-width="400">
            <v-card>
                <v-card-title> <span class="overline">吹付け (2F) </span> </v-card-title>
                    <v-container>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-radio-group
                                    v-model="siding2F"
                                    dense
                                    >
                                        <v-radio
                                            label="なし"
                                            value="0"
                                            @click="toggleDialogExteriorRequestContent('siding2F')"
                                        ></v-radio>
                                        <v-radio
                                            label="レナラックⅠ吹付"
                                            value="LENA_RACK"
                                            @click="toggleDialogExteriorRequestContent('siding2F')"
                                        ></v-radio>
                                        <v-radio
                                            label="シポストーン厚吹"
                                            value="SPRAY_SHIPO"
                                            @click="toggleDialogExteriorRequestContent('siding2F')"
                                        ></v-radio>
                                        <v-radio
                                            label="シナジオ・ｉ (超高耐久・低汚染)"
                                            value="SPRAY_SYNAGIO"
                                            @click="toggleDialogExteriorRequestContent('siding2F')"
                                        ></v-radio>
                                        <v-radio
                                            label="櫛引き調横貼防火サイディング＋シポロックリシンNEO厚吹（防カビ・防藻）"
                                            value="SIPOROKS"
                                            @click="toggleDialogExteriorRequestContent('siding2F')"
                                        ></v-radio>
                                        <v-radio
                                            label="櫛引柄デザインサイディング"
                                            value="COMB_DESIGNS"
                                            @click="toggleDialogExteriorRequestContent('siding2F')"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogSiding2F = false">キャンセル</v-btn>
                    <v-btn >保存</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog  v-model="dialogSiding3F" persistent max-width="400">
            <v-card>
                <v-card-title> <span class="overline">吹付け (3F) </span> </v-card-title>
                    <v-container>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-radio-group
                                    v-model="siding3F"
                                    dense
                                    >
                                        <v-radio
                                            label="なし"
                                            value="0"
                                            @click="toggleDialogExteriorRequestContent('siding3F')"
                                        ></v-radio>
                                        <v-radio
                                            label="レナラックⅠ吹付"
                                            value="LENA_RACK"
                                            @click="toggleDialogExteriorRequestContent('siding3F')"
                                        ></v-radio>
                                        <v-radio
                                            label="シポストーン厚吹"
                                            value="SPRAY_SHIPO"
                                            @click="toggleDialogExteriorRequestContent('siding3F')"
                                        ></v-radio>
                                        <v-radio
                                            label="シナジオ・ｉ (超高耐久・低汚染)"
                                            value="SPRAY_SYNAGIO"
                                            @click="toggleDialogExteriorRequestContent('siding3F')"
                                        ></v-radio>
                                        <v-radio
                                            label="櫛引き調横貼防火サイディング＋シポロックリシンNEO厚吹（防カビ・防藻）"
                                            value="SIPOROKS"
                                            @click="toggleDialogExteriorRequestContent('siding3F')"
                                        ></v-radio>
                                        <v-radio
                                            label="櫛引柄デザインサイディング"
                                            value="COMB_DESIGNS"
                                            @click="toggleDialogExteriorRequestContent('siding3F')"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogSiding3F = false">キャンセル</v-btn>
                    <v-btn >保存</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogExteriorRequestContent" persistent max-width="300">
            <v-card>
                <v-card-title> 
                    <span class="overline">外壁色依頼内容</span>
                    <v-spacer></v-spacer>
                    <v-icon dark @click="dialogExteriorRequestContent = false">mdi-close</v-icon>
                </v-card-title>
                <v-container>
                    <v-card-text>
                        <!-- LENA_RACK  -->
                        <template v-if="activeSidingDropdown == 'LENA_RACK'">
                            <v-autocomplete outlined dense :items="LENA_RACK" item-text="lena_name" item-value="id"></v-autocomplete>
                        </template>

                        <!-- SPRAY_SHIPO  -->
                        <template v-if="activeSidingDropdown == 'SPRAY_SHIPO'">
                            <v-autocomplete outlined dense :items="SPRAY_SHIPO" item-text="shipo_name" item-value="id"></v-autocomplete>
                        </template>

                        <!-- SPRAY_SYNAGIO  -->
                        <template v-if="activeSidingDropdown == 'SPRAY_SYNAGIO'">
                            <v-autocomplete outlined dense :items="SPRAY_SYNAGIO" item-text="synagio_name" item-value="id"></v-autocomplete>
                        </template>

                        <!-- SIPOROKS  -->
                        <template v-if="activeSidingDropdown == 'SIPOROKS'">
                            <v-autocomplete outlined dense :items="SIPOROKS" item-text="siporok_name" item-value="id"></v-autocomplete>
                        </template>

                        <!-- COMB_DESIGNS  -->
                        <template v-if="activeSidingDropdown == 'COMB_DESIGNS'">
                            <v-autocomplete outlined dense :items="COMB_DESIGNS" item-text="comb_name" item-value="id"></v-autocomplete>
                        </template>
                    </v-card-text>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogExteriorRequestContent = false">OK</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogExteriorWallTiles" persistent max-width="300">
            <v-card>
                <v-card-title> 
                    <span class="overline">外壁タイル</span>
                    <v-spacer></v-spacer>
                    <v-icon dark @click="dialogExteriorWallTiles = false">mdi-close</v-icon>
                </v-card-title>
                <v-container>
                    <v-card-text>
                        <v-autocomplete outlined dense label="色施工" :items="colorTones" item-text="text" item-value="value">

                        </v-autocomplete>
                        <v-autocomplete outlined dense label="外壁タイル">

                        </v-autocomplete>
                    </v-card-text>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogExteriorWallTiles = false">test</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
        <v-dialog v-model="dialogDesignLouver" persistent max-width="300">
            <v-card>
                <v-card-title> 
                    <span class="overline">デザインルーバー</span>
                    <v-spacer></v-spacer>
                    <v-icon dark @click="dialogDesignLouver = false">mdi-close</v-icon>
                </v-card-title>
                <v-container>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-radio-group v-model="selectedDesignLouver" dense >
                                    <v-radio
                                        label="なし"
                                        value="1"
                                    ></v-radio>
                                    <v-radio
                                        label="木目調シート仕上げ"
                                        value="2"
                                    ></v-radio>
                                    <v-radio
                                        label="塗装仕上げ"
                                        value="3"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                            <v-col cols="12">
                                <v-expand-transition>
                                    <v-autocomplete 
                                        v-show="selectedDesignLouver == '2'" 
                                        outlined 
                                        dense
                                        :items="LOUVER_WOODS"
                                        item-value="id"
                                        item-text="wood_name"
                                    ></v-autocomplete>
                                </v-expand-transition>
                                
                                <v-expand-transition>
                                    <v-autocomplete 
                                        v-show="selectedDesignLouver == '3'" 
                                        outlined 
                                        dense
                                        :items="LOUVER_PAINTS"
                                        item-value="id"
                                        item-text="paint_name"
                                    ></v-autocomplete>
                                </v-expand-transition>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogDesignLouver = false">test</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogEntranceDoor" persistent max-width="300">
            <v-card>
                <v-card-title> 
                    <span class="overline">玄関ドア</span>
                    <v-spacer></v-spacer>
                    <v-icon dark @click="dialogEntranceDoor = false">mdi-close</v-icon>
                </v-card-title>
                <v-container>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-radio-group v-model="selectedEntranceDoor" dense >
                                    <v-radio
                                        label="プロノーバ"
                                        value="1"
                                    ></v-radio>
                                    <v-radio
                                        label="ファノーバ"
                                        value="2"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete 
                                    outlined 
                                    dense 
                                    label="Door Item" 
                                    :items="selectedEntranceDoor == 1 ? pronovaEntranceDoors : fanovaEntranceDoors"
                                    item-value="id"
                                    item-text="door_item"
                                    > 
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete 
                                    outlined 
                                    dense 
                                    label="Door Color" 
                                    :items="selectedEntranceDoor == 1 ? pronovaEntranceDoors : fanovaEntranceDoors"
                                    item-value="id"
                                    item-text="door_color"
                                    > 
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogEntranceDoor = false">test</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogPorchTiles" persistent max-width="300">
            <v-card>
                <v-card-title> 
                    <span class="overline">ポーチタイル</span>
                    <v-spacer></v-spacer>
                    <v-icon dark @click="dialogPorchTiles = false">mdi-close</v-icon>
                </v-card-title>
                <v-container>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete v-model="selectedPorchTile" :items="PORCH_TILES" item-text="name" item-value="id" outlined dense ></v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete  :items="selectedPorchTileColors" item-text="color" item-value="id" outlined dense ></v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialogPorchTiles = false">test</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    props : {
        dialog : Boolean
    },
    data(){
        return {
            cadRequestColorPers: [],
            cadRequestColorPersContent: {
                is_request_color_info : null,
                roof : null,
                spray_1f : null,
                spray_2f : null,
                spray_3f : null,
                exterior_wall_tile : null,
                balcony_glass : null,
                design_louver : null,
                sash : null,
                front_door : null,
                mall_and_arrowhead_decoration : null,
                balcony_belt : null,
                tile_band : null,
                decorative_belt_1f : null,
                decorative_belt_2f : null,
                eaves_of_a_house : null,
                breaking_wind : null,
                base_draining : null,
                porch_tile : null,
                perspective_direction : null,
                viewpoint_height : null,
                garden_number : null,
            },
            radio: null,
            requestContents: [
                {text: "仕様書に従って作成", desc: "※仕様書指示がない場合はおまかせで作成", value:1},
                {text: "色情報を指示して依頼", desc: "※着⼿図⾯依頼以降は選択不可", value:2},
                {text: "依頼なし", desc: "", value:null},
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
            
            e6: 1,
            requestPattern: 0,
            patterns : {
                1: { direction: null, height: null },
                2: { direction: null, height: null },
                3: { direction: null, height: null },
                4: { direction: null, height: null },
            },

            colorPersRequestHeaders: [
                '依頼日',
                '図面番号',
                '建物タイプ',
                '屋根',
                '吹付け(1F)',
                '吹付け(2F)',
                '吹付け(3F)',
                '外壁タイル',
                'バルコニーガラス',
                'デザインルーバー',
                'サッシ',
                '玄関ドア',
                'モール・矢切飾り',
                'バルコニー帯',
                'タイル面帯',
                '化粧帯(1F)',
                '化粧帯(2F)',
                '軒天',
                '破風',
                '土台水切り',
                'ポーチタイル',
                '視点方向',
                '視点高さ',
                'ガーデン番号',
            ],
            dialogColorPers: false,
            tempHouseType: 1,
            dialogRoof: false,
            selectedRoof: null,

            dialogSiding1F: false,
            siding1F: undefined,
            dialogSiding2F: false,
            siding2F: undefined,
            dialogSiding3F: false,
            siding3F: undefined,

            dialogExteriorRequestContent: false,
            dialogExteriorWallTiles: false,
            dialogDesignLouver: false,
            dialogEntranceDoor: false,
            selectedDesignLouver: undefined,
            activeSidingDropdown: null,
            colorTones: [
                {text: '1色施工', value: '1'},
                {text: '2色施工', value: '2'}
            ],
            balconyGlass: [
                { text: "透明ｶﾞﾗｽ (ｱｰﾊﾞﾝｸﾞﾚｰ)", value: "透明ｶﾞﾗｽ" },
                { text: "ﾐｽﾄｶﾞﾗｽ (ｱｰﾊﾞﾝｸﾞﾚｰ)", value: "ﾐｽﾄｶﾞﾗｽ" },
            ],
            
            sash : [
                { text: "ｱｰﾊﾞﾝｸﾞﾚｰ (UG)", value: "UG" },
                { text: "ﾎﾜｲﾄ (WH)", value: "WH" },
                { text: "ﾌﾞﾗｯｸ (BK)", value: "BK" },
                { text: "木目調 (LE)", value: "LE" },
            ],
            selectedEntranceDoor: undefined,
            dialogPorchTiles: false,
            selectedPorchTile: null,

        }
    },

    computed: {
        ...mapState(
           [ 
                'ROOF_SELECTION', 
                'rules',
                'LENA_RACK',
                'SPRAY_SHIPO',
                'SPRAY_SYNAGIO',
                'COMB_DESIGNS',
                'SIPOROKS',
                'LOUVER_ITEMS',
                'LOUVER_WOODS',
                'LOUVER_PAINTS',
                'ENTRANCE_DOORS',
                'EAVES_SELECTIONS',
                'GABLE_SELECTIONS',
                'BASE_DRAINERS',
                'PORCH_TILES',
                'VIEW_DIRECTION_SELECTIONS',
                'VIEW_HEIGHT_SELECTIONS',
                'HOUSE_TYPES',
                'cadRequestLatestRevision',
                'cadRequestBasicInformation',
                'cadRequestRevisionContent'
            ]
        ),


        selectedPorchTileColors(){
            if(!this.selectedPorchTile) return []

            const data =  this.PORCH_TILES.find(res => res.id == this.selectedPorchTile)
            return data.colors
        },

        filteredRoof(){
            if(!this.tempHouseType){
                return this.ROOF_SELECTION.filter(res => res.house_type_id == null);
            }

           return this.ROOF_SELECTION.filter(res => res.house_type_id == this.tempHouseType);
        }, 

        roofSelectionsCombi(){
            if(!this.selectedRoof) return

            const data = this.filteredRoof.find(res => res.id == this.selectedRoof);
            return data.selections_combi
        },

        pronovaEntranceDoors(){
            const doors = ['PRONOVA (waku)', 'PRONOVA (jiku)'];
            const data =  this.ENTRANCE_DOORS.filter(res => doors.includes(res.door_type))
            return data;
        },

        fanovaEntranceDoors(){
            const doors = ['FANOVA (waku)', 'FANOVA (jiku)'];
            const data =  this.ENTRANCE_DOORS.filter(res => doors.includes(res.door_type))
            return data;
        }
    },

    methods: {
        ...mapActions(
            [
                '_getRoofSelection',
                '_getLenaRack',
                '_getSprayShipo',
                '_getSpraySynagio',
                '_getCombDesigns',
                '_getSiporoks',
                '_getLouverItems',
                '_getLouverWoods',
                '_getLouverPaints',
                '_getEntranceDoors',
                '_getEavesSelections',
                '_getGableSelections',
                '_getBaseDrainers',
                '_getPorchTiles',
                '_getViewDirectionSelections',
                '_getViewHeightSelections'
            ]
        ),
        testing(){
            // const data = {
			// 	basicInformation: this.$store.state.cadRequestBasicInformation,
			// 	latestRevision: this.$store.state.cadRequestLatestRevision,
			// 	revisionContent: this.$store.state.cadRequestRevisionContent,
            //     colorpers : this.patterns
			},

        togglePorchTilesDialog(){

            if( !this.PORCH_TILES.length ){
                console.log('Retrieving Data Please Wait')
                this._getPorchTiles()
                .then(() => {
                    console.log('Data Retrieved')
                })
                .finally(() => this.dialogPorchTiles = true)
            }else{
                this.dialogPorchTiles = true;
            }
        },

        StoreSiding1f(){
            if(this.$refs.StoreSiding1f.validate()){

            }
        },

        StoreRoof(){
            if(this.$refs.StoreRoof.validate()){

            }
        },

        toggleDialogEntranceDoor(){
            if( !this.ENTRANCE_DOORS.length ){
                console.log('Retrieving Data Please Wait')
                this._getEntranceDoors()
                .then(() => {
                    console.log('Data Retrieved')
                })
                .finally(() => this.dialogEntranceDoor = true)
            }else{
                this.dialogEntranceDoor = true;
            }
        },

        toggleDialogDesignLouvers(){
            this.dialogDesignLouver = true
        },

        toggleDialogExteriorWallTiles(){
            this.dialogExteriorWallTiles = true
        },

        toggleDialogExteriorRequestContent(vModel){
            console.log(vModel,this[vModel]);
            this.activeSidingDropdown = this[vModel];
            this.dialogExteriorRequestContent = true;
        },

        toggleOpenSidingDialog(value){
            switch (value) {
                case 'dialogSiding3F':
                case 'dialogSiding2F':
                case 'dialogSiding1F':
                    this[value] = true;
                    break;
            
                default:
                    break;
            }
        },

        toggleCloseSidingDialog(value){
            switch (value) {
                case 'dialogSiding3F':
                case 'dialogSiding2F':
                case 'dialogSiding1F':
                    this[value] = false;
                    break;
            
                default:
                    break;
            }
        },

        toggleDialogColorPerspective(value){
            this.$emit('toggleDialogColorPerspective', value)
        },

        toggleRoofDialog(){
            if(this.ROOF_SELECTION.length == 0){
                this._getRoofSelection()
                    .then(() => this.dialogRoof = true)
                    .finally(() => { return });
            }

            this.dialogRoof = true
            return
        },

        test(){
            alert('test');
        }

    },

    watch: {
        dialog(val) {
            if(!val){
                this.patterns[1].direction = null
                this.patterns[1].height = null

                this.patterns[2].direction = null
                this.patterns[2].height = null

                this.patterns[3].direction = null
                this.patterns[3].height = null

                this.patterns[4].direction = null
                this.patterns[4].height = null

                this.radio = null
                this.requestPattern = 0
                this.e6 = 1
               
            }
        },

        dialogRoof(val){
            if(!val){
                this.$refs.StoreRoof.reset();
            }
        }, 

        dialogSiding1F(val){
            if(!val){
                this.siding1F = undefined;
                this.$refs.StoreSiding1f.reset();
            }
        }, 
    },


    mounted(){
        this._getLenaRack() .then(() => {
            this._getSprayShipo() .then(() => {
                this._getSpraySynagio() .then(() => {
                    this._getCombDesigns() .then(() => {
                        this._getSiporoks() .then(() => {
                            this._getLouverItems() .then(() => {
                                this._getLouverWoods() .then(() => {
                                    this._getLouverPaints() .then(() => {
                                        this._getEavesSelections() .then(() => {
                                            this._getGableSelections() .then(() => {
                                                this._getBaseDrainers() .then(() => {
                                                    this._getViewDirectionSelections()
                                                    this._getViewHeightSelections()
                                                })
                                            })
                                        })
                                    })
                                })
                            })
                        })
                    })
                })
            })
        })
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