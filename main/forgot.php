<?php include_once("menu.php"); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8'>
	<title>Восстановление пароля</title>
	<link rel="stylesheet" href="css/forgot.css">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

  	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
</head>

<body>
	<div class="change">
		<div class="frame">
			<div ng-app ng-init="checked = false">
				<form class="form-signin" action="" method="post" name="form">
					<label for="login">Электронная почта или номер телефона</label>
					<input class="form-styling" type="text" name="login" id="login" pattern="[A-Za-z]+[0-9]*" required>
					<div id="error1"></div><br>
					<p></p>
					<div class="btn-animate">
						<input class="btn-signin" type="submit" name="button-code" id="button-code" value="Отправить письмо на почту">
					</div>
				</form>
			</div>
</body>
<script>
	login.onblur = function () {
		if (login.value.search(login.pattern) == -1) {
			login.classList.add('invalid');
			error1.innerHTML = 'Пожалуйста, введите электронную почту или номер телефона верно'
		}
	}
	login.onfocus = function () {
		if (this.classList.contains('invalid')) {
			this.classList.remove('invalid');
			error1.innerHTML = "";
		}
	}
	// if (login.value != "") {
	document.getElementById("button-code").onclick = function () {
		location.href = "autorization.php";
	}
		// }
</script>
</div>

</html>