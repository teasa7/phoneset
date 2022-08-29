<?php 
    include_once("link.php");
    include_once("menu.php"); 
    $token=$_COOKIE['cookieToken'];
    if ($_POST["check-hidden"] != 1) {
        $brand=$_POST["brand_select"];
        $model=$_POST["model_select"];
        $price_from=$_POST["price_from"];
        $price_to=$_POST["price_to"];
        $colors_product=$_POST["colors"];
        $memory_product=$_POST["memory"];
        $year_product=$_POST["years"];
        $discount=$_POST["discount"];;
    } 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>PhoneSet</title>
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body class="body">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

    <div class="main">
        <div class="filtration" id="block_filtration"> 
            <input type="hidden" name="hidden_brand" id="hidden_brand">
            <input type="hidden" name="hidden_model" id="hidden_model">      
            <form name="form" method="post" id="filtration">
                <input type='hidden' name="check-hidden" id="check-hidden" value="">
                <div class="block-filtration">
                    <p class="text">Бренд</p>
                    <select class="input-product options" name="brand_select" id="brand_select" onchange="select_model()">
                        <option class="options" disabled selected>Выберите бренд</option>  
                        <? $query_brand = "SELECT brand FROM `brands`";
                        $result_brand = mysqli_query($link, $query_brand);
                        while ($row_brand = mysqli_fetch_assoc($result_brand)) { ?>
                            <? if($brand == $row_brand['brand']) { ?>
                                <option class="options" value="<? echo $row_brand['brand'] ?>" selected>
                                    <? echo $row_brand['brand'] ?>
                                </option>  
                            <? }
                            else { ?>
                                <option class="options" value="<? echo $row_brand['brand'] ?>">
                                    <? echo $row_brand['brand'] ?>
                                </option>
                            <? }
                        } ?>
                    </select>
                </div><br>

                <div class="block-filtration">
                    <p class="text">Модель</p>
                    <select class="input-product options" id="model_select" name="model_select" onchange="hidden_model()">
                        <option class="options" disabled selected>Выберите модель</option>
                    </select><br>
                </div>

            <? $query_max_price = "SELECT MAX(price) AS 'max_price' FROM `prices`";
            $result_max_price = mysqli_query($link, $query_max_price);
            $row_max_price = mysqli_fetch_assoc($result_max_price); ?>
            <div class="block-filtration">
                <p class="text">Цена</p>
                <div class="block-price">
                    <input class="input-price" type="number" name="price_from" placeholder="от" min="0" value="<? echo $price_from; ?>">
                    <input class="input-price" type="number" name="price_to" placeholder="до" min="0" value="<? echo $price_to; ?>">
                </div>
            </div><br>

            <div class="block-filtration-discount">
                <p class="text">Акция</p>
                <label class="input-check"><input type="checkbox" class="form-check-input" name="discount" id="discount" value="Скидки" <? if($discount) { ?> checked <? } ?>>
                Скидки</label>
            </div>

            <div class="block-filtration">
                <p class="text">Цвет</p> 
                <ul class="list-group" id="scroll">
                    <? $colors_check = array();
                    $count=count($colors_product);
                    for($j = 0; $j <= $count; $j++) {
                        $one= $colors_product[$j];
                        if (!in_array($one, $colors_check)) { 
                            $colors_check[]=$one;
                        }
                    }
                    $i = 1; 
                    $query_color = "SELECT DISTINCT `name` FROM `colors`";
                    $result_color = mysqli_query($link, $query_color);
                    while ($row_color = mysqli_fetch_assoc($result_color)) { ?>
                        <li class="list-group-item input-product colors">
                            <label class="input-check-2"><input class="form-check-input me-1" type="checkbox" name="colors[]" value="<? echo $row_color["name"] ?>" 
                            <? if (in_array($row_color['name'], $colors_check)) { ?> checked <? } ?>><? echo $row_color["name"] ?></label>
                            <? $i = $i + 1; ?>                  
                        </li>
                    <? } ?>
                </ul>
            </div>

            <div class="block-filtration">
                <p class="text">Память</p>
                <div class="row">
                    <? $memories_selected = array();
                    $count=count($memory_product);              
                    for($j = 0; $j <= $count; $j++) {   
                        $memory_select= $memory_product[$j]; 
                        if (!in_array($memory_select, $memories_selected)) { 
                            $memories_selected[] = $memory_select;
                        }
                    } 
                    $i = 0;
                    $memory_check = array();
                    $result_count = mysqli_query($link, "SELECT memory FROM `products` ORDER BY memory ASC");
                    while($row_count = mysqli_fetch_assoc($result_count)) { 
                        $memory = $row_count["memory"];
                        if (!in_array($memory, $memory_check)) { ?>
                            <div class="col-md-6">
                                <label class="input-check-2"><input class="form-check-input" type="checkbox" name="memory[]" value="<? echo $memory; ?>" 
                                <? if (in_array($memory, $memories_selected)) { ?> checked <? } ?>> <? echo $memory; ?></label><br>
                            </div>
                            <? $memory_check[]=$memory;
                            $i = $i + 1;
                        } 
                           
                    } ?>
                </div>
            </div>

            <div class="block-filtration">
                <p class="text">Год выпуска</p>
                <div class="row">
                    <? $year = date('Y'); 
                    $year_check = array();
                    $count=count($year_product);
                    for($j = 0; $j <= $count; $j++) {
                        $two= $year_product[$j];
                        if (!in_array($two, $year_check)) { 
                            $year_check[]=$two;
                        }
                    } ?>
                    <div class="col-md-6">
                        <label class="input-check-2"><input class="form-check-input" type="checkbox" name="years[]" value="<? echo $year; ?>" 
                        <? if (in_array($year, $year_check)) { ?> checked <? } ?>> <? echo $year; ?></label><br>
                    </div>
                    <div class="col-md-6">
                        <label class="input-check-2"><input class="form-check-input" type="checkbox" name="years[]" value="<? echo $year-1; ?>" 
                        <? if (in_array($year-1, $year_check)) { ?> checked <? } ?>> <? echo $year-1; ?></label><br>
                    </div>
                    <div class="col-md-6">
                        <label class="input-check-2"><input class="form-check-input" type="checkbox" name="years[]" value="<? echo $year-2; ?>" 
                        <? if (in_array($year-2, $year_check)) { ?> checked <? } ?>> <? echo $year-2; ?></label><br>
                    </div>
                    <div class="col-md-6">
                        <label class="input-check-2"><input class="form-check-input" type="checkbox" name="years[]" value="<? echo $year-3; ?>" 
                        <? if (in_array($year-3, $year_check)) { ?> checked <? } ?>> <? echo $year-3; ?></label><br>
                    </div>
                    <div class="col-md-6">
                        <label class="input-check-2"><input class="form-check-input" type="checkbox" name="years[]" value="<? echo $year-4; ?>" 
                        <? if (in_array($year-3, $year_check)) { ?> checked <? } ?>> <? echo $year-4; ?></label><br>
                    </div> 
                </div>
            </div>
            
            <div class="button-animate bottom">
                <input class="button button-apply" type="submit" name="input" id="input" value="Применить">
                <input class="button button-reset" type="submit" name="reset" id="reset" value="Сбросить" onclick="document.getElementById('check-hidden').value='1'">
            </div>

            <?  $query_product="SELECT * FROM `products` WHERE NOT `status`='В архиве'"; //Формируется первоначальный запрос
                if(isset($_POST["input"])) {     //Если нажата кнопка "Применить"  
                    $brand=$_POST["brand_select"];  //Выбранный бренд  
                    $model=$_POST["model_select"];  //Выбранная модель
                    $query_brand = "SELECT ID FROM `brands` WHERE `brand`='$brand'";  //Запрос на поиск ID выбранного бренда
                    $result_brand = mysqli_query($link, $query_brand);
                    $row_brand = mysqli_fetch_assoc($result_brand);
                    $ID_brand = $row_brand["ID"];   //ID выбранного бренда

                    $query_product="SELECT * FROM `products` WHERE NOT `status`='В архиве'"; 
                    if((!empty($brand)) && (empty($model))) {   //Если выбран бренд, но не выбрана модель
                        $i = 0;
                        $query_model="SELECT ID FROM `models` WHERE ID_brand='$ID_brand'";    //Запрос на поиск ID всех моделей выбранного бренда
                        $result_model=mysqli_query($link, $query_model);
                        while($row_model=mysqli_fetch_assoc($result_model)) {   
                            $ID_model = $row_model["ID"]; //ID выбранной модели

                            $query_group="SELECT ID FROM `groups` WHERE ID_model='$ID_model'"; //Запрос на поиск ID всех групп с такой моделью
                            $result_group=mysqli_query($link, $query_group);
                            while($row_group=mysqli_fetch_assoc($result_group)) {
                                $ID_group = $row_group["ID"]; //ID группы
                                $i = $i + 1;
                                /* Формируется запрос */
                                if ($i == 1) {
                                    $query_product=$query_product." AND (ID_group=$ID_group";
                                }
                                else $query_product=$query_product." OR ID_group=$ID_group";  
                            } 
                        }  
                        /* Закрывается условие в итоговом запросе */
                        if($i != 0) {
                            $query_product=$query_product.") "; 
                        }
                        else $error = 1;
                    }

                    if(!empty($model)) { //Если выбран модель
                        $i = 0;
                        $query_model="SELECT ID FROM `models` WHERE ID_brand='$ID_brand' AND model='$model'"; //Запрос на поиск ID выбранной модели
                        $result_model=mysqli_query($link, $query_model);
                        $row_model=mysqli_fetch_assoc($result_model);
                        $ID_model = $row_model["ID"]; //ID выбранной модели  

                        $query_group="SELECT ID FROM `groups` WHERE ID_model='$ID_model'";    //Запрос на поиск ID всех групп с такой моделью
                        $result_group=mysqli_query($link, $query_group);
                        while($row_group=mysqli_fetch_assoc($result_group)) {
                            $ID_group = $row_group["ID"]; //ID группы
                            $i = $i + 1;
                            /* Формируется запрос */
                            if ($i == 1) {
                                $query_product=$query_product." AND (ID_group=$ID_group";
                            }
                            else $query_product=$query_product." OR ID_group=$ID_group";   
                        }  
                        /* Закрывается условие в итоговом запросе */
                        if($i != 0) {	
                            $query_product=$query_product.") ";  
                        }
                        else $error = 1;
                    }	
                    
                    if((!empty($_POST["price_from"])) || (!empty($_POST["price_to"]))) { //Если выбрано ОТ или ДО стоимости товара
                        $i = 0;
                        $result_max_price=mysqli_query($link, "SELECT MAX(price) FROM `prices`");  //Запрос на поиск максимальной стоимости
                        $row_max_price=mysqli_fetch_array($result_max_price);
                        $max_price=$row_max_price[0];

                        /* Если не выбрано значение от, то устанавливается 0 */
                        if(empty($_POST["price_from"]))	$price_from=0;
                        else $price_from=$_POST["price_from"];

                        /* Если не выбрано значение до, то устанавливается максимальная стоимость */
                        if(empty($_POST["price_to"])) $price_to=$max_price;
                        else $price_to=$_POST["price_to"];
                        
                        $ID_prices = array();
                        $price_many = array();
                        $result_product_price=mysqli_query($link, "SELECT ID, discount FROM `products`"); //Запрос на поиск скидки товара
                        while($row_product_price=mysqli_fetch_assoc($result_product_price)) {
                            $ID_product_price = $row_product_price["ID"];
                            $date = '0000-00-00';
                            
                            $result_product_date=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product_price'");  //Запрос на поиск цены товара
                            while($row_product_date=mysqli_fetch_assoc($result_product_date)) {
                                /* Поиск актуальной даты */
                                if ($row_product_date['date'] > $date) {
                                    $date = $row_product_date['date'];
                                    $ID_price = $row_product_date['ID'];
                                    $price_one = $row_product_date['price'];
                                }
                            }
                            if ($row_product_price['discount'] != "") {
                                /* Расчет стоимости с учетом скидки */
                                $discount = $price_one - ($price_one / 100 * $row_product_price['discount']);    
                            }
                            else $discount = $price_one;

                            if (!in_array($ID_price, $ID_prices)) {
                                $ID_prices[] = $ID_price;
                                $price_many[] = $discount;
                            }
                        }
                        $count=count($ID_prices); //Количество актуальных записей цен
                        for($j = 0; $j < $count; $j++) {
                            /* Запрос на поиск ОТ и ДО цен среди товаров */
                            $result_price_ID=mysqli_query($link, "SELECT ID_product FROM `prices` WHERE (ID=$ID_prices[$j]) AND ($price_many[$j] BETWEEN $price_from AND $price_to)");
                            while($row_price_ID=mysqli_fetch_assoc($result_price_ID)) {
                                $ID_price_product=$row_price_ID["ID_product"]; //ID продукта
                                $i = $i + 1;
                                /* Формируется запрос */
                                if ($i == 1) {
                                    $query_product=$query_product." AND (ID=$ID_price_product";
                                }
                                else $query_product=$query_product." OR ID=$ID_price_product";                                                
                            }       
                        }
                        /* Закрывается условие в итоговом запросе */
                        if($i != 0) {	
                            $query_product=$query_product.") ";  
                        }
                        else $error = 1;
                    }

                    $discount_product=$_POST["discount"]; //Скидка
                    if(!empty($discount_product)) { //Если выбрано "Со скидкой"
                        /* Добавление в итоговый запрос товаров со скидкой */
                        $query_product=$query_product." AND NOT discount='NULL' AND NOT discount='0'";
                    }	

                    $memory_product=$_POST["memory"]; //Память товара
                    if(!empty($memory_product)) {   //Если выбрана память товара
                        $i = 0;
                        $count=count($memory_product);  //Получаем количество выбранных значений
                        for($j = 0; $j < $count; $j++) {
                            /* Формируется запрос */
                            if ($j == 0) {
                                $query_product=$query_product." AND (memory=$memory_product[$j]";
                            }
                            else $query_product=$query_product." OR memory=$memory_product[$j]"; 
                        }
                        /* Закрывается условие в итоговом запросе */
                        if($j != 0) {	
                            $query_product=$query_product.") ";  
                        }
                        else $error = 1;
                    }

                    $year_product=$_POST["years"];  //Год выпуска
                    if(!empty($year_product)) { //Если выбран год выпуска
                        $i = 0;
                        $count=count($year_product);  //Получаем количество выбранных значений
                        for($j = 0; $j <= $count; $j++) {
                            /* Запрос на поиск моделей с выбранными годами выпуска */
                            $result_year_ID=mysqli_query($link, "SELECT ID FROM `models` WHERE `year_release`='$year_product[$j]'");
                            while($row_year_ID=mysqli_fetch_assoc($result_year_ID)) {
                                $ID_model_year_product=$row_year_ID["ID"];    //ID модели
                                
                                /* Запрос на поиск групп с такими моделями */
                                $result_group_year_ID=mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_model='$ID_model_year_product'");
                                while($row_group_year_ID=mysqli_fetch_assoc($result_group_year_ID)) {
                                    $ID_year_product=$row_group_year_ID["ID"];    //ID группы
                                    $i = $i + 1;
                                    /* Формируется запрос */
                                    if ($i == 1) {
                                        $query_product=$query_product." AND (ID_group=$ID_year_product";
                                    }
                                    else $query_product=$query_product." OR ID_group=$ID_year_product"; 
                                }
                            }
                        }
                        /* Закрывается условие в итоговом запросе */
                        if($i != 0) {	
                            $query_product=$query_product.") ";  
                        }
                        else $error = 1;
                    }	

                    $colors_product=$_POST["colors"];   //Цвет товара
                    if(!empty($colors_product)) {   //Если выбран цвет
                        $i = 0;
                        $colors = array();  
                        $count=count($colors_product); //Получаем количество выбранных значений
                        for($j = 0; $j <= $count-1; $j++) {
                            /* Запрос на поиск цвета с таким названием */
                            $result_color_ID=mysqli_query($link, "SELECT ID, `name` FROM `colors` WHERE `name`='$colors_product[$j]'");
                            while($row_color_ID=mysqli_fetch_assoc($result_color_ID)) {
                                $ID_color_product=$row_color_ID["ID"];  //ID цвета
                                /* Запрос на поиск группы с таким цветом */
                                $result_group_ID=mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_color='$ID_color_product'");
                                while($row_group_ID=mysqli_fetch_assoc($result_group_ID)) {
                                    $colors[] = $row_group_ID["ID"];    //Массив цветов
                                }
                            }
                        }
                        // var_dump($colors);
                        $count_colors=count($colors);   //Получаем количество выбранных цветов
                        for($k = 0; $k < $count_colors; $k++) {
                            $i = $i + 1;  
                            /* Формируется запрос */                                
                            if ($i == 1) {
                                $query_product=$query_product." AND (ID_group=$colors[$k]";
                            }
                            else $query_product=$query_product." OR ID_group=$colors[$k]"; 
                        }
                        /* Закрывается условие в итоговом запросе */
                        if($i != 0) {	
                            $query_product=$query_product.") ";  
                        }
                        else $error = 1;
                    }	          
                } 
                if(isset($_POST["reset"])) { 
                    $query_product="SELECT * FROM `products` WHERE NOT `status`='В архиве'";
                } 
            ?>
        </form>
    </div> 
    <form method="post" id="product">
        <? $query_info="SELECT * FROM `users` WHERE token='$token'";	
        $result_info=mysqli_query($link, $query_info);
        $row_info=mysqli_fetch_assoc($result_info); 
        $ID = $row_info["ID"]; ?> 
 
        <section class="main-content">
            <div class="container">
                <div class="row">
                    <? $codes=array(); 
                    $i = -1;
                    $query_product = $query_product." ORDER BY popularity DESC, discount DESC";
                    $result_product_filt=mysqli_query($link, $query_product);
					if((mysqli_num_rows($result_product_filt) > 0)  && ($error != 1)) {
						while($row_product_filt=mysqli_fetch_assoc($result_product_filt)) { ?>
                            <input type="hidden" value="<? echo $ID; ?>" id="IdUser" name="idUser">
                            <? if($query_product != "SELECT * FROM `products` WHERE NOT `status`='В архиве' ORDER BY popularity DESC, discount DESC") {
                                $ID_product=$row_product_filt['ID'];
                                $date = '0000-00-00';
                                $price = 0;
                                $result_price=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product'");
                                while($row_price=mysqli_fetch_assoc($result_price)) {
                                    if ($row_price['date'] > $date) {
                                        $date = $row_price['date'];
                                        $price = $row_price['price'];
                                    }
                                }

                                $ID_group = $row_product_filt["ID_group"]; 
                                $result_group=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group'");
                                $row_group=mysqli_fetch_assoc($result_group); 

                                $ID_model = $row_group['ID_model'];
                                $result_model=mysqli_query($link, "SELECT ID_brand, model FROM `models` WHERE ID='$ID_model'");
                                $row_model=mysqli_fetch_assoc($result_model);

                                $ID_brand = $row_model["ID_brand"];
                                $result_brand=mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand'");
                                $row_brand=mysqli_fetch_assoc($result_brand); 
                                
                                $result_image=mysqli_query($link, "SELECT * FROM `images` WHERE ID_group='$ID_group'");
                                $row_image=mysqli_fetch_assoc($result_image); ?>

                                <div class="col-lg-4 col-sm-6 mb-4">
                                    <div class="product-card">
                                        <div class="product-thumb">
                                            <a href="product.php?ID=<? echo $row_product_filt['ID'] ?>&popularity=1"><img id="image_product<? echo $row_product_filt['ID'];?>" src="data:image/jpeg;base64, <? echo base64_encode( $row_image['image'] ) ?>"></a>
                                        </div>

                                        <div class="product-details">
                                            <h4><a class="title-link" href="product.php?ID=<? echo $row_product_filt['ID']; ?>&popularity=1"> <?php echo $row_brand['brand']." ".$row_model['model']." "; ?><span class="small-link"><?echo $row_product_filt['memory']."ГБ "?></span></a></h4>
                                            
                                            <? 
                                            $result_cart=mysqli_query($link, "SELECT ID FROM `carts` WHERE ID_product='$ID_product' and ID_user='$ID'");
                                            $row_cart=mysqli_fetch_assoc($result_cart);
                                                
                                            $code = $row_product_filt['code'];
                                            
                                            $colors=array();
                                            
                                            $result_product=mysqli_query($link, "SELECT * FROM `products` WHERE code='$code'");
                                            while($row_product=mysqli_fetch_assoc($result_product)) { 
                                                if (!in_array($row_product['ID_group'], $colors)) { 
                                                    $ID_group_2 = $row_product['ID_group'];
                                                    $ID_product_2 = $row_product['ID'];

                                                    $result_group_2=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_2'");
                                                    $row_group_2=mysqli_fetch_assoc($result_group_2); 

                                                    $result_image_one=mysqli_query($link, "SELECT `image` FROM `images` WHERE ID_group='$ID_groupt_2'");
                                                    $row_image_one=mysqli_fetch_assoc($result_image_one); 
                                                    
                                                    $result_price=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product_2'");
                                                    while($row_price=mysqli_fetch_assoc($result_price)) {
                                                        if ($row_price['date'] > $date) {
                                                            $date = $row_price['date'];
                                                            $price = $row_price['price'];                                                           
                                                        }
                                                    }

                                                    $ID_color = $row_group_2['ID_color'];
                                                    $result_color=mysqli_query($link, "SELECT code FROM `colors` WHERE ID='$ID_color'");
                                                    $row_color=mysqli_fetch_assoc($result_color); ?>  
                                                    
                                                    <div class="colors_product">   
                                                        <a id="color_product<? echo $row_product['ID']; ?>" href="product.php?ID=<? echo $row_product['ID']; ?>&popularity=1" 
                                                        class="color_product <? if($row_product['ID'] == $row_product_filt['ID']) { ?> active_color <? }?>" style="background-color:<? echo $row_color['code']?>;"></a>                                                         
                                                        <? $colors[] = $row_product['ID_group']; ?>
                                                    </div> 
                                                <? } 
                                            } ?>
                                                                                                    
                                            <div class="product-bottom-details d-flex justify-content-between"> 
                                                <div class="product-price">
                                                    <? if ($row_product_filt['count'] > 0) {
                                                        if ($row_product_filt['discount'] != "") {
                                                            if ($row_product_filt['date_discount'] <= date("Y-m-d")) {
                                                                $new_price = round($price-($price / 100 * $row_product_filt["discount"])); 
                                                                $new_price = number_format($new_price, 0, '', ' '); 
                                                                $price = number_format($price, 0, '', ' ');?>
                                                                <snap class="bold"><? echo $new_price; ?> ₽ </span><strike><small><? echo $price; ?> ₽ </small></strike>    
                                                            <? }
                                                            else {
                                                                $price = number_format($price, 0, '', ' ');
                                                                echo $price." ₽";      
                                                            }
                                                                                                                
                                                        } 
                                                        else {    
                                                            $price = number_format($price, 0, '', ' ');
                                                            echo $price." ₽";    
                                                        } 
                                                    } 
                                                    else {    
                                                        echo "Товара нет в наличии";    
                                                    } ?>
                                                </div>

                                                    <? $result_cart=mysqli_query($link, "SELECT ID FROM `carts` WHERE ID_product='$ID_product' and ID_user='$ID'");
                                                    $row_cart=mysqli_fetch_assoc($result_cart);

                                                    $result_favorite=mysqli_query($link, "SELECT ID FROM `favorites` WHERE ID_product='$ID_product' and ID_user='$ID'");
                                                    $row_favorite=mysqli_fetch_assoc($result_favorite);?>
                                                    <? if($row_info["ID_right"] == 4) { ?>
                                                        <div class="product-icons" id="oneProduct<? echo $ID_product; ?>">                                                   
                                                            <button class="button-icons-product" id="favorite<? echo $row_favorite['ID']; ?>" onclick="check_favorite(<? echo $ID_product; ?>)">
                                                                <i id="favorite-icon<? echo $ID_product; ?>" class="<? if($row_favorite["ID"] == '') { ?>bi bi-suit-heart<? }                                   
                                                                else { ?> bi bi-suit-heart-fill <? } ?> button-icons-dark"></i>
                                                            </button> 
                                                                                            
                                                            <button class="button-icons-product" id="cart<? echo $row_cart['ID']; ?>" onclick="check_cart(<? echo $ID_product; ?>)">
                                                                <i id="cart-icon<? echo $ID_product; ?>" class="bi <? if($row_cart["ID"] == '') { ?> bi-cart3 <? } 
                                                                else { ?> bi-check2 <? } ?> button-icons-dark"></i> 
                                                            </button>
                                                        </div>    
                                                    <? } ?>
                                                    
                                                </div>
                                            </div>
                                        </div>            
                                    </div>               
                            <? }
                            else if(!in_array($row_product_filt['code'], $codes)) {                           
                                $ID_product=$row_product_filt['ID'];
                                $date = '0000-00-00';
                                $price = 0;
                                $result_price=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product'");
                                while($row_price=mysqli_fetch_assoc($result_price)) {
                                    if ($row_price['date'] > $date) {
                                        $date = $row_price['date'];
                                        $price = $row_price['price'];
                                    }
                                }

                                $ID_group = $row_product_filt["ID_group"]; 
                                $result_group=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group'");
                                $row_group=mysqli_fetch_assoc($result_group); 

                                $ID_model = $row_group['ID_model'];
                                $result_model=mysqli_query($link, "SELECT ID_brand, model FROM `models` WHERE ID='$ID_model'");
                                $row_model=mysqli_fetch_assoc($result_model);

                                $ID_brand = $row_model["ID_brand"];
                                $result_brand=mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand'");
                                $row_brand=mysqli_fetch_assoc($result_brand); 
                                 
                                $result_image=mysqli_query($link, "SELECT * FROM `images` WHERE ID_group='$ID_group'");
                                $row_image=mysqli_fetch_assoc($result_image); ?>

                                <div class="col-lg-4 col-sm-6 mb-4">
                                    <div class="product-card">
                                        <div class="product-thumb">
                                            <a href="product.php?ID=<? echo $row_product_filt['ID'] ?>&popularity=1"><img id="image_product<? echo $row_product_filt['ID'];?>" src="data:image/jpeg;base64, <? echo base64_encode( $row_image['image'] ) ?>"></a>
                                        </div>

                                        <div class="product-details">
                                            <h4><a class="title-link" href="product.php?ID=<? echo $row_product_filt['ID']; ?>&popularity=1"> <?php echo $row_brand['brand']." ".$row_model['model']." "; ?><span class="small-link"><?echo $row_product_filt['memory']."ГБ "?></span></a></h4>
                                            
                                            <? 
                                            $result_cart=mysqli_query($link, "SELECT ID FROM `carts` WHERE ID_product='$ID_product' and ID_user='$ID'");
                                            $row_cart=mysqli_fetch_assoc($result_cart);
                                                
                                            $code = $row_product_filt['code'];
                                            
                                            $colors=array();
                                            
                                            $result_product=mysqli_query($link, "SELECT * FROM `products` WHERE code='$code'");
                                            while($row_product=mysqli_fetch_assoc($result_product)) { 
                                                if (!in_array($row_product['ID_group'], $colors)) { 
                                                    $ID_group_2 = $row_product['ID_group'];
                                                    $ID_product_2 = $row_product['ID'];

                                                    $result_group_2=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_2'");
                                                    $row_group_2=mysqli_fetch_assoc($result_group_2); 

                                                    $result_image_one=mysqli_query($link, "SELECT `image` FROM `images` WHERE ID_group='$ID_groupt_2'");
                                                    $row_image_one=mysqli_fetch_assoc($result_image_one); 
                                                    
                                                    $result_price=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product_2'");
                                                    while($row_price=mysqli_fetch_assoc($result_price)) {
                                                        if ($row_price['date'] > $date) {
                                                            $date = $row_price['date'];
                                                            $price = $row_price['price'];                                                           
                                                        }
                                                    }

                                                    $ID_color = $row_group_2['ID_color'];
                                                    $result_color=mysqli_query($link, "SELECT code FROM `colors` WHERE ID='$ID_color'");
                                                    $row_color=mysqli_fetch_assoc($result_color); ?>  
                                                    
                                                    <div class="colors_product">   
                                                        <a id="color_product<? echo $row_product['ID']; ?>" href="product.php?ID=<? echo $row_product['ID']; ?>&popularity=1" 
                                                        class="color_product <? if($row_product['ID'] == $row_product_filt['ID']) { ?> active_color <? }?>" style="background-color:<? echo $row_color['code']?>;"></a>                                                         
                                                        <? $colors[] = $row_product['ID_group']; ?>
                                                    </div> 
                                                <? } 
                                            } ?>
                                                                                                    
                                            <div class="product-bottom-details d-flex justify-content-between"> 
                                                <div class="product-price">
                                                    <? if ($row_product_filt['count'] > 0) {
                                                        if ($row_product_filt['discount'] != "") {
                                                            if ($row_product_filt['date_discount'] <= date("Y-m-d")) {
                                                                $new_price = round($price-($price / 100 * $row_product_filt["discount"])); 
                                                                $new_price = number_format($new_price, 0, '', ' '); 
                                                                $price = number_format($price, 0, '', ' ');?>
                                                                <snap class="bold"><? echo $new_price; ?> ₽ </span><strike><small><? echo $price; ?> ₽ </small></strike>    
                                                            <? }
                                                            else {
                                                                $price = number_format($price, 0, '', ' ');
                                                                echo $price." ₽";      
                                                            }
                                                                                                                
                                                        } 
                                                        else {    
                                                            $price = number_format($price, 0, '', ' ');
                                                            echo $price." ₽";    
                                                        } 
                                                    } 
                                                    else {    
                                                        echo "Товара нет в наличии";    
                                                    } ?>
                                                </div>

                                                    <? $result_cart=mysqli_query($link, "SELECT ID FROM `carts` WHERE ID_product='$ID_product' and ID_user='$ID'");
                                                    $row_cart=mysqli_fetch_assoc($result_cart);

                                                    $result_favorite=mysqli_query($link, "SELECT ID FROM `favorites` WHERE ID_product='$ID_product' and ID_user='$ID'");
                                                    $row_favorite=mysqli_fetch_assoc($result_favorite);?>
                                                    <? if($row_info["ID_right"] == 4) { ?>
                                                        <div class="product-icons" id="oneProduct<? echo $ID_product; ?>">                                                   
                                                            <button class="button-icons-product" id="favorite<? echo $row_favorite['ID']; ?>" onclick="check_favorite(<? echo $ID_product; ?>)">
                                                                <i id="favorite-icon<? echo $ID_product; ?>" class="<? if($row_favorite["ID"] == '') { ?>bi bi-suit-heart<? }                                   
                                                                else { ?> bi bi-suit-heart-fill <? } ?> button-icons-dark"></i>
                                                            </button> 
                                                                                            
                                                            <button class="button-icons-product" id="cart<? echo $row_cart['ID']; ?>" onclick="check_cart(<? echo $ID_product; ?>)">
                                                                <i id="cart-icon<? echo $ID_product; ?>" class="bi <? if($row_cart["ID"] == '') { ?> bi-cart3 <? } 
                                                                else { ?> bi-check2 <? } ?> button-icons-dark"></i> 
                                                            </button>
                                                        </div>    
                                                    <? } ?>
                                                    
                                                </div>
                                            </div>
                                        </div>            
                                    </div>          
                                <? $codes[] = $row_product_filt['code'];
                                }                          
                            } 
                        } 
                        else { ?>
                            <div class="not-result">
                                <p class="text-not-result">Нет результатов</p>
                                <p class="small-text-not-result">Попробуйте изменить критерии поиска</p>
                            </div>
                        <? } ?>
                    </div>
                </div>    
            </section>
        </form>
    </div>
