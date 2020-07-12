<?php
if(isset($_GET['flag']))
    $flag = $_GET['flag'];
else if(isset($_POST['flag']))
    $flag = $_POST['flag'];

    // 检测是否登陆
if($flag == "indexStart")
{
    session_start();
    if(isset($_SESSION['admin']))
    {
        include("conn.php");
        $sql = "select userName from user where userAount=?";
        $result = $conn->prepare($sql);
        $result->bindValue(1, $_SESSION['admin']);
        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_NUM);
        echo(json_encode(array("res"=>200, "r"=>$res)));
        $result = null;
        $conn = null;
    }
    else
    {
        echo(json_encode(array("res"=>500)));
    }
}
// 添加员工
if($flag == "addEmplo")
{
    include("conn.php");

    $sql = "insert into user(userName, userAount, userPwd, userPermission) values(?, ?, ?, ?)";
    $result = $conn->prepare($sql);
    $name = $_POST['name'];
    $permission = $_POST['permission'];
    if($permission == "manage")
    {
        $permission = "km-1";
    }
    else if($permission == "101")
    {
        $permission = "km-2";
    }
    else
    {
        $permission = "km-3";
    }
    $aount = time();
    $pwd = "km".$aount;
    $result->bindValue(1, $name);
    $result->bindValue(2, $aount);
    $result->bindValue(3, $pwd);
    $result->bindValue(4, $permission);
    $result->execute();
    $ft = $conn->lastInsertId();
    if($ft)
    {
        echo(json_encode(array("res"=>200)));
    }
    else
    {
        echo(json_encode(array("res"=>500)));
    }
    $result = null;
    $conn = null;
}
// 获取员工列表
if($flag == "getEmplos")
{
    include("conn.php");
    $sql = "select userName,userAount,userPwd,userPermission from user";
    $result = $conn->prepare($sql);
    $result->execute();
    $res = $result->fetchAll(PDO::FETCH_NUM);
    echo(json_encode(array("r"=>$res)));
    $result = null;
    $conn = null;
}
// 删除指定员工
if($flag == "delEmploId")
{
    include("conn.php");
    $aountId = $_POST["aountId"];
    $sql = "delete from user where userAount=?";
    $result = $conn->prepare($sql);
    $result->bindValue(1, $aountId);
    $result->execute();
    $ft = $result->rowCount();
    if($ft)
    {
        echo(json_encode(array("res"=>200)));
    }
    else
    {
        echo(json_encode(array("res"=>500)));
    }
    $result = null;
    $conn = null;
}
// 修改密码
if($flag == "modifyPwd")
{
    include("conn.php");
    $pwd = $_POST["pwd"];
    $pwd1 = $_POST["pwd1"];
    session_start();
    if(isset($_SESSION['admin']))
    {
        $aount = $_SESSION['admin'];
        /// 查询提交的旧密码是否一致
        $sql1 = "select * from user where userAount=? and userPwd=?";
        $result = $conn->prepare($sql1);
        $result->bindValue(1, $aount);
        $result->bindValue(2, $pwd);
        $result->execute();
        $ft = $result->rowCount();
        if($ft)
        {
            $ft = 0;
            $result = null;
            $sql = "update user set userPwd=? where userAount=?";
            $result = $conn->prepare($sql);
            $result->bindValue(1, $pwd1);
            $result->bindValue(2, $aount);
            $result->execute();
            $ft = $result->rowCount();
            if($ft)
            {
                echo(json_encode(array("res"=>200)));
            }
            else
            {
                echo(json_encode(array("res"=>500)));
            }
            $result = null;
        }
        else
        {
            echo(json_encode(array("res"=>500)));
        }
    }
    else
    {
        echo(json_encode(array("res"=>808)));
    }
    $conn = null;
}
// 登陆
if($flag == "login")
{
    include("conn.php");
    $name = $_POST['name'];
    $pwd = $_POST['pwd'];
    $sql = "select * from user where userAount=? and userPwd=? and userPermission='km-1'";
    $result = $conn->prepare($sql);
    $result->bindValue(1, $name);
    $result->bindValue(2, $pwd);
    $result->execute();
    $ft = $result->rowCount();
    if($ft)
    {
        session_start();
        $_SESSION['admin'] = $name;
        echo(json_encode(array("res"=>200)));
    }
    else
    {
        echo(json_encode(array("res"=>500)));
    }
    $result = null;
    $conn = null;
}
// 退出登陆
if($flag == "loginOut")
{
    session_start();
    if(isset($_SESSION['admin']))
    {
        unset($_SESSION['admin']);
    }
    session_destroy();
    echo(json_encode(array("res"=>200)));
}
// 获取菜品分类列表
if($flag == "getMenuCategory")
{
    try {
        include("conn.php");
        $sql = "select * from category";
        $result = $conn->prepare($sql);
        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_NUM);
        echo(json_encode(array("status"=>200, "res"=>$res)));
        $conn = null;
        $result = null;
    } catch(PDOException $e) {
        echo(json_encode(array("status"=>500)));
    }
}
// 获取菜品列表
if($flag == "getMenus")
{
    try {
        include("conn.php");
        // 读取菜品信息
        $sql = "select * from `menu`";
        $result = $conn->prepare($sql);
        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_NUM);
        // 读取菜品对应的菜品类别
        $sql1 = "select menu.menuID,category.category from `menu`,`category`,`menucategory` where menu.menuID=menucategory.menuID and menucategory.CategoryID=category.categoryID";
        $result1 = $conn->prepare($sql1);
        $result1->execute();
        $res1 = $result1->fetchAll(PDO::FETCH_NUM);
        echo(json_encode(array("status"=>200, "res"=>$res, "res1"=>$res1)));
        $conn = null;
        $result = null;
        $result1 = null;
    } catch(PDOException $e) {
        echo(json_encode(array("status"=>500)));
    }
}
// 获取菜品分类列表
if($flag == "getMenuCate")
{
    try {
        include("conn.php");
        $sql = "select * from `category`";
        $result = $conn->prepare($sql);
        $result->execute();
        $res = $result->fetchAll(PDO::FETCH_NUM);
        echo(json_encode(array("status"=>200, "res"=>$res)));
        $conn = null;
        $result = null;
    } catch(PDOException $e) {
        echo(json_encode(array("status"=>500)));
    }
}
// 添加菜品分类
if($flag == "addMenuCate")
{
    $menuCateName = $_POST["data"];

    try {
        include("conn.php");
        $sql = "insert into `category`(category) values(?)";
        $result = $conn->prepare($sql);
        $result->bindValue(1, $menuCateName);
        $result->execute();
        $ft = $conn->lastInsertId();
        if($ft)
        {
            echo(json_encode(array("status"=>200)));
        }
        else
        {
            echo(json_encode(array("status"=>500)));
        }
        $conn = null;
        $result = null;
    } catch(PDOException $e) {
        echo(json_encode(array("status"=>500)));
    }
}
// 删除菜品分类
if($flag == "deleteMenuCate")
{
    $cateID = $_POST["data"];
    try {
        include("conn.php");
        $sql = "delete from `category` where categoryID=?";
        $result = $conn->prepare($sql);
        $result->bindValue(1, $cateID);
        $result->execute();
        $ft = $result->rowCount();
        if($ft)
        {
            echo(json_encode(array("status"=>200)));
        }
        else
        {
            echo(json_encode(array("status"=>500)));
        }
        $conn = null;
        $result = null;
    } catch(PDOException $e) {
        echo(json_encode(array("status"=>500)));
    }
}
?>