<?php include_once("menu.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - Восстановление пароля</title>
		<link rel="stylesheet" href="css/change.css">
		
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
	</head>
	<body>
		

		<div class="change">
		  	<div class="frame">
				<div ng-app ng-init="checked = false">
					<form class="form-change" action="" method="post" name="form">
					<label for="password_one">Пароль</label>
						<input class="form-styling" type="password" name="password_one" id="password_one" pattern="[A-Za-z0-9]+" maxlength="32" minlength="6" required>
						<div id="error1"></div><br>
					<label for="password_two">Подтверждение пароля</label>
						<input class="form-styling" type="password" name="password_two" id="password_two" pattern="[A-Za-z0-9]+" maxlength="32" minlength="6" required>
						<div id="error2"></div><br>
					<input class="btn-change" type="submit" name="change" value="Сменить пароль"><br><br>
				</div>	
			</div>
		

	</body>
	<script>
		login.onblur = function() {
			if (login.value.search(login.pattern)==-1) {
			   	login.classList.add('invalid');
			    error1.innerHTML = 'Пожалуйста, используйте английский алфавит и цифры длинной 6-32 символ'
			}
		}
		login.onfocus = function() {
			if (this.classList.contains('invalid')) {
			    this.classList.remove('invalid');
			    error1.innerHTML = "";
		  	}
		}
		password.onblur = function() {
			if (password.value.search(password.pattern)==-1) {
			   	password.classList.add('invalid');
			    error2.innerHTML = 'Пароли не совпадают'
			}
		}
		password.onfocus = function() {
			if (this.classList.contains('invalid')) {
			    this.classList.remove('invalid');
			    error2.innerHTML = "";
		  	}
		}
		document.getElementById("button-code").onclick = function () {
		location.href = "autorization.php";
	}
	</script>
	</div>
</html>