<?php
// 用户接口
interface User 
{
    // 密码修改
    public function modifyPWD($oldPwd, $newPwd);
    // 用户登录
    public function login();
    /// 添加用户
    public function add($name);
    /// 删除用户
    public function del();
}
?>