<?php
session_start();
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
      setDelete();
      break;
   
   // default:
   //    echo $comment->selectAll();
   //    break;
}

function setNew(){
   
   $comment = new Comment();   
   $commentText = isset($_POST['comment']) ? $_POST['comment'] : 'No hay comentario';
   $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : 0;
   $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

   $commentArray = [
      'comment' => $commentText,
      'article_id' => $article_id,
      'user_id' => $user_id,
   ];

   $comment->set(null, $commentText, $article_id, $user_id);   
   if($comment->create()){
      $commentArray['article-msg'] = 'Tu comentario ha sido enviado';
   }else {
      $commentArray['article-msg'] = 'No se pudo enviar el comentario';
   }
  
   echo json_encode($commentArray);
    
}

function setUpdate(){
   
   $comment = new Comment();
   $id = isset($_POST['id']) ? $_POST['id'] : 0;
   $commentText = isset($_POST['comment']) ? $_POST['comment'] : 'No hay comentario';
   $article_id = isset($_POST['article_id']) ? $_POST['article_id'] : 0;
   $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

   $commentArray = [      
      'comment' => $commentText,
      'article_id' => $article_id,
      'article_id' => $user_id,
   ];

   $comment->set($id, $commentText, $article_id, $user_id);   
   if($comment->update()){
      $commentArray['comment-msg'] = 'Comentario actualizado';
   }
   echo json_encode($commentArray);
}

function setDelete(){
   $comment = new Comment();
   $id = isset($_POST['id']) ? $_POST['id'] : 0;
   $user_id = $_SESSION['id'];

   echo $comment->delete($id, $user_id);
}

// $comment = new Comment();
// $comment->set(null, 'eduardo', 'hola', 1);


?>