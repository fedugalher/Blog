<?php

require('comment.php');

$comment = new Comment();

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
   case 'commentsTable':
      $comment->createTable();
      $comment->alterTable();
      echo json_encode($comment->message);
      break;
   case 'selectAll':
      echo $comment->selectAll($id);
      break;   
   case 'show':
      echo $comment->show($id);
      break;
   case 'selectLimit':
      echo $comment->selectLimit($limit);
      break;
   case 'new':
      setNew();
      break;
   case 'edit':
      echo $comment->show($id);
      break;
   case 'update':
      setUpdate();
      break;
   case 'delete':
      echo $comment->delete($id);
      break;
   
   // default:
   //    echo $comment->selectAll();
   //    break;
}

function setNew(){
   
   $comment = new Comment();
   $name = isset($_POST['name']) ? $_POST['name'] : 'No hay nombre';
   $commentText = isset($_POST['comment']) ? $_POST['comment'] : 'No hay comentario';
   $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : 0;

   $commentArray = [
      'name' => $name,
      'comment' => $commentText,
      'article_id' => $article_id,
   ];

   $comment->set(null, $name, $commentText, $article_id);   
   if($comment->create()){
      $commentArray['article-msg'] = 'Tu comentario ha sido enviado';
   }else {
      $commentArray['article-msg'] = 'No se pudo enviar el comentario';
   }
  
   echo json_encode($commentArray);
    
}

function setUpdate(){
   
   $comment = new Comment();
   $name = isset($_POST['name']) ? $_POST['name'] : 'No hay nombre';
   $commentText = isset($_POST['comment']) ? $_POST['comment'] : 'No hay comentario';
   $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : 0;

   $commentArray = [
      'name' => $name,
      'comment' => $commentText,
      'article_id' => $article_id,
   ];

   $comment->set($id, $name, $commentText, $article_id);   
   $comment->update();
   echo json_encode($commentArray);
}

// $comment = new Comment();
// $comment->set(null, 'eduardo', 'hola', 1);


?>