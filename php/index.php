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
                @$orderTotal = intval($val[$ke]);
            }
            if($k == "tableId")
            {
                @$tableID = intval($val[$k]);
            }
        }
        // print_r($value);
    }

    $orderFinish = 1;
    $orderNumber = "km".time();
    $orderTime = date('Y-m-d H:i:s', time());
    $sql = "insert into `order`(orderNumber, tableID, orderTime, orderPrice, orderFinish) values('?', ?, ?, ?, '?')";
    $result = $conn->prepare($sql);
    $result->bindValue(1, $orderNumber);
    $result->bindValue(2, $tableID);
    $result->bindValue(3, $orderTime);
    $result->bindValue(4, $orderTotal);
    $result->bindValue(5, $orderFinish);
    $result->execute();


    // 订单号
    // $orderNumber = "km".time();
    // // 订单时间
    // $orderTime = date('Y-m-d H:i:s', time());
    // $orderFinish = 1;
    // $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    
    // try {
    //     $conn->beginTransaction();
    //     $sql = "insert into `order`(orderNumber, tableID, orderTime, orderPrice, orderFinish) values('?', '?', '?', '?', '?')";
    //     $result = $conn->prepare($sql);
    //     $result->bindValue(1, $orderNumber);
    //     $result->bindValue(2, $tableID);
    //     $result->bindValue(3, $orderTime);
    //     $result->bindValue(4, $orderTotal);
    //     $result->bindValue(5, $orderFinish);
    //     $result->execute();
    //     echo $result->lastInsertId();
    //     // 订单详细插入
    //     for($i = 0; $i < count($orderData) - 2; $i ++)
    //     {
    //         /// 根据菜名获取到 id
    //         $mName = $orderData[$i]['name'];
    //         $mNumber = $orderData[$i]['number'];
    //         $sql1 = "select menuID from `menu` where menuName=?";
    //         $result1 = $conn->prepare($sql1);
    //         $result1->bindValue(1, $mName);
    //         $result1->execute();
    //         $res1 = $result1->fetchAll(PDO::FETCH_NUM);
    //         $menuID = $res1[0][0];
    //         $menuFinish = 0;
    //         /// 插入订单详细
    //         $sql2 = "insert into `orderdetail`(orderNumber, menuID, menuQuantity, menuFinish) values('?', '?', '?', '?')";
    //         $result2 = $conn->prepare($sql2);
    //         $result2->bindValue(1, $orderNumber);
    //         $result2->bindValue(2, $menuID);
    //         $result2->bindValue(3, $mNumber);
    //         $result2->bindValue(4, $menuFinish);
    //         $result2->execute();
    //         $result1 = null;
    //         $result2 = null;
    //     }
    //     $conn->commit();
    // } catch (PDOException $e) {
    //     $conn->rollback();
    //     echo(json_encode(array("res"=>500)));
    // }
    // echo(json_encode(array("res"=>200)));
    $result = null;
    $conn = null;
}

?>