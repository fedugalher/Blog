<?php
  	session_start();	
   if(!isset($_SESSION['started'])){
      header('location: index.php');
   }else{
      $sessionStarted = true;
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/users.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <title>Fedugalher Blog</title>
</head>
<body>
  
	<?php require_once('templates/navbar.php') ?>
	
	<div class="row justify-content-center main-container">
		<div class="col-lg-5 article-container">
			<article>
				<div class="row article-row">
					<h1>Mi perfil</h1>

					<div id="addUserBox" class="col-12 users-col">							
						<form id="userForm" class="user-form" action="../php/users_controller.php" method="post" enctype="multipart/form-data">								
							<label for="userImg" class="userImgLabel"></label>
							<input id="userImg" class="user-input unset" type="file" name="image">
							<div class="msg-box"></div>														
							<input id="username" class="user-input" type="text" placeholder="Nombre de Usuario" name="username">
                     <input id="email" class="user-input" type="email" placeholder="Correo Electrónico" name="email">
							<input id="password-new" class="user-input" type="password" placeholder="Contraseña nueva" name="password">
							<input id="password-confirm" class="user-input" type="password" placeholder="Confirmar contraseña" name="password-confirm">
							<input id="password" class="user-input" type="password" placeholder="Contraseña actual" name="password">
							<input id="btn-user" class="user-input btn-send" type="submit" value="Guardar">																
						</form>
					</div>
				</div>
			</article>
		</div>	
	</div>

	<?php require_once('templates/footer.php') ?>  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/main.js"></script> 
  <script src="../js/user_show.js"></script>
  
</body>
</html>