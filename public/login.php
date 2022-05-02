<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/index.css">
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
              <h1>Iniciar Sesión</h1>
              <hr>
              <div class="col-lg-4 login-box">
                <div class="login-img">
                  <i class="fa-solid fa-user-large"></i>								
                </div>

                <div class="login-msg"></div>

                <form action="" method="post" class="login-form">
                    <input type="text" id="username" class="input-login" placeholder="Usuario" name="username">
                    <input type="password" id="password" class="input-login" placeholder="Contraseña" name="password">
                    <input type="submit" id="login-btn" class="input-login" value="Iniciar Sesión">
                </form>

                <div class="login-links">
                  <a href="">Crear Cuenta</a>
                  <a href="">Restablecer Contraseña</a>
                </div>
              </div>
          </div>
				</article>
			</div>
		
		</div>


		<?php require_once('templates/footer.php') ?>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/main.js"></script>
  <script src="../js/login.js"></script>

</body>
</html>