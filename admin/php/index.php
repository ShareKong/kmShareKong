<?php
if(isset($_GET['flag']))
    $flag = $_GET['flag'];
else if(isset($_POST['flag']))
    $flag = $_POST['flag'];

// if($flag == "addEmplo")
// {
//     include("conn.php");

//     $sql = "insert into user(userName, userAount, userPwd, userPermission) values(?, ?, ?, ?)";
//     $result = $conn->prepare($sql);
//     $name = $_POST['name'];
//     $permission = $_POST['permission'];
//     if($permission == "manage")
//     {
//         $permission = "km-1";
//     }
//     else if($permission == "101")
//     {
//         $permission = "km-2";
//     }
//     else
//     {
//         $permission = "km-3";
//     }
//     $aount = time();
//     $pwd = "km".$aount;
//     $result->bindValue(1, $name);
//     $result->bindValue(2, $aount);
//     $result->bindValue(3, $pwd);
//     $result->bindValue(4, $permission);
//     $result->execute();
//     $ft = $conn->lastInsertId();
//     if($ft)
//     {
//         echo(json_encode(array("res"=>200)));
//     }
//     else
//     {
//         echo(json_encode(array("res"=>500, "sql"=>$sql)));
//     }
//     $result = null;
//     $conn = null;
// }
echo(json_encode(array("res"=>200)));
?>