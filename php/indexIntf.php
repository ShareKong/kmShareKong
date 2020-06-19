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
}
// 订单接口
interface OrderIntf
{
    // 生成订单
    public function createOrder($orderData, $table, $menu);
    // 获取订单
    public function getOrder($orderNumber);
}
// 餐桌接口
interface TableIntf
{
    // 获取餐桌状态
    public function getTablesStatus();
    // 获取指定餐桌状态
    public function getTableStatusID($tableID);
    // 改变指定餐桌状态
    public function modifyTableStatusID($tableID);
}
?>