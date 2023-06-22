require('./bootstrap');
require('./dialog_movable');
import 'vuetify/dist/vuetify.css';
import Vue from 'vue'
import Vuetify from 'vuetify'
import Router from './router'
import store from './store'
import App from './template/App';
import MasterApp from './template/MasterApp';
import Login from './auth/Login';
import VueDragscroll from 'vue-dragscroll' 
import io from 'socket.io-client';
import MyMixins from './MyMixins'

const socket = io("http://31.220.31.202:5000");

Vue.prototype.$socket = socket;
import VueSocketIO from 'vue-socket.io'

Vue.use(new VueSocketIO({
    // debug: false,
    connection: io('http://31.220.31.202:5000'), //options object is Optional
    vuex: {
        store,
        actionPrefix: "SOCKET_",
        mutationPrefix: "SOCKET_"
        }
    })
);
Vue.use(MyMixins)


Vue.use(VueDragscroll)
Vue.use(Vuetify)
new Vue({
    el: '#app',
    store,
    router:Router,
    vuetify: new Vuetify(),
    components : {
        App,
        Login,
        MasterApp
    }
});
