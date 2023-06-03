<template>
    <div>
        <app-toolbar :toolbar="toolbar"></app-toolbar>
        <v-container fluid>
            <v-simple-table class="mainTable" fixed-header height="78vh">
                <thead>
                    <tr>
                        <th> Customer Code </th>
                        <th> Revision </th>
                        <th width="20px"> Attachments </th>
                        <th> Created Date </th>
                        <th> Gravity </th>
                        <th> Express </th>
                        <th> House Type </th>
                        <th> House Type Name </th>
                        <th> Remarks </th>
                        <th> Fire Protection </th>
                        <th> Water Tight </th>
                        <th> Heavy Snow </th>
                        <th> Seismic Isolation </th>
                        <th> Rectangle Meter </th>
                        <th> Double Earthquake Resistance </th>
                        <th> High Fireproof OuterWall </th>
                        <th> After Kakou Reason </th>
                        <th> Design Contract </th>
                        <th> Calculation Basis </th>
                        <th> Color Layout </th>
                        <th v-show="viewMode"> Dxf </th>
                        <th v-show="viewMode"> ColorPers </th>
                        <th v-show="viewMode"> HP </th>
                        <th v-show="viewMode"> Specification Review </th>
                        <th v-show="viewMode"> Web Docs Materials </th>
                        <th v-show="viewMode"> Color Layout Points </th>
                        <th v-show="viewMode"> ALVS </th>
                        <th v-show="viewMode"> Proposal Electrical </th>
                        <th v-show="viewMode"> Denki Request </th>
                        <th v-show="viewMode"> Electrical </th>
                        <th v-show="viewMode"> Stop </th>
                        <th v-show="viewMode"> Start Drawing </th>
                        <th v-show="viewMode"> Final Checking </th>
                        <th v-show="viewMode"> Electrical Drawing </th>
                        <th v-show="viewMode"> Arrangement </th>
                        <th v-show="viewMode"> Trial Code </th>
                        <th v-show="viewMode"> Hrd Accept </th>
                        <th v-show="viewMode"> Created By Code </th>
                        <th v-show="viewMode"> Updated Date </th>
                        <th v-show="viewMode"> Updated By Code </th>
                        <th v-show="viewMode"> Deleted Date </th>
                        <th v-show="viewMode"> Deleted By Code </th>
                    </tr>
                </thead>
                <tbody>
                    <tr  v-for="(header, i) in 20" :key="i">
                        <td> 0000000-0041 </td>
                        <td> 5-2 </td>
                        <td>
                            <div class="custom-svg svg-icon_folder pointer text-center pt-2" @click="fileAttDialog = true"><p class="grey--text text--darken-4" > 2 </p></div>
                        </td>
                        <td> 2022-11-08 09:45:28 </td>
                        <td> large </td>
                        <td> 
                            <v-chip
                                class="ma-2"
                                :color="i % 3 == 0 ? 'green' : 'red'"
                                text-color="white"
                                x-small
                            >
                            {{ i % 3 == 0 ? 'YES' : 'NO' }}
                            </v-chip>
                        </td>
                        <td> waku </td>
                        <td> i-smart </td>
                        <td> Sarapoka,さらぽか </td>
                        <td> 一般仕様 </td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>240</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                        <td v-show="viewMode">test</td>
                    </tr>
                    
                </tbody>
            </v-simple-table>
        </v-container>
    
    <!-- Dialogs -->
    <v-dialog v-model="fileAttDialog" max-width="400" persistent>
        <v-card>
            <v-card-title>
                <span class="headline"> File Attachments </span>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-container>
                <v-card-text>
                    <v-simple-table class="mainTable">
                        <thead>
                            <tr>
                                <th> File </th>
                                <th> Path </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <span class="custom-svg svg-icon_pdf"></span> </td>
                                <td> /public/svg/custom-svg svg-icon_pdf </td>
                            </tr>
                            <tr>
                                <td> <span class="custom-svg svg-icon_pdf"></span> </td>
                                <td> /public/svg/custom-svg svg-icon_pdf </td>
                            </tr>
                        </tbody>
                    </v-simple-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn  small text  @click="fileAttDialog = false"> Close </v-btn>
                </v-card-actions>
            </v-container>
        </v-card>
    </v-dialog>

    <v-dialog v-model="StoreDialog" max-width="800" persistent>
        <v-form id="Store" ref="Store" @submit.prevent="Store">
            <v-card>
                <v-card-title>
                    <span class="headline"> PLANNER BASIC INFO </span>
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <template>
                                <v-col cols="6">
                                    <v-text-field
                                        name="name"
                                        label="お客様コード"
                                        id="id"
                                        outlined
                                        dense
                                        class="required"
                                        :rules="rules.required"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        name="name"
                                        label="建物タイプ"
                                        id="id"
                                        outlined
                                        dense
                                        class="required"
                                        :rules="rules.required"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                        name="remarks"
                                        label="備考欄"
                                        id="id"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="4">
                                    <v-autocomplete
                                        :items="['一般仕様', '準防火仕様', '準耐火仕様']"
                                        dense
                                        outlined
                                        label="防火仕様"
                                        class="required"
                                        :rules="rules.required"
                                    >
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="4">
                                    <v-autocomplete
                                        :items="['240', '260+']"
                                        dense
                                        outlined
                                        label="矩計"
                                        class="required"
                                        :rules="rules.required"
                                    >
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="4">
                                    <v-autocomplete
                                        :items="['耐水害（ｽﾀﾝﾀﾞｰﾄﾞ)', '耐水害（浮上)']"
                                        dense
                                        outlined
                                        label="耐水害住宅"
                                    >
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="4">
                                    <v-autocomplete
                                        :items="['あり', 'なし']"
                                        dense
                                        outlined
                                        label="２倍耐震"
                                        class="required"
                                        :rules="rules.required"
                                    >
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="4">
                                    <v-autocomplete
                                        :items="['あり', 'なし']"
                                        dense
                                        outlined
                                        label="高防火外壁"
                                        class="required"
                                        :rules="rules.required"
                                    >
                                    </v-autocomplete>
                                </v-col>

                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="上棟予定日"
                                        id="id"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label=" 加工依頼日"
                                        id="id"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="仮契約日"
                                        id="id"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="本契約日"
                                        id="id"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                                    
                                <v-col cols="12">
                                    <v-divider> </v-divider>
                                </v-col>
                                <v-col cols="12">
                                    <span class="overline font-weight-black">敷地情報</span>
                                </v-col>

                                <v-col cols="4">
                                    <v-autocomplete
                                        name="name"
                                        label="建築地"
                                        id="id"
                                        outlined
                                        dense
                                        :items="['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県']"
                                        class="required"
                                        :rules="rules.required"
                                    ></v-autocomplete>
                                </v-col>

                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="県コード"
                                        id="id"
                                        outlined
                                        dense
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="電力会社名"
                                        id="id"
                                        outlined
                                        dense
                                        class="required"
                                        :rules="rules.required"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="垂直積雪量"
                                        id="id"
                                        outlined
                                        dense
                                        suffix="cm"
                                        class="required"
                                        :rules="rules.required"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="基準風速"
                                        id="id"
                                        outlined
                                        dense
                                        suffix="m/s"
                                        class="required"
                                        :rules="rules.required"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        name="name"
                                        label="海岸からの距離"
                                        id="id"
                                        outlined
                                        dense
                                        suffix="km"
                                        class="required"
                                        :rules="rules.required"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-autocomplete
                                        name="name"
                                        label="積雪区分"
                                        id="id"
                                        outlined
                                        dense
                                        :items="['一般地域', '多雪区域内']"
                                        class="required"
                                        :rules="rules.required"
                                    ></v-autocomplete>
                                </v-col>

                            </template>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn  small text  type="submit"> Save </v-btn>
                    <v-btn  small text  @click="StoreDialog = false"> Close </v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>





    <!-- Floating Action Buttons  -->
    <v-btn
        color="primary"
        class="float-add"
        elevation="2"
        fab
        fixed
        right
        data-cad-step="3"
        @click="StoreDialog = true"
    >
    <v-icon>mdi-plus</v-icon>
    </v-btn>

    <v-btn
        color="primary"
        elevation="2"
        fab
        absolute
        fixed
        class="float-edit"
    right
    >
    <v-icon>mdi-pencil</v-icon>
    </v-btn>

    <app-footer :myProp="toolbar"></app-footer>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import ToolbarMenu from '../modules/ToolbarMenu.vue';
import Footer from '../modules/Footer.vue';

export default {
    components: {
        "app-toolbar" : ToolbarMenu,
        "app-footer" : Footer
    },
    data(){
        return {
            toolbar: {
                title: 'VIEW TABLE',
                test: 'test',
                view: true,
                back: false,
                filter: false,
            },
            fileAttDialog: false,
            StoreDialog: false,
            row: null,
            
        }   
    },

    computed: {
        ...mapState([
            'viewMode',
            'rules',
            'REMARKS'
        ])
    },

    methods:{
        ...mapActions([
            '_getRemarks',
        ]),

        Store(){
            if(this.$refs.Store.validate()){

            }
        }
    }, 

    mounted(){
        this._getRemarks();
    },

    watch:{
        StoreDialog(val){
            if(!val) this.$refs.Store.reset();
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

.v-btn--fab.float-add{
    /* right:24px; */
    right:80px;
}


/* .v-btn--floating {
    position: relative;
    float:right !important;
  } */
</style>