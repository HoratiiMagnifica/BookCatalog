import {createApp} from 'vue';
import App from './components/App.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {router} from './router.js';
import ScrollToTopButton from "./components/ScrollToTopButton.vue";
import Header from './components/Header.vue'
import 'bootstrap/scss/bootstrap.scss'
import store from "./store/index.js";
import '../sass/app.scss'


const app = createApp(App)
app.use(store)
app.use(router);
app.use(VueAxios, axios);
app.component('ScrollToTopButton', ScrollToTopButton)
app.component('Header', Header)

app.mount('#app')
