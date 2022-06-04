<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <title>Fedugalher Blog</title>
</head>
<body>
  
<?php require_once('templates/navbar.php') ?>

	
		<div class="row main-container">

			<div class="col-lg-12 login-container">
				<article>
					<div class="row justify-content-center login-row">
              <h1>Restablecer Contraseña</h1>
              <hr>
              <div class="col-lg-4 login-box">
                <div class="login-img">
                  <i class="fa-solid fa-key"></i>							
                </div>

                <span> Por favor ingresa tu nueva contraseña: </span>  
                <div class="login-msg"></div>
               
                <div id="userData-container">                  
                  <form action="" method="post" class="login-form" id="passwordReset-form">                                      
                    <input type="password" id="password" class="input-login" placeholder="Contraseña" name="password">
                    <input type="password" id="password2" class="input-login" placeholder="Confirmar Contraseña" name="passwordConfirm">
                    <input type="submit" id="login-btn" class="input-login" value="Enviar">
                  </form>               
                </div>

              </div>
          </div>
				</article>
			</div>
		
		</div>


		<?php require_once('templates/footer.php') ?>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/main.js"></script>
  <script src="../js/password_reset.js"></script>

</body>
</html>