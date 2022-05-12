<?php	
	if(isset($_SESSION['started'])){  
      $userId   = $_SESSION['id'];
      $username = $_SESSION['username'];
      $email    = $_SESSION['email'];
      $image    = $_SESSION['image'];
   }else{
      $userId   = '';
      $username = '';
      $email    = '';
      $image    = '';
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
         <span class="navbar-text navbar-right">
            <?php if($username){ ?>
               <img src="../images/users/<?php echo $image ?>" class="userImg">

               <div class="user-name dropdown">
                  <a class=" btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php echo $username ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">
                     <li>                        
                        <a class="dropdown-item" href="../php/users_controller.php?method=show" id="userProfile">
                           <i class="fa-solid fa-user login-icons"></i> 
                           Mi perfil
                        </a>
                     </li>
                     <li>
                        <a class="dropdown-item" href="../php/sesions_controller.php?method=sesionClose" id='sesionClose'>
                           <i class='fa-solid fa-right-from-bracket login-icons'></i>
                           Cerrar Sesión                           
                        </a>
                     </li>
                  </ul>
               </div>
            <?php }else{ ?>
               <a href="../public/login.php" class="login-link">
                  <i class="fa-solid fa-right-to-bracket login-icons"></i> 
                  Iniciar Sesión
               </a>
            <?php } ?>
         </span>
      </div>
   </div>
</nav>