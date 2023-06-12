require('./bootstrap');
import App from "./App.vue"
import { createApp } from 'vue'
import router from "./router/index.js"
import VueCookies from 'vue-cookies'
import 'ant-design-vue/dist/antd.css';
import { Table, Menu, List, Button, Card, Skeleton, } from 'ant-design-vue';


// import bootstrap 
import "bootstrap"
import 'bootstrap/dist/css/bootstrap-grid.min.css'
import 'bootstrap/dist/css/bootstrap-utilities.min.css'
import 'bootstrap/dist/css/bootstrap.min.css'


import Search from "./components/Search.vue"
import Header from "./components/Header.vue";
import leftSide from "./components/Menu.vue";
import FormAddProduct from "./components/FormAddProduct.vue";
import progressBar from './components/progressBar.vue'
import product from './elements/Product.vue'
import inputTag from './elements/inputTag.vue'
import selectTag from './elements/selectTag.vue'
import textareaTag from './elements/textareaTag.vue'
import confirmPopup from './popup/confirmPopup.vue'
import messageModal from './popup/messagePopup.vue'
import Toaster from "@meforma/vue-toaster";
import errorPopup from './popup/errorPopup.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
import listProduct from './components/listProduct.vue'
import VPagination from "@hennge/vue3-pagination";
import VueProgressBar from "@aacassandra/vue3-progressbar";
import loginForm from "./components/loginComp.vue"

library.add(fas)



const options = {
    color: "rgb(13 240 234)",
    failedColor: "#874b4b",
    thickness: "8px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300,
    },
    autoRevert: true,
    location: "top",
    inverse: false,
    position: 'absolute',
};
const app = createApp({});


app.config.warnHandler = () => {};
app.component('App', App);
app.component('Search', Search);
app.component('Header', Header)
app.component('Menu', leftSide)
app.component('FormAddProduct', FormAddProduct)
app.component('font-awesome-icon', FontAwesomeIcon);
app.component('VPagination', VPagination);
app.component('Product', product);
app.component('progressBar', progressBar)
app.component('inputTag', inputTag)
app.component('selectTag', selectTag)
app.component('textareaTag', textareaTag)
app.component('confirmPopup', confirmPopup)
app.component('errorModal', errorPopup)
app.component('messageModal', messageModal)
app.component('listProduct', listProduct)
app.component('loginForm', loginForm)

app.use(Toaster)
app.use(Button);
app.use(VueProgressBar, options);
app.use(router);
app.use(Card);
app.use(Table);
app.use(Menu)
app.use(Skeleton)
app.use(List)
app.use(VueCookies)
app.mount("#app")
