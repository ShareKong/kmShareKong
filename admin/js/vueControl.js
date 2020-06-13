

const vm = new Vue({
    el: "#all",
    data: {
        iskmDropDwonShowMenu: true
    },
    components: {
        'km-drop-dwon': {
            props:{
                isshow: Boolean
            },
            data() {
                return {
                    
                }
            },
            template: "#kmDropDwon",
        }
    }
});