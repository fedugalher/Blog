<?php	
  session_start();
	if(isset($_SESSION['username'])){
		$welcome = $_SESSION['username'];
	}else{
    $welcome = '<a href="../public/login.php">Iniciar Sesión</a>';
  }

  require('../routes.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo $host_dir ?>/css/index.css">
  <link rel="stylesheet" href="<?php echo $host_dir ?>/css/navbar.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <script src="https://kit.fontawesome.com/2c08c695f8.js" crossorigin="anonymous"></script>
  <title>Fedugalher Blog</title>
</head>
<body>
  
	<?php require_once('templates/navbar.php'); ?>

	<div class="container">
		<div class="row main-container">
			<div class="col-lg-12 article-container">
				<article>
					<div class="row article-row"></div>
				</article>
			</div>
			
		</div>
	</div>

	<?php require_once('templates/footer.php') ?>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="<?php echo $host_dir ?>/js/main.js"></script>
  <script src="<?php echo $host_dir ?>/js/articles.js"></script>
  <script src="<?php echo $host_dir ?>/js/article_delete.js"></script>
</body>
</html>