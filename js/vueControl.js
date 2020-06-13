

Vue.use(VueQriously);
// 二维码数组
let ewmarray = [
    {
        code: 1,
        url: "http://www.baidu.com"
    },
    {
        code: 2,
        url: "http://www.baidu.com"
    },
    {
        code: 3,
        url: "http://www.baidu.com"
    },
    {
        code: 4,
        url: "http://www.baidu.com"
    },
    {
        code: 5,
        url: "http://www.baidu.com"
    },
    {
        code: 6,
        url: "http://www.baidu.com"
    }
]
// 二维码
let ewm = new Vue({
    el: "#ewm",
    data: {
        ewmarray: ewmarray
    },
    mounted() {
        // axios.post("./php/index.php", {
        //     flag: "tableStatus"
        // })
        // .then(function(response){
        //     console.log(response.data.res);
        // })
        // .catch(function(error){
        //     console.log(error);
        // });
    },
    components: {
        ewmtable: {
            props: {
                ewmarray: Object
            },
            data() {
                return { 
                    qrcode: 'www.baidu.com'
                 }
            },
            template: "#table",
        }
    }
})