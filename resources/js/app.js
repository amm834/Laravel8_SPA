require('./bootstrap');

window.Vue = require('vue');
import {
  Form,
  HasError,
  AlertError
} from 'vform';
import Swal from 'sweetalert2';
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
  color: '#4cf9a2',
  failedColor: 'red',
  thickness:'3px',
  transition: {
    speed: '0.9s',
    opacity: '0.9s',
    termination: 300
  }
});
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);
window.Form = Form;
window.Swal = Swal;

const app = new Vue({
  el: '#app',
});