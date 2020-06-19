<?php
include("./indexIntf.php");

// 餐桌类
class Table implements TableIntf 
{
    // 获取所有餐桌状态<是否可用>
    public function getTablesStatus()
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
    // 获取指定餐桌状态<是否可用>
    public function getTableStatusID($tableID)
    {
        include("./conn.php");
        $sql4 = "select tableEmpty from `table` where tableID=$tableID";
        $res4 = $conn->query($sql4);
        // $rs4 = $res4->fetch(PDO::FETCH_NUM);
        // 如果查询到的结果为 1 ，则表示该餐桌可用
        // if($rs4[0])
        // {
        //     return TRUE;
        // }
        // else
        // {
        //     return FALSE;
        // }
        return TRUE;
        $res4 = null;
        $conn = null;
    }
    // 改变指定餐桌状态为不可用
    public function modifyTableStatusID($tableID)
    {
        include("./conn.php");
        $sql3 = "update `table` set tableEmpty=0 where tableID=?";
        $result = $conn->prepare($sql3);
        $result->bindValue(1, $tableID);
        $result->execute();
        $ft = $result->rowCount();
        if($ft)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
        $res = null;
        $conn = null;
    }
    // 改变指定餐桌状态为可用
    public function modifyTableStatusIDY($tableID)
    {
        include("./conn.php");
        $sql3 = "update `table` set tableEmpty=1 where tableID=?";
        $result = $conn->prepare($sql3);
        $result->bindValue(1, $tableID);
        $result->execute();
        $ft = $result->rowCount();
        if($ft)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
        $res = null;
        $conn = null;
    }
}

// 菜品类
class Menu implements MenuIntf
{
    // 获取菜品分类
    public function getMenuCategory()
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
    // 获取菜品
    public function getMenus()
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
    // 根据菜名获取对应ID
    public function getMenuIdByName($menuName)
    {
        include("./conn.php");
        $sql1 = "select menuID from `menu` where menuName=?";
        $result1 = $conn->prepare($sql1);
        $result1->bindValue(1, $menuName);
        $result1->execute();
        $res1 = $result1->fetchAll(PDO::FETCH_NUM);
        return $res1[0][0];
    }
    // 根据菜品类别获取对应的菜品
    public function getMenuByCategoryName($menuCategoryName)
    {
        include("./conn.php");
        $sql = "select menu.menuID,menu.menuName,menu.menuPrice,menu.menuPicture,menu.menuIntro from category,menu,menucategory where category.categoryID=menucategory.CategoryID and menucategory.menuID=menu.menuID and category=?;";
        $result = $conn->prepare($sql);
        $result->bindValue(1, $menuCategoryName);
        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_NUM);
        echo(json_encode(array("res"=>200, "r"=>$res)));
        $result = null;
        $conn = null;
    }
}

