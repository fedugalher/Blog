<?php	  
	if(isset($_SESSION['started'])){  
      $userId   = $_SESSION['id'];
      $username = $_SESSION['username'];
      $email    = $_SESSION['email'];
      $image    = $_SESSION['image'];
      $role     = $_SESSION['role'];
   }else{
      $userId   = '';
      $username = '';
      $email    = '';
      $image    = '';
      $role    = '';
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
            
         </ul>
         <span class="navbar-text navbar-right">
            <?php if($username){ ?>
               <?php if($image !== 'no-image.png'){ ?>
                  <img src="./images/users/<?php echo $userId.'/'.$image ?>" class="userImg">
               <?php }else{ ?>
                  <img src="./images/users/<?php echo $image ?>" class="userImg">
               <?php } ?>

               <div class="user-name dropdown">
                  <a class=" btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php echo $username ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">
                     <li> 
                        <?php if($role == 'admin'){ ?>       
                           <a class="dropdown-item" href="admin.php" id="adminMenu">
                           <i class="fa-solid fa-user-gear login-icons"></i>
                              Admin
                           </a>
                        <?php }else{ ?>  
                           <a class="dropdown-item" href="./php/users_controller.php?method=show" id="userProfile">
                              <i class="fa-solid fa-user login-icons"></i> 
                              Mi perfil
                           </a>
                        <?php } ?> 
                     </li>
                     <li>
                        <a class="dropdown-item" href="./php/sesions_controller.php?method=sesionClose" id='sesionClose'>
                           <i class='fa-solid fa-right-from-bracket login-icons'></i>
                           Cerrar Sesi??n                           
                        </a>
                     </li>
                  </ul>
               </div>
            <?php }else{ ?>
               <a href="login.php" class="login-link">
                  <i class="fa-solid fa-right-to-bracket login-icons"></i> 
                  Iniciar Sesi??n
               </a>
            <?php } ?>
         </span>
      </div>
   </div>
</nav>

