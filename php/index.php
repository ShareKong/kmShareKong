<?php
$flag = file_get_contents("php://input");
$flag = json_decode($flag, FALSE);

if($flag->{"flag"} == "tableStatus")
{
    echo(json_encode(array("res"=>"SUCCESS")));
}
else
{
    echo(json_encode(array("res"=>"FALUT", "flag"=>$flag)));
}


?>