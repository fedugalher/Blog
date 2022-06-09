<?php
session_start();

require('article.php');

$article = new Article();
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
$category = isset($_GET['category']) ? $_GET['category'] : 'none';
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';


if(isset($_GET['method'])){
   $method = $_GET['method'];
}elseif (isset($_POST['method'])) {
   $method = $_POST['method'];
}else {
   $method = 'No se recibió ningun metodo';
}

if($userRole === 'admin'){
   switch ($method) {
      case 'articlesTable':
         $article->createTable();
         $article->alterTable();
         echo json_encode($article->message);
         break;
      case 'selectAll':
         echo $article->selectAll();
         break;
      case 'selectCategory':
         echo $article->selectCategory($category);
         break;
      case 'all':
         echo $article->all();
         break;
      case 'show':
         echo $article->show($id);
         break;
      case 'selectLimit':
         echo $article->selectLimit($limit);
         break;
      case 'new':
         setNew();
         break;
      case 'edit':
         echo $article->show($id);
         break;
      case 'update':
         setUpdate();
         break;
      case 'delete':
         echo $article->delete($id);
         break;      
      default:
         header("location: /index.php");
         break;
   }
}else{
   switch ($method) {     
      case 'selectAll':
         echo $article->selectAll();
         break;
      case 'selectCategory':
         echo $article->selectCategory($category);
         break;     
      case 'show':
         echo $article->show($id);
         break;
      case 'selectLimit':
         echo $article->selectLimit($limit);
         break;      
      default:
         header("location: /index.php");
         break;
   }
}


function setNew(){
   
   $article = new Article();
   $title = isset($_POST['title']) ? $_POST['title'] : 'No hay titulo';
   $body = isset($_POST['body']) ? $_POST['body'] : 'No hay Texto';
   $preview = isset($_POST['preview']) ? $_POST['preview'] : 'No hay Texto';
   $category = isset($_POST['category']) ? $_POST['category'] : 'No hay Categoria';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'No hay Imagen';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
   $imgPath = '../images/articles/';
   $video = '';
   $status = isset($_POST['status']) &&  $_POST['status'] == 'true' ? 'published' : 'unpublished';
   $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

   $articleArray = [
      'titulo' => $title,
      'body' => $body,
      'preview' => $preview,
      'category' => $category,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath,
      'video' => $video,
      'status' => $status,
      'user_id' => $user_id,
   ];

   $article->set(null, $title, $body, $preview, $category, $image, $imageTmp, $video, $status, $user_id);
   $article->create();      
   echo json_encode($article->message);
    
}

function setUpdate(){
   
   $article = new Article();
   $id = isset($_POST['id']) ? $_POST['id'] : 0;
   $title = isset($_POST['title']) ? $_POST['title'] : 'No hay titulo';
   $body = isset($_POST['body']) ? $_POST['body'] : 'No hay Texto';
   $preview = isset($_POST['preview']) ? $_POST['preview'] : 'No hay Texto';
   $category = isset($_POST['category']) ? $_POST['category'] : 'No hay Categoria';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
   $imgPath = '../images/articles/';
   $video = '';
   $status = isset($_POST['status']) &&  $_POST['status'] == 'true' ? 'published' : 'unpublished';
   $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;   

   $articleArray = [
      'id' => $id,
      'titulo' => $title,
      'body' => $body,
      'preview' => $preview,
      'category' => $category,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath,
      'video' => $video,
      'status' => $status,
      'user_id' => $user_id,
   ];

   $article->set($id, $title, $body, $preview, $category, $image, $imageTmp, $video, $status, $user_id);
   $article->update();
   echo json_encode($article->message);
     
}


?>