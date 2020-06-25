<?php
include("./indexImplo.php");
///判断接收到的数据是哪种类型的传值
if(isset($_GET['flag']))
{
    $flag = $_GET['flag'];
}
else if(isset($_POST['flag']))
{
    $flag = $_POST['flag'];
}

$db = new Database();
$table = new Table($db);
$menu = new Menu($db);
$order = new Order($db, $table, $menu);

switch ($flag) {
    // 获取餐桌状态
    case 'tableStatus':
        $table->getTablesStatus();
        break;
    // 获取菜品分类
    case 'getMenuCategory':
        $menu->getMenuCategory();
        break;
    // 获取菜品
    case 'getMenus':
        $menu->getMenus();
        break;
    /// 提交订单
    case 'submitOrder':
        $orderData = $_POST['order'];
        $order->createOrder($orderData);
        break;
    // 获取订单
    case 'getOrderDe':
        $orderNumber = $_POST['orderNumber'];
        $order->getOrder($orderNumber);
        break;
    // 获取未完成订单
    case 'getNotFinishOrder':
        $order->getNotFinishOrder();
        break;
    // 获取历史订单
    case 'getHistoryOrder':
        $order->getHistoryOrder();
        break;
    // 完成订单
    case 'finishOrder':
        $orderNumber = $_POST['orderNumber'];
        $order->finishOrder($orderNumber);
        break;
    // 根据菜品分类查找对应菜品
    case 'getMenuByCategoryName':
        $categoryName = $_POST['categoryName'];
        $menu->getMenuByCategoryName($categoryName);
        break;
    default:
        # code...
        break;
}

?>