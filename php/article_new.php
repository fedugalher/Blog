<?php

   $method = isset($_POST['method']) ? $_POST['method'] : 'No hay titulo';
   $title = isset($_POST['title']) ? $_POST['title'] : 'No hay titulo';
   $body = isset($_POST['body']) ? $_POST['body'] : 'No hay Texto';
   $category = isset($_POST['category']) ? $_POST['category'] : 'No hay Categoria';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'No hay Imagen';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
   $imgPath = '../images/articles/'.$image;
   // echo $imgPath;

   // if (move_uploaded_file($imageTmp, $imgPath)) {
   //    echo 'Imagen guardada';
   // }else {
   //    echo 'Error al cargar la imagen';
   // }



   if (isset($_POST['title'])){
      $arreglo = [
         'titulo' => $title,
         'body' => $body,
         'category' => $category,
         'image' => $image,
         'method' => $method

      ];
   }else{
      $arreglo = [
         'titulo' => 'no hay datos',
         'body' => 'no hay texto'
      ];
   }
  

   echo json_encode($arreglo);

?>