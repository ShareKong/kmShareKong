$(function(){
// 判断用户是否登录
function isLogin()
{
    $.post("./php/waiter.php", {
        "flag" : "isLogin"
    }, function(data){
        if(data["status"] == 200)
        {
            window.location.href = "waiter.html";
        }
    }, "json");
}
// 登录
function login()
{
    $("#login").click(function(){
        let acount = $("#login-username").val();
        let pwd = $("#login-password").val();
        $.post("./php/waiter.php", {
            "flag" : "login",
            "acount" : acount,
            "pwd" : pwd
        }, function(data){
            if(data["status"] != 200)
            {
                $("#show").show(500);
            }
            else
            {
                window.location.href = "./waiter.html";
            }
        }, "json");
    });
    
}

function init()
{
    isLogin();
    login();
}
init();
})