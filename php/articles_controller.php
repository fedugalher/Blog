<?php

require('article.php');

$article = new Article();

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 0;



if(isset($_GET['method'])){
   $method = $_GET['method'];
}elseif (isset($_POST['method'])) {
   $method = $_POST['method'];
}else {
   $method = 'No se recibió ningun metodo';
}

switch ($method) {
   case 'articlesTable':
      $article->createTable();
      $article->alterTable();
      echo json_encode($article->message);
      break;
   case 'selectAll':
      echo $article->selectAll();
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
   
   // default:
   //    echo $article->selectAll();
   //    break;
}

function setNew(){
   
   $article = new Article();
   $title = isset($_POST['title']) ? $_POST['title'] : 'No hay titulo';
   $body = isset($_POST['body']) ? $_POST['body'] : 'No hay Texto';
   $category = isset($_POST['category']) ? $_POST['category'] : 'No hay Categoria';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'No hay Imagen';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
   $imgPath = '../images/articles/';
   $video = '';
   $status = isset($_POST['status']) &&  $_POST['status'] == 'true' ? 'published' : 'unpublished';
   $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;

   $articleArray = [
      'titulo' => $title,
      'body' => $body,
      'category' => $category,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath,
      'video' => $video,
      'status' => $status,
      'user_id' => $user_id,
   ];

   $article->set(null, $title, $body, $category, $image, $video, $status, $user_id);
   
   if($article->create()){
      if (move_uploaded_file($imageTmp, $imgPath.$article->image)) {
         $articleArray['article-msg'] = 'Articulo guardado';
      }else {
         $articleArray['article-msg'] = 'Error al guardar aticulo';
      }
      echo json_encode($articleArray);
   }  
}

function setUpdate(){
   
   $article = new Article();
   $id = isset($_POST['id']) ? $_POST['id'] : 0;
   $title = isset($_POST['title']) ? $_POST['title'] : 'No hay titulo';
   $body = isset($_POST['body']) ? $_POST['body'] : 'No hay Texto';
   $category = isset($_POST['category']) ? $_POST['category'] : 'No hay Categoria';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
   $imgPath = '../images/articles/';
   $video = '';
   $status = isset($_POST['status']) &&  $_POST['status'] == 'true' ? 'published' : 'unpublished';
   $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;   

   $articleArray = [
      'id' => $id,
      'titulo' => $title,
      'body' => $body,
      'category' => $category,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath,
      'video' => $video,
      'status' => $status,
      'user_id' => $user_id,
   ];

   $article->set($id, $title, $body, $category, $image, $video, $status, $user_id);
   
   if($article->update()){
      if ($image != '') {
         if (move_uploaded_file($imageTmp, $imgPath.$article->image)) {
            $articleArray['img-msg'] = 'Se actualizó la imagen';
         }else {
            $articleArray['img-msg'] = 'No se pudo actualizar la imagen';
         }
      }    
      $articleArray['article-msg'] = 'Articulo guardado'; 
      echo json_encode($articleArray);
   }  
}


?>