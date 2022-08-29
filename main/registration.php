<?
	ob_start();
	include_once("menu.php");
	include_once("link.php"); 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - Регистрация</title>
		
		<script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <link rel="preconnect" href="https://fonts.googleapis.com">

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/registration.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    </head>
	<body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
            crossorigin="anonymous"></script>	
        <div class="modal fade" id="modal_info" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Обработка и использование персональных данных</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Обработка персональных данных Клиента осуществляется без ограничения срока, любым законным способом, 
                        в том числе в информационных системах персональных данных с использованием средств автоматизации или без использования таких средств.<br><br>

                        Соглашаясь с настоящей Политикой конфиденциальности Клиент предоставляет Компании свое согласие на обработку указанных в разделе 
                        3 персональных данных всеми указанными в настоящей Политике способами, а также передачу указанных данных партнерам 
                        Компании для целей исполнения принятых на себя обязательств.<br><br>

                        Компания не вправе передавать информацию о Клиенте неаффилированным лицам или лицам, не связанным с Компанией договорными отношениями.<br><br>

                        Передача информации аффилированным лицам и лицам, которые связаны с Компанией договорными отношениями 
                        (курьерские службы), осуществляется для исполнения заказа Клиента, 
                        а также для возможности информирования Клиента о проводимых акциях, предоставляемых услугах, проводимых мероприятиях.<br><br>

                        Аффилированные лица и лица, связанные с Компанией договорными отношениями, принимают на 
                        себя обязательства обеспечивать конфиденциальность информации и гарантировать ее защиту, 
                        а также обязуются использовать полученную информацию исключительно для целей исполнения указанных действий или оказания услуг.<br><br>

                        Компания принимает все необходимые меры для защиты персональных данных Клиента от неавторизованного доступа, изменения, раскрытия или уничтожения.
                    </div>
                    
                </div>
            </div>
        </div>
        <? if ($_POST["check_save"] == 1) {
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
        } ?>
		<div class="registration">
            <div class="block-check"> 
                <div class="check" id="check"></div><br>
            </div>
	  		<div class="frame">
			    <div ng-app ng-init="checked = false">
					<form class="form-signup" method="post">
                        <input type="hidden" name="check_save" id="check_save" value="">
                        <input type="hidden" name="update" id="update" value="">
						<label for="name">Имя</label>
							<input class="form-styling" type="text" name="name" id="name" pattern="[А-Яа-яЁё]+" value="<? echo $name ?>" required>
							<br><br>

						<label for="surname">Фамилия</label>
							<input class="form-styling" type="text" name="surname" id="surname" pattern="[А-Яа-яЁё]+" value="<? echo $surname ?>" <? if ($_POST["update"] != "1") { ?> required <? } ?>>
							<br><br>

						<label for="email">Электронная почта</label>
							<input class="form-styling" type="text" name="email" id="email" placeholder="example@gmail.com" value="<? echo $email ?>" pattern="([a-zA-Z0-9]+(?:[._+-][a-zA-Z0-9]+)*)@([a-zA-Z0-9]+(?:[.-][a-zA-Z0-9]+)*[.][a-zA-Z]{2,})" required>
							<br><br>

						<label for="phone">Номер телефона</label>
							<input class="form-styling tel" type="text" name="phone" id="phone" placeholder="+79000000000" value="<? echo $phone ?>" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" required>
							<br><br>

						<label for="password_one">Пароль</label>
							<input class="form-styling" type="password" name="password_one" id="password_one" pattern="[A-Za-z0-9]+" maxlength="32" minlength="6" required>
							<br><br>

						<label for="password_two">Подтверждение пароля</label>
							<input class="form-styling" type="password" name="password_two" id="password_two" pattern="[A-Za-z0-9]+" maxlength="32" minlength="6" required>
							<br><br>

						<p class="agreement"><input type="checkbox" class="form-check-input" name="agreement" id="agreement" value="" required> <a class="link-signup" data-bs-target="#modal_info" data-bs-toggle="modal">Согласие на обработку персональных данных</a></p>

						<div class="btn-animate">
			    			<input class="btn-signup" type="submit" name="registration" value="Зарегистрироваться" onclick="document.getElementById('check_save').value='1';"><br>
                            <input class="btn-signin" type="submit" name="autorization" value="Войти" onclick="update_required()"><br><br>
						</div>
                        <script>
							$(function() {
								$('.tel').mask('+7(000)000-00-00');
							});
						</script>  
                        <? if(isset($_POST["autorization"])) { 
                            header("Location: autorization.php");
                        } ?>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
    function update_required() {
        document.getElementById("name").required = false;
        document.getElementById("surname").required = false;
        document.getElementById("email").required = false;
        document.getElementById("phone").required = false;
        document.getElementById("password_one").required = false;
        document.getElementById("password_two").required = false;
        document.getElementById("agreement").required = false;
    }
</script>
<?php

	if (isset($_POST["registration"])) {	//Регистрация по кнопке
		$password_one=$_POST["password_one"];   //Первый пароль
		$password_two=$_POST["password_two"];   //Повтор пароля
		
		if ($password_one==$password_two) {	//Если пароли равны, то выполняется условие

			$name=$_POST["name"]; 
			$surname=$_POST["surname"];  
			$email=$_POST["email"];  
			$phone=$_POST["phone"];  
            $phone = str_replace('(', '', $phone);
            $phone = str_replace(')', '', $phone);
            $phone = str_replace('-', '', $phone);
			$date=date("Y.m.d");  
                  
			$query1="SELECT phone FROM `users` WHERE phone='$phone'";	//Запрос на выборку логина
			$result1=mysqli_query($link, $query1);
			$row1=mysqli_fetch_row($result1);

			$query2="SELECT email FROM `users` WHERE email='$email'";	//Запрос на выборку электронной почты
			$result2=mysqli_query($link, $query2);
			$row2=mysqli_fetch_row($result2);

			if ((!mysqli_num_rows($result1)) && (!mysqli_num_rows($result2))) {	//Если телефона и почты нет в списке, то выполняется условие
				$hash1=password_hash($password_one, PASSWORD_BCRYPT);	//Хеширование пароля

				$query_once="INSERT INTO users(`name`, surname, email, ID_right, phone, `password`, registration_date) VALUES ('$name', '$surname', '$email', 4, '$phone', '$hash1', '$date')";	//Запрос на ввод данных в базу данных      

				if (mysqli_query($link, $query_once)) {
                    $bytes=bin2hex(openssl_random_pseudo_bytes(20));	//Создание токена
					$query="UPDATE users SET token='$bytes' WHERE email='$email' AND phone='$phone'";	//Ввод токена в базу данных
					mysqli_query($link, $query);	//Выполнение запроса
					setcookie("cookieToken", $bytes);
					header("Location: index.php");	//Переход на сайт
				}
				else echo "<script>
                                check.innerHTML='Произошла ошибка'; 
								document.getElementById('check').classList.add('total_error');
							</script>";				
			}
			else echo "<script>
                            check.innerHTML='Такой логин уже зарегистрирован';
							document.getElementById('check').classList.add('total_error');
						</script>";
		}	
		else echo "<script>
                        check.innerHTML='Пароли не совпадают';
						document.getElementById('check').classList.add('total_error');               
					</script>";
	}
	ob_end_flush();
?>