<?php
include_once("link.php");
$token=$_COOKIE['cookieToken'];
$query = "SELECT * FROM `users` WHERE token='$token'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result); 
$ID = $row["ID"]; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/menu.css"></head>

    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>

<header class="header">
    <? ini_set('date.timezone', 'Asia/Yekaterinburg'); ?>
    <div class="header-grid">
        <div class="title-logo">
            <a class="title" href="index.php">PhoneSet</a>
            <a class="button-icons"><i class="bi bi-phone logo"></i></a>
        </div>

        <div class="support">
            <a class="link" href="tel:+79605196239">+7(965)534-92-64</a>
            <a class="link" href="#">г. Асбест, ул.Ленинградская, 26</a>
        </div>

        <div class="icons">
            <form method="post" id="modals" class="icon">
                <? if(($row["ID_right"] == 4) || (empty($token))) { ?>
                    <a class="button-icons" data-bs-target="#modal-heart" data-bs-toggle="modal" onclick="open_favorite()" href="#">
                        <i class="bi bi-suit-heart button-icons"></i>
                        <? $result_count_favorite = mysqli_query($link, "SELECT * FROM `favorites` WHERE ID_user='$ID'"); 
                        $count_favorite = mysqli_num_rows($result_count_favorite); 
                        if($count_favorite > 0) { ?>
                            <span id="favorite_block">
                                <span class="button-icons-count button-icons-favorite" id="count_favorite"><? echo $count_favorite ?></span>
                            </span>
                        <? } ?>
                    </a>
                    <a class="button-icons" data-bs-target="#modal-cart" data-bs-toggle="modal" onclick="open_cart()" href="#">
                        <i class="bi bi-cart3 button-icons"></i>
                        <? $result_count_cart = mysqli_query($link, "SELECT * FROM `carts` WHERE ID_user='$ID'"); 
                        $count_cart = mysqli_num_rows($result_count_cart); 
                        if($count_cart > 0) { ?>
                            <span id="cart_block">
                                <span class="button-icons-count button-icons-cart" id="count_cart"><? echo $count_cart ?></span>
                            </span>
                        <? } ?>
                    </a>
                <? } ?>
            </form>
        </div>
        
        <?php
        if (!empty($token)) { ?>
            <div class="person">
                <? if ($row['user_photo'] != '') { ?>
                    <a class="link" href="person-area.php"><img class="img-menu" src="data:image/jpeg;base64, <? echo base64_encode($row['user_photo']) ?>"></a>
                <? } else { ?> <a class="link" href="person-area.php"><img class="img-menu" src="img/avatar.jpg"></a> <?php } ?>
                <a class="link" style="margin-right: 10px;" href="person-area.php"><?php echo $row["name"]; ?></a>
                <a class="link" href="exit.php">Выйти</a>
            </div>
        <? } else { ?>
            <div class="person">
                <a class="link" style="margin-right: 10px;" href="autorization.php">Авторизация</a>
                <a class="link" href="registration.php">Регистрация</a>
            </div>

        <? } ?>
    </div>

        <div class="modal fade" id="modal-cart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" >

                    <div class="modal-header">
                        <input type="hidden" value="<? echo $ID; ?>" id="IdUser" name="idUser">
                        <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="close_modal()"></button>
                    </div>
                    <? 
                    $result_num_cart=mysqli_query($link, "SELECT * FROM `carts` WHERE ID_user='$ID'");
                    if (!empty($token)) { 
                        if(mysqli_num_rows($result_num_cart) != 0) { ?>
                        <div class="modal-body" id="cart_update">
                            <form method="post" id="cartForm">
                                <table class="table" id="table_cart">
                                    <tbody>
                                        <? $product = array();
                                        $query_cart = "SELECT * FROM `carts` WHERE ID_user='$ID' ORDER BY date_cart DESC";
                                        $result_cart = mysqli_query($link, $query_cart);
                                        while ($row_cart = mysqli_fetch_assoc($result_cart)) {
                                            $ID_product = $row_cart["ID_product"];

                                            if (!in_array($ID_product, $product)) {
                                                $product[] = $ID_product;

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

                                                <tr class="one-line" id="line<? echo $row_cart['ID']; ?>">
                                                    <td class="block-image-cart" rowspan="2"><img class="image-cart" src="data:image/jpeg;base64, <? echo base64_encode($row_image['image']) ?>"></td>
                                                    <td class="col1">
                                                        <a href="#" class="link-product"><? echo $row_brand["brand"] . " "; echo $row_model["model"] . " "; echo $row_product["memory"] . " "; echo $row_color["name"];?></a>
                                                    </td>
                                                    <td class="text col2">
                                                        <div name="one-price">
                                                            <input type="hidden" id="one-price<? echo $row_cart['ID']; ?>" value="<? echo $new_price; ?>">
                                                            <span class="main-price" id="price<? echo $row_cart['ID']; ?>"><? echo $new_price * $row_cart['count']; ?></span><span class="main-price">  ₽</span>
                                                        </div><br>
                                                        <div class="number">
                                                            <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(), send_count(<? echo $row_cart['ID']; ?>, '-', <? echo $row_product['count'] ?>)">-</button>
                                                            <input class="number-center" type="number" id="cart-count<? echo $row_cart['ID']; ?>" min="1" max="<? echo $row_product['count']; ?>" value="<? echo $row_cart['count']; ?>" readonly>
                                                            <button class="number-plus" type="button" <? if ($row_cart['count'] < $row_product['count']+1) { ?>onclick="this.previousElementSibling.stepUp(), send_count(<? echo $row_cart['ID']; ?>, '+', <? echo $row_product['count'] ?>)" <? } ?>>+</button>
                                                        </div>
                                                    </td>
                                                    <? $totalPrice = $totalPrice + ($new_price * $row_cart['count']); ?>
                                                    <td class="col3">
                                                        <button class="button-icons-close" id="delete_cart<? echo $row_cart['ID']; ?>" onclick="delete_cart(<? echo $row_cart['ID']; ?>);">
                                                            <i class="bi bi-x-lg link-product"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr></tr>
                                            <? }
                                        } ?>
                                    </tbody>
                                </table>
                                <? $result_cart_delete = mysqli_query($link, "SELECT * FROM `carts` WHERE ID_user='$ID'");
                                if(mysqli_num_rows($result_cart_delete)) { ?>
                                    <div id="footer_cart" class="modal-footer footer-border">
                                        <p class="all-price">Общая стоимость всех товаров <span id="total_price"><? echo $totalPrice; ?></span><span>  ₽</span></p>
                                        <span class="all-price-two" id="total_price">Итого <? echo $totalPrice; ?> ₽</span>
                                        <button class="btn-cart btn-checkout"><a href="ordering.php" class="link-cart">Оформить заказ</a></button>
                                        </div>
                                    </div>
                                <? } ?>
                            </form>
                        </div> 
                        <? }
                        else {  ?>
                            <div class="not-result">
                                <p class="text-not-result">Для корзине нет товаров</p>
                            </div>
                        <? } 
                    }
                    else {  ?>
                        <div class="not-result">
                            <p class="text-not-result">Для добавлений товаров в корзину необходимо зарегистрироваться или войти</p>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-heart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Избранное</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="close_modal()"></button>
                    </div>

                    <? $result_num_favorite=mysqli_query($link, "SELECT * FROM `favorites` WHERE ID_user='$ID'");
                    if (!empty($token)) { 
                        if(mysqli_num_rows($result_num_favorite) != 0) { ?>
                        <div class="modal-body">
                            <form method="post" id="favoriteForm">
                                <table class="table" id="favorite_update">                                   
                                    <tbody>
                                        <? $favorite_product = array();
                                        $query_favorite = "SELECT * FROM `favorites` WHERE ID_user='$ID' ORDER BY date_favorite DESC";
                                        $result_favorite = mysqli_query($link, $query_favorite);
                                        $count = 0;
                                        $all_count = mysqli_num_rows($result_favorite);
                                        while ($row_favorite = mysqli_fetch_assoc($result_favorite)) {
                                            $ID_product_2 = $row_favorite["ID_product"];
                                            $count = $count + 1;
                                            if (!in_array($ID_product_2, $favorite_product)) {
                                                $favorite_product[] = $ID_product_2;

                                                $result_product_2 = mysqli_query($link, "SELECT * FROM `products` WHERE ID='$ID_product_2'");
                                                $row_product_2 = mysqli_fetch_assoc($result_product_2);

                                                $ID_group_2 = $row_product_2["ID_group"];
                                                $result_group_2=mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$ID_group_2'");
                                                $row_group_2=mysqli_fetch_assoc($result_group_2); 

                                                $ID_model_2 = $row_group_2['ID_model'];
                                                $result_model_2 = mysqli_query($link, "SELECT ID_brand, model FROM `models` WHERE ID='$ID_model_2'");
                                                $row_model_2 = mysqli_fetch_assoc($result_model_2);

                                                $ID_brand_2 = $row_model_2["ID_brand"];
                                                $result_brand_2 = mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$ID_brand_2'");
                                                $row_brand_2 = mysqli_fetch_assoc($result_brand_2);

                                                $ID_color_2 = $row_group_2["ID_color"];
                                                $result_color_2 = mysqli_query($link, "SELECT `name` FROM `colors` WHERE ID='$ID_color_2'");
                                                $row_color_2 = mysqli_fetch_assoc($result_color_2);

                                                $result_cart = mysqli_query($link, "SELECT ID FROM `carts` WHERE ID_product='$ID_product_2' and ID_user='$ID'");
                                                $row_cart = mysqli_fetch_assoc($result_cart);

                                                $date_2 = '0000-00-00';
                                                $result_price_2 = mysqli_query($link, "SELECT * FROM `prices` WHERE ID_product='$ID_product_2'");
                                                while ($row_price_2 = mysqli_fetch_assoc($result_price_2)) {
                                                    if ($row_price_2['date'] > $date_2) {
                                                        $price_2 = $row_price_2['price'];
                                                        $date_2 = $row_price_2['date'];
                                                    }
                                                }
                                                $result_image_2=mysqli_query($link, "SELECT `image` FROM `images` WHERE ID_group='$ID_group_2' ORDER BY ID_group DESC");
                                                $row_image_2=mysqli_fetch_assoc($result_image_2);

                                                $new_price_2 = round($price_2 - ($price_2 / 100 * $row_product_2["discount"])); ?>

                                                <tr class="one-line" id="line2<? echo $row_favorite['ID']; ?>">
                                                    <input type="hidden" name="ID_favorite" id="ID_favorite<?php printf($row_favorite['ID']) ?>" value="<?php printf($row_favorite['ID']) ?>">
                                                    <td class="block-image-cart" rowspan="2"><img class="image-cart" src="data:image/jpeg;base64, <? echo base64_encode($row_image_2['image']) ?>"></td>
                                                    <td class="col1">
                                                        <a href="#" class="link-product"><? echo $row_brand_2["brand"] . " "; echo $row_model_2["model"] . " "; echo $row_product_2["memory"] ." "; echo $row_color_2["name"]; ?></a>
                                                    </td>
                                                    <td class="text col2">
                                                        <div name="one-price">
                                                            <p class="main-price"><? echo $new_price_2; ?><span class="main-price">  ₽</span></p>
                                                        </div><br><br>
                                                    </td>
                                                    <td class="col3" rowspan="2">
                                                        <button class="button-icons-close" id="delete_favorite<? echo $row_favorite['ID']; ?>" onclick="delete_favorite(<? echo $row_favorite['ID']; ?>)">
                                                            <i class="bi bi-x-lg link-product"></i>
                                                        </button>
                                                        <? if ($row_cart["ID"] == '') { ?>
                                                            <button type="button" class="button button-like" id="buy2<? echo $row_favorite['ID']; ?>" onclick="add_cart(<? echo $row_favorite['ID']; ?>)">В корзину</button>
                                                        <? } 
                                                        else { ?>
                                                            <button class="button-product-afore_favorite" type="button">В корзинe</button>
                                                        <? } ?>
                                                    </td>
                                                </tr>
                                                <tr></tr>
                                            <? }
                                        } ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    <? }
                    else { ?> 
                        <div class="not-result">
                            <p class="text-not-result">В избранном нет товаров</p>
                        </div>  
                    <? } 
                } 
                else { ?> 
                    <div class="not-result">
                        <p class="text-not-result">Для добавлений товаров в избранное необходимо зарегистрироваться и войти</p>
                    </div>  
                <? } ?>

            </div>
        </div>
    </div>
</header>

<script>  
    function open_favorite() {
        $("#favoriteForm").load("menu.php #favorite_update");
    }

    function open_cart() {
        $("#favoriteForm").load("menu.php #favorite_update");
        $("#cart_update").load("menu.php #cartForm");
    }

    function close_modal() {
        $("#cart_update").load("menu.php #cartForm");
        $("#favoriteForm").load("menu.php #favorite_update");
        $("#product").load("index.php #product");
        $("#filtration").load("index.php #filtration");
    }

    function send_count(id_cart, sign, max_count) {
        var servResponse = document.querySelector('#total_price');

        var count = document.getElementById("cart-count" + id_cart).value;
        
        if(count < max_count+1) {
            var onePrice = Number(document.getElementById('one-price' + id_cart).value);
            var price = Number(document.getElementById("price" + id_cart).innerText);
            var ID_user = document.getElementById("IdUser").value;

            var xhr = new XMLHttpRequest();

            xhr.open('POST', 'function-count-price.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    max_price = onePrice*max_count;
                    if ((sign == '+') && (price != max_price)) {
                        document.getElementById("price" + id_cart).innerText = price + onePrice;
                    }
                    if ((sign == "-") && (price != onePrice)) {
                        document.getElementById("price" + id_cart).innerText = price - onePrice;
                    }
                    servResponse.textContent = xhr.responseText;
                    var text = servResponse.textContent;
                    document.getElementById("total_price").innerText = text;
                }
            }

            xhr.send(`count=${count}` + `&id=${id_cart}` + `&user=${ID_user}`);    
        }         
    }

    function delete_cart(id_cart) {
        var servResponse = document.querySelector('#line' + id_cart);

        var ID_user = document.getElementById("IdUser").value;

        document.forms.cartForm.onsubmit = function(e) {
            e.preventDefault();
        }

        var table = document.getElementById("table_cart");
        var count = table.rows.length;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-delete-cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if(count == 2) {
                    document.getElementById("line" + id_cart).remove();
                    // document.getElementById("footer_cart").style.display = "none";
                    $("#table_cart").load("menu.php #cartForm");
                }
                else {
                    document.getElementById("line" + id_cart).remove();
                    var text = xhr.responseText;
                    document.getElementById("total_price").innerText = text;    
                }
                
            }
        }

        xhr.send(`&id=${id_cart}` + `&user=${ID_user}`);
    }

    function delete_favorite(id_favorite) {
        var servResponse = document.querySelector('#line2' + id_favorite);

        document.forms.favoriteForm.onsubmit = function(e) {
            e.preventDefault();
        }

        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-delete-favorite-menu.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("line2" + id_favorite).remove();    
            }
        }

        xhr.send(`&id=${id_favorite}`);
    }

    function add_cart(id_favorite) {
        var servResponse = document.querySelector('#line2' + id_favorite);
 
        var xhr = new XMLHttpRequest();

        xhr.open('POST', 'function-add-cart-menu.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("buy2" + id_favorite).innerText = "В корзине";
            }
            $("#cartForm").load("menu.php #cartForm");
        }

        xhr.send(`&id=${id_favorite}`);
    }
</script>

</html>