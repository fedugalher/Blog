<?php
session_start();

//importar rutas, ahi se guarda la ruta del localhost
require('../routes.php');

require('category.php');

$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$category_id = isset($_GET['id']) ? $_GET['id'] : '';

$category = new Category();

if(isset($_GET['method'])){
   $method = $_GET['method'];
}elseif (isset($_POST['method'])) {
   $method = $_POST['method'];
}else {
   $method = 'No se recibió ningun metodo';
}

if($userRole === 'admin'){
   switch ($method) {
      case 'categoriesTable':
         $category->createTable();
         break;
      case 'selectAll':
         echo $category->selectAll();
         break;
      case 'new':
         setNew();
         break;
      case 'delete':
         echo $category->delete($category_id);
         break;      
      default:
         header("location: $host_dir/public/index.php");
         break;
   }
}else{
   switch ($method) {      
      case 'selectAll':
         echo $category->selectAll();
         break;
      default:
         header("location: $host_dir/public/index.php");
         break;
   }
}

function setNew(){
   
   $category = new Category();
   $name = isset($_POST['name']) ? $_POST['name'] : 'No hay nombre';   

   $categoryArray = [
      'name' => $name,
   ];

   $category->set(null, $name);
   
   if($category->create()){ 
      array_push($category->message, ['category-msg'=>'Categoría registrada', 'msgType'=>'succes']);    
   }else{
      array_push($category->message, ['category-msg'=>'No se pudo registrar la categoría', 'msgType'=>'error']);   
   } 

   echo json_encode($category->message); 
}

?>