import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		company: {}
	},
	getters: {
		getCompany(state) {
			return state.company
		}
	},
	actions: {
		homeDataCompany(context, data) {
	    	context.commit('setCompany', data)	    	
	    }
	},
	mutations: {
		setCompany(state, data) {			
			return state.company = data
		}
	}
});