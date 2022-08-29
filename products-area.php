<?php
ob_start();
include_once("menu.php");
include_once("link.php");
include_once("check.php");
include_once("menu-area.php");

if ($_GET['page'] != '') {
    $page = $_GET['page'];
} else $page = 1;
if ($_GET['sort'] != '') {
    $sort = $_GET['sort'];
}
if ($_GET['brand'] != '') {
    $brand = $_GET['brand'];
}
if ($_GET['model'] != '') {
    $model = $_GET['model'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PhoneSet - товары</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <link rel="stylesheet" href="css/products-area.css">
</head>

<body>
    <main>
        <? $query_products = "SELECT * FROM `products`";
        if ($result_products  = mysqli_query($link, $query_products)) { ?>
            <div class="main-products">
                <div class="block-products">
                    <p class="title-area">Товары</p>
                    <? $all_count = mysqli_num_rows($result_products);
                    $result_brand_2 = mysqli_query($link, "SELECT * FROM `brands`"); ?>
                    <div>                     
                        <? $all_count = mysqli_num_rows($result_products);
                        $result_brand_2 = mysqli_query($link, "SELECT * FROM `brands`"); ?>
                        <form class="selects-products" method="post">
                            <select class="select-products" name="select_brand" id="select_brand" onchange="name_brand()">
                                <? if(empty($brand)) { ?>
                                    <option class="options" disabled selected>Выберите бренд</option>
                                <? } ?>
                                <? while ($row_brand_2 = mysqli_fetch_array($result_brand_2)) { ?>
                                    <option <? if ($row_brand_2["ID"] == $brand) { echo "selected"; } ?> value='<? echo $row_brand_2["ID"]; ?>'><? echo $row_brand_2["brand"]; ?></option>
                                <? } ?>
                            </select>
                            <select class="select-products" id="model_select" name="model_select" onchange="name_model()">
                                <option class="options" disabled selected>Выберите модель</option>
                                <? if(!empty($brand)) {
                                    $result_model_2 = mysqli_query($link, "SELECT * FROM `models` WHERE ID_brand='$brand'");
                                    while($row_model_2 = mysqli_fetch_assoc($result_model_2)) { ?>
                                        <option <? if ($row_model_2["ID"] == $model) { echo "selected"; } ?> value='<? echo $row_model_2["ID"]; ?>'><? echo $row_model_2["model"]; ?></option>
                                    <? }    
                                } ?>
                            </select>
                            <input type="submit" id="hidden_save" name="hidden_save" style="display:none;">
                        </form>
                        <script>
                            function name_brand() {
                                document.getElementById("model_select").selected = false;
                                var select = document.querySelector('#model_select').getElementsByTagName('option');
                                select[0].selected=true;
                                document.getElementById("hidden_save").click();
                            }
                            function name_model() {
                                document.getElementById("hidden_save").click();
                            }
                        </script>
                        <a class="link-area" href="products-area.php?page=<? echo $page ?>">Сбросить фильтры</a>
                        <span class="all-area">Всего товаров: <? echo $all_count ?></span>
                    </div><br>
                    <div class="table-responsive">
                        <table class="table area-table">
                            <? $lenght_sort_check = strlen($sort);
                            if ($lenght_sort_check != 0) {
                                $one_field = array();
                                $count_fields = 0;
                                for ($i = 0; $i < $lenght_sort_check; $i++) {
                                    $result_sort = substr($sort, $i, 1);
                                    if (!in_array($result_sort, $one_field)) {
                                        $one_field[] = $result_sort;
                                        $count_fields = $count_fields + 1;
                                    }
                                }
                                for ($i = 1; $i <= 5; $i++) {
                                    $count_one = substr_count($sort, $i);
                                    if ($count_one > 2) {
                                        $sort = str_replace($i, '', $sort);
                                        $sort = $sort . $i;
                                        header("location: products-area.php?page=" . $page . "&sort=" . $sort . "&brand=" . $brand . "&model=" . $model);
                                    }
                                }
                            } ?>

                            <? $num = 10;   // Переменная хранит число сообщений выводимых на станице
                            $query_count = "SELECT * FROM `products`"; // Определяем общее число сообщений в базе данных

                            if (isset($_POST["hidden_save"])) {
                                if(!empty($_POST["model_select"])) header("Location: products-area.php?page=". $page ."&brand=" . $_POST["select_brand"] . "&model=" . $_POST["model_select"]);
                                else header("Location: products-area.php?page=". $page ."&brand=" . $_POST["select_brand"]);
                            }

                            $result_count = mysqli_query($link, $query_count);
                            $posts_count = mysqli_num_rows($result_count);

                            $total = intval(($posts_count - 1) / $num) + 1;   // Находим общее число страниц     
                            $page = intval($page);  // Определяем начало сообщений для текущей страницы                 
                            if (empty($page) or $page < 0) $page = 1;
                            if ($page > $total) $page = $total;
                            $start = $page * $num - $num; // Вычисляем начиная к какого номера следует выводить сообщения

                            if ((!empty($_GET["brand"])) && (empty($_GET["model"]))) {
                                $i = 0;
                                $ID_brand = $_GET["brand"];
                                $result_model_two = mysqli_query($link, "SELECT ID FROM `models` WHERE ID_brand='$ID_brand'");
                                while ($row_model_two = mysqli_fetch_array($result_model_two)) {
                                    $ID_model = $row_model_two["ID"];
                                    $result_group_two = mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_model='$ID_model'");
                                    $count = mysqli_num_rows($result_group_two);
                                    while ($row_group_two = mysqli_fetch_array($result_group_two)) {
                                        $ID_group = $row_group_two["ID"];
                                        $result_product_two = mysqli_query($link, "SELECT * FROM `products` WHERE ID_group='$ID_group'");
                                        $count_two = mysqli_num_rows($result_product_two);
                                        while($row_product_two = mysqli_fetch_array($result_product_two)) {
                                            $ID_product = $row_product_two["ID"];

                                            if ($i == 0) {
                                                $query_product_brand = "ID='$ID_product'";
                                            }
                                            else {
                                                $query_product_brand = $query_product_brand." OR ID='$ID_product'";
                                            }
                                            $i = $i + 1;
                                        }                                          
                                    }    
                                }
                                if($i != 0) {
                                    $query_brand = "WHERE (".$query_product_brand. ")";    
                                }
                                else $error_filt = true;

                            }

                            if (!empty($_GET["model"])) {
                                $i = 0;
                                $ID_model = $_GET["model"];
                                $result_model_two = mysqli_query($link, "SELECT ID FROM `models` WHERE ID='$ID_model'");
                                $row_model_two = mysqli_fetch_array($result_model_two);
                                
                                $ID_model = $row_model_two["ID"];

                                $result_group_two = mysqli_query($link, "SELECT ID FROM `groups` WHERE ID_model='$ID_model'");
                                $count = mysqli_num_rows($result_group_two);
                                while ($row_group_two = mysqli_fetch_array($result_group_two)) {
                                    $ID_group = $row_group_two["ID"];

                                    $result_product_two = mysqli_query($link, "SELECT * FROM `products` WHERE ID_group='$ID_group'");
                                    $count_two = mysqli_num_rows($result_product_two);
                                    while($row_product_two = mysqli_fetch_array($result_product_two)) {
                                        $ID_product = $row_product_two["ID"];

                                        if ($i == 0) {
                                            $query_product_brand = "ID='$ID_product'";
                                        }
                                        else {
                                            $query_product_brand = $query_product_brand." OR ID='$ID_product'";
                                        }
                                        $i = $i + 1;                                       
                                    }                       
                                }
                                if($i != 0) {
                                    $query_brand = "WHERE (".$query_product_brand.")";    
                                }  
                                else $error_filt = true;
                            }

                            if((!empty($_GET["brand"])) || (!empty($_GET["model"]))) {
                                if(!$error_filt) {
                                    $query_all = "SELECT * FROM `products` ".$query_brand;

                                    $result_count_two = mysqli_query($link, $query_all);
                                    $posts_count = mysqli_num_rows($result_count_two);
                                    
                                    $total = intval(($posts_count - 1) / $num) + 1;   // Находим общее число страниц     
                                    $page = intval($page);  // Определяем начало сообщений для текущей страницы                 
                                    if (empty($page) or $page < 0) $page = 1;
                                    if ($page > $total) $page = $total;
                                    $start = $page * $num - $num; // Вычисляем начиная к какого номера следует выводить сообщения
                                }
                                else $posts_count = 0;
                            }
                            else $query_all = "SELECT * FROM `products` ";

                            $lenght_sort = strlen($sort);
                            $one_product = array();
                            $count_fields = 0;
                            $one_field = array();
                            $count = array();
                            if ($lenght_sort != 0) {
                                $query_sort = "ORDER BY ";
                                for ($i = 0; $i < $lenght_sort; $i++) {
                                    $result_sort = substr($sort, $i, 1);
                                    if (!in_array($result_sort, $one_field)) {
                                        $one_field[] = $result_sort;
                                        $new_sort = $new_sort . $result_sort;
                                        $count_fields = $count_fields + 1;
                                    }
                                }
                                
                                for ($i = 0; $i < $lenght_sort; $i++) {
                                    $result_sort = substr($sort, $i, 1);
                                    if ($result_sort == 1) $count[1] = $count[1] + 1;
                                    if ($result_sort == 2) $count[2] = $count[2] + 1;
                                    if ($result_sort == 3) $count[3] = $count[3] + 1;
                                    if ($result_sort == 4) $count[4] = $count[4] + 1;
                                    if ($result_sort == 5) $count[5] = $count[5] + 1;
                                }
                                for ($i = 0; $i < $count_fields; $i++) {
                                    $result_sort = substr($new_sort, $i, 1);
                                    if ($result_sort == 1) $field = "ID";
                                    if ($result_sort == 2) $field = "popularity";
                                    if ($result_sort == 3) $field = "discount";
                                    if ($result_sort == 4) $field = "count";
                                    if ($result_sort == 5) $field = "status";

                                    if (($count_fields > 1) && ($i == 0)) {
                                        if ($count[$result_sort] >= 2) {
                                            $query_sort = $query_sort . $field . " ASC, ";
                                        } else $query_sort = $query_sort . $field . " DESC, ";
                                    } else if (($count_fields > 1) && ($i != 0) && ($count_fields - 1 != $i)) {
                                        if ($count[$result_sort] >= 2) {
                                            $query_sort = $query_sort . $field . " ASC, ";
                                        } else $query_sort = $query_sort . $field . " DESC, ";
                                    }
                                    if (($count_fields - 1 == $i)) {
                                        if ($count[$result_sort] == 2) {
                                            $query_sort = $query_sort . $field . " ASC";
                                        } else $query_sort = $query_sort . $field . " DESC";
                                    }
                                }
                                $query_all = $query_all. $query_sort . " LIMIT $start, $num ";
                            } 
                            else $query_all = $query_all." LIMIT $start, $num ";
                                
                            if($posts_count > 0) { ?>
                                <tr>
                                    <? $lenght_sort_check = strlen($sort);
                                    if ($lenght_sort_check != 0) {
                                        $one_field = array();
                                        $count_fields = 0;
                                        for ($i = 0; $i < $lenght_sort_check; $i++) {
                                            $result_sort = substr($sort, $i, 1);
                                            if (!in_array($result_sort, $one_field)) {
                                                $one_field[] = $result_sort;
                                                $count_fields = $count_fields + 1;
                                            }
                                        }
                                        for ($i = 1; $i <= 5; $i++) {
                                            $count_one = substr_count($sort, $i);
                                            if ($count_one > 2) {
                                                $sort = str_replace($i, '', $sort);
                                                $sort = $sort . $i;
                                                header("location: products-area.php?page=" . $page . "&sort=" . $sort . "&brand=" . $brand . "&model=" . $model);

                                            }
                                        }
                                    } ?>
                                    <th class="area-title"><a class="link-sort" href="products-area.php?page=<? echo $page ?>&sort=<? echo $sort . '1' ?>&brand=<? echo $brand ?>&model=<? echo $model ?>">ID</a></th>
                                    <th class="area-title">Название</th>
                                    <th class="area-title"><a class="link-sort" href="products-area.php?page=<? echo $page ?>&sort=<? echo $sort . '2' ?>&brand=<? echo $brand ?>&model=<? echo $model ?>">Просмотры</a></th>
                                    <th class="area-title">Заказы</th>
                                    <th class="area-title">Стоимость</th>
                                    <th class="area-title"><a class="link-sort" href="products-area.php?page=<? echo $page ?>&sort=<? echo $sort . '3' ?>&brand=<? echo $brand ?>&model=<? echo $model ?>">Скидка</a></th>
                                    <th class="area-title">Дата скидки</th>
                                    <th class="area-title"><a class="link-sort" href="products-area.php?page=<? echo $page ?>&sort=<? echo $sort . '4' ?>&brand=<? echo $brand ?>&model=<? echo $model ?>">Кол-во</a></th>
                                    <th class="area-title"><a class="link-sort" href="products-area.php?page=<? echo $page ?>&sort=<? echo $sort . '5' ?>&brand=<? echo $brand ?>&model=<? echo $model ?>">Статус товара</a></th>
                                    <th colspan="4" class="area-title">Действие</th>
                                </tr>
                                <? $result_all = mysqli_query($link, $query_all);
                                while ($row_all = mysqli_fetch_assoc($result_all)) {
                                    $check_status = 0;
                                    $ID = $row_all['ID'];

                                    $ID_product = $row_all['ID'];

                                    $popularity = $row_all["popularity"];

                                    $date = '0000-00-00 00:00:00';
                                    $result_price = mysqli_query($link, "SELECT ID, price, `date` FROM `prices` WHERE ID_product='$ID_product'");
                                    while ($row_price = mysqli_fetch_assoc($result_price)) {
                                        if ($row_price['date'] > $date) {
                                            $date = $row_price['date'];
                                            $price = $row_price['price'];
                                            $ID_price_one = $row_price['ID'];
                                        }
                                    }

                                    $group_ID = $row_all["ID_group"];
                                    $result_group = mysqli_query($link, "SELECT * FROM `groups` WHERE ID='$group_ID'");
                                    $row_group = mysqli_fetch_assoc($result_group);

                                    $model_ID = $row_group["ID_model"];
                                    $result_model = mysqli_query($link, "SELECT model, ID_brand FROM `models` WHERE ID='$model_ID'");
                                    $row_model = mysqli_fetch_assoc($result_model);

                                    $brand_ID = $row_model["ID_brand"];
                                    $result_brand = mysqli_query($link, "SELECT brand FROM `brands` WHERE ID='$brand_ID'");
                                    $row_brand = mysqli_fetch_assoc($result_brand);

                                    $count_product = 0;
                                    $result_count_order = mysqli_query($link, "SELECT `count` FROM `orders` WHERE ID_product='$ID'");
                                    while($row_count_order = mysqli_fetch_assoc($result_count_order)) {
                                        $count_product = $count_product + $row_count_order["count"];
                                    }

                                    $ID_product_color = $row_group['ID_color'];
                                    $result_color = mysqli_query($link, "SELECT `name` FROM `colors` WHERE ID='$ID_product_color'");
                                    $row_color = mysqli_fetch_assoc($result_color);

                                    if ($_POST["check-save" . $ID] == 1) {
                                        $price = $_POST["price" . $ID];
                                        $discount = $_POST["discount" . $ID];

                                        if (($discount != '') && ($discount != 0)) {
                                            if ($_POST["date_discount" . $ID] == '') {
                                                $date_discount = date("Y-m-d");
                                            } else $date_discount = $_POST["date_discount" . $ID];
                                        } else $date_discount = NULL;

                                        $date = date("Y-m-d H:i:s");

                                        $count = $_POST["count" . $ID];
                                        $status = $_POST["select_status" . $ID];

                                        if (($count > 0) && ($count != $row_all["count"]) && ($status == "Нет в наличии")) {
                                            $status = "В продаже";
                                        }
                                        if (($status == "Нет в наличии") && ($count != 0) && ($count != '')) {
                                            $count = 0;
                                            $query_count = "UPDATE `products` SET `count`='$count' WHERE ID='$ID'";
                                            mysqli_query($link, $query_count);
                                        }
                                        if (($count == 0) || ($count == '') && $status == "В продаже") $status = "Нет в наличии";
                                        if ($status == "Нет в наличии") {
                                            $status2 = "В архиве";
                                            $status3 = 0;
                                        }
                                        if ($status == "В архиве") {
                                            $status2 = "В продаже";
                                            $status3 = "Нет в наличии";
                                        }
                                        if ($status == "В продаже") {
                                            $status2 = "Нет в наличии";
                                            $status3 = 0;
                                        }
                                    } else {
                                        $status = $row_all['status'];
                                        if ($status == "В продаже") {
                                            $status2 = "Нет в наличии";
                                            $status3 = 0;
                                        }
                                        if ($status == "Нет в наличии") {
                                            $status2 = "В продаже";
                                            $status3 = 0;
                                        }
                                        if ($status == "В архиве") {
                                            $status2 = "В продаже";
                                            $status3 = "Нет в наличии";
                                        }
                                        $discount = $row_all["discount"];
                                        $date_discount = $row_all["date_discount"];
                                        $count = $row_all["count"];
                                    }
                                ?>

                                    <tr>
                                        <form name="form<? echo $ID ?>" method="post" action="">
                                            <td class="area-text">
                                                <input type="hidden" name="ID" id="ID" value="<?php printf($row_all["ID"]) ?>" size="5px"><?php printf($row_all["ID"]) ?>
                                            </td>
                                            <input type="hidden" name="check-save<? echo $ID ?>" id="check-save<? echo $ID ?>" value="">
                                            <td class="area-text"><?php printf($row_brand['brand'] . " " . $row_model["model"] . " " . $row_all["memory"] . " ГБ " . $row_color["name"]) ?></td>
                                            <td class="area-text area-center"><?php echo $popularity ?></td>
                                            <td class="area-text area-center"><?php echo $count_product ?></td>
                                            <td class="area-text"><input class="input-products" type="number" name="price<? echo $ID ?>" id="price<? echo $ID ?>" min="0" value="<? echo $price; ?>"></td>
                                            <td class="area-text"><input class="input-products" type="number" name="discount<? echo $ID ?>" id="discount<? echo $ID ?>" min="0" value="<? echo $discount; ?>"></td>
                                            <td class="area-text"><input class="input-products" type="date" name="date_discount<? echo $ID ?>" id="date_discount<? echo $ID ?>" value="<? echo $date_discount; ?>"></td>
                                            <td class="area-text"><input class="input-products" type="number" name="count<? echo $ID ?>" id="count<? echo $ID ?>" min="0" value="<? echo $count; ?>"></td>
                                            <td class="area-text">
                                                <select class="select-product" id="select_status<? echo $ID ?>" name="select_status<? echo $ID ?>">
                                                    <option value='<? echo $status ?>' selected><? echo $status ?></option>
                                                    <option value='<? echo $status2 ?>'><? echo $status2 ?></option>
                                                    <? if ($status3 != "0") { ?>
                                                        <option value='<? echo $status3 ?>'><? echo $status3 ?></option>
                                                    <? } ?>

                                                </select>
                                            </td>

                                            <td class="area-text">
                                                <button class="btn-products" type="submit" name="save<? echo $ID ?>" title="Сохранить" onclick="document.getElementById('check-save<? echo $ID ?>').value='1';">
                                                    <i id="cart-icon<? echo $ID_product; ?>" class="bi bi-check2"></i>
                                                </button>
                                            </td>
                                            <td class="area-text">
                                                <button class="btn-products" type="submit" name="copy<? echo $ID ?>" title="Копировать">
                                                    <i id="cart-icon<? echo $ID_product; ?>" class="bi bi-plus"></i>
                                                </button>
                                            </td>
                                            <td class="area-text">
                                                <button class="btn-products" type="submit" name="edit<? echo $ID ?>" title="Изменить">
                                                    <i id="cart-icon<? echo $ID_product; ?>" class="bi bi-pencil"></i>
                                                </button>
                                            </td>
                                            <td class="area-text">
                                                <button class="btn-products" type="submit" name="delete<? echo $ID ?>" title="Удалить">
                                                    <i id="cart-icon<? echo $ID_product; ?>" class="bi bi-trash"></i>
                                                </button>
                                            </td>

                                        </form>
                                    </tr>
                                <? if (isset($_POST["copy" . $ID])) {
                                        header("location: create-product-area.php?ID=" . $row_all["ID"]);
                                    }

                                    if (isset($_POST["edit" . $ID])) {
                                        header("location: edit-product-area.php?ID=" . $row_all["ID"]);
                                    }

                                    if (isset($_POST["delete" . $ID])) {
                                        $query_delete = "UPDATE `products` SET `status`='В архиве' WHERE ID='$ID'";
                                        if(mysqli_query($link, $query_delete)) {
                                            header("location: products-area.php?page=" . $page);    
                                        }
                                        
                                    }
                                    if (isset($_POST["save" . $ID])) {

                                        $ID =  $_POST["ID"];

                                        $count = $_POST["count" . $ID];
                                        $status = $_POST["select_status" . $ID];

                                        $query_price_2 = "SELECT price, `date` FROM `prices` WHERE ID='$ID_price_one'";
                                        $result_price_2 = mysqli_query($link, $query_price_2);
                                        $row_price_2 = mysqli_fetch_assoc($result_price_2);

                                        $query_product_2 = "SELECT discount, date_discount FROM `products` WHERE ID='$ID'";
                                        $result_product_2 = mysqli_query($link, $query_product_2);
                                        $row_product_2 = mysqli_fetch_assoc($result_product_2);

                                        $discount = $row_product_2["discount"]; //Старая скидка
                                        $date_discount = $row_product_2["date_discount"]; //Старая дата скидки 

                                        $discount_new = $_POST["discount" . $ID];
                                        $date_discount_new = $_POST["date_discount" . $ID];

                                        $price = $row_price_2["price"]; //Старая цена
                                        $date_price = $row_price_2["date"];  //Старая дата цены	

                                        $price_new = $_POST["price" . $ID];

                                        if (($status != $row_all['status']) || ($count != $row_all["count"])) {
                                            if ($status == "В архиве") {
                                                $query_status = "UPDATE `products` SET `count`='$count', `status`='В архиве' WHERE ID='$ID'";
                                                $_POST["select_status" . $ID] = "В архиве";
                                                $_POST["count" . $ID] = $count;
                                            } else 
                                                if ($row_all["count"] == 0 && $count > 0) {
                                                $query_status = "UPDATE `products` SET `count`='$count', `status`='В продаже' WHERE ID='$ID'";
                                                $_POST["select_status" . $ID] = 'В продаже';
                                                $_POST["count" . $ID] = $count;
                                            } else
                                                if ($count == 0) {
                                                $query_status = "UPDATE `products` SET `count`=0, `status`='Нет в наличии' WHERE ID='$ID'";
                                                $_POST["select_status" . $ID] = "Нет в наличии";
                                                $_POST["count" . $ID] = 0;
                                            } else
                                                if ($status == "Нет в наличии") {
                                                $query_status = "UPDATE `products` SET `count`=0, `status`='Нет в наличии' WHERE ID='$ID'";
                                                $_POST["select_status" . $ID] = "Нет в наличии";
                                                $_POST["count" . $ID] = 0;
                                            } else {
                                                $query_status = "UPDATE `products` SET `count`='$count', `status`='$status' WHERE ID='$ID'";
                                                $_POST["select_status" . $ID] = $status;
                                                $_POST["count" . $ID] = $count;
                                            }

                                            if (mysqli_query($link, $query_status)) {
                                                $accept = 1;
                                            }
                                        }

                                        if (($discount_new != $discount) || ($date_discount_new != $date_discount)) {
                                            if (($date_discount_new != $date_discount) && ($date_discount_new != '')) {
                                                if (($date_discount_new != $date_discount) && ($discount_new != '')) {
                                                    if ($date_discount_new >= date("Y-m-d")) {
                                                        $query_save = "UPDATE `products` SET `count`='$count', discount='$discount_new', date_discount='$date_discount_new' WHERE ID='$ID'";
                                                    }
                                                }
                                            }

                                            if (($discount_new == '') || ($discount_new == 0)) {
                                                $query_save = "UPDATE `products` SET `count`='$count', discount=NULL, date_discount=NULL WHERE ID='$ID'";
                                                $date_discount = NULL;
                                            } else if (($date_discount_new == $date_discount) || ($date_discount_new == '')) {
                                                $date_discount = date("Y-m-d");
                                                $query_save = "UPDATE `products` SET `count`='$count', discount='$discount_new', date_discount='$date_discount' WHERE ID='$ID'";
                                            }

                                            if (mysqli_query($link, $query_save)) {
                                                $accept = 1;
                                            } else {
                                                $error_discount = 1;
                                            }
                                        }

                                        if ($price_new != $price) {
                                            $date_price_today = date("Y-m-d H:i:s");
                                            $query_save_price = "INSERT INTO `prices` (price, `date`, ID_product) VALUES ('$price_new', '$date_price_today', $ID)";

                                            if ($query_save_price != '') {
                                                if (mysqli_query($link, $query_save_price)) {
                                                    $accept = 1;
                                                } else {
                                                    $error_price = 1;
                                                }
                                            }
                                        }
                                    }
                                } 
                            } 
                            else { ?>
                                <div class="not-result-two">
                                    <p class="text-not-result-two">Товаров нет</p>
                                </div>  
                            <? } ?>
                        </table>
                    </div>
                    <div class="block-check">
                        <div class="check" id="check"></div><br>
                        <div class="check2" id="check2"></div>
                    </div>
                    <? if ($accept == 1) {
                        echo "<script>
                           check.innerHTML='Изменения прошли успешно'; 
                           document.getElementById('check').classList.add('accept');
                        </script>";
                    }
                    if ($error_discount == 1) {
                        echo "<script>
                            check2.innerHTML='Ошибка, дата скидки может быть только будущей или настоящей'; 
                            document.getElementById('check2').classList.add('error');
                        </script>";
                    }
                    if ($error_price == 1) {
                        echo "<script>
                            check2.innerHTML='Ошибка, дата цены может быть только будущей или настоящей'; 
                            document.getElementById('check2').classList.add('error');
                        </script>";
                    } ?>
                    <? if ($posts_count >= $num) { ?>
                        <div class="pagination-block">
                            <? if ($page != 1) $pervpage = '<a class="page" href=products-area.php?page=1' . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '><i class="bi bi-chevron-double-left"></i></a>
                                                        <a class="page" href=products-area.php?page=' . ($page - 1) . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '><i class="bi bi-chevron-left"></i></a> ';
                            // Проверяем нужны ли стрелки вперед
                            if ($page != $total) $nextpage = ' <a class="page" href=products-area.php?page=' . ($page + 1) . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '><i class="bi bi-chevron-right"></i></a>
                                                            <a class="page" href=products-area.php?page=' . $total . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '><i class="bi bi-chevron-double-right"></i></a>';

                            // Находим две ближайшие станицы с обоих краев, если они есть
                            if ($page - 2 > 0) $page2left = ' <a class="page" href=products-area.php?page=' . ($page - 2) . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '>' . ($page - 2) . '</a>';
                            if ($page - 1 > 0) $page1left = '<a class="page" href=products-area.php?page=' . ($page - 1) . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '>' . ($page - 1) . '</a>';
                            if ($page + 2 <= $total) $page2right = '<a class="page" href=products-area.php?page=' . ($page + 2) . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '>' . ($page + 2) . '</a>';
                            if ($page + 1 <= $total) $page1right = '<a class="page" href=products-area.php?page=' . ($page + 1) . '&sort=' . $sort . '&brand=' . $brand . '&model=' . $model . '>' . ($page + 1) . '</a>';


                            echo $pervpage . $page2left . $page1left . '<a class="page active">' . $page . '</a>' . $page1right . $page2right . $nextpage; // Вывод меню
                            ?>
                            <div>
                            <? } ?>
                            </div>
                        </div>
    </main>
</body>

</html>
<? }
    include_once("footer.php");
    ob_end_flush();
?>