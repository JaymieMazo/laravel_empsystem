import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex)
export default new Vuex.Store({
    state:{
       isLogin: 0,
       employeeID:null, 

    },
    actions:{}, 
    mutations:{
        LoggedIn(state, param){
                state.isLogin=param.IsLogin
                console.log(state.isLogin)
        }
    },
    getters:{},
    plugins: [createPersistedState()]
});