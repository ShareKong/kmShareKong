<?php
// 用户接口：
// 密码修改
// 用户登录
interface User 
{
    public function modifyPWD($oldPwd, $newPwd);
    public function login();
}
?>