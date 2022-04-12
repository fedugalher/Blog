<?php

require('article.php');


if (isset($_GET['method'])) {
   $metodo = $_GET['method'];
   $article = new Article();

   if ($metodo === 'selectAll') {          
      echo $article->selectAll();     
   }
   elseif($metodo === 'show' && isset($_GET['id'])){
      $id = $_GET['id'];
      echo $article->show($id);
   }
   elseif($metodo === 'selectLimit' && isset($_GET['limit'])){
      $limit = $_GET['limit'];
      echo $article->selectLimit($limit);
   }

   
}


?>