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
   case 'selectAll':
      echo $article->selectAll();
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
   
   // default:
   //    echo $article->selectAll();
   //    break;
}


// if (isset($_GET['method'])) {
//    $metodo = $_GET['method'];
//    $article = new Article();

//    if ($metodo === 'selectAll') {          
//       echo $article->selectAll();     
//    }
//    elseif($metodo === 'show' && isset($_GET['id'])){
//       $id = $_GET['id'];
//       echo $article->show($id);
//    }
//    elseif($metodo === 'selectLimit' && isset($_GET['limit'])){
//       $limit = $_GET['limit'];
//       echo $article->selectLimit($limit);
//    }   
// }


function setNew(){
   
      $article = new Article();
      $title = isset($_POST['title']) ? $_POST['title'] : 'No hay titulo';
      $body = isset($_POST['body']) ? $_POST['body'] : 'No hay Texto';
      $category = isset($_POST['category']) ? $_POST['category'] : 'No hay Categoria';
      $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'No hay Imagen';
      $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
      $imgPath = '../images/articles/';
      $video = '';

      $articleArray = [
         'titulo' => $title,
         'body' => $body,
         'category' => $category,
         'image' => $image,
         'imageTmp' => $imageTmp,
         'imgPath' => $imgPath,
         'video' => $video
      ];

      $article->set(null, $title, $body, $category, $image, $video);
      
      if($article->create()){
         if (move_uploaded_file($imageTmp, $imgPath.$article->image)) {
            $articleArray['article-msg'] = 'Articulo guardado';
         }else {
            $articleArray['article-msg'] = 'Error al guardar aticulo';
         }
         echo json_encode($articleArray);
      }

     
  
}


?>