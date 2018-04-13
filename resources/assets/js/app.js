
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import mavonEditor from "mavon-editor"
import 'mavon-editor/dist/css/index.css'

window.toastr = require('toastr');
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right-custom",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(mavonEditor);

import MdEditor from './components/MdEditor'
import TextBody from './components/TextBody'
import MsgBox from './components/MsgBox'
import FollowButton from './components/FollowButton'
import FavorButton from './components/FavorButton'

const app = new Vue({
    el: '#app',
    data:{
        textinput:'',
        t_status:false,
        t_pre:"preview",
    },
    components:{
        TextBody,
        MdEditor,
        MsgBox,
        FollowButton,
        FavorButton,
    },
    methods:{
        edittext:function(data){
           this.textinput = data
        },
        edittextbody:function(data){
           this.textinput = data
        }
    }
});

