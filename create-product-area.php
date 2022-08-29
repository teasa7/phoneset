<?php ob_start();
include_once("menu.php"); 
include_once("link.php");
include_once("check.php");
include_once("menu-area.php");
$token=$_COOKIE['cookieToken']; 
$ID_copy = $_GET["ID"];
if(!empty($ID_copy)) {
    $query_product_one = "SELECT * FROM `products` WHERE ID='$ID_copy'";
    $result_product_one  = mysqli_query($link, $query_product_one);
    $row_product_one  = mysqli_fetch_assoc($result_product_one);

    $ID_group_one = $row_product_one["ID_group"]; 
    $result_group_one=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_one'");
    $row_group_one=mysqli_fetch_assoc($result_group_one); 

    $ID_model_one = $row_group_one['ID_model'];
    $ID_color_one = $row_group_one['ID_color'];
    $ID_specification_one = $row_product_one["ID_specification"];

    $result_specification_one  = mysqli_query($link, "SELECT * FROM `specifications` WHERE ID='$ID_specification_one'");
    $row_specification_one  = mysqli_fetch_assoc($result_specification_one); 

    $result_model_one  = mysqli_query($link, "SELECT * FROM `models` WHERE ID='$ID_model_one'");
    $row_model_one  = mysqli_fetch_assoc($result_model_one); 
    $ID_brand_one = $row_model_one['ID_brand'];

    $result_brand_one  = mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand_one'");
    $row_brand_one  = mysqli_fetch_assoc($result_brand_one); 

    $result_color_one  = mysqli_query($link, "SELECT * FROM `colors` WHERE ID='$ID_color_one'");
    $row_color_one  = mysqli_fetch_assoc($result_color_one); 
    
    $date_one = '0000-00-00';
    $result_price_one=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_copy'");
    while($row_price_one=mysqli_fetch_assoc($result_price_one)) {
        if ($row_price_one['date'] > $date_one) {
            $date_one = $row_price_one['date'];
            $price_one = $row_price_one['price'];
        }
    }
} ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <title>PhoneSet - создание товара</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">

    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css/create-product-area.css">
</head>

