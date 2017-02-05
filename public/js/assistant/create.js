Vue.component('v-select', VueSelect.VueSelect)

new Vue({
    el: '#myApp',
    data: function(){
        return {
            selected: null,
            options: ['foo','bar','baz']
        }
    }
})