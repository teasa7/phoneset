<?php 
	ob_start();
    include_once("link.php");
	include_once("menu.php"); 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - оформление заказа</title>
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
            <? $token=$_COOKIE['cookieToken'];
			$query_info="SELECT ID, `name`, surname, email, phone FROM `users` WHERE token='$token'";	
			$result_info=mysqli_query($link, $query_info);
			$row_info=mysqli_fetch_assoc($result_info); ?>

			<div class="main-order">
				<div class="block-order">
                    <p class="title-area">Оформление заказа</p>
					<form name="form" method="post" action="" enctype="multipart/form-data">
						<div class="form-order container">
                            <div class="bottom-line">
                                <div class="row">
                                    <div class="col-sm">
                                        <table class="table">
                                            <tbody>
                                                <p class="title-area">Товары</p>
                                                <? $totalPrice = 0;
                                                $query_cart = "SELECT * FROM `carts` WHERE ID_user='$ID' ORDER BY date_cart DESC";
                                                $result_cart = mysqli_query($link, $query_cart); 
                                                while($row_cart = mysqli_fetch_assoc($result_cart)) { 
                                                    $ID_product = $row_cart["ID_product"];

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
                                                            <a href="product.php?ID=<? echo $row_cart['ID_product']; ?>&popularity=1" class="link-product"><? echo $row_brand["brand"] . " "; echo $row_model["model"] . " "; echo $row_product["memory"] . " "; echo $row_color["name"];?></a>
                                                        </td>
                                                        <td class="col2">
                                                            <span class="text"><? echo $new_price ?> руб</span>  
                                                            <span class="text">(<? echo $row_cart['count']; ?> шт)</span>                                                    
                                                        </td>
                                                        <? $totalPrice = $totalPrice + ($new_price * $row_cart['count']); ?>     
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
                                            <p class="title-area">Ваши данные</p>
                                            <label class="info">Имя</label><br>
                                            <input class="input-person" type="text" name="name" id="name" value="<?php printf($row_info["name"]) ?>" pattern="[А-Яа-яЁё]+" required><br>
                                            <label class="info">Фамилия</label><br>
                                            <input class="input-person" type="text" name="surname" id="surname" value="<?php printf($row_info["surname"]) ?>" pattern="[А-Яа-яЁё]+" required><br>
                                            <label class="info">Электронная почта</label><br>
                                            <input class="input-person" type="text" name="email" id="email" value="<?php printf($row_info["email"]) ?>" 
                                            pattern="([a-zA-Z0-9]+(?:[._+-][a-zA-Z0-9]+)*)@([a-zA-Z0-9]+(?:[.-][a-zA-Z0-9]+)*[.][a-zA-Z]{2,})" readonly required><br>
                                            <label class="info">Номер телефона</label><br>
                                            <input class="input-person" type="text" name="phone" id="phone" value="<?php printf($row_info["phone"]) ?>" 
                                            pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{10}$" required>
                                            <label class="info">Способ получения</label><br>
                                            <div class="input-person-block">
                                                <input class="input-person-two <? if(isset($_POST["pickup"])) { ?> active <? } ?>" type="submit" name="pickup" id="pickup" value="Самовывоз">
                                                <input class="input-person-two <? if(isset($_POST["сourier"])) { ?> active <? } ?>" type="submit" name="сourier" id="сourier" value="Курьер">
                                            </div>
                                            <? if(isset($_POST["сourier"])) { ?>
                                                <label class="info">Район</label><br>
                                                <select class="input-person base" name="area_select" id="area_select" onchange="select_area()">
                                                    <option disabled selected>Выберите район</option>
                                                    <? $query_area = "SELECT * FROM `areas`";
                                                    $result_area = mysqli_query($link, $query_area);
                                                    while ($row_area = mysqli_fetch_assoc($result_area)) { ?>  
                                                        <option value="<? echo $row_area['ID'] ?>">
                                                            <? echo $row_area['area'] ?>
                                                        </option>                                               
                                                    <? 
                                                    } ?>
                                                </select><br>                                               
                                                <label class="info input-house">Улица</label>
                                                <label class="info input-house-2">Квартира</label>
                                                <label class="info input-house-2">Дом</label>
                                                <div class="input-person-block">
                                                    <input class="input-person input-house" type="text" name="outside" id="outside" pattern="[А-Яа-яЁё]+">
                                                    <input class="input-person input-house-2" type="text" name="room" id="room" pattern="[0-9]+">                                           
                                                    <input class="input-person input-house-2" type="text" name="house" id="house" pattern="[0-9]+">
                                                </div>
                                                <label class="info">Дата доставки</label>
                                                <? 
                                                $today = date("Y-m-d");
                                                $clock = date("H:i:s");  
                                                if ($clock > '20:00:00') {
                                                    $start_date = date("Y-m-d", strtotime($today.'+ 2 days')); 
                                                }
                                                else $start_date = date("Y-m-d", strtotime($today.'+ 1 days'));    
                                                
                                                $end_date = date("Y-m-d", strtotime($today.'+ 7 days')); ?>
                                                <input class="input-person" type="date" name="date_order" id="date_order" min="<? echo $start_date ?>" max="<? echo $end_date ?>" value="<? echo $start_date ?>" onchange="select_date()">
                                                <span id="price_area" class="text price-area"><span></span></span>         
                                                                                    
                                            <? } ?>
                                            
                                        </div>
                                    </div>	
                                </div><br>
                            </div>
                            <div class="all_price_2">        
                                <? if(isset($_POST["pickup"])) { ?>
                                    <span id="price_area_all" class="text all_price_text">Итоговая стоимость заказа: <span id="totalPriceAll"><? echo $totalPrice ?></span> руб.</span><br>
                                    <? $today = date("d.m.Y", strtotime($today.'+ 5 days')); ?>
                                    <span class="text all_price_text">Заказ хранится в магазине до <? echo $today ?></span>
                                <? } 
                                else if(isset($_POST["сourier"])) { ?>
                                    <span id="price_area_all" class="text all_price_text">Итоговая стоимость заказа с учётом доставки: <span id="totalPriceAll"><? echo $totalPrice ?></span> руб.</span><br>  
                                <? } 
                                else { ?>
                                    <span id="price_area_all" class="text all_price_text">Итоговая стоимость заказа: <span id="totalPriceAll"><? echo $totalPrice ?></span> руб.</span><br>
                                <? } ?>
                                <span id="price_area_text" class="text all_price_text"></span>
                            </div>
							<div class="block-btn">
								<input class="btn-order" type="submit" name="buy" name="buy" value="Оформить заказ">
							</div>
                        </div>             	            
					</form>						
				</div>
            </div>
		</main>
    </body>
</html>
<? if (isset($_POST["buy"])) {
	$name = $_POST["name"];
	$surname = $_POST["surname"];
	$phone = $_POST["phone"];

    $date_order = $_POST["date_order"];
    $outside = $_POST["outside"];
	$room = $_POST["room"];
	$house = $_POST["house"];

    $ID_area = $_POST["area_select"];
    $ID=$row_info["ID"];
	$date = date('Y-m-d H:i:s');

    $address= $outside." ".$house."/".$room;
	
    $user = $surname." ".$name;

	$result_order=mysqli_query($link, "SELECT MAX(`code`) FROM `orders`");
    $row_order=mysqli_fetch_array($result_order);
    $code = $row_order[0] + 1;

	$result_carts=mysqli_query($link, "SELECT * FROM `carts` WHERE ID_user='$ID'");	

	while ($row_carts=mysqli_fetch_assoc($result_carts)) {
        $ID_product = $row_carts['ID_product'];
        
        $count = $row_carts['count'];
        
        if ($ID_area != '') {
            $query_add_order="INSERT INTO orders(ID_user, ID_product, ID_area, user, phone, `address`, `count`, date_order, delivery_date, ID_status, way, `code`) VALUES ($ID, $ID_product, $ID_area, '$user', '$phone', '$address', '$count', '$date', '$date_order', 1, 'Курьер', '$code')";       
        }
	    else  $query_add_order="INSERT INTO orders(ID_user, ID_product, user, phone, `count`, date_order, ID_status, way, `code`) VALUES ($ID, $ID_product, '$user', '$phone', '$count', '$date', 1, 'Самовывоз', '$code')";       

        if (mysqli_query($link, $query_add_order)) {
            $result_product=mysqli_query($link, "SELECT `count` FROM `products` WHERE ID='$ID_product'");
            $row_product=mysqli_fetch_assoc($result_product);
            $count_product = $row_product["count"] - $count;
  
            $query_update_count="UPDATE products SET `count`='$count_product' WHERE ID='$ID_product'";
            $query_delete_carts="DELETE FROM `carts` WHERE ID_user='$ID'";
            if(mysqli_query($link, $query_update_count) && (mysqli_query($link, $query_delete_carts))) {
                header("Location: my-orders.php?page=1");      
            }  
        }  
	}
    
} ?>	
<script>

    function select_area() {
        var servResponse = document.querySelector('#price_area');

        var price = Number(document.getElementById("price").value);       
        var ID_area = document.getElementById("area_select").value;
        var date_order = document.getElementById("date_order").value;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-post-area.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                servResponse.textContent = xhr.responseText;
                var text = servResponse.textContent; 

                document.getElementById("outside").required = true;
                document.getElementById("room").required = true;
                document.getElementById("house").required = true;
                document.getElementById("date_order").required = true;
                document.getElementById("price_area").innerText = "Стоимость доставки в Ваш район составит " + text + " руб.";
                document.getElementById("totalPriceAll").innerText=Number(price)+Number(text);
            }
        }

        xhr.send(`&ID_area=${ID_area}`);
    }

    function select_date() {
        var date_order = document.getElementById("date_order").value;

        Data = new Date(date_order);

        Year = Data.getFullYear();
        Month = Data.getMonth() + 1;
        Day = Data.getDate();

        if(Month < 10) {
            Month = ('0' + Month).slice(-2);
        }
        if(Day < 10) {
            Day = ('0' + Day).slice(-2);
        }

        document.getElementById("price_area_text").innerText = "Ваш заказ будет доставлен " + Day + "."  + Month + "." + Year + " с 16:00 до 20:00";
    }
</script>
<?php 
include_once("footer.php"); 
ob_end_flush();
?>
