$(function(){
// 
function init() 
{ 
    getTableStatus();
    // const t_time = 5;
    // let getSever = setInterval(function(){
    //     getTableStatus();
    // }, 1000 * t_time);
}

function getTableStatus()
{
    $.post("./php/index.php", {
        "flag": "tableStatus"
    }, function (data) { 
        if(data["res"] == 200)
        {
            dataConver(data["r"]);
        }
        else if(data["res"] == 500)
        {
            alert("获取失败");
        }
    }, "json");
}

function dataConver(data)
{
    let ewmarray = [];
    for(let key in data)
    {
        ewmarray.push({"code": data[key][0], "url": "http://47.95.210.129/xiaotianOrderFood/html/choose.html", "yn": data[key][1]});
    }
    ewms(ewmarray);
}

function ewms(ewmarray)
{
    let ewm = new Vue({
        el: "#ewm",
        data: {
            ewmarray
        },
        components: {
            ewmtable: {
                props: {
                    ewmarray: Object
                },
                data() {
                    return { 
                        qrcode: '',
                     }
                },
                template: "#table",
                methods: {
                    enter () {
                        // alert(this.ewmarray.yn);
                        if(this.ewmarray.yn == 0)
                        {
                            alert("当前餐桌有人，请换张桌子谢谢");
                        }
                        else if(this.ewmarray.yn == 1)
                        {
                            window.location.href = "./html/choose.html?" + this.ewmarray.code;
                        }
                    }
                },
            }
        }
    })
    // 二维码生成
    const qrs = $("#ewm div[id]");
    
    ewmarray.forEach(element => {
        for(let i = 0; i < qrs.length; i++)
        {
            if(qrs.eq(i).attr("id") == String(element.code))
            {
                qrs.eq(i).text("");
                qrs.eq(i).qrcode(element.url + "?" + element.code);
                break;
            }
        }
    });

}

function all()
{
    init();
}
all();

})

