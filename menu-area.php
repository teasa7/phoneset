<?php 
	ob_start();
	include_once("link.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="css/menu-area.css">
    </head>
    <body class="menu-area">
    <?php 
        $token=$_COOKIE['cookieToken'];
        $query="SELECT ID_right FROM `users` WHERE token='$token'";	
        $result=mysqli_query($link, $query);
        $row=mysqli_fetch_assoc($result);
        if ($row["ID_right"] == 4) { ?>
            <div class="menu">
                <ul class="block-menu">
                    <li class="line-menu"><a class="link_area" href="person-area.php">Личные данные</a></li>
                    <li class="line-menu"><a class="link_area" href="my-orders.php">Мои заказы</a></li>                     
                </ul>
            </div>
        <?php 
        }
        if ($row["ID_right"] == 1) { ?>
            <div class="menu">
                <ul class="block-menu">
                    <li class="line-menu"><a class="link_area" href="person-area.php">Личные данные</a></li>
                    <!-- <li class="line-menu"><a class="link_area" href="my-orders.php">Мои заказы</a></li>  -->
                    <li class="line-menu"><a class="link_area" href="users-area.php">Пользователи</a></li>
                    <li class="line-menu"><a class="link_area" href="products-area.php">Товары</a></li>
                    <li class="line-menu"><a class="link_area" href="create-product-area.php">Создание товара</a></li>      
                    <li class="line-menu"><a class="link_area" href="orders.php">Заказы</a></li>            
                </ul>
            </div>
        <?php 
        }
        if ($row["ID_right"] == 2) { ?>
            <div class="menu">
                <ul class="block-menu">
                    <li class="line-menu"><a class="link_area" href="person-area.php">Личные данные</a></li>
                    <!-- <li class="line-menu"><a class="link_area" href="my-orders.php">Мои заказы</a></li>      -->
                    <li class="line-menu"><a class="link_area" href="products-area.php">Товары</a></li>
                    <li class="line-menu"><a class="link_area" href="create-product-area.php">Создание товара</a></li>
                </ul>
            </div>
            <?php 
        } 
        if (($row["ID_right"] == 3) || ($row["ID_right"] == 5)){ ?>
            <div class="menu">
                <ul class="block-menu">
                    <li class="line-menu"><a class="link_area" href="person-area.php">Личные данные</a></li>  
                    <!-- <li class="line-menu"><a class="link_area" href="my-orders.php?">Мои заказы</a></li>   -->
                    <? if ($row["ID_right"] == 3) { ?>
                        <li class="line-menu"><a class="link_area" href="orders.php?area=Асбест">Заказы</a></li>
                    <? } 
                    else { ?>
                        <li class="line-menu"><a class="link_area" href="orders.php">Заказы</a></li>    
                    <? } ?>              
                </ul>
            </div>
        <?php 
        } ?>
    </body>
</html>