</body> 
<script>
    function check_favorite(id_product) {
        var servResponse = document.querySelector('#oneProduct' + id_product);

        var id_user = document.getElementById("IdUser").value;

        document.forms.product.onsubmit = function(e) {
            e.preventDefault();
        }

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-ckeck-favorite.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var text = xhr.responseText;
                if (text == 1) {
                    document.getElementById("favorite-icon" + id_product).classList.remove("bi-suit-heart");
                    document.getElementById("favorite-icon" + id_product).classList.remove("bi-suit-heart-fill");
                    document.getElementById("favorite-icon" + id_product).classList.add("bi-suit-heart-fill");
                }
                else if (text == 0) {
                    document.getElementById("favorite-icon" + id_product).classList.remove("bi-suit-heart");
                    document.getElementById("favorite-icon" + id_product).classList.remove("bi-suit-heart-fill");
                    document.getElementById("favorite-icon" + id_product).classList.add("bi-suit-heart");
                }
                $("#favorite_block").load("menu.php #count_favorite");
            }
        }
        xhr.send(`&id_product=${id_product}` + `&id_user=${id_user}`);    
    }

    function check_cart(id_product) {
        var servResponse = document.querySelector('#oneProduct' + id_product);

        var id_user = document.getElementById("IdUser").value;

        document.forms.product.onsubmit = function(e) {
            e.preventDefault();
        }

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-ckeck-cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var text = xhr.responseText;
                if (text == 1) {
                    document.getElementById("cart-icon" + id_product).classList.remove("bi-check2");
                    document.getElementById("cart-icon" + id_product).classList.remove("bi-cart3");
                    document.getElementById("cart-icon" + id_product).classList.add("bi-check2");
                }
                else if (text == 0) {
                    document.getElementById("cart-icon" + id_product).classList.remove("bi-check2");
                    document.getElementById("cart-icon" + id_product).classList.remove("bi-cart3");
                    document.getElementById("cart-icon" + id_product).classList.add("bi-cart3");
                }
                $("#cart_block").load("menu.php #count_cart");
            }
        }

        xhr.send(`&id_product=${id_product}` + `&id_user=${id_user}`);

    }

    function select_model() {
        var servResponse = document.querySelector('#model_select');

        var brand = document.getElementById("brand_select").value;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-post-model.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                servResponse.textContent = xhr.responseText;
                var i;
                var text = servResponse.textContent;
                var model = "";
                var selectedModel="<? echo $_POST["model_select"]; ?>";
                document.getElementById("model_select").options.text = "Выберите модель";
                let newOption = new Option("Выберите модель", "");
                newOption.classList.add("options");
                document.getElementById("model_select").append(newOption);
                newOption.selected = true;
                newOption.disabled = true;

                for (i = 0; i < text.length; i++) {
                    if (text[i] == ",") {
                        let newOption = new Option(model, model);
                        document.getElementById("model_select").append(newOption);
                        newOption.classList.add("options");
                        if(selectedModel==model) newOption.selected=true;
                        model = "";
                    } else model = model + text[i];
                }
            }
        }
        xhr.send('brand=' + brand);
        var brand = document.getElementById("brand_select").value;
        document.getElementById("hidden_brand").value = brand;
    }

    function hidden_model() {
        var model123 = document.getElementById("model_select").value;
        document.getElementById("hidden_model").value = model123;
    }
    
</script>
<? if(empty($_POST["brand_select"])) ?> <script> select_model(); </script>
<? include_once("footer.php"); ?>
</html>