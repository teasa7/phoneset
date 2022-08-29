<?php
	ob_start();
	include_once("link.php");
	include_once("menu.php");
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>PhoneSet - Авторизация</title>
	
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/autorization.css">
</head>

<body>
	<div class="autorization">
        <div class="block-check"> 
            <div class="check" id="check"></div><br>
        </div>
        <? if(!empty($_GET['error'])) {
            echo "<script>
                check.innerHTML='Необходимо авторизоваться'; 
                document.getElementById('check').classList.add('total_error');
            </script>";
        } ?>
        <? if ($_POST["check_save"] == 1) {
            $login = $_POST["login"];
        } ?>
		<div class="frame">
			<div ng-app ng-init="checked = false">
				<form class="form-signin" action="" method="post" name="form">
                    <input type="hidden" name="check_save" id="check_save" value="">

					<label for="login">Электронная почта или номер телефона</label>
					<input class="form-styling" type="text" name="login" id="login" value="<? echo $login ?>"
                    pattern="([a-zA-Z0-9]+(?:[._+-][a-zA-Z0-9]+)*)@([a-zA-Z0-9]+(?:[.-][a-zA-Z0-9]+)*[.][a-zA-Z]{2,})||(\+7|8)(\(\d{3}\)|\d{3})\d{7}" required><br><br>

					<label for="password">Пароль</label>
					<input class="form-styling" type="password" name="password" minlength="6" maxlength="32" id="password" required pattern="[A-Za-z0-9]+"><br><br><br>

					<div class="btn-animate">
						<input class="btn-signin" type="submit" name="input" value="Войти" onclick="document.getElementById('check_save').value='1';"><br>
                        <input class="btn-signup" type="submit" name="registration" value="Зарегистрироваться" onclick="update_required()"><br><br>
						</div>
                        <? if(isset($_POST["registration"])) { 
                            header("Location: registration.php");
                        } ?>
					</div>
                </form>
			</div>
        </div>
    </div>
</body>
<script>
    function update_required() {
        document.getElementById("login").required = false;
        document.getElementById("password").required = false;
    }
</script>
</html>
<?
	if (isset($_POST["input"])) {	//Авторизация по кнопке

		$login=$_POST["login"]; //Получаем введенный логин
		$password=$_POST["password"];   //Получаем введенный пароль
 
		$query="SELECT email, phone, `password`, `name` FROM `users` WHERE email=? || phone=?";	 //Запрос на существование логина в базе данных

		if ($stmt=mysqli_prepare($link, $query)) {	//Создаётся подготавливаемый запрос
			mysqli_stmt_bind_param($stmt, 'ss', $login, $login);	//Связываются параметры с метками
			mysqli_stmt_execute($stmt);	//Запускается запрос
			$result=mysqli_stmt_get_result($stmt);	//Связываются переменные с результатами запросы

			if(mysqli_num_rows($result)) {	//Получает число рядов в результирующей выборке
				while ($row=mysqli_fetch_assoc($result)) {	//Пока перебираются получаемые значения выполняется действие
					if($row["email"]==$login || $row["phone"]==$login) {
						if(password_verify($password, $row["password"])) {	//Если пароль совпадает с тем, который введён пользователем, то
							$bytes=bin2hex(openssl_random_pseudo_bytes(20));	//Создание токена
							$query="UPDATE users SET token='$bytes' WHERE email='$login' or phone='$login'";	//Ввод токена в базу данных
							mysqli_query($link, $query);	//Выполнение запроса
							setcookie("cookieToken", $bytes);
						 	header("Location: index.php");	//Переход на сайт
						}
						else echo "<script>
                                    check.innerHTML='Неверный пароль'; 
									document.getElementById('check').classList.add('total_error');
								</script>";		
					}
					else echo "<script>
                                    check.innerHTML='Пользователь с таким логином не найден'; 
									document.getElementById('check').classList.add('total_error');
								</script>";		
				}
			}
			else echo "<script>
                            check.innerHTML='Пользователь с таким логином не найден'; 
							document.getElementById('check').classList.add('total_error');
						</script>";
		}
		else echo "<script>
                        check.innerHTML='Пользователь с таким логином не найден'; 
						document.getElementById('check').classList.add('total_error');
					</script>";
	}
	ob_end_flush();
?>