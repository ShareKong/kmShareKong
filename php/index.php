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

$table = new Table();
$menu = new Menu();
$order = new Order();

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
        $order->createOrder($orderData, $table, $menu);
        break;
    // 获取订单
    case 'getOrderDe':
        $orderNumber = $_POST['orderNumber'];
        $order->getOrder($orderNumber);
        break;
    default:
        # code...
        break;
}

?>