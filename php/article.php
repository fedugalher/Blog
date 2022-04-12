<?php

require('database.php');

class Article extends Database{
   public $id;
   public $title;
   public $body;
   public $category;
   public $image;
   public $video;
   public $date;   

   // public function __construct($title, $body, $category){
   //    $this->title = $title;
   //    $this->body = $body;
   //    $this->category = $category;
   //    date_default_timezone_set('America/Chihuahua');
   //    $this->date = date('Y-m-d H:i:s');
   // }

   public function set($id, $title, $body, $category, $image, $video){   
      $this->id = $id;   
      $this->title = $title;
      $this->body = $body;
      $this->category = $category;    
      $this->image = $image;
      $this->video = $video; 
      date_default_timezone_set('America/Chihuahua');
      $this->date = date('Y-m-d H:i:s');
      
   }


   public function selectAll(){
      $data;
      $articleData = array();      
      $query = "SELECT * FROM `articles`";
      
      $this->connect();
      $select = $this->mysqli->query($query);      
      $this->disconnect();

      for ($rows = $select->num_rows - 1; $rows >= 0; $rows--) {
         $row = $select->fetch_assoc();
         array_push($articleData,[
            'id' => $row['id'], 
            'title' => $row['title'], 
            'body' => $row['body'], 
            'category' => $row['category'], 
            'image' => $row['image'],
            'video' => $row['video'],
            'date' => $row['date']
         ]);

      }

      $data = [
         'data' => $articleData,
         'messages' => $this->message
      ];

      return json_encode($data);     
   }


   public function show($id){
      $query = "SELECT * FROM articles WHERE id = $id";
      $this->connect();
      $select = $this->mysqli->query($query);
      $this->disconnect();
      
      while($row = $select->fetch_assoc()){
         $articleData = [
            'id' => $row['id'], 
            'title' => $row['title'], 
            'body' => $row['body'], 
            'category' => $row['category'], 
            'image' => $row['image'],
            'video' => $row['video'],
            'date' => $row['date']
         ];

      }
      return json_encode($articleData);      
   }


   public function create(){
      $nextId = $this->last()['id']+1;
      $this->image = $this->image != '' ? "{$nextId}-$image" : "no-image.png";
      $this->video = $this->video != '' ? "{$nextId}-$video" : null;

      $query = "INSERT INTO `articles` (`id`, `title`, `body`, `category`, `image`, `video`,`date`) 
         VALUES (NULL, '{$this->title}', '{$this->body}', '{$this->category}', '{$this->image}',  '{$this->video}', '{$this->date}')";
      $this->connect();
      $this->executeQuery($query, 'Articulo agregado correctamente', 'Error al agregar el articulo');
      $this->disconnect();
   }



   public function delete($id){
      $query = "DELETE FROM articles WHERE `articles`.`id` = {$id}";
      $this->connect();
      $this->executeQuery($query, 'Articulo eliminado', 'No se puede eliminar el articulo');
      $this->disconnect();
   }

   

   public function update($id, $title, $body, $category, $image, $video, $date){
      $query = "UPDATE `articles` SET 
         `title` = '{$title}', 
         `body` = '{$body}', 
         `category` = '{$category}', 
         `image` = '{$image}', 
         `video` = '{$video}', 
         `date` = '{$date}' 
         WHERE `articles`.`id` = {$id}";
       $this->connect();
       $this->executeQuery($query, 'Articulo actualizado', 'No se puede actualizar el articulo');
       $this->disconnect();
   }


   //Funciones de ayuda
   public function last(){
      $articleData = array();
      $query = "SELECT MAX(id) AS id, `title`, `body`, `category`, `image`, `video`, `date` FROM articles";
      $this->connect();
      $select = $this->mysqli->query($query);     
      $this->disconnect(); 

      for ($rows = $select->num_rows - 1; $rows >= 0; $rows--) {
         $row = $select->fetch_assoc();
         $articleData = [
            'id' => $row['id'], 
            'title' => $row['title'], 
            'body' => $row['body'], 
            'category' => $row['category'], 
            'image' => $row['category'],
            'video' => $row['category'],
            'date' => $row['date']
         ];
      }      
      return $articleData; //Retorna arreglo
   }

   public function selectLimit($limit){
      $data = array();
      $articleData = array();
      $query = "SELECT * FROM `articles` LIMIT $limit";
      $this->connect();
      $select = $this->mysqli->query($query);      
      $this->disconnect();

      while($row = $select->fetch_assoc()){
         array_push($articleData,[
            'id' => $row['id'], 
            'title' => $row['title'], 
            'body' => $row['body'], 
            'category' => $row['category'], 
            'image' => $row['image'],
            'video' => $row['video'],
            'date' => $row['date']
         ]);
      }
      $data = [
         'data' => $articleData,
         'messages' => $this->message
      ];
      return json_encode($data);
   }
}

// Pruebas
// $article = new Article();
// echo $article->set('Publicación 1', 'Texto Publicación 1', 'gameplays', 'imagen.jpg', 'video.mp4');
// $article->create();
// $article->delete(4);
// $article->update(3, 'Prueba update', 'prueba update body', 'prueba update category', date('Y-m-d H:i:s'));
// $article->selectAll();
// $article->last()['id']; //ejemplo mostrar ultimo id
// $article->show(10);
// $article->selectLimit(10);

?>