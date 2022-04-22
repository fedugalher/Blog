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
  <link rel="stylesheet" href="css/database.css">
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
						<h1>Base de datos</h1>
						<hr>
						<div class="col-12 db-col">
							<h3>Crear base de datos</h3>
							<button class="btn-db" id="btn-db">Crear base de datos</button>
							<button class="btn-db" id="btn-users">Crear Tabla Usuarios</button>
							<button class="btn-db" id="btn-articles">Crear Tabla Articulos</button>
							<button class="btn-db" id="btn-comments">Crear Tabla Comentarios</button>
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
  <script src="js/database.js"></script>
</body>
</html>