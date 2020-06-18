$(function(){
function init()
{
    getMenuCategory();
    getMenus();
}
// 菜品导航
function getMenuCategory() 
{
    const menuC = $("#menuCategory");

    $.post("../php/index.php", {
        "flag": "getMenuCategory"
    }, function (data) { 
        if(data["res"] == 200)
        {
            let menus = data["r"];
            let temp = "<li>全部</li>";
            for(let key in menus)
            {
                temp += "<li>"+menus[key][1]+"</li>";
            }
            menuC.html(temp);
        }
        else
        {
            alert("获取菜品分类失败");
        }
    }, "json");
}

function getMenus()
{
    const foodShow = $(".km-food-show");
    $.post("../php/index.php", {
        "flag": "getMenus"
    }, function (data) { 
        if(data["res"] == 200)
        {
            let menus = data["r"];
            let temp = "";
            for(let key in menus)
            {
                temp += '<div class="km-panel"><div class="km-panel-head"><img src="'+menus[key][3]+'" alt=""></div><div class="km-panel-body"><div class="km-panel-body-title" title="'+menus[key][1]+'">'+menus[key][1]+'</div><div class="km-panel-body-price">'+menus[key][2]+'</div><div class="km-panel-body-content">'+menus[key][4]+'</div></div><div class="km-panel-footer"><div><button class="btn btn-info">-</button><input type="text" value="0"><button class="btn btn-info">+</button></div><button class="btn btn-info">加入菜单</button></div></div>';
            }
            foodShow.html(temp);
        }
        else
        {
            alert("获取菜品失败");
        }
        getOrder();
    }, "json");
}

// 获取点菜的信息
function getOrder()
{
    let order = [];
    const joinBtn = $(".km-panel .km-panel-footer>button");
    // 加入菜单
    joinBtn.each(function(){
        $(this).click(function(){
            const name = $(this).parents(".km-panel").find(".km-panel-body-title").text();
            const price = $(this).parents(".km-panel").find(".km-panel-body-price").text();
            const number = $(this).parent().find("div input").val();

            let t_count = 0;
            let t_key = 0;
            for(let key in order)
            {
                if(order[key].name == name)
                {
                    t_count ++;
                    t_key = key;
                }
            }
            // 当菜单里面已经有了这份菜时
            if(t_count)
            {
                order[t_key]["number"] = number;
            }
            else
            {
                order.push({
                    "name": name,
                    "price": price,
                    "number": number
                })
            }
            // 测试
            for(let key in order)
            {
                console.log(order[key]);
            }
            sum(order);
        });
    });
    const comBtnSub = $(".km-panel .km-panel-footer>div button:first-child");
    comBtnSub.click(function(){
        let number = $(this).parent().find("input").val();
        if(number > 0)
        {
            number --;
        }
        $(this).parent().find("input").val(number);
    });
    const comBtnAdd = $(".km-panel .km-panel-footer>div button:last-child");
    comBtnAdd.click(function(){
        let number = $(this).parent().find("input").val();
        number ++;
        $(this).parent().find("input").val(number);
    });
    const comSubmit = $("#submitOrder button");
    comSubmit.click(function(){
        // alert("submit");
        let lastTotal = $("#total").text();
        order.push({
            "total": lastTotal
        });
        submitOrder(order);
    });
}
// 提交订单
function submitOrder(order)
{
    // 测试
    console.log("=");
    // alert("submitOrder");
    for(let key in order)
    {
        console.log(order[key]);
    }

    // 获取桌号
    let tableId = location.search;
    tableId = tableId.substring(1);
    order.push({
        "tableId": tableId
    });

    $.post("../php/index.php", {
        "flag": "submitOrder",
        "order": order
    }, function (data) { 
        if(data["res"] == 200)
        {
            alert("下单成功");
            window.location.href = "../index.html";
        }
        else
        {
            alert("下单失败");
        }
    }, "json");
}

function sum(order)
{
    // alert("order");
    let totalSum = 0;
    for(let key in order)
    {
        let price = Number(order[key].price) * Number(order[key].number);
        totalSum += price;
        // console.log(order[key].number);
    }
    $("#total").text(totalSum);
}

function all()
{
    init();
}
all();

})