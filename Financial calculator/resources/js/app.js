require('./bootstrap');

window.Vue = require('vue');

Vue.component('data-table', require('./components/Table.vue').default);
Vue.component('data-addcompany', require('./components/AddCompany.vue').default);
Vue.component('data-formulas', require('./components/Formulas.vue').default);
Vue.component('data-order', require('./components/Order.vue').default);
Vue.component('data-select-company', require('./components/SelectCompany.vue').default);
Vue.component('data-textarea', require('./components/Textarea.vue').default);
Vue.component('data-forecast-table', require('./components/ForecastTable.vue').default);
Vue.component('data-accept-comment', require('./components/AcceptComment.vue').default);
Vue.component('data-accept-forecast', require('./components/AcceptForecast.vue').default);

import store from './store';

const app = new Vue({
	el: '#app',
	store: store	
});

