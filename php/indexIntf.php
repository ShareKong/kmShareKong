<?php
// 菜品接口
interface MenuIntf
{
    // 获取菜品分类
    public function getMenuCategory();
    // 获取菜品
    public function getMenus();
    // 根据菜名获取对应ID
    public function getMenuIdByName($menuName);
    // 根据菜品类别获取对应的菜品
    public function getMenuByCategoryName($menuCategoryName);
}
// 订单接口
interface OrderIntf
{
    // 生成订单
    public function createOrder($orderData, $table, $menu);
    // 获取订单
    public function getOrder($orderNumber);
    // 获取未完成订单
    public function getNotFinishOrder();
    // 获取历史订单
    public function getHistoryOrder();
    // 完成订单
    public function finishOrder($orderNumber, $table);
    // 通过单号查找对应餐桌号
    public function getTableIDByOrderNumber($orderNumber);
}
// 餐桌接口
interface TableIntf
{
    // 获取所有餐桌状态
    public function getTablesStatus();
    // 获取指定餐桌状态
    public function getTableStatusID($tableID);
    // 改变指定餐桌状态为不可用
    public function modifyTableStatusID($tableID);
    // 改变指定餐桌状态为可用
    public function modifyTableStatusIDY($tableID);
}
?>