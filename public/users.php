<?php
	session_start();
	if(!isset($_SESSION['started']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
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
	
	<div class="row main-container">
		<div class="col-lg-9 article-container">
			<article>
				<div class="row article-row">
					<h1>Usuarios</h1>
					<hr>
					<div id="addUserBox" class="col-12 users-col">
						<h3>Agregar Usuario</h3>
						<form class="user-form" action="" method="post" enctype="multipart/form-data">
							<label for="userImg" class="userImgLabel"></label>
							<div class="msg-box"></div>
							<input id="userImg" class="user-input unset" type="file" name="image">
							<input id="email" class="user-input" type="email" placeholder="Correo Electrónico" name="email">
							<input id="username" class="user-input" type="text" placeholder="Nombre de Usuario" name="username">
							<input id="password" class="user-input" type="password" placeholder="Contraseña" name="password">
							<input id="password-confirm" class="user-input" type="password" placeholder="Confirmar Contraseña" name="password-confirm">
							<select id="user-role" class=" user-input" aria-label="Default select example" name="user-role">
								<option selected>Rol del Usuario</option>
								<option value="admin">Administrador</option>
								<option value="user">Usuario</option>
								</select>                     
							<input id="btn-user" class="user-input btn-send" type="submit" value="Guardar">
						</form>
					</div>						

					<div class="col-12 users-col table-responsive">
						<h3>Usuarios Registrados</h3>
						<table class="table table-sm table-hover align-middle">
							<thead class="text-center">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Imagen</th>
									<th scope="col">Usuario</th>
									<th scope="col">Correo Electrónico</th>
									<th scope="col">Rol</th>
									<th scope="col">Password</th>
									<th scope="col">Fecha de registro</th>
									<th scope="col">Acciones</th>
								</tr>
							</thead>
							<tbody id="usersTable-body">								 									
							</tbody>
							</table>
					</div>
				</div>
			</article>
		</div>
		
		<?php require_once('templates/admin_menu.php') ?>
		
	</div>

	<?php require_once('templates/footer.php') ?>  

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="../js/main.js"></script> 
	<script src="../js/users.js"></script>
	<script src="../js/user_new.js"></script>
	<script src="../js/user_edit.js"></script>
	<script src="../js/user_delete.js"></script>
  
</body>
</html>