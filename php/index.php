<?php
///判断接收到的数据是哪种类型的传值
if(isset($_GET['flag']))
{
    $flag = $_GET['flag'];
}
else if(isset($_POST['flag']))
{
    $flag = $_POST['flag'];
}

// 获取餐桌状态
if($flag == "tableStatus")
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

?>