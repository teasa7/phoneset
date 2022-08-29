<?php 
	ob_start();
    include_once("link.php");
	include_once("menu.php"); 
    $token=$_COOKIE['cookieToken'];
    $result_right  = mysqli_query($link,"SELECT ID_right FROM `users` WHERE token='$token'");
    $row_right  = mysqli_fetch_assoc($result_right);
    $ID_right = $row_right["ID_right"];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - просмотр заказа</title>
		<link rel="icon" type="image/png" href="img/favicon.ico">
		
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
	    
        <link rel="stylesheet" href="css/ordering.css"></head>

    </head>
	<body>
		<main>
            <? $code = $_GET["code"]; ?>

			<div class="main-order">
				<div class="block-order">
                    <a class="back" onclick="javascript:history.back(); return false;">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <p class="title-area">Просмотр заказа № <? echo $code ?></p>
					<form name="form" method="post" action="" enctype="multipart/form-data">
						<div class="form-order container">
                            <div class="bottom-line">
                                <div class="row">
                                    <div class="col-sm">
                                        <table class="table">
                                            <tbody>
                                                <p class="title-area">Товары</p>
                                                <? $totalPrice = 0;
                                                $result_order = mysqli_query($link, "SELECT * FROM `orders` WHERE code='$code'"); 
                                                while($row_order = mysqli_fetch_assoc($result_order)) { 
                                                    $status = $row_order["ID_status"];
                                                    $ID_product = $row_order["ID_product"];

                                                    $result_product = mysqli_query($link, "SELECT * FROM `products` WHERE ID='$ID_product'");
                                                    $row_product = mysqli_fetch_assoc($result_product);

                                                    $ID_group = $row_product["ID_group"]; 
                                                    $result_group=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group'");
                                                    $row_group=mysqli_fetch_assoc($result_group); 

                                                    $ID_model = $row_group['ID_model'];
                                                    $result_model = mysqli_query($link, "SELECT ID_brand, model FROM `models` WHERE ID='$ID_model'");
                                                    $row_model = mysqli_fetch_assoc($result_model);

                                                    $ID_brand = $row_model["ID_brand"];
                                                    $result_brand = mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand'");
                                                    $row_brand = mysqli_fetch_assoc($result_brand);

                                                    $ID_color = $row_group["ID_color"];
                                                    $result_color = mysqli_query($link, "SELECT `name` FROM `colors` WHERE ID='$ID_color'");
                                                    $row_color = mysqli_fetch_assoc($result_color);                                                   

                                                    $date = '0000-00-00';
                                                    $result_price = mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product'");
                                                    while ($row_price = mysqli_fetch_assoc($result_price)) {
                                                        if ($row_price['date'] > $date) {
                                                            $price = $row_price['price'];
                                                            $date = $row_price['date'];
                                                        }
                                                    }

                                                    $result_image=mysqli_query($link, "SELECT `image` FROM `images` WHERE ID_group='$ID_group'");
                                                    $row_image=mysqli_fetch_assoc($result_image);

                                                    $new_price = round($price - ($price / 100 * $row_product["discount"])); ?>

                                                    <tr class="one-line">
                                                        <td class="block-image-cart" rowspan="2"><img class="image-cart" src="data:image/jpeg;base64, <? echo base64_encode($row_image['image']) ?>"></td>
                                                        <td class="col1">
                                                            <a href="product.php?ID=<? echo $row_order['ID_product']; ?>&popularity=1" class="link-product"><? echo $row_brand["brand"] . " "; echo $row_model["model"] . " "; echo $row_product["memory"] . " "; echo $row_color["name"];?></a>
                                                        </td>
                                                        <td class="col2">
                                                            <span class="text"><? echo $new_price ?> руб</span>  
                                                            <span class="text">(<? echo $row_order['count']; ?> шт)</span>                                                    
                                                        </td>
                                                        <? $totalPrice = $totalPrice + ($new_price * $row_order['count']); ?>     
                                                    </tr>
                                                    <tr></tr>
                                                <? } ?> 
                                            </tbody>     
                                        </table>   
                                        <input type="hidden" id="price" name="price" value="<? echo $totalPrice; ?>">
                                        <span id="total_price" name="total_price" class="text all_price">Общая стоимость всех товаров: <? echo $totalPrice ?></span>                            					
                                    </div>
                                    <div class="col-sm">
                                        <div class="block-person">
                                            <p class="title-area">Данные</p>
                                              
                                            <? $result_order = mysqli_query($link, "SELECT * FROM `orders` WHERE code='$code'"); 
                                            $row_order = mysqli_fetch_assoc($result_order); 
                                                
                                            $ID_area = $row_order['ID_area'];
                                            $result_area = mysqli_query($link, "SELECT area, price FROM `areas` WHERE ID='$ID_area'");
                                            $row_area = mysqli_fetch_assoc($result_area); ?>

                                            <label class="info">Имя и фамилия</label><br>
                                            <input class="input-person" type="text" name="name" id="name" value="<?php printf($row_order["user"]) ?>" pattern="[А-Яа-яЁё]+" readonly><br>
                                            
                                            <label class="info">Номер телефона</label><br>
                                            <input class="input-person" type="text" name="phone" id="phone" value="<?php printf($row_order["phone"]) ?>" readonly>
                                            
                                            <label class="info">Способ получения</label><br>
                                            <input class="input-person" type="text" name="way" id="way" value="<?php printf($row_order["way"]) ?>" readonly>
                                            
                                            <? if($row_order["way"] == "Курьер") { ?>   
                                                <label class="info">Район</label><br>
                                                <input class="input-person" type="text" name="area" id="area" value="<?php printf($row_area["area"]) ?>" readonly>
                                                <label class="info">Адрес</label><br>
                                                <input class="input-person" type="text" name="address" id="address" value="<?php printf($row_order["address"]) ?>" readonly>
                                                <label class="info">Дата доставки</label><br>
                                                <input class="input-person" type="text" name="delivery_date" id="delivery_date" value="<?php printf($row_order["delivery_date"]) ?>" readonly>
                                            <? } ?>
                                        </div>
                                    </div>	
                                </div><br>
                            </div>
                            <div class="all_price_2">
                                <span id="price_area_all" class="text all_price_text">Итоговая сумма заказа: <span id="totalPriceAll"><? echo $totalPrice + $row_area["price"] ?></span> руб.</span>
                                <? if(($ID_right == "4") && ($status == "1")) { ?><input class="btn-order-close" type="submit" name="close" name="close" value="Отменить заказ"><? } ?>
                            </div><br>
                        </div>  
                        <? if (isset($_POST["close"])) {
                            $result_update_order=mysqli_query($link, "UPDATE orders SET ID_status='5' WHERE code='$code'");
                            mysqli_fetch_assoc($result_update_order);
                            header("Location: my-orders.php");
                        } ?>
					</form>						
				</div>
            </div>
		</main>
    </body>
</html>
<?php 
include_once("footer.php"); 
ob_end_flush();
?>