<body>
    <main>
        <div class="main-product">
            <div class="modal fade" id="modal_brand" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog .modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Создание бренда</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                onclick="close_modal_brand()"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input-order-block" id="block_brand">
                                <label class="info-modal">Название бренда</label><br>
                                <input class="input-modal" type="text" name="brand" id="brand" value=""><br>
                                <label class="info-modal">Изображение бренда</label><br>
                                <form class="input-photo" method="post" enctype="multipart/form-data" >
                                    <input class="img-product-small-big" type='file' id="image_brand_one" name="image_brand"
                                        onchange="get_image_one()" accept=".jpg, .jpeg, .png" title="Выберите изображение">
                                </form>
                            </div>

                        </div>
                        <div class="modal-footer footer-border">
                            <button class="btn-checkout"><a class="link-modal" href="#" data-bs-dismiss="modal" aria-label="Close" onclick="add_brand()" class="link-modal">Добавить бренд</a></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_model" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog .modal-sm">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Создание модели</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                onclick="close_modal_model()"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input-order-block" id="block_model">
                                <label class="info-modal">Название бренда</label>
                                <select class="input-modal" name="brand_select_modal" id="brand_select_modal">
                                    <option disabled selected>Выберите бренд</option>
                                    <? $query_brand = "SELECT ID, brand FROM `brands`";
                                    $result_brand = mysqli_query($link, $query_brand);
                                    while ($row_brand = mysqli_fetch_assoc($result_brand)) { ?>
                                        <option value="<? echo $row_brand['ID'] ?>">
                                            <? echo $row_brand['brand'] ?>
                                        </option>
                                    <? } ?>
                                </select>   

                                <label class="info-modal">Название модели</label>
                                <input class="input-modal" type="text" name="model" id="model">

                                <label class="info-modal">Год выпуска</label>
                                <input class="input-modal" type="year" name="year_model" id="year_model">

                                <label class="info-modal">Страна производитель</label>
                                <select class="input-modal" name="country_select" id="country_select">
                                    <option disabled selected>Выберите страну</option>
                                    <? $query_country = "SELECT ID, country FROM `countries`";
                                    $result_country = mysqli_query($link, $query_country);
                                    while ($row_country = mysqli_fetch_assoc($result_country)) { ?>
                                        <option value="<? echo $row_country['ID'] ?>">
                                            <? echo $row_country['country'] ?>
                                        </option>
                                    <? } ?>
                                </select>   
                            </div>

                        </div>
                        <div class="modal-footer footer-border">
                            <button class="btn-checkout"><a class="link-modal" href="#" data-bs-dismiss="modal" aria-label="Close" onclick="add_model()" class="link-modal">Добавить модель</a></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_color" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog .modal-sm">
                    <div class="modal-content size-color">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Создание цвета</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="close_modal_color()"></button>
                        </div>

                        <div class="modal-body">
                            <div class="input-order-block" id="block_color">
                                <label class="info-modal">Цвет</label><br>
                                <input class="input-code" type="color" name="color_code" id="color_code" value=""><br>

                                <label class="info-modal">Название цвета</label><br>
                                <input class="input-modal" type="text" name="color_name" id="color_name">
                            </div>
                        </div>

                        <div class="modal-footer footer-border">
                            <button class="btn-checkout"><a class="link-modal" href="#" data-bs-dismiss="modal" aria-label="Close" onclick="add_color()" class="link-modal">Добавить цвет</a></button>
                        </div>
                    </div>
                </div>
            </div>

            <? if (!empty($token)) { ?>
            <div class="block-product">
                <? if(!empty($ID_copy)) { ?>
                    <a class="back" onclick="javascript:history.back(); return false;">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                <p class="title-area">Копирование товара №
                    <? echo $ID_copy ?>
                </p>
                <? } 
                else { ?>
                    <p class="title-area">Создание товара</p>
                <? } ?>
                <div class="form-product container">
                    <div class="line">
                        <div class="row">
                            <div class="col-sm content-product">
                                <form method="post" name="create" enctype="multipart/form-data">
                                    <div id="image_block_all">   
                                        <div class="image-block" id="image_block">
                                            <? if(!empty($ID_copy)) { 
                                                $result_image_one=mysqli_query($link, "SELECT * FROM `images` WHERE ID_group='$ID_group_one'");
                                                $n = 0;
                                                $ID_image = array();
                                                while($row_image_one=mysqli_fetch_assoc($result_image_one)) { 
                                                    if(!empty($row_image_one['image'])) { ?>
                                                        <img class="img-product-small" src="data:image/jpeg;base64, <? echo base64_encode($row_image_one['image']) ?>"; 
                                                        style="background-size: contain;">
                                                        <? $n = $n + 1;
                                                        $ID_image[] = $row_image_one['ID'];     
                                                    } 
                                                }
                                                if($n != 0) {  
                                                    while($n != 6) { ?>
                                                        <img class="img-product-small" src="img/not.png" style="background-size: cover;">    
                                                    <? $n = $n + 1;
                                                    }
                                                }
                                            } 
                                            else { 
                                                $k = 0;
                                                while($k != 6) { ?>
                                                    <input class="img-product-small" type='file' id="photo<? echo $k ?>" name="photo[]"
                                                        onchange="get_images(<? echo $k ?>)" accept=".jpg, .jpeg, .png"
                                                        title="Выберите изображение">
                                                    <? $k = $k + 1;
                                                }
                                            } ?>

                                        </div>
                                    </div>
                                    <label class="info">Бренд</label><br>
                                    <div id="check_brand">
                                        <? if(empty($ID_copy)) { ?>
                                            <select class="input-product spec select-brand_modal" name="brand_select" id="brand_select"
                                                onchange="select_model()" required>
                                                <? if($ID_copy != '') { ?>
                                                    <option value="<? echo $row_brand_one['brand'] ?>" selected>
                                                        <? echo $row_brand_one['brand'] ?>
                                                    </option>
                                                <? } 
                                                else { ?>
                                                    <option disabled selected>Выберите бренд</option>
                                                <? } ?>
                                                <? $ID_brand=$row_brand_one['brand'];
                                                $query_brand = "SELECT brand FROM `brands` WHERE NOT brand='$ID_brand'";
                                                $result_brand = mysqli_query($link, $query_brand);
                                                while ($row_brand = mysqli_fetch_assoc($result_brand)) { ?>
                                                    <option value="<? echo $row_brand['brand'] ?>">
                                                        <? echo $row_brand['brand'] ?>
                                                    </option>
                                                <? } ?>
                                            </select>         
                                            <input class="input-product check-modal" type="submit" data-bs-target="#modal_brand"
                                                data-bs-toggle="modal" name="new_brand" id="new_brand" value="+">
                                        <? } 
                                        else { ?>
                                            <input class="input-product spec" type="text" name="brand_select_2" id="brand_select_2" value="<? echo $row_brand_one['brand'] ?>" readonly>
                                        <? } ?>
                                    </div>

                                    <label class="info">Модель</label><br>
                                    <div id="check_model">
                                        <? if(empty($ID_copy)) { ?>
                                            <select class="input-product spec select-brand_modal" id="model_select" name="model_select" required onchange="update_image()">
                                                <? if($ID_copy != '') { ?>
                                                    <option value="<? echo $row_model_one['ID'] ?>" selected>
                                                        <? echo $row_model_one['model'] ?>
                                                    </option>
                                                <? } 
                                                else { ?>
                                                    <option disabled selected>Выберите модель</option>
                                                <? } ?>
                                            </select>
                                            <input class="input-product check-modal" type="submit" data-bs-target="#modal_model"
                                                data-bs-toggle="modal" name="new_model" id="new_model" value="+">
                                        <? } 
                                        else { ?>
                                            <input class="input-product spec" type="text" id="model_select_2" name="model_select_2" value="<? echo $row_model_one['model'] ?>" readonly>
                                        <? } ?>
                                    </div>
                                    
                            </div>

                            <div class="col-sm content-product">
                                <label class="info-spec-two">Количество</label><br>
                                <input class="input-product spec-two" type="number" min="1" name="count" id="count"
                                    min="1" value="1" pattern="[0-9]+" <? if($ID_copy !='' ) { ?> value="<? echo $row_product_one['count'] ?>"<? } ?> required><br>         

                                <label class="info-spec-two">Закупочная цена</label><br>
                                <input class="input-product spec-two" type="number" name="price" id="price" min="1"
                                    pattern="[0-9]+" required><br>

                                <label class="info-spec-two">Наценка</label><br>
                                <input class="input-product spec-two" type="number" name="discount" id="discount"
                                    min="1" max="100" value="1" pattern="[0-9]+" required><br>

                                <label class="info-spec-two">Память</label><br>
                                <input class="input-product spec-two" type="number" name="memory" id="memory" min="1"
                                    max="2000" <? if($ID_copy !='' ) { ?> value="<? echo $row_product_one['memory'] ?>"<? } ?> required><br>

                                <label class="info-spec-two">Код видео Youtube</label><br>
                                <input class="input-product spec-two" type="text" name="code_video" id="code_video"
                                    <? if($ID_copy !='') { ?> value="<? echo $row_model_one['video'] ?>" readonly <? } ?> placeholder="h4n175pMcOc"><br>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="title-spec">Характеристики</p>
                        <div class="col-sm content-product">
                            <label class="info">Гарантия(месяцев)</label><br>
                            <input class="input-product spec" type="text" name="guarantee" id="guarantee" <? if($ID_copy
                                !='' ) { ?> value="<? echo $row_specification_one['guarantee'] ?>" readonly
                            <? } else { ?> min="0" pattern="[0-9]+" placeholder="12" required <? } ?>><br>

                            <label class="info">Формат сим-карт</label><br>
                            <input class="input-product spec" type="text" name="sim_format" id="sim_format" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['sim_format'] ?>" readonly
                            <? } else { ?> placeholder="Nano-SIM (12.3x8.8x0.67 мм)" required <? } ?>><br>

                            <label class="info">Количество сим-карт</label><br>
                            <input class="input-product spec" type="text" name="count_sim" id="count_sim" <? if($ID_copy
                                !='' ) { ?> value="<? echo $row_specification_one['count_sim'] ?>" readonly
                            <? } else { ?> placeholder="2" required <? } ?>><br>

                            <label class="info">Диагональ экрана</label><br>
                            <input class="input-product spec" type="text" name="screen_diagonal" id="screen_diagonal" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['screen_diagonal'] ?>" readonly
                            <? } else { ?> placeholder="4.5" required <? } ?>><br>

                            <label class="info">Разрешение экрана</label><br>
                            <input class="input-product spec" type="text" name="screen_resolution"
                                id="screen_resolution" <? if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['screen_resolution'] ?>" readonly
                            <? } else { ?> placeholder="1200x600" required <? } ?>><br>

                            <label class="info">Материал корпуса</label><br>
                            <input class="input-product spec" type="text" name="body_material" id="body_material" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['body_material'] ?>" readonly
                            <? } else { ?> placeholder="металл/стекло" required <? } ?>><br>

                            <label class="info">Версия ОС</label><br>
                            <input class="input-product spec" type="text" name="OS_version" id="OS_version" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['OS_version'] ?>" readonly
                            <? } else { ?> placeholder="Android" required <? } ?>><br>

                            <label class="info">Модель процессора</label><br>
                            <input class="input-product spec" type="text" name="processor_model" id="processor_model" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['processor_model'] ?>" readonly
                            <? } else { ?> placeholder="Apple A13 Bionic" required <? } ?>><br>

                            <label class="info">Количество ядер процессора</label><br>
                            <input class="input-product spec" type="count" name="count_cores" id="count_cores" min="1"
                                <? if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['count_cores'] ?>" readonly
                            <? } else { ?> placeholder="3" required <? } ?>><br>

                            <label class="info">Аккумулятор</label><br>
                            <input class="input-product spec" type="text" name="battery" id="battery" <? if($ID_copy
                                !='' ) { ?> value="<? echo $row_specification_one['battery'] ?>" readonly
                            <? } else { ?> placeholder="Li-Ion" required <? } ?>><br>

                            <label class="info">Емкость аккумулятора</label><br>
                            <input class="input-product spec" type="text" name="size_battery" id="size_battery" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['size_battery'] ?>" readonly
                            <? } else { ?> placeholder="1440 мА*ч" required <? } ?>><br>

                            <label class="info">Оперативная память</label><br>
                            <input class="input-product spec" type="number" name="RAM" id="RAM" min="1" max="20" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['RAM'] ?>" readonly
                            <? } else { ?> placeholder="4" required <? } ?>><br>

                            <label class="info">Тип карты памяти</label><br>
                            <input class="input-product spec" type="text" name="type_cards" id="type_cards" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['type_cards'] ?>"
                            <? } else { ?> placeholder="microSD" required <? } ?>><br>
                        </div>
                        
                        <div class="col-sm content-product">
                            <div id="check_color">
                                <label class="info-spec-two">Цвет</label><br>
                                <? if(empty($ID_copy)) { ?>
                                    <select class="input-product spec select-color" name="color_select" id="color_select" 
                                    onchange="update_image()">
                                        <? if($ID_copy != '') { ?>
                                            <option class="option-color" style="background-color: <? echo $row_color_one["code"] ?>;" 
                                            value='<? echo $row_color_one["ID"]?>'><? echo $row_color_one["name"]?></option>
                                        <? } ?>
                                        <? $result_color = mysqli_query($link, "SELECT * FROM `colors`"); 
                                        while($row_color = mysqli_fetch_assoc($result_color)) { ?>
                                            <option class="option-color" style="background-color: <? echo $row_color["code"] ?>;" 
                                            value='<? echo $row_color["ID"]?>'><? echo $row_color["name"]?></option>
                                        <? } ?>
                                    </select>             
                                    <input class="input-product color" type="submit" data-bs-target="#modal_color"
                                        data-bs-toggle="modal" name="new_color" id="new_color" value="+"><br>
                                <? } 
                                else { ?>
                                    <input type="hidden" name="color_select_2" id="color_select_2" value="<? echo $row_color_one['ID'] ?>" readonly>
                                    <input class="input-product spec-two" type="text" value="<? echo $row_color_one['name'] ?>" readonly>
                                <? } ?>
                            </div>

                            <label class="info-spec-two">Количество основных камер</label><br>
                            <input class="input-product spec-two" type="number" name="count_cameras" id="count_cameras"
                                <? if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['count_cameras'] ?>" readonly
                            <? } else { ?> placeholder="1" min="1" max="10" required <? } ?>><br>

                            <label class="info-spec-two">Количество мегапикселей основной камеры</label><br>
                            <input class="input-product spec-two" type="text" name="main_camera" id="main_camera" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['main_camera'] ?>" readonly
                            <? } else { ?> placeholder="12" min="1" max="50" required <? } ?>><br>

                            <label class="info-spec-two">Количество мегапикселей фронтальной камеры</label><br>
                            <input class="input-product spec-two" type="text" name="front_camera" id="front_camera" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['front_camera'] ?>" readonly
                            <? } else { ?> placeholder="7" min="1" max="50" required <? } ?>><br>

                            <label class="info-spec-two">Bluetooth</label><br>
                            <input class="input-product spec-two" type="text" name="Bluetooth" id="Bluetooth" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['Bluetooth'] ?>" readonly
                            <? } else { ?> placeholder="5.0" required <? } ?>><br>

                            <label class="info-spec-two">Wi-fi</label><br>
                            <input class="input-product spec-two" type="text" name="Wi_fi" id="Wi_fi" <? if($ID_copy
                                !='' ) { ?> value="<? echo $row_specification_one['Wi_fi'] ?>" readonly
                            <? } else { ?> placeholder="4 (802.11n), 5 (802.11ac), 6 (802.11ax)" required <? } ?>><br>

                            <label class="info-spec-two">NFS</label><br>
                            <input class="input-product spec-two" type="text" name="NFS" id="NFS" <? if($ID_copy !='' )
                            { ?> value="<? echo $row_specification_one['NFS'] ?>"  readonly <? } else { ?> placeholder="есть" required <? } ?>><br>

                            <label class="info-spec-two">Тип разъема</label><br>
                            <input class="input-product spec-two" type="text" name="wire_type" id="wire_type" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['wire_type'] ?>" readonly
                            <? } else { ?> placeholder="Lightning 8-pin" required <? } ?>><br>

                            <label class="info-spec-two">Комплектация</label><br>
                            <input class="input-product spec-two" type="text" name="equipment" id="equipment" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['equipment'] ?>" readonly
                            <? } else { ?>placeholder="кабель, скрепка для извлечения слота SIM-карты" required <? } ?>><br>

                            <label class="info-spec-two">Ширина(мм)</label><br>
                            <input class="input-product spec-two" type="number" step="any" name="width" id="width" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['width'] ?>" readonly
                            <? } else { ?> placeholder="65.1" min="1" max="200" required <? } ?>><br>

                            <label class="info-spec-two">Высота(мм)</label><br>
                            <input class="input-product spec-two" type="number" step="any" name="height" id="height" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['height'] ?>" readonly
                            <? } else { ?> placeholder="130.5" min="1" max="200" required <? } ?>><br>

                            <label class="info-spec-two">Толщина(мм)</label><br>
                            <input class="input-product spec-two" type="number" step="any" name="thickness"
                                id="thickness" <? if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['thickness'] ?>" readonly
                            <? } else { ?> placeholder="7.2" min="1" max="50" required <? } ?>><br>

                            <label class="info-spec-two">Вес(гр)</label><br>
                            <input class="input-product spec-two" type="number" step="any" name="weight" id="weight" <?
                                if($ID_copy !='' ) { ?> value="<? echo $row_specification_one['weight'] ?>" readonly
                            <? } else { ?> placeholder="120" min="1" max="1000" required <? } ?>><br>
                        </div>
                    </div><br>
                    <div class="block-btn">
                        <input class="btn-product" type="submit" name="save" value="Сохранить">
                    </div>
                    </form>
                </div>
            </div> 
        <? } ?>
    </main>
