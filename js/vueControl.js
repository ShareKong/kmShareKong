$(function(){
    
// 二维码数组
let ewmarray = [
    {
        code: 1,
        url: "./php/index.php"
    },
    {
        code: 2,
        url: "http://www.csdn.net"
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
function ewms()
{
    let ewm = new Vue({
        el: "#ewm",
        data: {
            ewmarray
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
                        qrcode: 'www.baidu.com',
                     }
                },
                template: "#table",
                methods: {
                    enter () {
                        $.post("./php/index.php", {
                            "flag": "ind"
                        }, function(data){
                            alert("success");
                        });
                    }
                },
            }
        }
    })
    // 
    const qrs = $("#ewm div[id]");
    
    ewmarray.forEach(element => {
        for(let i = 0; i < qrs.length; i++)
        {
            if(qrs.eq(i).attr("id") == String(element.code))
            {
                qrs.eq(i).qrcode(element.url + "?" + element.code);
                break;
            }
        }
    });
        // alert(typeof(ewmarray[0].code));

}

function all()
{
    ewms();
    // $("#ttt").qrcode("http://www.baidu.com");
}
all();

})

