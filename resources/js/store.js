import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex)
const persistedData = new createPersistedState({
    key:'crypto-system',
    storage: localStorage,
    reducer : state => ({
        loggedInUser : state.loggedInUser,
        token: state.token,
        searchItem: state.searchItem,
        toTrading: state.toTrading
    })
})

export default new Vuex.Store({
    state:{
        token: {},
        loggedInUser : null,
        allUsers : [],
        rules: {
            constructionCodeRule: [
                (v) => (v || v == undefined || "").length > 0 || "Field is required",
                (v) => (v || v == undefined || "").length <= 12 || "Max 12 characters.",
            ],
            requireOnMultiple : [
                (v) => v.length > 0 || "Field is required"
            ],
            required: [
                (v) => (v == 0 || !!v) || "Field is required",
            ],
            email: [
                (v) =>
                    !v ||
                    /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                    "E-mail must be valid",
            ],
            password: [
                (v) => !!v || "Field is required",
                // (v) => !v || /[0-9]/.test(v) || "Must contain number",
                // (v) => !v || /[a-zA-Z]/.test(v) || "Must contain letter",
                // v => !v || /[@$!%*?&]/.test(v) || 'Must contain symbol',
                (v) => (v || "").length >= 8 || "Must contain atlest 8 characters.",
            ],
            hex: [
                (v) =>
                    !v || /[0-9A-Fa-f]{6}/.test(v) || "Must be a hex value",
            ],
            confirmpassword(temp, actual) {
                return [(v) => temp === actual || "Password must match"];
            },
            uniqueRole(list) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => 
                        // console.log(typeof _.find(list, {name : v}) === 'object', list, v)
                        typeof _.find(list, {name : v}) === 'undefined' ||
                        "Role is already exists.",
                ];
            },

            uniqueData(list) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => 
                        // console.log(typeof _.find(list, {name : v}) === 'object', list, v)
                        typeof _.find(list, {name : v}) === 'undefined' ||
                        "is already exists.",
                ];
            },

            uniqueDataEdit(list, excludeName) {
                return [
                  (v) => !!v || "Field is required",
                  (v) =>
                    typeof _.find(list, (item) => item.name === v && item.name !== excludeName) === 'undefined' ||
                    "already exists.",
                ];
            },
              
            array: [(v) => !v.length == 0 || "Field is required"],
            higher_number(min, max) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => v > min || "Must Higher",
                    (v) => v <= max || "Too much",
                ];
            },
            positiveNumber: [
                (v) => {
                    if ( !!v  && v >= 0 && v <= 99 && !isNaN(v)) return true;
                    return "Field is required and must be a number";
                },
            ],
            uniqueRemarks(list) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => 
                        // console.log(typeof _.find(list, {name : v}) === 'object', list, v)
                        typeof _.find(list, {name : v}) === 'undefined' ||
                        "Remark Already exists.",
                ];
            },
        },
        viewMode: false,
        editMode: false,
        filterMode: false,
        
        timeout: null,
        loader: false,
        searchItem: '',

        tradeorders : [],
        UserAccounts : [],
        accounts : [],
        toTrading : [],
        userDeposit : [],

        //MASTER DATA
        PERMISSIONS: [],
        ROLES: [],
        AGENTS: [],
        ADMIN_AGENTS: [],

    },

    actions:{

        async saveToken({commit}, data){
            commit('saveToken', data)
        },

        async login({commit}){ //> only saving data for localStorage, not the actual login.
            axios({
                method : "GET",
                url : 'auth-user',
            })
            .then( response => {
                commit('login', response.data);
            } )
        },

        logout(context){
            context.commit('logout');
        },

        toggleViewMode({commit}){
            commit('toggleViewMode');
        },

        toggleEditMode({commit}){
            commit('toggleEditMode')
        },

        toggleFilterMode({commit}){
            commit('toggleFilterMode')
        },

        toggleLoader({commit}, payload){
            commit('toggleLoader', payload)
        },

        toggleSearchColumn({dispatch, state}, payload){
            const timeOut = 1000
            clearTimeout(state.timeout)
            
            state.timeout = setTimeout(function() {
                var index = Array.from(payload.selector.closest("th").parentNode.children).indexOf(payload.selector.closest("th"));
                if(typeof payload.complexThead !== "undefined" && payload.complexThead){
                    var TopTh = payload.selector.closest("tr").parentNode.firstChild.children[index]
                }else{
                    var TopTh = payload.selector.closest("tr").parentNode.firstChild.children[index]
                }

                if(!TopTh.classList.contains("Filtered")){
                    state[payload.search].push({column: payload.column, val: payload.selector.value})
                    TopTh.classList.add("Filtered")
                }else{
                    var payload_index = _.findIndex(state[payload.search], function(o) { return o.column == payload.column; });
                    if(payload.selector.value.length == 0){
                        TopTh.classList.remove("Filtered")
                        state[payload.search].splice(payload_index, 1)
                    }else{
                        if(payload_index > -1 ){
                            state[payload.search][payload_index].val = payload.selector.value
                        }else{
                            state[payload.search].push({column: payload.column,val: payload.selector.value})
                        }
                    }
                }

                dispatch(payload.action)
            }, timeOut);
        },

        _getPermissions({commit}){
            axios({
                method: "get",
                url: "/api/master/permissions"
            }).then(({ data }) => {
                console.log(data)
                commit("_getPermissions", data)
            })
        },
        _getRoles({commit}){
            axios({
                method: "get",
                url: "/api/master/roles"
            }).then(({ data }) => {
                console.log(data)
                commit("_getRoles", data)
            })
        },
        GetTradeorders( { commit } )
        {
            axios( {
                method : 'GET',
                url : 'api/TradeOrders',
            } )
            .then(res => {
                commit('GetTradeorders', res.data)
            })
        },//end of GetTradeorders
        GetAccounts( { commit } )
        {
            axios( {
                method : 'GET',
                url : 'api/accounts'
            } )
            .then(res => {
                commit('GetAccounts', res.data)
            })
        },//end of GetAccounts
        _getAgents({commit}){
            axios({
                method: "get",
                url: "/api/master/admin/agents"
            }).then(({ data }) => {
                commit("_getAgents", data)
            })
        },//end _getAgents
        _getAdminAgents({commit}){
            axios({
                method: "get",
                url: "/api/master/admin/admin_agents"
            }).then(({ data }) => {
                commit("_getAdminAgents", data)
            })
        },//end _getAdminAgents


    },

    mutations:{
        saveToken(state, payload){
            state.token = payload
        },

        login(state, payload){
            state.loggedInUser = payload
            state.loggedInUser.uniqId = `${payload.email}-${makeid(20)}`

            function makeid(length) {
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                let counter = 0;
                while (counter < length) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
                  counter += 1;
                }
                return result;
            }

            window.location.href='/';
        },

        logout(state){
            state.loggedInUser = {}
            state.token = {}
        },

        getUsers(state, data){
            state.allUsers = data
        },

        toggleViewMode(state){
            state.viewMode = !state.viewMode
        },

        toggleEditMode(state){
            state.editMode = !state.editMode
        },

        toggleFilterMode(state){
            state.filterMode = !state.filterMode
        },

        toggleSearchColumn(state, payload){
            console.log(state[payload])
        },

        toggleLoader(state, payload){
            state.loader = payload
        },
        
        _getPermissions( state, payload ){
            state.PERMISSIONS = payload;
        },
        _getRoles( state, payload ){
            state.ROLES = payload;
        },

        
        GetUsers( state, payload ){
            state.UserAccounts = [...payload];
        },

        GetTradeorders( state, payload ){
            state.tradeorders = [...payload];
        },

        GetAccounts( state, payload ){
            state.accounts = [...payload];
        },

        "STORE_TRADING" : (state, newState)=>{
            state.toTrading = newState
        },

        "STORE_USERDEPOSIT" : (state, newState)=>{
            state.userDeposit = newState
        },

        _getAgents(state, payload){
            state.AGENTS = payload
        },

        _getAdminAgents(state, payload){
            state.ADMIN_AGENTS = payload
        }


    },
    getters:{},
    plugins: [persistedData]
});
