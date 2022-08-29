<?php ob_start();
include_once("menu.php"); 
include_once("link.php");
include_once("check-buy.php");
include_once("menu-area.php");
$token=$_COOKIE['cookieToken']; ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>PhoneSet - мои заказы</title>	   
        <link rel="stylesheet" href="https://itchief.ru/examples/libs/chief-slider/chief-slider.min.css">
        <script defer src="https://itchief.ru/examples/libs/chief-slider/chief-slider.min.js"></script>
        
        <link rel="stylesheet" href="css/my-orders.css">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const slider = new ChiefSlider('.slider', {
                    loop: false
                });
            });
        </script>
    </head>
	<body class="body">
        <main>
            <div class="main-product">
                <div class="products">
                    <p class="title-area">Заказанные товары</p><br>
                    <?php if (!empty($token)) { 
                        $query_info="SELECT ID FROM `users` WHERE token='$token'";	
                        $result_info=mysqli_query($link, $query_info);
                        $row_info=mysqli_fetch_assoc($result_info); 
                        $ID = $row_info["ID"];

                        $num = 3;   // Переменная хранит число сообщений выводимых на станице
                        $i = array();
                        $page = $_GET['page'];  // Извлекаем из URL текущую страницу
                        $query_count = "SELECT DISTINCT `code` FROM `orders` WHERE ID_user='$ID'"; // Определяем общее число сообщений в базе данных

                        $result_count = mysqli_query($link, $query_count); 
                        $posts_count = mysqli_num_rows($result_count);
                        
                        $total = intval(($posts_count - 1) / $num) + 1;   // Находим общее число страниц     

                        $page = intval($page);  // Определяем начало сообщений для текущей страницы                 
                        if(empty($page) or $page < 0) $page = 1;
                        if($page > $total) $page = $total;
                       
                        $start = $page * $num - $num; // Вычисляем начиная к какого номера следует выводить сообщения
                        
                        $query_all = "SELECT DISTINCT `code`, date_order FROM `orders` WHERE ID_user='$ID' ORDER BY date_order DESC LIMIT $start, $num ";
                        if(mysqli_query($link, $query_all)) {
                            $result_all = mysqli_query($link, $query_all); 
                            if(mysqli_num_rows($result_all) != 0) {     
                            while ($postrow = mysqli_fetch_assoc($result_all)) { 
                                $d = $d + 1; ?>
                                <div class="product-cart <? if (($start == $posts_count-1) || ($start+$d == $posts_count) || ($start == $posts_count)) { ?> last <? } ?>">
                                    <a class="link-cart row" href="order.php?code=<? echo $postrow["code"]; ?>">
                                        <? $count = 0;
                                        $product_code = $postrow['code'];
                                        $query_count = "SELECT COUNT(1) FROM `orders` WHERE ID_user='$ID' AND `code`='$product_code'";
                                        $result_count = mysqli_query($link, $query_count); 
                                        $row_one = mysqli_fetch_array($result_count);
                                        $count_product = $row_one[0]; ?>

                                        <? if ($count_product >= 2) { ?> <div class="col-sm"> <? } 
                                        $query_one = "SELECT * FROM `orders` WHERE ID_user='$ID' AND `code`='$product_code'";
                                        $result_one = mysqli_query($link, $query_one); 
                                        $i = 0;
                                        $k = 0; 
                                        while ($row_one = mysqli_fetch_assoc($result_one)) {
                                            $i = $i + 1;
                                           
                                            if(!empty($row_one["ID_area"])) {
                                                $area = $row_one["ID_area"];
                                                $result_area=mysqli_query($link, "SELECT * FROM `areas` WHERE ID='$area'");
                                                $row_area = mysqli_fetch_assoc($result_area);
                                                $price_area = $row_area["price"];
                                            }
                                            else $price_area=0;

                                            $product = $row_one['ID_product'];
                                            $result=mysqli_query($link, "SELECT * FROM `products` WHERE ID='$product'");
                                            $row=mysqli_fetch_assoc($result);

                                            $ID_group = $row["ID_group"]; 
                                            $result_group=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group'");
                                            $row_group=mysqli_fetch_assoc($result_group); 

                                            $ID_model = $row_group['ID_model'];
                                            $result_model=mysqli_query($link, "SELECT ID_brand, model FROM `models` WHERE ID='$ID_model'");
                                            $row_model=mysqli_fetch_assoc($result_model);
                                                    
                                            $ID_brand = $row_model["ID_brand"];
                                            $result_brand=mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand'");
                                            $row_brand=mysqli_fetch_assoc($result_brand); 
                                            
                                            $ID_product=$row['ID'];
                                            $date = '0000-00-00 00:00:00';
                                                $query_price="SELECT * FROM `prices` WHERE ID_product='$ID_product'";
                                                $result_price=mysqli_query($link, $query_price);
                                                while($row_price=mysqli_fetch_assoc($result_price)) {
                                                    if (($row_price['date'] > $date) && !($row_price['date'] > $row_one['date_order'])) {
                                                        $date = $row_price['date'];
                                                        $price = $row_price['price'];
                                                    }
                                                } 
                                            
                                            $result_image=mysqli_query($link, "SELECT `image` FROM `images` WHERE ID_group='$ID_group' ORDER BY ID_group DESC");
                                            $row_image=mysqli_fetch_assoc($result_image); ?>
                                            
                                            <? if ($count_product == 1) { ?> <div class="col-sm"> <? } ?>
                                            <? if (($i == 1) && ($i != $count_product)) { ?>
                                                <div class="container">
                                                    <div class="slider">
                                                        <div class="slider__wrapper">
                                                            <div class="slider__items"><? } 
                                                                $k = $k + 1; ?>   
                                                                <div class="slider__item"><img src="data:image/jpeg;base64, <? echo base64_encode( $row_image['image'] ) ?>"></div>
                                                                <? if (($i == $count_product) && ($count_product != 1)) { ?> 
                                                            </div>
                                                        </div>                                                                                         
                                                    </div> 
                                                </div>                
                                            <? } ?>
                                            <? 
                                            $result_date = mysqli_query($link, "SELECT * FROM `orders` WHERE code='$product_code'"); 
                                            $row_date = mysqli_fetch_assoc($result_date);
                                            $date_order = $row_date['date_order'];

                                            $total_price = $price * $row_one['count'] + $price_area;                                                
                                            $count = $count + $row_one['count'];
                                            $ID_status = $row_one['ID_status'];
                                            $way = $row_one['way']; ?>                   
                                        <? } ?>     
                                        </div>                                 
                                        <div class="col-sm">                 
                                            <div class="product-bottom-details justify-content-between">       
                                                <? $result_status=mysqli_query($link, "SELECT color, `name` FROM `status` WHERE ID='$ID_status'");
                                                $row_status=mysqli_fetch_assoc($result_status); 
                                                $status = $row_status["name"];?>
                                                
                                                <p class="price-product"><span class="status" style="background-color: <? echo $row_status['color']; ?>"><? echo $status; ?></span></p> 
                                                <? ?> 
                                                <p class="price-product"><? echo "Дата заказа: ".date("d.m.Y", strtotime($date_order)); ?> </p>  
                                                <p class="price-product"><? echo "Количество: ".$count." шт" ?></p>
                                                <p class="price-product"><? echo "Итоговая сумма заказа: ".$total_price?></p>   
                                                <? $new_date = date("Y-m-d", strtotime($date_order.'+ 2 days')); 
                                                $new_date_2 = date("Y-m-d", strtotime($date_order.'+ 7 days'));  ?>
                                                <? if ($way == "Курьер") { 
                                                    if ($new_date >= date("Y-m-d")) { ?>
                                                        <p class="price-product"><? echo "Заказ будет доставлен ".date("d.m.Y", strtotime($new_date))." с 16:00 до 20:00" ?></p>
                                                    <? }
                                                } 
                                                else { 
                                                    if ($new_date_2 >= date("Y-m-d")) { ?>
                                                        <p class="price-product"><? echo "Заказ хранится в магазине до ".date("d.m.Y", strtotime($new_date_2)) ?></p>  
                                                    <? }
                                                } ?>
                                                                                    
                                            </div>
                                        </div>
                                    </a>   
                                </div>                  
                            <? } 
                            }
                            else { ?> 
                                <div class="not-result-two">
                                    <p class="text-not-result-two">У Вас нет заказов</p>
                                </div>  
                            <? } 
                        } ?>
                        <? if($posts_count >= $num) { ?>
                            <div class="pagination-block">
                            <? if ($page != 1) $pervpage = '<a class="page" href=my-orders.php?page=1><i class="bi bi-chevron-double-left"></i></a>
                                                            <a class="page" href=my-orders.php?page='. ($page - 1) .'><i class="bi bi-chevron-left"></i></a> ';
                                // Проверяем нужны ли стрелки вперед
                                if ($page != $total) $nextpage = ' <a class="page" href=my-orders.php?page='. ($page + 1) .'><i class="bi bi-chevron-right"></i></a>
                                                                <a class="page" href=my-orders.php?page=' .$total. '><i class="bi bi-chevron-double-right"></i></a>';
                                
                                // Находим две ближайшие станицы с обоих краев, если они есть
                                if($page - 2 > 0) $page2left = ' <a class="page " href=my-orders.php?page='. ($page - 2) .'>'. ($page - 2) .'</a>';
                                if($page - 1 > 0) $page1left = '<a class="page" href=my-orders.php?page='. ($page - 1) .'>'. ($page - 1) .'</a>';
                                if($page + 2 <= $total) $page2right = '<a class="page" href=my-orders.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>';
                                if($page + 1 <= $total) $page1right = '<a class="page" href=my-orders.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>';
                                
                                
                                echo $pervpage.$page2left.$page1left.'<a class="page active">'.$page.'</a>'.$page1right.$page2right.$nextpage; // Вывод меню
                                ?>
                            <div>
                        <? } ?>
                    </div> 
                </div> 
            <? } ?>                                                             
        </main>
    </body>     
</html>

<?php 
include_once("footer.php"); 
ob_end_flush();
?>
