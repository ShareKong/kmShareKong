<?php
if(isset($_GET['flag']))
{
    $flag = $_GET['flag'];
}
else if(isset($_POST['flag']))
{
    $flag = $_POST['flag'];
}

if($flag == "isLogin")
{
    session_start();
    if(isset($_SESSION["waiter"]))
    {
        echo(json_encode(array("status"=>200)));
    }
    else
    {
        echo(json_encode(array("status"=>500)));
    }
}

if($flag == "login")
{
    include("conn.php");
    $acount = $_POST['acount'];
    $pwd = $_POST['pwd'];
    $sql = "select * from user where userAount=? and userPwd=? and userPermission='km-3'";
    $result = $conn->prepare($sql);
    $result->bindValue(1, $acount);
    $result->bindValue(2, $pwd);
    $result->execute();
    $ft = $result->rowCount();
    if($ft)
    {
        session_start();
        $_SESSION['waiter'] = $acount;
        echo(json_encode(array("status"=>200)));
    }
    else
    {
        echo(json_encode(array("status"=>500)));
    }
    $result = null;
    $conn = null;
}
?>