</body>

</html>
<?php
    if (isset($_POST["save"])) {
                    
        if(empty($ID_copy)) {   
            $brand = $_POST["brand_select"];
            $model = $_POST["model_select"];   
            $color = $_POST["color_select"]; 
        }
        else { 
            $brand = $_POST["brand_select_2"];
            $model = $_POST["model_select_2"];
            $color = $_POST["color_select_2"];   
        }
        
        $memory = $_POST["memory"];
        $count = $_POST["count"];
        $code_video = $_POST["code_video"];

        $result_brand_ID = mysqli_query($link, "SELECT ID FROM `brands` WHERE brand='$brand'");
        $row_brand_ID = mysqli_fetch_assoc($result_brand_ID);
        $ID_brand = $row_brand_ID["ID"];

        $result_model = mysqli_query($link, "SELECT ID FROM `models` WHERE model='$model' and ID_brand='$ID_brand'");
        $row_model = mysqli_fetch_assoc($result_model);
        $ID_model = $row_model["ID"];

        $result_group=mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_model='$ID_model' AND ID_color='$color'");
        $row_group=mysqli_fetch_assoc($result_group); 
        $ID_group = $row_group["ID"];

        $input = $row_model["ID"].$memory;
        $code = str_pad($input, 6, "0", STR_PAD_LEFT);
        
        $result_product_check= mysqli_query($link, "SELECT ID FROM `products` WHERE ID_group='$ID_group' AND memory='$memory'");
        $row_product_check = mysqli_fetch_assoc($result_product_check);

        if ($row_product_check["ID"] !='') {
            $product_ID = $row_product_check["ID"];
        }
        else {
            if($ID_group == "") {
                $query_data_group="INSERT INTO groups(ID_model, ID_color) VALUE ('$ID_model', '$color')"; 
                mysqli_query($link, $query_data_group);
                
                $result_group=mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_model='$ID_model' AND ID_color='$color' ORDER BY ID DESC LIMIT 1");
                $row_group=mysqli_fetch_assoc($result_group); 
                $ID_group = $row_group["ID"];
            }
            if($count > 0) {
                $query_data_product="INSERT INTO products(ID_group, memory, `count`, `code`, `status`) VALUE ('$ID_group', '$memory', '$count', '$code', 'В продаже')";    
            }
            else {
                $query_data_product="INSERT INTO products(ID_group, memory, `count`, `code`, `status`) VALUE ('$ID_group', '$memory', '$count', '$code', 'Нет в наличии')";    
            }
            if(!empty($code_video)) {
                $query_data_model="UPDATE `models` SET video='$code_video' WHERE ID='$ID_model'"; 
                mysqli_query($link, $query_data_model);
            } 
            $query_data_product="INSERT INTO products(ID_group, memory, `count`, `code`, `status`) VALUE ('$ID_group', '$memory', '$count', '$code', 'В продаже')";    
            if (mysqli_query($link, $query_data_product)) {          
                $result_product = mysqli_query($link, "SELECT * FROM `products` ORDER BY ID DESC LIMIT 1");
                $row_product = mysqli_fetch_assoc($result_product);
                $product_ID = $row_product["ID"];
            }
        }

        echo $query_data_group;
        echo $query_data_product;

        if ($product_ID != '') { 
            $price = $_POST["price"] + ($_POST["price"] * $_POST["discount"]/100);
            $date = date("Y-m-d H:i:s"); 
            $query_price = "INSERT INTO prices(`price`, `date`, ID_product) VALUE ('$price', '$date', '$product_ID')";
            mysqli_query($link, $query_price);

            if(empty($ID_group)) {
                if($ID_copy != '') {                
                    $query_group = "INSERT INTO groups(ID_model, ID_color) VALUE ('$ID_model', '$ID_color')";
                    $result_group=mysqli_query($link, "SELECT ID FROM `groups` ORDER BY ID DESC LIMIT 1");
                    $row_group=mysqli_fetch_assoc($result_group); 
                    $ID_group = $row_group["ID"];

                    for($i = 0; $i < 6; $i++) {
                        if (!empty($_FILES['photo']['tmp_name'][$i])) {
                            if (addslashes(file_get_contents($_FILES['photo']['tmp_name'][$i]))) {
                                $photo = addslashes(file_get_contents($_FILES['photo']['tmp_name'][$i]));
                                $query_image = "INSERT INTO images(`image`, ID_group) VALUE ('$photo', '$ID_group')";
                                mysqli_query($link, $query_image); 
                            }
                        }              
                    }        
                }
            }

            $guarantee = $_POST["guarantee"];
            $sim_format = $_POST["sim_format"];  
            $count_sim = $_POST["count_sim"];
            $screen_diagonal = $_POST["screen_diagonal"];
            $screen_resolution = $_POST["screen_resolution"];
            $body_material = $_POST["body_material"];
            $OS_version = $_POST["OS_version"];
            $processor_model = $_POST["processor_model"];
            $count_cores = $_POST["count_cores"];
            $battery = $_POST["battery"];
            $size_battery = $_POST["size_battery"];
            $RAM = $_POST["RAM"];
            $type_cards = $_POST["type_cards"];
            $count_cameras = $_POST["count_cameras"];
            $main_camera = $_POST["main_camera"];
            $front_camera = $_POST["front_camera"];
            $Bluetooth = $_POST["Bluetooth"];
            $Wi_fi = $_POST["Wi_fi"];
            $NFS = $_POST["NFS"];
            $wire_type = $_POST["wire_type"];
            $equipment = $_POST["equipment"];
            $width = $_POST["width"];
            $height = $_POST["height"];
            $thickness = $_POST["thickness"];
            $weight = $_POST["weight"];                                  

            $result_specification_two = mysqli_query($link, "SELECT ID FROM `specifications` WHERE guarantee='$guarantee' AND sim_format='$sim_format' AND count_sim='$count_sim' AND screen_diagonal='$screen_diagonal' AND
            screen_resolution='$screen_resolution' AND body_material='$body_material' AND OS_version='$OS_version' AND processor_model='$processor_model' AND count_cores='$count_cores' 
            AND battery='$battery' AND size_battery='$size_battery' AND RAM='$RAM' AND type_cards='$type_cards' AND count_cameras='$count_cameras' AND main_camera='$main_camera' 
            AND front_camera='$front_camera' AND Bluetooth='$Bluetooth' AND Wi_fi='$Wi_fi' AND NFS='$NFS' AND wire_type='$wire_type'
            AND equipment='$equipment' AND width='$width' AND height='$height' AND thickness='$thickness' AND `weight`='$weight'");

            $row_specification_two = mysqli_fetch_assoc($result_specification_two);
            $specification_ID = $row_specification_two["ID"];
            
            if($specification_ID != '') {
                $query_product_2 = "UPDATE `products` SET ID_specification='$specification_ID' WHERE ID='$product_ID'";
                mysqli_query($link, $query_product_2);  
            }
            else {                
                $query_data_specifications="INSERT INTO specifications(guarantee, sim_format, count_sim, screen_diagonal, screen_resolution, 
                body_material, OS_version, processor_model, count_cores, battery, size_battery,
                RAM, type_cards, count_cameras, main_camera, front_camera, Bluetooth,
                Wi_fi, NFS, wire_type, equipment, width, height, thickness, `weight`) VALUE 
                ('$guarantee', '$sim_format', '$count_sim', '$screen_diagonal', '$screen_resolution',
                '$body_material', '$OS_version', '$processor_model', '$count_cores', '$battery', '$size_battery',
                '$RAM', '$type_cards', '$count_cameras', '$main_camera', '$front_camera', '$Bluetooth',
                '$Wi_fi', '$NFS', '$wire_type', '$equipment', '$width', '$height', '$thickness', '$weight')";

                if(mysqli_query($link, $query_data_specifications)) {
                    $result_specification = mysqli_query($link, "SELECT * FROM `specifications` ORDER BY ID DESC LIMIT 1");
                    $row_specification = mysqli_fetch_assoc($result_specification);
                    $ID_specification = $row_specification["ID"];
                    $query_product_2 = "UPDATE `products` SET ID_specification='$ID_specification' WHERE ID='$product_ID'";
                    mysqli_query($link, $query_product_2);
                }  
            }  
        } 
        
        // header("Location: products-area.php?page=1");
    } ?>
