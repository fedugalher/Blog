<?php
	session_start();
	if(!isset($_SESSION['started'])){
		header('location: index.html');
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
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/users.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <title>Fedugalher Blog</title>
</head>
<body>
  
<?php require_once('templates/navbar.php') ?>

	
		<div class="row main-container">

			<div class="col-lg-8 article-container">
				<article>
					<div class="row article-row">
                  <h1>Usuarios</h1>
                  <hr>

                  <div class="col-12 users-col">
							<h3>Agregar Usuario</h3>
							<form class="user-form" action="" method="post" enctype="multipart/form-data">
								<input id="userImg" class="user-input" type="file" name="image">
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

						<div class="col-12 users-col">
							<h3>Usuarios Registrados</h3>

							<table class="table table-hover align-middle">
								<thead>
								  <tr>
									 <th scope="col">#</th>
									 <th scope="col">Imagen</th>
									 <th scope="col">Usuario</th>
									 <th scope="col">Rol</th>
									 <th scope="col">Fecha de registro</th>
									 <th scope="col">Acciones</th>
								  </tr>
								</thead>
								<tbody id="usersTable-body">
								  <!-- <tr>
									<th scope="row">1</th>
									<td><img src="images/users/no-image.png" alt="" class="user-img"></td>
									<td>fedugalher</td>
									<td>Administrador</td>
									<td>
									<a href="" class="edit-icon"><i class="fa-solid fa-pen-to-square"></i></a> 
									<a href="" class="delete-icon"><i class="fa-solid fa-trash-can"></i></a>
									</td>
								  </tr>
								  <tr>
									<th scope="row">2</th>
									<td><img src="images/users/no-image.png" alt="" class="user-img"></td>
									<td>fedugalher</td>
									<td>Administrador</td>
									<td>
										<a href="" class="edit-icon"><i class="fa-solid fa-pen-to-square"></i></a> 
										<a href="" class="delete-icon"><i class="fa-solid fa-trash-can"></i></a>
									</td>
								 </tr>										  -->
								</tbody>
							 </table>
							 
								

						</div>

               </div>
				</article>
			</div>
			
         <!-- Aside -->
         <div class="col-lg-4">
            <aside class="aside-container">
            <h4>Menú</h4>
            <hr>
            
            <div class="list-group">
               <a href="article_new.html" class="list-group-item list-group-item-action active" aria-current="true">
                 Agregar Artículo
               </a>
					<a href="admin.html" class="list-group-item list-group-item-action">Editar Artículo</a>
               <a href="users.html" class="list-group-item list-group-item-action">Usuarios</a>
					<a href="database.html" class="list-group-item list-group-item-action">Base de datos</a>
               <a class="list-group-item list-group-item-action disabled">A disabled link item</a>
             </div>
            </aside>
         </div>
		</div>


		<?php require_once('templates/footer.php') ?>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="js/users.js"></script>
  <script src="js/user_new.js"></script>
  
</body>
</html>