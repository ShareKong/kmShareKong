$(function(){
function init()
{
    getMenuCategory();
}
// 菜品导航
function getMenuCategory() {
    const menuC = $("#menuCategory");
    // let temp = "";
    // for(let i = 0; i < 10; i++)
    // {
    //     temp += "<li>家常菜</li><li>鲁菜</li>";
    //     // menus.push("家常菜");
    //     // menus.push("鲁菜");
    // }
    // menuC.html(temp);
    // // alert(temp);

    $.post("../php/index.php", {
        "flag": "getMenuCategory"
    }, function (data) { 
        if(data["res"] == 200)
        {
            let menus = data["r"];
        }
        else
        {
            alert("获取菜品失败");
        }
    }, "json");
}

function all()
{
    init();
}
all();

})