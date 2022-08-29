<?php ob_start();
include_once("menu.php"); 
include_once("link.php");
include_once("check.php");
include_once("menu-area.php"); 
$token=$_COOKIE['cookieToken']; 
$ID = $_GET["ID"];

$result_product_one  = mysqli_query($link, "SELECT * FROM `products` WHERE ID='$ID'");
$row_product_one  = mysqli_fetch_assoc($result_product_one);

$ID_group_one = $row_product_one["ID_group"]; 
$result_group_one=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_one'");
$row_group_one=mysqli_fetch_assoc($result_group_one); 

$date_one = '0000-00-00';
$result_price_one=mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID'");
while($row_price_one=mysqli_fetch_assoc($result_price_one)) {
    $price_new = date("Y-m-d", strtotime($row_price_one['date']));
    if ($price_new > $date_one) {
        $date_one = $price_new;
        $price_one = $row_price_one['price'];
    }
}

$ID_group_one = $row_product_one["ID_group"]; 
$result_group_one=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_one'");
$row_group_one=mysqli_fetch_assoc($result_group_one); 
$ID_model_one = $row_group_one['ID_model'];
$ID_specification_one = $row_product_one["ID_specification"];

$result_specification_one  = mysqli_query($link, "SELECT * FROM `specifications` WHERE ID='$ID_specification_one'");
$row_specification_one  = mysqli_fetch_assoc($result_specification_one); 

$result_model_one  = mysqli_query($link, "SELECT * FROM `models` WHERE ID='$ID_model_one'");
$row_model_one  = mysqli_fetch_assoc($result_model_one); 
$ID_brand_one = $row_model_one['ID_brand'];

