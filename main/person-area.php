<?php 
	ob_start();
    include_once("link.php");
	include_once("menu.php"); 
    include_once("menu-area.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>PhoneSet - личный кабинет</title>
		<link rel="icon" type="image/png" href="img/favicon.ico">
		
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
	    
        <link rel="stylesheet" href="css/person-area.css">
    </head>
	<body>
		<main>
            <?php $token=$_COOKIE['cookieToken'];
			$query_info="SELECT ID, `name`, user_photo, surname, email, phone, `password` FROM `users` WHERE token='$token'";	
			$result_info=mysqli_query($link, $query_info);
			$row_info=mysqli_fetch_assoc($result_info); 
            if ($_POST["check-save"] == 1) {
				$name = $_POST["name"];
                $surname = $_POST["surname"];
                $phone = $_POST["phone"];
                if(!empty($_FILES['photo']['tmp_name'])) {
                    $image = file_get_contents($_FILES['photo']['tmp_name']);
					$image = base64_encode($image);
                }
				else $image = base64_encode($row_info['user_photo']);    
            } 
            else {
                $name = $row_info["name"];
                $surname = $row_info["surname"];
                $phone = $row_info["phone"];
                $image = base64_encode($row_info['user_photo']);
            } ?>
			<div class="main-person">
				<div class="block-person">
                    <p class="title-area">Личный кабинет</p>
					<form name="form" method="post" action="" enctype="multipart/form-data">
                        <input type='hidden' name="check-save" id="check-save" value="">
						<div class="form-person container">
						 	<div class="row" id="block">
								<div class="col-sm content-person">
									<?php if ($image != '') { ?> 
										<img class="img-person" src="data:image/jpeg;base64, <? echo $image ?>"><br>
									<? } 
									else { ?> 
                                        <img class="img-person" src="img/avatar.jpg"><br> 
                                    <? } ?>
									<input class="file-image" type='file' name="photo" accept=".jpg, .jpeg, .png"><br>
									<label class="info">Текущий пароль</label><br>
									<input class="input-person password" type="password" name="password" id="password" value="" minlength="6" maxlength="32" pattern="[A-Za-z0-9]+"><br>
									<label class="info">Новый пароль</label><br>
									<input class="input-person password" type="password" name="password_one" id="password_one" value="" minlength="6" maxlength="32" pattern="[A-Za-z0-9]+"><br>
									<label class="info">Повтор пароля</label><br>
									<input class="input-person password" type="password" name="password_two" id="password_two" value="" minlength="6" maxlength="32" pattern="[A-Za-z0-9]+"><br><br>
					
                                </div>
								<div class="col-sm content-person">
									<label class="info">Имя</label><br>
									<input class="input-person" type="text" name="name" id="name" value="<?php echo $name ?>" pattern="[А-Яа-яЁё]+"><br>
									<label class="info">Фамилия</label><br>
									<input class="input-person" type="text" name="surname" id="surname" value="<?php echo $surname ?>" pattern="[А-Яа-яЁё]+"><br>
									<label class="info">Электронная почта</label><br>
									<input class="input-person" type="text" name="email" id="email" value="<?php printf($row_info["email"]) ?>" pattern="([a-zA-Z0-9]+(?:[._+-][a-zA-Z0-9]+)*)@([a-zA-Z0-9]+(?:[.-][a-zA-Z0-9]+)*[.][a-zA-Z]{2,})" readonly><br>
									<label class="info">Номер телефона</label><br>
									<input class="input-person" type="text" name="phone" id="phone" value="<?php echo $phone ?>" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{10}$" readonly>
								</div>	
							</div>
                            <div class="block-check"> 
                                <div class="check" id="check"></div><br>
                            </div>
                            	
							<div class="block-btn">
								<input class="btn-person" type="submit" name="save" value="Сохранить" onclick="document.getElementById('check-save').value='1'">
							</div>
						</div>
                        
						
					</form>	
					
				</div>
				<?php
					if (isset($_POST["save"])) {
						
                        if (!empty($_FILES['photo']['tmp_name'])) {
                            if (addslashes(file_get_contents($_FILES['photo']['tmp_name']))) {
							    $photo=addslashes(file_get_contents($_FILES['photo']['tmp_name']));
						    }
                        }
						
						$name = $_POST["name"];
						$surname = $_POST["surname"];

						$p = $_POST["password"];
						$p1 = $_POST["password_one"];
						$p2 = $_POST["password_two"];
						$ID=$row_info["ID"];

						if ($photo != '') {
                            $query_data="UPDATE users SET `name`='$name', surname='$surname', user_photo='$photo' WHERE token='$token'";    
                        }
                        else $query_data="UPDATE users SET `name`='$name', surname='$surname' WHERE token='$token'";    
						
						if(mysqli_query($link, $query_data)) {
							$checkData=true;	
						}				
	
						if(!empty($_POST["password"])) {
							$query_password="SELECT `password` FROM `users` WHERE token='$token'";
							$result_password=mysqli_query($link, $query_password);	

							while ($row_password=mysqli_fetch_assoc($result_password)) {
								if (password_verify($p, $row_password["password"])) {
									if ($p1==$p2) {
										$hash1=password_hash($p1, PASSWORD_BCRYPT);
										$query_save_password="UPDATE users SET `password`='$hash1' WHERE ID='$ID'";
										mysqli_query($link, $query_save_password);
										$checkPassword=true;
									}
									else echo "<script>
                                                    check.innerHTML='Пароли не совпадают'; 
                                                    document.getElementById('check').classList.add('error');
                                            	</script>";
								}
								else echo "<script>
                                                check.innerHTML='Пароли не совпадают'; 
                                                document.getElementById('check').classList.add('error');
											</script>";
							}
						}
						else $checkPassword=true;
						
						if($checkPassword && $checkData) {
                            echo "<script>
                                    check.innerHTML='Изменения прошли успешо'; 
                                    document.getElementById('check').classList.add('accept');
								</script>";
                        }
					} ?>		
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
<?php 
include_once("footer.php"); 
ob_end_flush();
?>
