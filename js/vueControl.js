
// 二维码数组
let ewmarray = new Array();
for(i = 0; i < 6; i++)
{
    ewmarray.push(i + 1);
}
// 二维码
let ewm = new Vue({
    el: "#ewm",
    data: {
        ewmarray: ewmarray
    },
    mounted() {
        axios.post("./php/index.php", {
            flag: "tableStatus"
        })
        .then(function(response){
            console.log(response.data.res);
        })
        .catch(function(error){
            console.log(error);
        });
    },
    components: {
        ewmtable: {
            props: {
                ewmarray: Array,
                tablecode: Number,
            },
            template: "#table"
        }
    }
})