<script>
    function update_image() {
        var ID_color = document.getElementById("color_select").value;
        document.getElementById('hidden_color').value = ID_color;
        var ID_model = document.getElementById("model_select").value;
        document.getElementById('hidden_model').value = ID_model;
        $('#image_block_all').load('create-product-area.php?ID_model=' + ID_model + '&ID_color=' + ID_color +' #image_block'); 
    }

    function add_color() {
        var servResponse = document.querySelector('#block_color');

        var color_code = document.getElementById("color_code").value;
        var color_name = document.getElementById("color_name").value;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-add-color.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $("#check_color").load("create-product-area.php #check_color");
            }
        }

        xhr.send(`&code=${color_code}` + `&name=${color_name}`);
    }

    function add_brand() {
        var formData = new FormData();
		if (($('#image_brand_one')[0].files).length !=0){
		    $.each($('#image_brand_one')[0].files, function(i, file){
				formData.append("file[" + i + "]", file);
			});
            formData.append("brand", document.getElementById("brand").value);
	    }
		else {
			return false;
		}
		$.ajax({
            type:"POST",
            url:"function-add-brand.php",
            cache:false,
            dataType:"json",
            contentType: false,
            processData: false,
            data: formData,
            complete: $("#check_brand").load("create-product-area.php #check_brand"),
        });
    }

    function add_model() {
        var servResponse = document.querySelector('#block_color');

        var ID_brand = document.getElementById("brand_select_modal").value;
        var model = document.getElementById("model").value;
        var year = document.getElementById("year_model").value;
        var ID_country = document.getElementById("country_select").value;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-add-model.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                $("#check_model").load("create-product-area.php #check_model");
            }
        }

        xhr.send(`&ID_brand=${ID_brand}` + `&model=${model}` + `&year=${year}` + `&ID_country=${ID_country}`);
    }

    function close_modal_brand() {
        $("#check_brand").load("create-product-area.php #check_brand");
    }

    function close_modal_model() {
        $("#check_model").load("create-product-area.php #check_model");
    }

    function close_modal_color() {
        $("#check_color").load("create-product-area.php #check_color");
    }  

    function get_image_one() {
        file_one = document.getElementById("image_brand_one").files[0];

        var link_image_one = "";
        if (file_one) {
            link_image_one = URL.createObjectURL(file_one);
            localStorage.setItem('my_image_one', link_image_one);
        }
        link_image_one = localStorage.getItem('my_image_one');
        document.getElementById("image_brand_one").classList.remove("img-product-small-big");
        document.getElementById("image_brand_one").classList.add("img-product-small-big-after");
        document.getElementById("image_brand_one").style.backgroundImage = "url(" + link_image_one + ")";
        document.getElementById("image_brand_one").style.backgroundRepeat = "no-repeat";
        document.getElementById("image_brand_one").style.backgroundSize = "contain";
    }

    function get_images(id_image) {
        file = document.getElementById("photo" + id_image).files[0];

        var link_image = "";
        if (file) {
            link_image = URL.createObjectURL(file);
            localStorage.setItem('my_image', link_image);
        }
        link_image = localStorage.getItem('my_image');
        document.getElementById("photo" + id_image).classList.remove("img-product-small");
        document.getElementById("photo" + id_image).classList.add("img-product-small-after");
        document.getElementById("photo" + id_image).style.backgroundImage = "url(" + link_image + ")";
        document.getElementById("photo" + id_image).style.backgroundRepeat = "no-repeat";
        document.getElementById("photo" + id_image).style.backgroundSize = "contain";
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
                document.getElementById("model_select").options.text = "Выберите модель";
                let newOption = new Option("Выберите модель", "");
                document.getElementById("model_select").append(newOption);
                newOption.selected = true;
                newOption.disabled = true;

                for (i = 0; i < text.length; i++) {
                    if (text[i] == ",") {
                        let newOption = new Option(model, model);
                        document.getElementById("model_select").append(newOption);
                        model = "";
                    } 
                    else model = model + text[i];
                }
            }
        }
        xhr.send('brand=' + brand);
    }
</script>
<?php 
include_once("footer.php"); 
ob_end_flush();
?>