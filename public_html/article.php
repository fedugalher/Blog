<?php 
  session_start(); 
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
  <title>Fedugalher Blog</title>
</head>
<body>
  
<?php require_once('templates/navbar.php'); ?>

  <div class="row main-container">
      
      <div class="col-md-12 col-lg-8">
        <article class="article-container">
          
          <div class="row article-row">
            <div class="col-12">
              <div class="article-content">
                <h3 id="article-title"></h3>                
                <div class="article-img">
                  <div class="article-img text-center">
                    <img src="images/articles/no-image.png" alt="" id="article-img">
                  </div>                  
                  <div class="article-text"></div>
                  <span class="article-date" id="article-date"></span>
                </div>
              </div>   
            </div>                       
          </div>  
          
          <div class="row form-coment-row">
            <div class="col-lg-12 form-coment-col">  
              <h3>Comentarios</h3> 
              <hr>           
              <?php if($username){ ?>
                <form id="comment-form" action="" method="post">
                  <div class="userData">  
                      <img src="images/users/<?php echo $userId.'/'.$image; ?>" class="userImg">                 
                      <span id="username"><?php echo $username; ?></span>
                  </div>
                  <textarea id="comment" class="coment-input" name="comment" placeholder="Escribe tu mensaje"></textarea>
                  <input id="coment-btn" class="coment-input btn-send" type="submit" value="Comentar">
                </form>
              <?php }else{ ?>
                <div class="comments-msg">
                  <a href="public_html/login.php" class="login-link">Inicia Sesión</a>
                  para dejar tu comentario.                  
                </div> 
              <?php } ?>
              <div id="comments"></div>
            </div>
          </div>
          
        </article>
      </div> 

      

      <!-- Aside -->
      <div class="col-md-12 col-lg-3">
        <aside class="aside-container">
          <h4>Lo más nuevo</h4>
          <hr>          
        </aside>
      </div>
    
  </div>

	<?php require_once('templates/footer.php'); ?>

  <script src="js/main.js"></script>
  <script src="js/article.js"></script>
  <script src="js/comments.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>