import service from './query'

const selectorMethods = {
    apiMultiData:[],
    apiMultiCalback:[],
    methods: {
        $(selector,refs) {
            if(!refs) {
                return $(selector)
            }else {
                return $(this.$$(refs).querySelectorAll(selector))
            }
        },
        $$(refs){
            return this.$refs[refs].$el
        }
    }
}

export default selectorMethods
