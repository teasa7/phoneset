<?php
	ob_start();
	include_once("link.php");
	include_once("menu.php");
    include_once("check.php");
    include_once("menu-area.php"); 
    $token=$_COOKIE['cookieToken'];
    $result_my_ID  = mysqli_query($link,"SELECT ID, ID_right FROM `users` WHERE token='$token'");
    $row_my_ID  = mysqli_fetch_assoc($result_my_ID);

    if ($_GET['page'] != '') {
        $page = $_GET['page'];
    }
    else $page = 1;
    if ($_GET['sort'] != '') {
        $sort = $_GET['sort'];
    }
    if ($_GET['right'] != '') {
        $right = $_GET['right'];
    }
?>	
<!DOCTYPE html>	
	<html>
		<head>
			<meta charset='utf-8'>
			<title>PhoneSet - пользователи</title>
            
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
            integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
			
            <link rel="stylesheet" href="css/users-area.css">
    	</head>
    	<body>
    		<main>  			
				<div class="main-users">
					<div class="block-users">
                        <p class="title-area">Пользователи</p>
						<div class="table-responsive">
                            <div>
                                <form class="selects-rights" method="post" action="">
                                    <? $result_right=mysqli_query($link, "SELECT * FROM `rights`"); ?>
                                        <select class="select-rights" name="select_right" id="select_right" onchange="name_right()">
                                            <? if(empty($right)) { ?>
                                                <option class="options" disabled selected>Выберите право доступа</option>
                                            <? } ?>
                                            <? while($row_right = mysqli_fetch_array($result_right)) { ?>
                                                <option <? if($row_right["name"] == $_GET["right"]) { echo "selected"; } ?> 
                                                    value='<? echo $row_right["name"]; ?>'><? echo $row_right["name"]; ?></option>   
                                            <? } ?>
                                        </select>
                                        <input type="submit" id="hidden_save" name="hidden_save" style="display:none;"> 
                                    <script>
                                        function name_right() {
                                            document.getElementById("hidden_save").click(); //Нажимаем на кнопку
                                        }
                                    </script>  
                                </form>   
                                <? if (!empty($_GET["right"])) { 
                                    $name_right =  $_GET["right"];
                                    $result_right_two=mysqli_query($link, "SELECT ID FROM `rights` WHERE `name`='$name_right'"); //Запрос на поиск ID в базе данных
                                    $row_right_two = mysqli_fetch_array($result_right_two);
                                    $ID_right = $row_right_two["ID"];   

                                    $result_count = mysqli_query($link, "SELECT * FROM `users` WHERE ID_right='$ID_right'");
                                }
                                else $result_count = mysqli_query($link, "SELECT * FROM `users`");
                                $all_count = mysqli_num_rows($result_count); ?>
                                <a class="link-area" href="users-area.php?page=<? echo $page ?>">Сбросить фильтры</a>
                                <span class="all-area">Всего пользователей: <? echo $all_count ?></span>
                            </div><br>

                            <? if (!empty($_GET["right"])) {                                                            
                                $query="SELECT * FROM `users` WHERE ID_right='$ID_right'"; 
                            }
                            else $query="SELECT * FROM `users`"; ?>

                        <? if(mysqli_query($link, $query)) {
                            $result=mysqli_query($link, $query);
                            if(mysqli_num_rows($result) != 0) { ?>
							<table class="table area-table"> 
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
                                                header("location: users-area.php?page=".$page."&sort=".$sort."&right=".$right);            
                                            }                  
                                        }                     
                                    } ?>                        
                                    <tr>
                                        <!-- Сортируемые поля -->
                                        <th class="area-title"><a class="link-sort" href="users-area.php?page=<? echo $page ?>&sort=<? echo $sort.'1' ?>&right=<? echo $right ?>">ID</a></th>
                                        <th class="area-title">Имя</th>
                                        <th class="area-title"><a class="link-sort" href="users-area.php?page=<? echo $page ?>&sort=<? echo $sort.'2' ?>&right=<? echo $right ?>">Фамилия</a></th>
                                        <th class="area-title"><a class="link-sort" href="users-area.php?page=<? echo $page ?>&sort=<? echo $sort.'3' ?>&right=<? echo $right ?>">Право доступа</a></th>
                                        <th class="area-title"><a class="link-sort" href="users-area.php?page=<? echo $page ?>&sort=<? echo $sort.'6' ?>&right=<? echo $right ?>">Дата регистрации</a></th>
                                        <th class="area-title"><a class="link-sort" href="users-area.php?page=<? echo $page ?>&sort=<? echo $sort.'4' ?>&right=<? echo $right ?>">Электронная почта</a></th>
                                        <th class="area-title"><a class="link-sort" href="users-area.php?page=<? echo $page ?>&sort=<? echo $sort.'5' ?>&right=<? echo $right ?>">Номер телефона</a></th>
                                        <th class="area-title"></th>
                                    </tr><?php
                                    $num = 10;   // Переменная хранит число сообщений выводимых на станице
                                    $page = $_GET['page'];  // Извлекаем из URL текущую страницу    
                                    $posts_count = mysqli_num_rows($result_count);
                                    
                                    $total = intval(($posts_count - 1) / $num) + 1;   // Находим общее число страниц     

                                    $page = intval($page);  // Определяем начало сообщений для текущей страницы                 
                                    if(empty($page) or $page < 0) $page = 1; //Проверка на несуществующие значения      
                                    if($page > $total) $page = $total;
                                
                                    $start = $page * $num - $num; // Вычисляем начиная к какого номера следует выводить сообщения
                                    
                                    // Сортировка 
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
                                            if ($result_sort == 6) $count[6] = $count[6] + 1;                               
                                        }
                                        for ($i = 0; $i < $count_fields; $i++) {
                                            $result_sort = substr($new_sort, $i, 1); // Получаем 1 значение
                                            /* Получаем наименование сортируемых полей */
                                            if ($result_sort == 1) $field = "ID";
                                            if ($result_sort == 2) $field = "surname";
                                            if ($result_sort == 3) $field = "ID_right";
                                            if ($result_sort == 4) $field = "email";
                                            if ($result_sort == 5) $field = "phone";
                                            if ($result_sort == 6) $field = "registration_date";

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
                                        if (!empty($_GET["right"])) {                                                            
                                            $query_right="WHERE ID_right='$ID_right' "; 
                                            $query_all = "SELECT * FROM `users` ".$query_right.$query_sort." LIMIT $start, $num ";
                                        }
                                        else $query_all = "SELECT * FROM `users` ".$query_sort." LIMIT $start, $num ";
                                    }
                                    else {
                                        if (!empty($_GET["right"])) {                                                            
                                            $query_right="WHERE ID_right='$ID_right'"; 
                                            $query_all = "SELECT * FROM `users` ".$query_right." LIMIT $start, $num ";
                                        }
                                        else $query_all = "SELECT * FROM `users` LIMIT $start, $num ";
                                    }

                                    $result_all = mysqli_query($link, $query_all); 
                                    while ($row_all = mysqli_fetch_assoc($result_all)) { 
                                        $ID = $row_all["ID"];

                                        $ID_right=$row_all["ID_right"]; 
                                        $result_right_one = mysqli_query($link, "SELECT ID, `name` FROM `rights` WHERE ID='$ID_right'"); 
                                        $row_right_one = mysqli_fetch_assoc($result_right_one);
                                        $ID_right_one = $row_right_one["ID"];

                                        if (!empty($_POST["select_right".$ID])) {
                                            $right = $_POST["select_right".$ID];
                                            
                                            $result_right_two = mysqli_query($link, "SELECT ID, `name` FROM `rights` WHERE `name`='$right'"); 
                                            $row_right_two = mysqli_fetch_assoc($result_right_two);
                                            $ID_right_two = $row_right_two["ID"]; 
                                        }  
                                        else {
                                            $right = $row_right_one["name"];
                                        }

                                        if (isset($_POST["hidden_save"])) {   
                                            header("Location: users-area.php?page=".$page."&sort=".$sort."&right=".$_POST["select_right"]); //Если нажата кнопка, то формируется новый url страницы      
                                        } ?>

                                        <tr>
                                            <form method="post" action=""> 
                                                <td class="area-text"><input type="hidden" name="ID" id="ID" value=<?php printf($row_all["ID"]) ?> size="5px"><?php printf($row_all["ID"]) ?></td>
                                                <td class="area-text"><?php printf($row_all["name"]) ?></td>
                                                <td class="area-text"><?php printf($row_all["surname"])?></td>
                                                <td class="area-text">
                                                    <? if($row_my_ID["ID"] != $ID) { ?>
                                                        <select class="select-user" name="select_right<? echo $ID ?>">  
                                                            <option value='<? echo $right ?>'><? echo $right ?></option>
                                                            
                                                            <? $result_right = mysqli_query($link, "SELECT ID, `name` FROM `rights` WHERE NOT ID='$ID_right_one'");   
                                                            while($row_right = mysqli_fetch_assoc($result_right)) { ?>
                                                                <option value='<? echo $row_right["name"] ?>'><? echo $row_right["name"]?></option>
                                                            <? } ?>
                                                        </select>    
                                                    <? } 
                                                    else { ?>
                                                        <div class="select-user">
                                                            <? $my_right = $row_my_ID["ID_right"];
                                                            $result_my_right = mysqli_query($link, "SELECT `name` FROM `rights` WHERE ID='$my_right'");   
                                                            $row_my_right = mysqli_fetch_assoc($result_my_right); 
                                                            printf($row_my_right["name"]); ?>
                                                        </div>
                                                    <? } ?>
                                                    
                                                </td>
                                                <td class="area-text area-center"><?php printf(date("d.m.Y", strtotime($row_all["registration_date"]))) ?></td>
                                                <td class="area-text"><?php printf($row_all["email"]) ?></td>
                                                <td class="area-text"><?php printf($row_all["phone"]) ?></td>
                                                <td class="area-text">
                                                    <button class="btn-users" type="submit" name="save<? echo $ID ?>" title="Сохранить">
                                                        <i id="cart-icon<? echo $ID_product; ?>" class="bi bi-check2"></i> 
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                        <? if (isset($_POST["save".$ID])) {
                                            $right=$_POST["select_right".$ID];

                                            $result_right_one = mysqli_query($link, "SELECT ID FROM `rights` WHERE `name`='$right'");                                        
                                            $row_right_one = mysqli_fetch_assoc($result_right_one);

                                            $ID_right = $row_right_one["ID"];
                                            $ID = $_POST["ID"];
                                            if($ID_right != '') {
                                                $query_ID = "UPDATE users SET ID_right='$ID_right' WHERE ID='$ID'";
                                                if(mysqli_query($link, $query_ID)) {
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
                                } 
                            } 
                            else { 
                                if (isset($_POST["hidden_save"])) {   
                                    header("Location: users-area.php?page=".$page."&sort=".$sort."&right=".$_POST["select_right"]);      
                                } ?>
                                <div class="not-result">
                                    <p class="text-not-result">Нет пользователей с таким правом доступа</p>
                                </div>
                            <? } ?>
						</div>
                        
                        <? if(($posts_count >= $num) && ($posts_count != '')) { ?>
                            <div class="pagination-block">
                                <? if ($page != 1) $pervpage = '<a class="page" href=users-area.php?page=1&sort=' . $sort . '&right=' . $_POST["select_right"] . '><i class="bi bi-chevron-double-left"></i></a>
                                                            <a class="page" href=users-area.php?page='. ($page - 1) . '&sort=' . $sort .'&right=' . $_POST["select_right"].'><i class="bi bi-chevron-left"></i></a> ';
                                // Проверяем нужны ли стрелки вперед
                                if ($page != $total) $nextpage = ' <a class="page" href=users-area.php?page='. ($page + 1) . '&sort=' . $sort .'&right=' . $_POST["select_right"].'><i class="bi bi-chevron-right"></i></a>
                                                                <a class="page" href=users-area.php?page=' .$total. '&sort=' . $sort .'&right=' . $_POST["select_right"].'><i class="bi bi-chevron-double-right"></i></a>';
                                
                                // Находим две ближайшие станицы с обоих краев, если они есть
                                if($page - 2 > 0) $page2left = ' <a class="page" href=users-area.php?page='. ($page - 2) . '&sort=' . $sort .'&right=' . $_POST["select_right"].'>'. ($page - 2) .'</a>';
                                if($page - 1 > 0) $page1left = '<a class="page" href=users-area.php?page='. ($page - 1) . '&sort=' . $sort .'&right=' . $_POST["select_right"].'>'. ($page - 1) .'</a>';
                                if($page + 2 <= $total) $page2right = '<a class="page" href=users-area.php?page='. ($page + 2) . '&sort=' . $sort .'&right=' . $_POST["select_right"].'>'. ($page + 2) .'</a>';
                                if($page + 1 <= $total) $page1right = '<a class="page" href=users-area.php?page='. ($page + 1) . '&sort=' . $sort .'&right=' . $_POST["select_right"].'>'. ($page + 1) .'</a>';
                                                      
                                echo $pervpage.$page2left.$page1left.'<a class="page active">'.$page.'</a>'.$page1right.$page2right.$nextpage; // Вывод меню
                                ?>
                            <div>
                        <? } ?>
					</div>
				</div>
			</main>
		</body>
	</html>
	<script>
        setTimeout(checkRadio(), 10000);
        function checkRadio() {
            var check = document.getElementById("check");
            check.classList.toggle("radio");
            setTimeout(() => check.innerHTML='', 5000);
            setTimeout(() => document.getElementById('check').classList.remove("error"), 5000);
            setTimeout(() => document.getElementById('check').classList.remove("accept"), 5000);
            setTimeout(() => check.classList.remove("radio"), 5000);
        }
    </script>			

	<? }

    
    include_once("footer.php"); 
	ob_end_flush();
?>