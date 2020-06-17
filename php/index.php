<?php

// $flag = (object)[];
if(isset($_GET['flag']))		///判断接收到的数据是哪种类型的传值
{
    $flag = $_GET['flag'];
}
else if(isset($_POST['flag']))
{
    $flag = $_POST['flag'];
}


if($flag == "tableStatus")
{
    echo(json_encode(array("res"=>"SUCCESS")));
}
else
{
    echo(json_encode(array("res"=>"FALUT", "flag"=>$flag)));
}

?>