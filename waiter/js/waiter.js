$(function(){
function init()
{
    getNotFinishOrder();
    // 左侧栏未完成订单按钮
    $(".km-left-side ul li:first-child").click(function(){
        getNotFinishOrder();
    });
    // 左侧栏历史订单
    $(".km-left-side ul li:last-child").click(function(){
        getHistoryOrder();
    });
}
// 获取未完成订单
function getNotFinishOrder()
{
    $.post("../php/index.php",{
        "flag": "getNotFinishOrder"
    }, function(data){
        if(data["res"] == 200)
        {
            const orderData = data["r"];
            let t_p = "";
            orderData.forEach(value => {
                t_p += '<tr><td>'+value[0]+'</td><td>'+value[1]+'</td><td>'+value[2]+'</td><td>'+value[3]+'</td><td><button class="btn btn-primary btn-sm">完成订单</button><button class="btn btn-info btn-sm ml-1">订单详情</button></td></tr>';
            });
            $("tbody").html(t_p);
            tableBtnClick();
        }
        else if(data["res"] == 500)
        {
            console.log("获取未完成订单失败");
        }
    }, "json");
}
// 获取历史账订单
function getHistoryOrder()
{
    $.post("../php/index.php",{
        "flag": "getHistoryOrder"
    }, function(data){
        if(data["res"] == 200)
        {
            const orderData = data["r"];
            let t_p = "";
            orderData.forEach(value => {
                t_p += '<tr><td>'+value[0]+'</td><td>'+value[1]+'</td><td>'+value[2]+'</td><td>'+value[3]+'</td><td><button class="btn btn-info btn-sm ml-1">订单详情</button></td></tr>';
            });
            $("tbody").html(t_p);
            tableBtnClick();
        }
        else if(data["res"] == 500)
        {
            console.log("获取未完成订单失败");
        }
    }, "json");
}
// 表格按钮
function tableBtnClick()
{
    // 完成订单按钮
    $(".km-right-side tbody tr td:last-child button:first-child").click(function(){
        const orderNumber = $(this).parents("tr").find("td:nth-child(2)").text();
        $.post("../php/index.php",{
            "flag": "finishOrder",
            "orderNumber": orderNumber
        }, function(data){
            if(data["res"] == 200)
            {
                alert("订单已完成");
                getNotFinishOrder();
            }
        }, "json");
    });
    // 订单详情按钮
    $(".km-right-side tbody tr td:last-child button:last-child").click(function(){
        const orderNumber = $(this).parents("tr").find("td:nth-child(2)").text();
        window.location.href = "../html/orderDe.html?" + orderNumber;
    });
}
// 判断用户是否登录
function isLogin()
{
    $.post("./php/waiter.php", {
        "flag" : "isLogin"
    }, function(data){
        if(data["status"] != 200)
        {
            window.location.href = "index.html";
        }
        else
        {
            init();
        }
    }, "json");
}

function all()
{
    isLogin();
}
all();
})