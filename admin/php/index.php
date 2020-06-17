<?php
if(isset($_GET['flag']))
    $flag = $_GET['flag'];
else if(isset($_POST['flag']))
    $flag = $_POST['flag'];

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
?>