$result_brand_one  = mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand_one'");
$row_brand_one  = mysqli_fetch_assoc($result_brand_one); 

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - редактирование товара</title>
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="stylesheet" href="css/edit-product-area.css">

  		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  		<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
	</head>
	<body>
        <main>
        <div class="main-product">

            <div class="main-product">
                <?php if (!empty($token)) { ?>
                <div class="block-product">
                    <a class="back" onclick="javascript:history.back(); return false;">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <p class="title-area">Изменение товара</p>
                    <div class="form-product container">
                        <div class="line">
                            <div class="row">             
                                <div class="col-sm content-product">
                                    <form method="post" enctype="multipart/form-data"> 
                                        <div class="image-block">
                                            <? $result_image=mysqli_query($link, "SELECT ID, `image` FROM `images` WHERE ID_group='$ID_group_one'"); 
                                            $m = 0;
                                            $ID_image = array();
                                            while($row_image=mysqli_fetch_assoc($result_image)) { ?>                               
                                                <? if($row_image['image'] != "") { ?>
                                                    <input class="img-product-small" type='file' id="photo<? echo $m ?>" name="photo[]" style="background-image: url('data:image/jpeg;base64,<? echo base64_encode($row_image['image']) ?>');
                                                    background-size: contain;" onchange="get_images(<? echo $m ?>)" accept=".jpg, .jpeg, .png" title="Выберите изображение">
                                                    <? $m = $m + 1;
                                                    $ID_image[] = $row_image['ID']; ?>
                                                <? } 
                                            } 
                                            if($m != 0) {    
                                                while($m != 6) { ?>
                                                    <input class="img-product-small" onchange="get_images(<? echo $m ?>)" type='file' id="photo<? echo $m ?>" name="photo[]" background-image="img/not.png" accept=".jpg, .jpeg, .png" title="Выберите изображение">    
                                                    <? $m = $m + 1;
                                                } 
                                            } 
                                            else {
                                                while($m != 6) { ?>
                                                    <input class="img-product-small" onchange="get_images(<? echo $m ?>)" type='file' id="photo<? echo $m ?>" name="photo[]" background-image="img/not.png" accept=".jpg, .jpeg, .png" title="Выберите изображение">    
                                                    <? $m = $m + 1;
                                                }  
                                            }?>                                                      
                                        </div><br>

                                        <label class="info">Бренд</label><br>
                                        <select class="input-product spec" name="brand_select" id="brand_select" onchange="select_model()">
                                            <option value="<? echo $row_brand_one['brand'] ?>" selected><? echo $row_brand_one['brand'] ?></option>
                                            <? $brand_one = $row_brand_one['brand']; 
                                            $query_brand = "SELECT brand FROM `brands` WHERE NOT brand='$brand_one'";
                                            $result_brand = mysqli_query($link, $query_brand);
                                            while ($row_brand = mysqli_fetch_assoc($result_brand)) { ?>
                                                <option value="<? echo $row_brand['brand'] ?>">
                                                    <? echo $row_brand['brand'] ?>
                                                </option>
                                            <? } ?>
                                        </select><br>

                                        <label class="info">Модель</label><br>
                                        <select class="input-product spec" id="model_select" name="model_select">
                                            <option value="<? echo $row_model_one['model'] ?>"><? echo $row_model_one['model'] ?></option>
                                        </select>
                                </div>                     
                                <div class="col-sm content-product">
                                    <label class="info-spec-two">Количество</label><br>
                                    <input class="input-product spec-two" type="number" min="0" name="count" id="count"
                                    pattern="[0-9]+" value="<? echo $row_product_one['count'] ?>"><br>

                                    <label class="info-spec-two">Цена</label><br>
                                    <input class="input-product spec-two" type="number" name="price" id="price" value="<? echo $price_one ?>" readonly><br>

                                    <label class="info-spec-two">Дата установки цены</label><br>
                                    <input class="input-product spec-two"  type="date" name="date" id="date" value="<? echo $date_one ?>" readonly><br>

                                    <label class="info-spec-two">Память</label><br>
                                    <input class="input-product spec-two" type="number" name="memory" id="memory" min="1" max="2000" value="<? echo $row_product_one['memory'] ?>" readonly><br>  

                                    <label class="info-spec-two">Код видео Youtube</label><br>
                                    <input class="input-product spec-two" type="text" name="code_video" id="code_video"
                                    value="<? echo $row_model_one['video'] ?>" placeholder="h4n175pMcOc"><br>

                                </div>
                            </div>     
                        </div>

                        <div class="row">
                            <p class="title-spec">Характеристики</p>
                            <div class="col-sm content-product">
                                <label class="info">Гарантия(месяцев)</label><br>
                                <input class="input-product spec" type="text" name="guarantee" id="guarantee" min="0" pattern="[0-9]+"
                                value="<? echo $row_specification_one['guarantee'] ?>"><br>

                                <label class="info">Формат сим-карт</label><br>
                                <input class="input-product spec" type="text" name="sim_format" id="sim_format"
                                value="<? echo $row_specification_one['sim_format'] ?>"><br>

                                <label class="info">Количество сим-карт</label><br>
                                <input class="input-product spec" type="text" name="count_sim" id="count_sim"
                                value="<? echo $row_specification_one['count_sim'] ?>"><br>

                                <label class="info">Диагональ экрана</label><br>
                                <input class="input-product spec" type="text" name="screen_diagonal" id="screen_diagonal"
                                value="<? echo $row_specification_one['screen_diagonal'] ?>"><br>  
                                
                                <label class="info">Разрешение экрана</label><br>
                                <input class="input-product spec" type="text" name="screen_resolution" id="screen_resolution"
                                value="<? echo $row_specification_one['screen_resolution'] ?>"><br>

                                <label class="info">Материал корпуса</label><br>
                                <input class="input-product spec" type="text" name="body_material" id="body_material"
                                value="<? echo $row_specification_one['body_material'] ?>"><br>

                                <label class="info">Версия ОС</label><br>
                                <input class="input-product spec" type="text" name="OS_version" id="OS_version"
                                value="<? echo $row_specification_one['OS_version'] ?>"><br>

                                <label class="info">Модель процессора</label><br>
                                <input class="input-product spec" type="text" name="processor_model" id="processor_model"
                                value="<? echo $row_specification_one['processor_model'] ?>"><br>

                                <label class="info">Количество ядер процессора</label><br>
                                <input class="input-product spec" type="count" name="count_cores" id="count_cores" min="1"
                                value="<? echo $row_specification_one['count_cores'] ?>"><br>

                                <label class="info">Аккумулятор</label><br>
                                <input class="input-product spec" type="text" name="battery" id="battery"
                                value="<? echo $row_specification_one['battery'] ?>"><br>

                                <label class="info">Емкость аккумулятора</label><br>
                                <input class="input-product spec" type="text" name="size_battery" id="size_battery"
                                value="<? echo $row_specification_one['size_battery'] ?>"><br>
                
                                <label class="info">Оперативная память</label><br>
                                <input class="input-product spec" type="number" name="RAM" id="RAM" min="1" max="20"
                                value="<? echo $row_specification_one['RAM'] ?>"><br>
                                
                                <label class="info">Тип карты памяти</label><br>
                                <input class="input-product spec" type="text" name="type_cards" id="type_cards"
                                value="<? echo $row_specification_one['type_cards'] ?>"><br>
                            </div>
                            <div class="col-sm content-product">
                                <div id="check_color">
                                    <label class="info-spec-two">Цвет</label><br>
                                    <select class="input-product spec-two" name="select_color"> 
                                        <? $ID_color_one = $row_group_one["ID_color"];
                                        $result_color = mysqli_query($link, "SELECT * FROM `colors` WHERE ID='$ID_color_one'"); 
                                        $row_color = mysqli_fetch_assoc($result_color); ?> 
                                        <option class="option-color" style="background-color: <? echo $row_color["code"] ?>;" value='<? echo $row_color["ID"]?>'><? echo $row_color["name"]?></option>
                                        <? $result_color = mysqli_query($link, "SELECT * FROM `colors`"); 
                                        while($row_color = mysqli_fetch_assoc($result_color)) { ?>
                                            <option class="option-color" style="background-color: <? echo $row_color["code"] ?>;" value='<? echo $row_color["ID"]?>'><? echo $row_color["name"]?></option>
                                        <? } ?>
                                    </select>
                                </div>

                                <label class="info-spec-two">Количество основных камер</label><br>
                                <input class="input-product spec-two" type="number" name="count_cameras" id="count_cameras" min="1" max="10"
                                value="<? echo $row_specification_one['count_cameras'] ?>"><br>

                                <label class="info-spec-two">Количество мегапикселей основной камеры</label><br>
                                <input class="input-product spec-two" type="text" name="main_camera" id="main_camera" min="1" max="50"
                                value="<? echo $row_specification_one['main_camera'] ?>"><br>

                                <label class="info-spec-two">Количество мегапикселей фронтальной камеры</label><br>
                                <input class="input-product spec-two" type="text" name="front_camera" id="front_camera" min="1" max="50"
                                value="<? echo $row_specification_one['front_camera'] ?>"><br>

                                <label class="info-spec-two">Bluetooth</label><br>
                                <input class="input-product spec-two" type="text" name="Bluetooth" id="Bluetooth"
                                value="<? echo $row_specification_one['Bluetooth'] ?>"><br>

                                <label class="info-spec-two">Wi-fi</label><br>
                                <input class="input-product spec-two" type="text" name="Wi_fi" id="Wi_fi"
                                value="<? echo $row_specification_one['Wi_fi'] ?>"><br>

                                <label class="info-spec-two">NFS</label><br>
                                <input class="input-product spec-two" type="text" name="NFS" id="NFS"
                                value="<? echo $row_specification_one['NFS'] ?>"><br>

                                <label class="info-spec-two">Тип разъема</label><br>
                                <input class="input-product spec-two" type="text" name="wire_type" id="wire_type"
                                value="<? echo $row_specification_one['wire_type'] ?>"><br>

                                <label class="info-spec-two">Комплектация</label><br>
                                <input class="input-product spec-two" type="text" name="equipment" id="equipment"
                                value="<? echo $row_specification_one['equipment'] ?>"><br>

                                <label class="info-spec-two">Ширина(мм)</label><br>
                                <input class="input-product spec-two" type="number" step="any" name="width" id="width" min="1" max="200"
                                value="<? echo $row_specification_one['width'] ?>"><br>

                                <label class="info-spec-two">Высота(мм)</label><br>
                                <input class="input-product spec-two" type="number" step="any" name="height" id="height" min="1" max="200"
                                value="<? echo $row_specification_one['height'] ?>"><br>

                                <label class="info-spec-two">Толщина(мм)</label><br>
                                <input class="input-product spec-two" type="number" step="any" name="thickness" id="thickness" min="1" max="50"
                                value="<? echo $row_specification_one['thickness'] ?>"><br>

                                <label class="info-spec-two">Вес(гр)</label><br>
                                <input class="input-product spec-two" type="number" step="any" name="weight" id="weight" min="1" max="1000"
                                value="<? echo $row_specification_one['weight'] ?>"><br>
                            </div>
                        </div><br>
                        <div class="block-btn">
                            <input class="btn-product" type="submit" name="save" value="Сохранить">
                        </div>
                        </form>
                    </div>  
                </div>
            </div>
        </main>	
    </body>
</html>
    <? if (isset($_POST["save"])) {                                  
        
        $brand = $_POST["brand_select"];
        $model = $_POST["model_select"];
        $memory = $_POST["memory"];
        $count = $_POST["count"];
        $ID_color = $_POST["select_color"];
        $code_video = $_POST["code_video"];

        $result_brand_ID = mysqli_query($link, "SELECT ID FROM `brands` WHERE brand='$brand'");
        $row_brand_ID = mysqli_fetch_assoc($result_brand_ID);
        $ID_brand = $row_brand_ID["ID"];

        $result_model = mysqli_query($link, "SELECT ID FROM `models` WHERE model='$model' and ID_brand='$ID_brand'");
        $row_model = mysqli_fetch_assoc($result_model);
        $ID_model = $row_model["ID"];

        $result_group_one=mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_model='$ID_model' AND ID_color='$ID_color'");
        if($row_group_one=mysqli_fetch_assoc($result_group_one)) {
            $ID_group = $row_group_one["ID"];    
        }
        else {
            $result_group_one=mysqli_query($link, "INSERT INTO groups(ID_model, ID_color) VALUE ('$ID_model', '$ID_color')");
            $result_group=mysqli_query($link, "SELECT ID FROM `groups` ORDER BY ID DESC LIMIT 1");
            $row_group=mysqli_fetch_assoc($result_group); 
            $ID_group = $row_group["ID"];
        }
        $input = $row_model["ID"].$memory;
        $code = str_pad($input, 6, "0", STR_PAD_LEFT);
        
        if(($count == 0) || ($count == '')) {
            $query_data_product="UPDATE `products` SET ID_group='$ID_group', memory='$memory', `count`='$count', 
            `code`='$code', `status`='Товара нет в наличии' WHERE ID='$ID'";       
        }
        else {          
            $query_data_product="UPDATE `products` SET ID_group='$ID_group', memory='$memory', `count`='$count', 
            `code`=$code, `status`='В продаже' WHERE ID='$ID'";
        }
        mysqli_query($link, $query_data_product); 

        if(!empty($code_video)) {
            $query_data_model="UPDATE `models` SET video='$code_video' WHERE ID='$ID_model'"; 
            mysqli_query($link, $query_data_model);
        } 

        if ($m != 0) {
            for($i = 0; $i < 6; $i++) {
                if (!empty($_FILES['photo']['tmp_name'][$i])) {
                    if (addslashes(file_get_contents($_FILES['photo']['tmp_name'][$i]))) {
                        $photo = addslashes(file_get_contents($_FILES['photo']['tmp_name'][$i]));
                        $result_image = mysqli_query($link, "SELECT * FROM `images` WHERE ID='$ID_image[$i]'");
                        if($row_image = mysqli_fetch_assoc($result_image)) {
                            $query_image="UPDATE images SET `image`='$photo', ID_group='$ID_group' WHERE ID='$ID_image[$i]'";
                        }
                        else $query_image = "INSERT INTO images(`image`, ID_group) VALUE ('$photo', '$ID_group')";
                        mysqli_query($link, $query_image); 

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

        $query_data_specifications="UPDATE specifications SET guarantee='$guarantee', sim_format='$sim_format', count_sim='$count_sim', screen_diagonal='$screen_diagonal', 
            screen_resolution='$screen_resolution', body_material='$body_material', OS_version='$OS_version', processor_model='$processor_model', count_cores='$count_cores',
            battery='$battery', size_battery='$size_battery', RAM='$RAM', type_cards='$type_cards', count_cameras='$count_cameras', main_camera='$main_camera', front_camera='$front_camera',
            Bluetooth='$Bluetooth', Wi_fi='$Wi_fi', NFS='$NFS', wire_type='$wire_type', equipment='$equipment', width='$width', height='$height', thickness='$thickness', 
            `weight`='$weight' WHERE ID='$ID_specification_one'"; 

        if(mysqli_query($link, $query_data_specifications)) {
            $query_product_2 = "UPDATE `products` SET ID_specification='$specification_ID' WHERE ID='$ID'";
            mysqli_query($link, $query_product_2);    
        } 
 
        header("Location: products-area.php?page=1");
    }             
} 
include_once("footer.php"); 
ob_end_flush();
?>
<script>
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