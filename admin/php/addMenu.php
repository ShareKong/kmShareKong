<?php
    // $menuName = time();
    // $menuName = $menuName.".jpg";
    // $filePath = "../../imgs/menus/";
    // $fileName = $filePath.$menuName;
    // if(move_uploaded_file($_FILES['menuFile']['tmp_name'], $fileName))
    // {
    //     try {
    //         include("./conn.php");
    //         $menuPicture = "../imgs/menus/".$menuName;
            // 菜名
            $menuName = $_POST['menuName'];
            $menuCategory = $_POST['menuCategory'];
            $menuIntro = $_POST['menuIntro'];
            $menuPrice = $_POST['menuPrice'];
            print_r($menuCategory);
            // 插入菜品信息
            // $sql = "insert into menu(menuName,menuPrice,menuPicture,menuIntro) values(?, ?, ?, ?)";
            // $result = $conn->prepare($sql);
            // $result->bindValue(1, $menuName);
            // $result->bindValue(2, $menuPrice);
            // $result->bindValue(3, $menuPicture);
            // $result->bindValue(4, $menuIntro);
            // $result->execute();
            // // 得到刚刚插入菜品的ID
            // $menuID = $conn->lastInsertId();
            // if($menuID)
            // {

            // }
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    // }
    // header("Location: ../addMenu.html");
?>