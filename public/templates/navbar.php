<?php	
	if(isset($_SESSION['started'])){
      $id = $_SESSION['id'];;
      $username = $_SESSION['username'];
      $image = $_SESSION['image'];
		$welcome = $username.' <a href="../php/sesions_controller.php?method=sesionClose" id="sesionClose"><i class="fa-solid fa-right-from-bracket login-icons"></i></a>';
   }else{
      $id = 0;
      $username = 'Inicia Sesion para poder comentar';
      $welcome = '<a href="../public/login.php" class="login-link"><i class="fa-solid fa-right-to-bracket login-icons"></i> Iniciar Sesión</a>';
   }
?>
<header>
   <div class="container-header"></div>
</header> 
	  
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
   <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Fedugalher</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link" aria-current="page" href="">Gameplays</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="">Noticias</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="">Recomendaciones</a>
            </li>            
         </ul>
         <span class="navbar-text">
            <?php echo $welcome ?>
         </span>
      </div>
   </div>
</nav>