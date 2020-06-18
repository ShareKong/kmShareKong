<?php
///判断接收到的数据是哪种类型的传值
if(isset($_GET['flag']))
{
    $flag = $_GET['flag'];
}
else if(isset($_POST['flag']))
{
    $flag = $_POST['flag'];
}

// 获取餐桌状态
if($flag == "tableStatus")
{
    include("./conn.php");
    $sql = "select * from `table`";
    $result = $conn->prepare($sql);
    $result->execute();
    $res = $result->fetchAll(PDO::FETCH_NUM);
    echo(json_encode(array("res"=>200, "r"=>$res)));
    $result = null;
    $conn = null;
}
// 获取菜品分类
if($flag == "getMenuCategory")
{
    include("./conn.php");
    $sql = "select * from `category`";
    $result = $conn->prepare($sql);
    $result->execute();
    $res = $result->fetchAll(PDO::FETCH_NUM);
    echo(json_encode(array("res"=>200, "r"=>$res)));
    $result = null;
    $conn = null;
}
// 获取菜品列表
if($flag == "getMenus")
{
    include("./conn.php");
    $sql = "select * from `menu`";
    $result = $conn->prepare($sql);
    $result->execute();
    $res = $result->fetchAll(PDO::FETCH_NUM);
    echo(json_encode(array("res"=>200, "r"=>$res)));
    $result = null;
    $conn = null;
}

/// 提交订单
if($flag == "submitOrder")
{
    include("./conn.php");
    $orderData = $_POST['order'];
    // 餐桌号
    $tableID = 0;
    // 订单总价
    $orderTotal = 0;
    
    // print_r($orderData);
    foreach ($orderData as $key => $value) {
        foreach ($value as $k => $val) {
            if($k == "total")   
            {
                // print_r($val);
                $orderTotal = $val;
            }
            if($k == "tableId")
            {
                $tableID = $val;
            }
        }
    }

    // 订单号
    $orderNumber = "km".time();
    // 订单时间
    $orderTime = date('Y-m-d H:i:s', time());
    $orderFinish = 1;
    $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    
    try {
        $conn->beginTransaction();
        // 将该餐桌改变状态
        $sql3 = "update `table` set tableEmpty=0 where tableID=$tableID";
        $conn->query($sql3);
        // 插入订单信息
        $sql = "insert into `order`(orderNumber, tableID, orderTime, orderPrice, orderFinish) values('$orderNumber', '$tableID', '$orderTime', $orderTotal, '$orderFinish')";
        $conn->query($sql);
        // 订单详细插入
        for($i = 0; $i < count($orderData) - 2; $i ++)
        {
            /// 根据菜名获取到 id
            $mName = $orderData[$i]['name'];
            $mNumber = $orderData[$i]['number'];
            // $sql1 = "select menuID from `menu` where menuName=$mName";
            // $result1 = $conn->query($sql1);
            $sql1 = "select menuID from `menu` where menuName=?";
            $result1 = $conn->prepare($sql1);
            $result1->bindValue(1, $mName);
            $result1->execute();
            // $res1 = $conn->fetchAll(PDO::FETCH_NUM);
            $res1 = $result1->fetchAll(PDO::FETCH_NUM);
            // print_r($res1[0][0]);
            $menuID = $res1[0][0];
            $menuFinish = 0;
            // /// 插入订单详细
            $sql2 = "insert into `orderdetail`(orderNumber, menuID, menuQuantity, menuFinish) values('$orderNumber', '$menuID', '$mNumber', '$menuFinish')";
            $conn->query($sql2);
        }
        $conn->commit();
        echo(json_encode(array("res"=>200, "orderNumber"=>$orderNumber)));
    } catch (PDOException $e) {
        $conn->rollback();
        echo(json_encode(array("res"=>500)));
    }
    $result = null;
    $conn = null;
}
// 获取详细订单
if($flag == "getOrderDe")
{
    include("./conn.php");
    try {
        $orderNumber = $_POST["orderNumber"];
        $sql = "select distinct `order`.tableID,`order`.orderNumber,`order`.orderTime,`order`.orderPrice,menu.menuName,orderdetail.menuQuantity,menu.menuPrice from `order`,orderdetail,menu where `order`.orderNumber=orderdetail.orderNumber and orderdetail.menuID=menu.menuID and order.orderNumber=?";
        $result = $conn->prepare($sql);
        $result->bindValue(1, $orderNumber);
        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_NUM);
        echo(json_encode(array("res"=>200, "r"=>$res)));
    } catch (\Throwable $th) {
        //throw $th;
    }
    $result = null;
    $conn = null;
}

?>