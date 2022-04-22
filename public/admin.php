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
  <link rel="stylesheet" href="../css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <title>Fedugalher Blog</title>
</head>
<body>
  
  <?php require_once('templates/navbar.php'); ?>

	
		<div class="row main-container">

			<div class="col-lg-8 article-container">
				<article>
					<div class="row article-row"></div>
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
					<a href="php/sesions_controller.php?method=sesionClose" id="sesionClose" class="list-group-item list-group-item-action">Cerrar Sesion</a>
				   <a class="list-group-item list-group-item-action disabled">A disabled link item</a>
             </div>
            </aside>
         </div>
		</div>


		<?php require_once('templates/footer.php') ?>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/main.js"></script>
  <script src="../js/admin.js"></script>
  <script src="../js/article_delete.js"></script>
</body>
</html>