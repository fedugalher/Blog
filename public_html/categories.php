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
  <link rel="stylesheet" href="../css/categories.css">
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
					<h1>Categorias</h1>
					<hr>
					<div id="categoriesBox" class="col-12 categories-col">
						<h3>Agregar categoría</h3>
						<form class="category-form" action="" method="post" enctype="multipart/form-data">							
							<div class="msg-box"></div>
							<input id="name" class="category-input" type="text" placeholder="Nombre de la categoría" name="name">							                  
							<input id="btn-category" class="category-input btn-send" type="submit" value="Guardar">
						</form>
					</div>						

					<div class="col-12 categories-col table-responsive">
						<h3>Lista de categorias</h3>
						<table class="table table-sm table-hover align-middle">
							<thead class="text-center">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nombre</th>
									<th scope="col">Fecha de registro</th>									
									<th scope="col">Acciones</th>
								</tr>
							</thead>
							<tbody id="categoriesTable-body">								 									
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
	<script src="../js/categories.js"></script>
	<script src="../js/category_new.js"></script>
	<script src="../js/category_delete.js"></script>
  
</body>
</html>