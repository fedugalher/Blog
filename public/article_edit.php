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
  <link rel="stylesheet" href="css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <title>Fedugalher Blog</title>
</head>
<body>
  
  <header>
    <div class="container-header">

    </div>
  </header> 

  <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html">Fedugalher</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.html#Gameplays-category">Gameplays</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.html#Noticias-category">Noticias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.html#Recomendaciones-category">Recomendaciones</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="row main-container">
      
      <div class="col-md-12 col-lg-8">
        <article class="article-container">
           
          
            <div class="row form-coment-row">
               <div class="col-lg-12 form-coment-col">  
                  <h3>Editar artículo</h3> 
                  <hr>
                                  
                  <div class="article-img">
                     <div class="article-img text-center">
                        <!-- <img src="images/no-image.png" alt="" id="article-img"> -->
                     </div>                  
                     <p class="article-text"></p>
                     <span class="article-date" id="article-date">dd/mm/aaaa</span>
                   </div>       
                  <form id="article-form" action="php/article_new.php" method="post" enctype="multipart/form-data">
                     <input id="img-file" class="article-input" type="file" name="image">
                     <input id="title" class="coment-input" type="text" placeholder="Título" name="title">
                     <select id="category" class="form-select coment-input" aria-label="Default select example" name="category">
                        <option selected>Selecciona una categoría</option>
                        <option value="Gameplays">Gameplays</option>
                        <option value="Noticias">Noticias</option>
                        <option value="Recomendaciones">Recomendaciones</option>
                      </select>
                     <textarea id="body" class="coment-input" name="body" placeholder="Escribe el cuerpo del artículo"></textarea>
                     <input type="checkbox" name="status" id="status" value="published"> <label for="status">Publicar</label>
                     <input id="btn-publish" class="coment-input btn-send" type="submit" value="Publicar">
                  </form>
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
           <a href="#" class="list-group-item list-group-item-action">A second link item</a>
           <a href="#" class="list-group-item list-group-item-action">A third link item</a>
           <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
           <a class="list-group-item list-group-item-action disabled">A disabled link item</a>
         </div>
        </aside>
     </div>
    
  </div>

  <?php require_once('templates/footer.php') ?>

    
    <script src="js/article_edit.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>