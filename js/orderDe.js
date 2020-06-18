$(function(){
     
    function init()
    {
        let orderNumber = location.search;
        orderNumber = orderNumber.substring(1);
        // alert(orderNumber);
        $.post("../php/index.php", {
            "flag": "getOrderDe",
            "orderNumber": orderNumber
        }, function(data){
            if(data["res"] == 200)
            {
                const orderData = data["r"];
                const tableID = orderData[0][0];
                const orderNumber = orderData[0][1];
                const orderTime = orderData[0][2];
                const ordertotal = orderData[0][3];
                let t_p = "";
                orderData.forEach(value => {
                    t_p += "<tr><td>"+value[4]+"</td><td>"+value[6]+"</td><td>"+value[5]+"</td><td>"+(value[5]*value[6])+"</td></tr>";
                });
                $(".km-time span:last-child").text(orderTime);
                $("table tbody").html(t_p);
                $(".km-table-code span").text(tableID);
                $(".km-total span:last-child").text(ordertotal);
                $(".card-footer span:last-child").text(orderNumber);
            }
            else
            {
                console.log("获取订单详细失败");
            }
        }, "json");
    }

    function all()
    {
        init();
    }
    all();
})