<?php

require('database.php');

if(isset($_GET['method'])){
   $method = $_GET['method'];
}elseif (isset($_POST['method'])) {
   $method = $_POST['method'];
}else {
   $method = 'No se recibió ningun metodo';
}
$db = new Database();

switch ($method) {
   case 'createDB':
      $db->createDB('fedugalher_blog');
      echo json_encode($db->message);
      break;
   case 'dropDB':
      $db->dropDB('fedugalher_blog');
      echo json_encode($db->message);
      break;   
   // default:
   //    echo $user->selectAll();
   //    break;
}



?>