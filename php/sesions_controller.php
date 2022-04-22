<?php

require('sesion.php');

$sesion = new Sesion();

if (isset($_POST['method'])) {
   $method = $_POST['method'];
   $username = isset($_POST['username']) ? $_POST['username'] : 'No User';
   $password = isset($_POST['password']) ? $_POST['password'] : 'No Password';
}elseif(isset($_GET['method'])){
   $method = $_GET['method'];
}else {
   $method = 'No se recibió ningun metodo';
}


switch ($method) {
   case 'startSesion':
      $sesion->set($username, $password);
      echo $sesion->startSesion();
      break;
   case 'closeSesion':
      echo $sesion->closeSesion();
      break;

   // default:
   //    echo $sesion->selectAll();
   //    break;
}

?>