<?php 
	ob_start();
	include_once("menu.php"); 
	include_once("link.php");
    $ID_product = $_GET["ID"];
    $one_popularity = $_GET["popularity"];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>PhoneSet - товар</title>
        <link rel="icon" type="image/png" href="img/favicon.ico">

        <link rel="stylesheet" href="https://itchief.ru/examples/libs/simple-adaptive-slider/simple-adaptive-slider.min.css">

        <script defer src="https://itchief.ru/examples/libs/simple-adaptive-slider/simple-adaptive-slider.dev.min.js"></script>

  		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  		<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="css/product.css">
    </head>
	<body>
        <? $token = $_COOKIE['cookieToken'];

        $query_info="SELECT * FROM `products` WHERE ID='$ID_product'";	
        $result_info=mysqli_query($link, $query_info);
        $row_info=mysqli_fetch_assoc($result_info); 
        if($one_popularity == 1) {
            $more_popularity = $row_info["popularity"] + 1;
            $query_popularity="UPDATE products SET popularity='$more_popularity' WHERE ID='$ID_product'";
            if(mysqli_query($link, $query_popularity)) {
                header("Location: product.php?ID=".$ID_product);
            }     
        } ?>
        
        <div class="main-product">
            <div class="block-product">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-product container">
                        <div class="row">
                            <? $ID_group = $row_info["ID_group"];
                            $result_group=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group'");
                            $row_group=mysqli_fetch_assoc($result_group); 

                            $ID_model = $row_group['ID_model'];
                            $result_model=mysqli_query($link, "SELECT * FROM `models` WHERE ID='$ID_model'");
                            $row_model=mysqli_fetch_assoc($result_model);  
                                
                            $ID_brand = $row_model['ID_brand'];
                            $result_brand=mysqli_query($link, "SELECT brand, `image` FROM `brands` WHERE ID='$ID_brand'");
                            $row_brand=mysqli_fetch_assoc($result_brand); 

                            $ID_color = $row_group['ID_color'];
                            $result_color=mysqli_query($link, "SELECT `name` FROM `colors` WHERE ID='$ID_color'");
                            $row_color=mysqli_fetch_assoc($result_color);

                            $date = '0000-00-00';
                            $result_price=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product'");
                            while($row_price=mysqli_fetch_assoc($result_price)) {
                                if ($row_price['date'] > $date) {
                                    $date = $row_price['date'];
                                    $price = $row_price['price'];
                                }
                            }

                            $result_user=mysqli_query($link, "SELECT * FROM `users` WHERE token='$token'");
                            $row_user=mysqli_fetch_assoc($result_user);
                            $ID_user = $row_user["ID"];

                            $result_cart=mysqli_query($link, "SELECT ID FROM `carts` WHERE ID_product='$ID_product' and ID_user='$ID_user'");
                            $row_cart=mysqli_fetch_assoc($result_cart);

                            $result_favorite=mysqli_query($link, "SELECT ID FROM `favorites` WHERE ID_product='$ID_product' and ID_user='$ID_user'");
                            $row_favorite=mysqli_fetch_assoc($result_favorite);?>

                            <p class="title-product"><? echo $row_brand['brand']." ".$row_model['model']." ".$row_info['memory']." ГБ ".$row_color['name']?></p><br>
                            <div class="col-sm content-product one">
 
                                <div class="slider__container">
                                    <div class="slider">
                                        <div class="slider__wrapper">
                                            <div class="slider__items">
                                                <? $result_image=mysqli_query($link, "SELECT * FROM `images` WHERE ID_group='$ID_group'"); 
                                                while($row_image=mysqli_fetch_assoc($result_image)) {  ?>                               
                                                    <div class="slider__item">
                                                        <img src="data:image/jpeg;base64, <? echo base64_encode( $row_image['image'] ) ?>" loading="lazy">
                                                    </div>
                                                <? } 
                                                if(!empty($row_model['video'])) { ?>
                                                    <div class="slider__item">
                                                        <iframe class="video" src="http://www.youtube.com/embed/<? echo $row_model['video'] ?>" frameborder="0" allowfullscreen loading="lazy"></iframe>
                                                    </div>
                                                <? } ?> 
                                            </div>
                                        </div>    
                                    </div><br>
                                    <div class="slider__thumbnails">
                                        <? $i = 0;
                                        $result_image=mysqli_query($link, "SELECT * FROM `images` WHERE ID_group='$ID_group'"); 
                                        while($row_image=mysqli_fetch_assoc($result_image)) {  ?>                               
                                            <img class="slider__thumbnails-item" data-slide-to="<? echo $i ?>" src="data:image/jpeg;base64, <? echo base64_encode( $row_image['image'] ) ?>" loading="lazy">
                                        <? $i = $i + 1; 
                                        } 
                                        if(!empty($row_model['video'])) { ?>
                                            <img class="slider__thumbnails-item videoplay" data-slide-to="<? echo $i ?>" src="img/videoplay.jpg" loading="lazy">
                                        <? } ?>
                                    </div>
                                </div> 
                            <p class="small-text">Код товара: <? echo str_pad($row_info['code'], 6, '0', STR_PAD_LEFT); ?></p>
                            </div>

                            <div class="col-sm content-product two">
                                <div class="block-price">
                                    <? if ($row_info['count'] > 0) { ?>
                                        <? if ($row_info['discount'] != "") {
                                            if ($row_info['date_discount'] <= date("Y-m-d")) {
                                                $discount = ceil($price - ($price / 100 * $row_info['discount']));   
                                                $price = number_format($price, 0, '', ' ');
                                                $discount = number_format($discount, 0, '', ' ');?> 
                                                <span class="price-product"><? echo $discount ?></span><span class="price-product-small"> ₽</span>
                                                <span class="old-price"><? echo $price. " ₽"; ?></span>
                                            <? }
                                            else { 
                                                $price = number_format($price, 0, '', ' '); ?> 
                                                <span class="price-product"><? echo $price?></span><span class="price-product-small"> ₽</span> 
                                            <? } ?>
                                        <? }
                                        else { 
                                            $price = number_format($price, 0, '', ' '); ?> 
                                            <span class="price-product"><? echo $price?></span><span class="price-product-small"> ₽</span> 
                                        <? }  
                                    } 
                                    else { ?> <p class="count-product">Товара нет в наличии</p> <?php } ?>
                                    
                                    <div class="color-center">
                                        <p class="title-product-select">Цвет</p>
                                        <?  $code = $row_info['code'];
                                            
                                            $colors=array();
                                            $products=array();
                                            $query_product="SELECT * FROM `products` WHERE code='$code'";
                                            $result_product=mysqli_query($link, $query_product);
                                            while($row_product=mysqli_fetch_assoc($result_product)) { 
                                                if (!in_array($row_product['ID_group'], $colors)) {

                                                    $ID_group_two = $row_product['ID_group'];
                                                    $result_group_two=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_two'");
                                                    $row_group_two=mysqli_fetch_assoc($result_group_two); 

                                                    $ID_color_two = $row_group_two["ID_color"];	
                                                    $result_color_two=mysqli_query($link, "SELECT code FROM `colors` WHERE ID='$ID_color_two'");
                                                    $row_color_two=mysqli_fetch_assoc($result_color_two); ?>

                                                    <div class="colors_product">      
                                                        <? if ($row_product['ID_group'] == $row_info['ID_group']) { ?>
                                                            <? if (!$row_product['count'] <= 0) { ?>
                                                                <a href="product.php?ID=<? echo $row_product['ID']; ?>" class="color_product active_color" style="background-color:<? echo $row_color_two['code']?>;"></a>
                                                                <? $colors[] = $row_product['ID_group'];                                                          
                                                            }
                                                            else { ?>
                                                                <a href="product.php?ID=<? echo $row_product['ID']; ?>" class="color_product active_color" style="background-color:<? echo $row_color_two['code']?>;"></a>
                                                                <? $colors[] = $row_product['ID_group'];   
                                                            }
                                                        }
                                                        else { ?>
                                                            <a href="product.php?ID=<? echo $row_product['ID']; ?>" class="color_product" style="background-color:<? echo $row_color_two['code']?>;"></a>
                                                            <? $colors[] = $row_product['ID_group'];
                                                        } ?>
                                                    </div> 
                                                <? } 
                                            } ?>           
                                        <br>
                                    </div>    
                                    
                                    <p class="title-product-select">Память</p>
                                    <? $ID_group = $row_info["ID_group"];

                                        $query_product="SELECT ID, memory FROM `products` WHERE ID_group='$ID_group' ORDER BY memory";
                                        $result_product=mysqli_query($link, $query_product);
                                        while($row_product=mysqli_fetch_assoc($result_product)) { ?>
                                            <div class="memories_product"> 
                                                <? if ($row_product['ID'] == $ID_product) { ?>
                                                    <a href="product.php?ID=<? echo $row_product['ID']; ?>" class="memory_product active_memory"><? echo $row_product['memory'] ?></a>
                                                <? }
                                                else { ?>
                                                    <a href="product.php?ID=<? echo $row_product['ID']; ?>" class="memory_product"><? echo $row_product['memory'] ?></a>
                                                <? } ?>
                                            </div>
                                        <? } ?>    
                                    <br><br>
                                    <? if ($row_info['count'] != 0) {
                                        if(($row_user["ID_right"] == "4") || (empty($token))) { ?>
                                            <div class="block-buy"> 
                                                <? if($row_cart["ID"] == '') { ?>
                                                    <input class="btn-product" type="submit" name="buy" value="В корзину">
                                                <? }                                   
                                                else { ?>
                                                    <input class="btn-product-afore" data-bs-target="#modal-cart" data-bs-toggle="modal" type="button" value="В корзине">
                                                <? } ?>
                                                <? if($row_favorite["ID"] == '') { ?>
                                                    <button class="btn-product favorite" type="submit" id="favorite" name="favorite">
                                                        <i class="bi bi-suit-heart"></i>
                                                    </button> 
                                                <? }                                   
                                                else { ?>
                                                    <button class="btn-product-afore favorite" type="submit" id="delete_favorite" name="delete_favorite">
                                                        <i class="bi bi-suit-heart-fill"></i>
                                                    </button> 
                                                <? } ?>                                        	
                                            </div><br>
                                        <? }   
                                        if ($row_info['count'] <= 10) { ?>
                                            <p class="count-product">Осталось: <? echo $row_info['count'] ?>. Успейте купить!</p>
                                        <? } 
                                    }?>  
                                    <? if ($row_info['status'] == "В продаже") { ?>
                                        <div class="way">
                                            <div class="pickup">
                                                Самовывоз:<br>
                                                <? $today = date("d.m.Y");
                                                $clock = date("H:i:s");  
                                                if ($clock <= '20:00:00') {
                                                    echo "сeгодня (".$today. ")"; 
                                                } 
                                                else {
                                                    $date_delivery = date("d.m.Y", strtotime($today.'+ 1 days')); 
                                                    echo "завтра (".$date_delivery. ")"; 
                                                }?>
                                                
                                            </div> 
                                            <div class="delivery">
                                                Доставка на дом:<br>
                                                <? $today = date("d.m.Y");
                                                $day = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));
                                                if($day == 6) {
                                                    $date_delivery = date("d.m.Y", strtotime($today.'+ 2 days')); 
                                                    echo "послезавтра (".$date_delivery. ")";
                                                }
                                                else {
                                                    $clock = date("H:i:s");  
                                                    if ($clock <= '20:00:00') {
                                                        $date_delivery = date("d.m.Y", strtotime($today.'+ 1 days')); 
                                                        echo "завтра (".$date_delivery. ")"; 
                                                    } 
                                                    else {
                                                        $date_delivery = date("d.m.Y", strtotime($today.'+ 2 days')); 
                                                        if($day == 5) {
                                                            $date_delivery = date("d.m.Y", strtotime($today.'+ 3 days')); 
                                                            echo $date_delivery; 
                                                        }
                                                        else echo "послезавтра (".$date_delivery. ")"; 
                                                        
                                                    }
                                                } ?>
                                            </div> 
                                        </div> 
                                    <? } ?>    
                                </div><br>   
                                <div class="block-spec">
                                    <? $ID_product_spec=$row_info['ID_specification'];
                                    $query_spec="SELECT * FROM `specifications` WHERE ID='$ID_product_spec'";	
                                    $result_spec=mysqli_query($link, $query_spec);
                                    $row_spec=mysqli_fetch_assoc($result_spec); ?>
                                    <span class="spes_product"><? echo $row_spec['OS_version']. ", ".$row_spec['RAM']. " ГБ, ".$row_spec['count_sim']. " SIM, "
                                    .$row_spec['battery']. " ".$row_spec['size_battery']. ", ".$row_spec['screen_resolution']. ", ".$row_spec['wire_type']. " " ?>
                                    <a class="a-spec" href="#spec">подробнее</a></span>
                                    <img class="img-logo" src="data:image/jpeg;base64, <? echo base64_encode( $row_brand['image'] ) ?>"><br>
                                </div><br>
                                
                            </div>


                            <div class="content-info">
                                <div class="block-info">                                                                   
                                    <p id="spec" class="specifications">Характеристики</p>
                                    
                                    <? $mod10  = $row_spec['guarantee'] % 10;
                                    $mod100 = $row_spec['guarantee'] % 100; ?>
                                    <table class="specifications-table">
                                        <tbody class="specifications-body">
                                            <th class="one-th" colspan="2">Общие данные</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Гарантия</td>
                                                <td><?if ($mod10 == 1 && $mod100 != 11) {?>
                                                    <? echo $row_spec['guarantee'] ?> месяц<?
                                                    } 
                                                    else if (($mod10 > 1 && $mod10 < 5) && ($mod100 < 12 || $mod100 > 14)) {
                                                        ?><? echo $row_spec['guarantee'] ?> месяцa<?
                                                    } 
                                                    else if ($mod10 == 0 || ($mod10 > 4 && $mod10 < 10) || ($mod100 > 10 && $mod100 < 15)) {
                                                        if ($row_spec['guarantee'] == 0) {
                                                            ?>На устройство нет гарантии<?
                                                        }
                                                        else if ($row_spec['guarantee'] > 0) {
                                                            ?><? echo $row_spec['guarantee'] ?> месяцев<?
                                                        }
                                                    } ?>
                                                </td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Страна производитель</td>
                                                <td><? $result_country=mysqli_query($link, "SELECT ID_country, year_release FROM `models` WHERE ID='$ID_model'");
                                                $row_country=mysqli_fetch_assoc($result_country); 
                                                $ID_country = $row_country["ID_country"];

                                                $result_name_country=mysqli_query($link, "SELECT country FROM `countries` WHERE ID='$ID_country'");
                                                $row_name_country=mysqli_fetch_assoc($result_name_country); 
                                                echo $row_name_country['country']; ?>
                                                </td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Год релиза</td>
                                                <td><? $result_model=mysqli_query($link, "SELECT year_release FROM `models` WHERE ID='$ID_model'");
                                                $row_model=mysqli_fetch_assoc($result_model); 
                                                echo $row_model['year_release']; ?>
                                                </td>
                                            </tr>


                                            <th class="one-th" colspan="2">Внешний вид</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Цвет корпуса</td>
                                                <td><? $result_color=mysqli_query($link, "SELECT `name` FROM `colors` WHERE ID='$ID_color'");
                                                $row_color=mysqli_fetch_assoc($result_color); 
                                                echo $row_color["name"] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Материал корпуса</td>
                                                <td><? echo $row_spec['body_material'] ?></td>
                                            </tr>

                                            <th class="one-th" colspan="2">Экран</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Диагональ экрана</td>
                                                <td><? echo $row_spec['screen_diagonal']. "''" ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Разрешение экрана</td>
                                                <td><? echo $row_spec['screen_resolution'] ?></td>
                                            </tr>


                                            <th class="one-th" colspan="2">Система</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Операционная система</td>
                                                <td><? echo $row_spec['OS_version'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Модель процессора</td>
                                                <td><? echo $row_spec['processor_model'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Количество ядер процессора</td>
                                                <td><? echo $row_spec['count_cores'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Оперативная память</td>
                                                <td><? echo $row_spec['RAM']. " ГБ"?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Втроенная память</td>
                                                <td><? echo $row_info['memory']. " ГБ" ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Карта памяти</td>
                                                <td><? echo $row_spec['type_cards'] ?></td>
                                            </tr>


                                            <th class="one-th" colspan="2">Мобильная связь</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Количество сим-карт</td>
                                                <td><? echo $row_spec['count_sim']. " шт" ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Формат сим-карт</td>
                                                <td><? echo $row_spec['sim_format'] ?></td>
                                            </tr>
                                                

                                            <th class="one-th" colspan="2">Камеры</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Количество основных камер</td>
                                                <td><? echo $row_spec['count_cameras']. " шт" ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Количество мегапикселей основной камеры</td>
                                                <td><? echo $row_spec['main_camera']. " Мп" ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Количество мегапикселей фронтальной камеры</td>
                                                <td><? echo $row_spec['front_camera']. " Мп" ?></td>
                                            </tr>


                                            <th class="one-th" colspan="2">Питание</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Акккумулятор</td>
                                                <td><? echo $row_spec['battery'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Емкость аккумулятора</td>
                                                <td><? echo $row_spec['size_battery'] ?></td>
                                            </tr>
                                            
                                            
                                            <th class="one-th" colspan="2">Дополнительная информация</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Bluetooth</td>
                                                <td><? echo $row_spec['Bluetooth'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Wi-fi</td>
                                                <td><? echo $row_spec['Wi_fi'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">NFS</td>
                                                <td><? echo $row_spec['NFS'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Тип разъема</td>
                                                <td><? echo $row_spec['wire_type'] ?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Комплектация</td>
                                                <td><? echo $row_spec['equipment'] ?></td>
                                            </tr>

                                            <th class="one-th" colspan="2">Габариты и вес</th>
                                            <tr class="one-tr">
                                                <td class="one-td">Ширина</td>
                                                <td><? echo $row_spec['width']." мм"?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Высота</td>
                                                <td><? echo $row_spec['height']." мм"?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Толщина</td>
                                                <td><? echo $row_spec['thickness']." мм"?></td>
                                            </tr>
                                            <tr class="one-tr">
                                                <td class="one-td">Вес</td>
                                                <td><? echo $row_spec['weight']." гр" ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>  
                            </div>							
                        </div>
                    </div>
                </form>				  
            </div>
        </div>	
        <? 
        if (isset($_POST["buy"])) {                       
            if (!empty($token)) { 
                $query_user = "SELECT ID FROM `users` WHERE token='$token'";
                $result_user=mysqli_query($link, $query_user);
                $row_user=mysqli_fetch_assoc($result_user); 

                $ID_user = $row_user["ID"];

                $date = date('Y-m-d H:i:s');

                $query_buy="INSERT INTO carts(ID_user, ID_product, `date_cart`) VALUE ('$ID_user', '$ID_product', '$date')";
                if(mysqli_query($link, $query_buy)) {
                    header("Location: product.php?ID=".$ID_product);
                }
                else echo "Ошибка"; 
            }     
            else header("Location: autorization.php?error=1");
        }
        	
        if (isset($_POST["favorite"])) {                       
            if (!empty($token)) {  

                $date = date('Y-m-d H:i:s');

                $query_favorite="INSERT INTO favorites(ID_user, ID_product, `date_favorite`) VALUE ('$ID_user', '$ID_product', '$date')";
                if(mysqli_query($link, $query_favorite)) {
                    header("Location: product.php?ID=".$ID_product);
                }
                else echo "Ошибка"; 
            }     
            else header("Location: autorization.php?error=1");
        } 

        if (isset($_POST["delete_favorite"])) {                       
            if (!empty($token)) {  

                $query_delete_favorite="DELETE FROM `favorites` WHERE ID_user='$ID_user' and ID_product='$ID_product'";
                if(mysqli_query($link, $query_delete_favorite)) {
                    header("Location: product.php?ID=".$ID_product);
                }
                else echo "Ошибка"; 
            }     
            else header("Location: autorization.php?error=1");
        } ?>		
    </body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var slider = new SimpleAdaptiveSlider('.slider', {
        loop: true,
        autoplay: false,
        swipe: true
    });
    var thumbnailsItem = document.querySelectorAll('.slider__thumbnails-item');
    function setActiveThumbnail() {
        var sliderItemActive = document.querySelector('.slider__item_active');
        var index = parseInt(sliderItemActive.dataset.index);
        for (var i = 0, length = thumbnailsItem.length; i < length; i++) {
        if (i !== index) {
            thumbnailsItem[i].classList.remove('active');
        } else {
            thumbnailsItem[index].classList.add('active');
        }
        }
    }
    setActiveThumbnail();
    document.querySelector('.slider').addEventListener('slider.set.active', setActiveThumbnail);
    var sliderThumbnails = document.querySelector('.slider__thumbnails');
    sliderThumbnails.addEventListener('click', function(e) {
        $target = e.target.closest('.slider__thumbnails-item');
        if (!$target) {
        return;
        }
        var index = parseInt($target.dataset.slideTo, 10);
        slider.moveTo(index);
    });
    });
</script>
<?php 
    include_once("footer.php"); 
    ob_end_flush();
?>
