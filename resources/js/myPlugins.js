import { mapState, mapMutations } from 'vuex'


const myPlugins = {
    install(Vue) {
        Vue.mixin({
            data: () => ({}),
            computed: {
                ...mapState([
                    'view',
              
                ])
            },
            methods: {
                ...mapMutations([
                    'viewData',
                  
                ])
            }
        })
    }
}

export default myPlugins