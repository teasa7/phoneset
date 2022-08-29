<?
	ob_start();
	include_once("menu.php"); 
	include_once("link.php");
    include_once("check.php");
    include_once("menu-area.php"); 

    if ($_GET['page'] != '') {
        $page = $_GET['page'];
    }
    else $page = 1;
    if ($_GET['sort'] != '') {
        $sort = $_GET['sort'];
    }
    if ($_GET['area'] != '') {
        $area = $_GET['area'];
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - заказы</title>
        <link rel="icon" type="image/png" href="img/favicon.ico">

  		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  		<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="css/orders.css">
    </head>
	<body>
        <main>  	     
			<div class="main-users">
				<div class="block-users">
                    <p class="title-area">Заказы</p>
                    <div>
                        <form class="selects-areas" method="post" action="">
                            <? $token=$_COOKIE['cookieToken'];
                            $query_info="SELECT * FROM `users` WHERE token='$token'";	
                            $result_info=mysqli_query($link, $query_info);
                            $row_info=mysqli_fetch_assoc($result_info);                    
                            
                            if ($row_info["ID_right"] == "3") { //Есль пользователь - курьер
                                $result_area=mysqli_query($link, "SELECT * FROM `areas`"); //Поиск всех районов ?>
                                <div class="area-block">
                                    <select class="select-area" name="select_area" id="select_area" onchange="name_area()"> 
                                        <? if(empty($area)) { ?>
                                            <option class="options" disabled selected>Выберите район</option>
                                        <? } ?>
                                        <? while($row_area = mysqli_fetch_array($result_area)) { ?>
                                            <!-- Если в GET-запросе есть район, то он выбирается в списке --> 
                                            <option <? if($row_area["area"] == $_GET["area"]) { echo "selected"; } ?> 
                                                value='<? echo $row_area["area"]; ?>'><? echo $row_area["area"]; ?></option>   
                                        <? } ?>
                                    </select>
                                    <input type="submit" id="hidden_save" name="hidden_save" style="display:none;"> 
                                </div>
                                <script>
                                    function name_area() {
                                        document.getElementById("hidden_save").click(); //Нажимаем на кнопку
                                    }
                                </script>  
                            <? } ?>  
                        </form>       
                    
                    <? $lenght_sort_check = strlen($sort); // Количество сортируемых полей
                    if ($lenght_sort_check != 0) {
                        $one_field = array();
                        $count_fields = 0;
                        for ($i = 0; $i < $lenght_sort_check; $i++) {
                            $result_sort = substr($sort, $i, 1); // Получаем 1 значение
                            if (!in_array($result_sort, $one_field)) { // Фильтрация только уникальных значений 
                                // Подсчет количества и запись в массив
                                $one_field[] = $result_sort;
                                $count_fields = $count_fields + 1;
                            }         
                        }
                        for ($i = 1; $i <= 6; $i++) {
                            $count_one = substr_count($sort, $i); // Подсчет количества одинаковых значений
                            if($count_one > 2) { // Если значений больше 2
                                $sort = str_replace($i, '', $sort);  // Удаление этих символов
                                $sort = $sort.$i; // Запись только 1 значения
                                header("location: orders.php?page=".$page."&sort=".$sort);            
                            }                  
                        }                     
                    }     

                    $lenght_sort = strlen($sort);
                    $one_field = array();  
                    $count_fields = 0;
                    $count = array();
                    if ($lenght_sort != 0) { // Если есть сортируемые поля
                        $query_sort = "ORDER BY ";  // Изначальный запрос
                        for ($i = 0; $i < $lenght_sort; $i++) {
                            $result_sort = substr($sort, $i, 1);    // Получаем 1 значение
                            if (!in_array($result_sort, $one_field)) { 
                                /* Записываем уникальные значения и подсчитываем их количество */
                                $one_field[] = $result_sort;
                                $new_sort = $new_sort.$result_sort;
                                $count_fields = $count_fields + 1;
                            }                         
                        }
                        for ($i = 0; $i < $lenght_sort; $i++) {
                            $result_sort = substr($sort, $i, 1); // Получаем 1 значение
                            /* Записываем в разные массивы количество повторяющихся цифр */
                            if ($result_sort == 1) $count[1] = $count[1] + 1;
                            if ($result_sort == 2) $count[2] = $count[2] + 1;
                            if ($result_sort == 3) $count[3] = $count[3] + 1;
                            if ($result_sort == 4) $count[4] = $count[4] + 1;
                            if ($result_sort == 5) $count[5] = $count[5] + 1;                            
                        }
                        for ($i = 0; $i < $count_fields; $i++) {
                            $result_sort = substr($new_sort, $i, 1); // Получаем 1 значение
                            /* Получаем наименование сортируемых полей */
                            if ($result_sort == 1) $field = "code";
                            if ($result_sort == 2) $field = "ID_status";
                            if ($result_sort == 3) $field = "ID_area";
                            if ($result_sort == 4) $field = "date_order";
                            if ($result_sort == 5) $field = "delivery_date";    
                            /* Формируем запрос с учетом каждого поля */
                            if (($count_fields > 1) && ($i == 0)) {
                                if ($count[$result_sort] >= 2) {
                                    $query_sort = $query_sort.$field." ASC, ";      
                                }
                                else $query_sort = $query_sort.$field." DESC, ";     
                            }
                            else if (($count_fields > 1) && ($i != 0) && ($count_fields-1 != $i)) {
                                if ($count[$result_sort] >= 2) {
                                    $query_sort = $query_sort.$field." ASC, ";      
                                }
                                else $query_sort = $query_sort.$field." DESC, ";        
                            }
                            if (($count_fields-1 == $i)) {
                                if ($count[$result_sort] == 2) {
                                    $query_sort = $query_sort.$field." ASC";      
                                }
                                else $query_sort = $query_sort.$field." DESC";        
                            }   
                        }
                    }
                    if(!empty($query_sort)) {
                        $query_sort = " ".$query_sort;  
                    }
                    else $query_sort = "";
                    
                    if ($row_info["ID_right"] == "3") { //Есль пользователь - курьер 
                        if (!empty($_GET["area"])) { //Есль GET-запрос не пустой
                            $name_area =  $_GET["area"];
                            $result_area_two=mysqli_query($link, "SELECT ID FROM `areas` WHERE `area`='$name_area'"); //Запрос на поиск ID в базе данных
                            $row_area_two = mysqli_fetch_array($result_area_two);
                            $ID_area = $row_area_two["ID"]; //ID района                                  
                        }                              
                        $query_orders="SELECT DISTINCT `code` FROM `orders` WHERE ID_area='$ID_area' AND way='Курьер' ".$query_sort; //Формируется итоговый запрос
                    }
                    else if($row_info["ID_right"] == "5") { 
                        $query_orders="SELECT DISTINCT `code` FROM `orders` WHERE way='Самовывоз' ".$query_sort; //Формируется итоговый запрос
                    }
                    else if ($row_info["ID_right"] == "1") {
                        $query_orders="SELECT DISTINCT `code` FROM `orders`".$query_sort; //Формируется итоговый запрос
                    } ?>

                    
                        <? $result_count = mysqli_query($link, $query_orders);
                        $all_count = mysqli_num_rows($result_count); 
                        $today = date("m");
                        $count_month = 0;
                        $count_month_two = 0;
                        while($row_count = mysqli_fetch_array($result_count)) {
                            $code_check = $row_count["code"];
                            $result_orders_two=mysqli_query($link, "SELECT * FROM `orders` WHERE code='$code_check'");
                            $row_orders_two = mysqli_fetch_array($result_orders_two);
                            $date = date($row_orders_two["date_order"]);                           
                            list($day, $month, $year) = explode('-', $date);
                            if($month == $today) {
                                $count_month = $count_month + 1;
                            }
                            if($month == $today-1) {
                                $count_month_two = $count_month_two + 1;
                            }
                        } 
                        if(($count_month_two != 0) && ($count_month != 0)) {
                            if ($count_month_two > $count_month) {
                                $result_count = "меньше, чем в прошлом месяце";

                                $razn = $count_month_two / $count_month * 100 - 100;
                            } 
                            else if ($count_month > $count_month_two) {
                                $result_count = "больше, чем в прошлом месяце";
                                $razn = $count_month / $count_month_two * 100 - 100;
                            } 
                            else if ($count_month = $count_month_two) {
                                $result_count = "столько же";
                            }     
                        }
                        else $error = 1; ?>
                        <? if(!empty($razn)) $razn = "на ".round($razn, 2); 
                        if($row_info["ID_right"] == "3") { ?>
                            <a class="link-area" href="orders.php?page=<? echo $page ?>.&area=<? echo $area ?>">Сбросить фильтры</a>
                        <? }
                        else { ?>
                            <a class="link-area" href="orders.php?page=<? echo $page ?>">Сбросить фильтры</a>
                        <? } ?>
                        
                        <span class="all-area">Всего заказов: <? echo $all_count ?></span><br>
                        <? if (($row_info["ID_right"] == "1") && ($error != 1)) { ?>
                            <span class="all-area">Заказов в этом месяце: <? echo $count_month ?> (<? echo $razn."% ".$result_count ?>)</span>
                        <? } ?>
                    </div><br>

                    <? if(mysqli_query($link, $query_orders)) {
                        $result_orders=mysqli_query($link, $query_orders);
                        if(mysqli_num_rows($result_orders) != 0) { ?>   

                            <div class="table-responsive"> 
                                <table class="table area-table"> 
                                    <tr>
                                        <th class="area-title"><a class="link-sort" href="orders.php?page=<? echo $page ?>&sort=<? echo $sort.'1' ?>&area=<? echo $area ?>">Код</a></th>
                                        <th class="area-title"><a class="link-sort" href="orders.php?page=<? echo $page ?>&sort=<? echo $sort.'2' ?>&area=<? echo $area ?>">Статус</a></th>
                                        <? if (($row_info["ID_right"] == "3") || ($row_info["ID_right"] == "1")) { ?>
                                            <th class="area-title"><a class="link-sort" href="orders.php?page=<? echo $page ?>&sort=<? echo $sort.'3' ?>&area=<? echo $area ?>">Район</a></th>
                                        <? } ?>                               
                                        <th class="area-title"><a class="link-sort" href="orders.php?page=<? echo $page ?>&sort=<? echo $sort.'4' ?>&area=<? echo $area ?>">Дата заказа</a></th>
                                        <th class="area-title">Кол-во</th>
                                        <th class="area-title">Пользователь</th>
                                        <? if (($row_info["ID_right"] == "3") || ($row_info["ID_right"] == "1")) { ?>
                                            <th class="area-title">Адрес</th>
                                            <th class="area-title"><a class="link-sort" href="orders.php?page=<? echo $page ?>&sort=<? echo $sort.'5' ?>&area=<? echo $area ?>">Дата доставки</a></th>
                                        <? } ?>       
                                        <th colspan="2" class="area-title">Действие</th>
                                    </tr>                   
                                    <? $num = 10;   // Переменная хранит число сообщений выводимых на станице
                                    $page = $_GET['page'];  // Извлекаем из URL текущую страницу
                                    $query_count = $query_orders; // Определяем общее число сообщений в базе данных
                                    
                                    if (isset($_POST["hidden_save"])) {   
                                        header("Location: orders.php?page=".$page."&area=".$_POST["select_area"]."&sort=".$sort); //Если нажата кнопка, то формируется новый url страницы      
                                    }
                                
                                    $result_count = mysqli_query($link, $query_count); 
                                    $posts_count = mysqli_num_rows($result_count);

                                    $total = intval(($posts_count - 1) / $num) + 1;   // Находим общее число страниц     
                                
                                    $page = intval($page);  // Определяем начало сообщений для текущей страницы                 
                                    if(empty($page) or $page < 0) $page = 1;
                                    if($page > $total) $page = $total;
                                
                                    $start = $page * $num - $num; // Вычисляем начиная к какого номера следует выводить сообщения
                                    $query_all_code = $query_orders." LIMIT $start, $num";
                                    $result_all_code = mysqli_query($link, $query_all_code);

                                    while ($row_all_code = mysqli_fetch_assoc($result_all_code)) { 
                                        $count = 0;

                                        $one_code = $row_all_code["code"];
                                        $result_all_2 = mysqli_query($link, "SELECT * FROM `orders` WHERE code='$one_code'"); 
                                        while($row_all_2 = mysqli_fetch_assoc($result_all_2)) {
                                            $count = $count + $row_all_2["count"];
                                        }

                                        $result_all = mysqli_query($link, "SELECT * FROM `orders` WHERE code='$one_code'"); 
                                        $row_all = mysqli_fetch_assoc($result_all);

                                        $ID = $row_all["ID"];
                                        $ID_area=$row_all["ID_area"]; 
                                        $result_area = mysqli_query($link, "SELECT area FROM `areas` WHERE ID='$ID_area'"); 
                                        $row_area = mysqli_fetch_assoc($result_area);
                                        $area = $row_area["area"];
                                    
                                        $result_date = mysqli_query($link, "SELECT DATE_FORMAT(date_order, '%Y-%m-%d') as new_date FROM `orders` WHERE code='$one_code'"); 
                                        $row_date = mysqli_fetch_assoc($result_date);

                                        $ID_status=$row_all["ID_status"]; 
                                        $result_status = mysqli_query($link, "SELECT `name` FROM `status` WHERE ID='$ID_status'"); 
                                        $row_status = mysqli_fetch_assoc($result_status);
                                        $status = $row_status["name"];
                                    
                                        if (!empty($_POST["select_status".$ID])) {
                                            $status = $_POST["select_status".$ID];

                                            $result_status_two = mysqli_query($link, "SELECT ID FROM `status` WHERE `name`='$status'");                                      
                                            $row_status_two = mysqli_fetch_assoc($result_status_two);
                                            $ID_status = $row_status_two["ID"]; ?>
                                        <? }  
                                        else {
                                            $status = $row_status["name"];   
                                        } ?>

                                        <tr>
                                            <form method="post" action="">   
                                                <td class="area-text area-center">
                                                    <input type="hidden" name="code<? echo $ID ?>" id="code<? echo $ID ?>" value="<?php printf($row_all["code"]) ?>"><?php printf($row_all["code"]) ?></a>
                                                </td>
                                                <td class="area-text">
                                                    <select class="select-status" name="select_status<? echo $ID ?>">  
                                                        <option value='<? echo $status ?>'><? echo $status ?></option>
                                                        <? $query_status = "";
                                                        if($ID_status != "1") $query_status = " AND NOT ID='5'";
                                                        if ($row_info["ID_right"] == "3") {
                                                            $result_status = mysqli_query($link, "SELECT `name` FROM `status` WHERE NOT ID='$ID_status'".$query_status." AND (`name`='В пути' OR `name`='Завершён')");   
                                                        }
                                                        else if ($row_info["ID_right"] == "5") {
                                                            $result_status = mysqli_query($link, "SELECT `name` FROM `status` WHERE NOT ID='$ID_status'".$query_status." AND (`name`='На этапе сборки' OR `name`='Завершен')"); 
                                                        }
                                                        else if ($row_info["ID_right"] == "1") {
                                                            $result_status = mysqli_query($link, "SELECT `name` FROM `status` WHERE NOT ID='$ID_status'".$query_status); 
                                                        }
                                                        while($row_status = mysqli_fetch_assoc($result_status)) { ?>
                                                            <option value='<? echo $row_status["name"] ?>'><? echo $row_status["name"]?></option>
                                                        <? } ?>
                                                    </select>
                                                </td>
                                                <? if (($row_info["ID_right"] == "3") || ($row_info["ID_right"] == "1")) { ?>
                                                    <td class="area-text area-center"><?php echo $area ?></td>
                                                <? } ?>
                                                <td class="area-text area-center"><?php echo date("d.m.Y", strtotime($row_date["new_date"])); ?></td>
                                                <td class="area-text area-center"><?php printf($count) ?></td>
                                                <td class="area-text"><?php printf($row_all["user"]) ?></td>
                                                <? if(($row_info["ID_right"] == "3") || ($row_info["ID_right"] == "1")) { ?>
                                                    <? if($row_all["address"] != "") { ?>
                                                        <td class="area-text"><?php printf($row_all["address"]) ?></td>
                                                        <td class="area-text area-center"><?php printf(date("d.m.Y", strtotime($row_all["delivery_date"]))) ?></td>
                                                    <? }
                                                    else { ?> 
                                                        <td class="area-text"><?php echo "" ?></td>
                                                        <td class="area-text area-center"><?php echo "" ?></td>
                                                    <? }
                                                } ?>
                                                
                                                <td class="area-text">
                                                    <button class="btn-products" type="submit" name="scan<? echo $ID ?>" title="Просмотреть">
                                                        <i id="scan<? echo $ID; ?>" class="bi bi-search"></i> 
                                                    </button>
                                                </td>
                                                <td class="area-text">
                                                    <button class="btn-products" type="submit" name="save<? echo $ID ?>" title="Сохранить">
                                                        <i id="save<? echo $ID ?>" class="bi-check2"></i> 
                                                    </button>
                                                </td> 
                                            </form>
                                        </tr>
                                        <? if (isset($_POST["scan".$ID])) {
                                            header("location: order.php?code=".$one_code);
                                        }
                                        if (isset($_POST["save".$ID])) {
                                            $i = 0;
                                            $j = 0;
                                            $status=$_POST["select_status".$ID];
                                        
                                            $result_status_one = mysqli_query($link, "SELECT ID FROM `status` WHERE `name`='$status'");                                        
                                            $row_status_one = mysqli_fetch_assoc($result_status_one);
                                        
                                            $code = $row_all["code"];
                                            $ID_status = $row_status_one["ID"];
                                        
                                            if($ID_status != '') {
                                                $result_order_status = mysqli_query($link, "SELECT ID FROM `orders` WHERE `code`='$code'");
                                                while($row_order_status = mysqli_fetch_assoc($result_order_status)) {     
                                                    $j = $j + 1;                                          
                                                    $ID_order = $row_order_status["ID"];
                                                    $query_ID = "UPDATE orders SET ID_status='$ID_status' WHERE ID='$ID_order'";

                                                    if(mysqli_query($link, $query_ID)) {
                                                        $i = $i + 1;
                                                    }    
                                                }    
                                                if($i == $j) {
                                                    $one_check = 1;
                                                }
                                            }   
                                        }                                                              
                                    } ?>
                                </table>  
                                <div class="block-check"> 
                                    <div class="check" id="check"></div>
                                </div><br>  
                                <? if ($one_check == 1) {
                                    echo "<script>
                                            check.innerHTML='Изменения прошли успешно'; 
                                            document.getElementById('check').classList.add('accept');
                                        </script>";   
                                } ?>
                            </div>
                        <? } 
                        else { 
                            if (isset($_POST["hidden_save"])) {   
                                header("Location: orders.php?page=".$page."&area=".$_POST["select_area"]."&sort=".$sort);      
                            } ?>
                            <div class="not-result">
                                <p class="text-not-result">Нет заказов</p>
                            </div>
                        <? }
                    }
                    
                    if(($posts_count >= $num) && ($posts_count != '')) { ?>
                        <div class="pagination-block">
                            <? if ($page != 1) $pervpage = '<a class="page" href=orders.php?page=1><i class="bi bi-chevron-double-left"></i></a>
                                                        <a class="page" href=orders.php?page='. ($page - 1) .'><i class="bi bi-chevron-left"></i></a> ';
                            // Проверяем нужны ли стрелки вперед
                            if ($page != $total) $nextpage = ' <a class="page" href=orders.php?page='. ($page + 1) .'><i class="bi bi-chevron-right"></i></a>
                                                            <a class="page" href=orders.php?page=' .$total. '><i class="bi bi-chevron-double-right"></i></a>';
                            
                            // Находим две ближайшие станицы с обоих краев, если они есть
                            if($page - 2 > 0) $page2left = ' <a class="page" href=orders.php?page='. ($page - 2) .'>'. ($page - 2) .'</a>';
                            if($page - 1 > 0) $page1left = '<a class="page" href=orders.php?page='. ($page - 1) .'>'. ($page - 1) .'</a>';
                            if($page + 2 <= $total) $page2right = '<a class="page" href=orders.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>';
                            if($page + 1 <= $total) $page1right = '<a class="page" href=orders.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>';
                                                  
                            echo $pervpage.$page2left.$page1left.'<a class="page active">'.$page.'</a>'.$page1right.$page2right.$nextpage; // Вывод меню
                            ?>
                        <div>
                    <? } ?>	
				</div>
			</div>
		</main>		         			
    </body>
</html>

<?php 
include_once("footer.php"); 
ob_end_flush();
?>