// 订单类
class Order implements OrderIntf
{
    // 生成订单
    public function createOrder($orderData, $table, $menu)
    {
        include("./conn.php");
        // 餐桌号
        $tableID = 0;
        // 订单总价
        $orderTotal = 0;
        // 从数据中提取
        foreach ($orderData as $key => $value) {
            foreach ($value as $k => $val) {
                if($k == "total")   
                {
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
        $orderFinish = 0;
        $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        
        try {
            $conn->beginTransaction();
            // 判断当前餐桌是否已经被占用
            if($table->getTableStatusID($tableID))
            {
                // 将该餐桌改变状态
                if($table->modifyTableStatusID($tableID))
                {
                    // 插入订单信息
                    $sql = "insert into `order`(orderNumber, tableID, orderTime, orderPrice, orderFinish) values('$orderNumber', '$tableID', '$orderTime', $orderTotal, '$orderFinish')";
                    $conn->query($sql);
                    // 订单详细插入
                    for($i = 0; $i < count($orderData) - 2; $i ++)
                    {
                        $mName = $orderData[$i]['name'];
                        $mNumber = $orderData[$i]['number'];
                        /// 根据菜名获取到 id
                        $menuID = $menu->getMenuIdByName($mName);
                        $menuFinish = 0;
                        /// 插入订单详细
                        $sql2 = "insert into `orderdetail`(orderNumber, menuID, menuQuantity, menuFinish) values('$orderNumber', '$menuID', '$mNumber', '$menuFinish')";
                        $conn->query($sql2);
                    }
                    $conn->commit();
                    echo(json_encode(array("res"=>200, "orderNumber"=>$orderNumber)));
                }
                else
                {
                    echo(json_encode(array("res"=>550)));
                }
            }
            else
            {
                echo(json_encode(array("res"=>550)));
            }
        } catch (PDOException $e) {
            $conn->rollback();
            echo(json_encode(array("res"=>500)));
        }
        $result = null;
        $conn = null;
    }
    // 获取订单
    public function getOrder($orderNumber)
    {
        include("./conn.php");
        try {
            $sql = "select distinct `order`.tableID,`order`.orderNumber,`order`.orderTime,`order`.orderPrice,menu.menuName,orderdetail.menuQuantity,menu.menuPrice from `order`,orderdetail,menu where `order`.orderNumber=orderdetail.orderNumber and orderdetail.menuID=menu.menuID and order.orderNumber=?";
            $result = $conn->prepare($sql);
            $result->bindValue(1, $orderNumber);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_NUM);
            echo(json_encode(array("res"=>200, "r"=>$res)));
        } catch (\Throwable $th) {
            echo(json_encode(array("res"=>500)));
        }
        $result = null;
        $conn = null;
    }
    // 获取未完成订单
    public function getNotFinishOrder()
    {
        include("./conn.php");
        try {
            $sql = "select tableID,orderNumber,orderTime,orderPrice from `order` where orderFinish=0";
            $result = $conn->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_NUM);
            echo(json_encode(array("res"=>200, "r"=>$res)));
        } catch (\Throwable $th) {
            echo(json_encode(array("res"=>500)));
        }
        $result = null;
        $conn = null;
    }
    // 获取历史订单
    public function getHistoryOrder()
    {
        include("./conn.php");
        try {
            $sql = "select tableID,orderNumber,orderTime,orderPrice from `order` where orderFinish=1";
            $result = $conn->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_NUM);
            echo(json_encode(array("res"=>200, "r"=>$res)));
        } catch (\Throwable $th) {
            echo(json_encode(array("res"=>500)));
        }
        $result = null;
        $conn = null;
    }
    // 完成订单
    public function finishOrder($orderNumber, $table)
    {
        include("./conn.php");
        $conn->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        try {
            $conn->beginTransaction();
            $sql = "update `order` set orderFinish=1 where orderNumber=?";
            $result = $conn->prepare($sql);
            $result->bindValue(1, $orderNumber);
            $result->execute();
            // 通过单号查找对应餐桌号
            $tableID = $this->getTableIDByOrderNumber($orderNumber);
            // 将订单号对应的餐桌变为可用
            if($table->modifyTableStatusIDY($tableID))
            {
                $ft = $result->rowCount();
                $conn->commit();
                if($ft)
                {
                    echo(json_encode(array("res"=>200)));
                }
                else
                {
                    echo(json_encode(array("res"=>500)));
                }
            }
        } catch (PDOException $e) {
            $conn->rollback();
            echo(json_encode(array("res"=>500)));
        }
        $result = null;
        $conn = null;
    }
    // 通过单号查找对应餐桌号
    public function getTableIDByOrderNumber($orderNumber)
    {
        include("./conn.php");
        try {
            $sql = "select tableID from `order` where orderNumber=?";
            $result = $conn->prepare($sql);
            $result->bindValue(1, $orderNumber);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_NUM);
            return $res[0][0];
        } catch (\Throwable $th) {
            return FALSE;
        }
        $result = null;
        $conn = null;
    }
}

?>