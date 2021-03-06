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
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <link rel="icon" href="images/icons-img/F-char.png">
  <title>Fedugalher Blog</title>
</head>
<body>
  
  <?php require_once('templates/navbar.php'); ?>

  <div class="row main-container">
      
      <div class="col-md-12 col-lg-8">
        <article class="article-container">           
          
            <div class="row form-coment-row">
              <div class="col-lg-12 form-coment-col">  
                  <h3>Agregar Publicación</h3> 
                  <hr>
                                  
                  <div class="article-img">
                     <div class="article-img text-center">
                        <!-- <img src="images/no-image.png" alt="" id="article-img"> -->
                     </div>                     
                  </div> 

                  <h3 id="article-title"></h3>    
                  <div class="article-text"></div>
                  <span class="article-date" id="article-date">dd/mm/aaaa</span>  

                  <form id="article-form" action="php/article_new.php" method="post" enctype="multipart/form-data">
                     <input id="img-file" class="article-input" type="file" name="image">
                     <input id="title" class="coment-input" type="text" placeholder="Título" name="title">
                     <select id="category" class="form-select coment-input" aria-label="Default select example" name="category">
                        <option selected>Selecciona una categoría</option>
                     </select>      
                     <div class="char-count" id="counter1">0/3000</div>               
                     <textarea id="body" class="coment-input" name="body" placeholder="Escribe el cuerpo del artículo"></textarea>
                     <div class="char-count" id="counter2">0/100</div> 
                     <textarea id="preview" class="coment-input" name="preview" placeholder="Escribe un resumen del artículo"></textarea>
                     <input type="checkbox" name="status" id="status" value="published"> <label for="status">Publicar</label>
                     <input id="btn-publish" class="coment-input btn-send" type="submit" value="Publicar">
                  </form>
              </div>                 
            </div>

            
          
        </article>
      </div>       

      <?php require_once('templates/admin_menu.php'); ?>
    
  </div>

  <?php require_once('templates/footer.php') ?>

  <script src="js/main.js"></script>
  <script src="js/article_new.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>