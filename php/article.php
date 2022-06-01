<?php

require('database.php');

class Article extends Database{
   public $id;
   public $title;
   public $body;
   public $category;
   public $image;
   public $imageTmp;
   public $video;
   public $status;
   public $created_at;
   public $updated_at;  
   public $user_id;
   public $isSucces;
   public $arrayPrueba = [1,2,3,4,5,6];

   // public function __construct($title, $body, $category){
   //    $this->title = $title;
   //    $this->body = $body;
   //    $this->category = $category;
   //    date_default_timezone_set('America/Chihuahua');
   //    $this->date = date('Y-m-d H:i:s');
   // }

   public function set($id, $title, $body, $category, $image, $imageTmp, $video, $status, $user_id){   
      $this->id = $id != null ? $id : null;   
      $this->title = $title;
      $this->body = $body;
      $this->category = $category;    
      $this->image = $image;
      $this->imageTmp = $imageTmp;
      $this->video = $video; 
      $this->status = $status;
      date_default_timezone_set('America/Chihuahua');
      $this->created_at = date('Y-m-d H:i:s');
      $this->updated_at = date('Y-m-d H:i:s');
      $this->user_id = $user_id;

      // echo json_encode($this->arrayPrueba);
      
   }


   public function createTable(){
      $this->connect();
      if($this->mysqli->query(
         "CREATE TABLE IF NOT EXISTS `articles` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `title` VARCHAR(100) NOT NULL , 
            `body` VARCHAR(1000) NOT NULL ,
            `category` VARCHAR(1000) NOT NULL ,
            `image` VARCHAR(100) ,
            `video` VARCHAR(100) ,
            `status` VARCHAR(20) DEFAULT 'unpublished',
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `updated_at` DATETIME NOT NULL, 
            `user_id` INT(11) NOT NULL ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin"
         )
      ){
         array_push($this->message, ['article-msg'=>"Se creó la tabla articles", 'msgType'=>'succes']);
      }
      else{
         array_push($this->message, ['article-msg'=>"Erorr al crear la tabla users", 'msgType'=>'error']);
      }   
      $this->disconnect();
   }

   public function alterTable(){
      $query = "ALTER TABLE `articles` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
      $this->connect();
      if($this->mysqli->query($query)){
         array_push($this->message, ['article-msg'=>"Se creo la relación de la tabla articles con users", 'msgType'=>'succes']);
      }
      else{
         array_push($this->message, ['article-msg'=>"Error al crear la relacion de la tabla articles con users", 'msgType'=>'error']);
      }   
      $this->disconnect();
   }


   public function dropTable(){
      $this->connect();
      if($this->mysqli->query("DROP TABLE `articles`")){
         echo "Se eliminó la tabla articles";
      }
      else{
         echo "Error al eliminar la tabla articles";
      }   
      $this->disconnect();
   }


   public function selectAll(){
      $data;
      $articleData = array();      
      $query = "SELECT * FROM `articles` WHERE status = 'published' ORDER BY category, created_at DESC";
      
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
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
         ]);

      }

      $data = [
         'data' => $articleData,
         'messages' => $this->message
      ];

      return json_encode($data);     
   }


   public function selectCategory($category){
      $data;
      $articleData = array();      
      $query = "SELECT * FROM `articles` WHERE status = 'published' AND category = '$category' ORDER BY created_at DESC";
      
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
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
         ]);

      }

      $data = [
         'data' => $articleData,
         'messages' => $this->message
      ];

      return json_encode($data);     
   }


   public function all(){
      $data;
      $articleData = array();      
      $query = "SELECT * FROM `articles` ORDER BY category";
      
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
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
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
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'comments' => []
         ];
      }    
      
      return json_encode($articleData);      
   }


   public function create(){
      $nextId = $this->nextId()['next_id'];
      $articleName = str_replace(" ","_",$this->created_at);
      $articleName = str_replace(":","",$articleName);
      $articleName = $articleName."_".$nextId.".jpg";

      $this->image = $this->image != '' ? $articleName : "no-image.png";
      $this->video = $this->video != '' ? "{$this->video}" : null;

      $query = "INSERT INTO `articles` (`id`, `title`, `body`, `category`, `image`, `video`, `status`, `created_at`, `updated_at`, `user_id`) 
         VALUES (NULL, '{$this->title}', '{$this->body}', '{$this->category}', '{$this->image}',  '{$this->video}', '{$this->status}', '{$this->created_at}', '{$this->updated_at}', '{$this->user_id}')";
      $this->connect();
      $this->executeQuery($query, 'Articulo agregado correctamente', 'Error al agregar el articulo');
      $this->disconnect();

      if($this->message[3]['msgType'] == 'succes'){
         if(!file_exists("../images/articles/$nextId")){
            mkdir("../images/articles/$nextId",0777);
         }
         if (move_uploaded_file($this->imageTmp, "../images/articles/$nextId/".$this->image)) {
            array_push($this->message, ['article-msg'=>"Se guardó la imagen", 'msgType'=>'succes']);
         }else {
            array_push($this->message, ['article-msg'=>"Error al guardar imagen", 'msgType'=>'error']);
         } 
         array_push($this->message, ['article-msg'=>"Artículo guardado", 'msgType'=>'succes']);       
      }else{
         array_push($this->message, ['article-msg'=>"Error al guardar artículo", 'msgType'=>'error']);
      }    
   }



   public function delete($id){
      $query = "DELETE FROM articles WHERE `articles`.`id` = {$id}";
      $this->connect();
      $this->executeQuery($query, 'Articulo eliminado', 'No se puede eliminar el articulo');
      $this->disconnect();

      if($this->message[1]['msgType'] == 'succes'){
         $directory = "../images/articles/$id/";
         $files = scandir($directory);
         foreach ($files as $key => $value) {
            if(!is_dir($value)){              
               if(unlink($directory.$value)){
                  array_push($this->message, ['article-msg'=>"Se eliminó la imagen: $value", 'msgType'=>'succes']);
               }else{
                  array_push($this->message, ['article-msg'=>"Error al eliminar la imagen: $value", 'msgType'=>'error']);
               }                           
            }                
         }
         if (rmdir($directory)) {            
            array_push($this->message, ['article-msg'=>'Se eliminó el directorio del artículo', 'msgType'=>'succes']);
         }else {
            array_push($this->message, ['article-msg'=>'No se pudo eliminar el directorio del articulo', 'msgType'=>'error']);
         }
      }

      return json_encode($this->message);
   }

   

   public function update(){
     if($this->image != '' || $this->video != ''){
         $articleName = str_replace(" ","_",$this->created_at);
         $articleName = str_replace(":","",$articleName);
         $articleName = $articleName."_".$this->id.".jpg";
         $this->image = $this->image != '' ? $articleName : "no-image.png";
         $this->video = $this->video != '' ? "{$this->video}" : null;
         $query = "UPDATE `articles` SET 
         `title` = '{$this->title}', 
         `body` = '{$this->body}', 
         `category` = '{$this->category}', 
         `image` = '{$this->image}', 
         `video` = '{$this->video}',
         `status` = '{$this->status}', 
         `updated_at` = '{$this->updated_at}',         
         `user_id` = '{$this->user_id}'
         WHERE `articles`.`id` = {$this->id}";
     }else{
         $query = "UPDATE `articles` SET 
         `title` = '{$this->title}', 
         `body` = '{$this->body}', 
         `category` = '{$this->category}',      
         `status` = '{$this->status}', 
         `updated_at` = '{$this->updated_at}',
         `user_id` = '{$this->user_id}'
         WHERE `articles`.`id` = {$this->id}";
     }     
       $this->connect();
       $this->executeQuery($query, 'Articulo actualizado', 'No se puede actualizar el articulo');
       $this->disconnect();
         
      if($this->message[2]['msgType'] == 'succes'){
         if ($this->image != '') {
            if (move_uploaded_file($this->imageTmp, "../images/articles/{$this->id}/{$this->image}")) {
               array_push($this->message, ['article-msg'=>"Se guardó la imagen", 'msgType'=>'succes']);
               $this->deletePastImages($this->id, $this->image);
            }else {
               array_push($this->message, ['article-msg'=>"Error al guardar imagen", 'msgType'=>'error']);
            } 
         } 
         array_push($this->message, ['article-msg'=>"Artículo actualizado", 'msgType'=>'succes']); 
      }else{
         array_push($this->message, ['article-msg'=>"Error al actualizar artículo", 'msgType'=>'error']);
      } 
   }


   //Funciones de ayuda
   public function nextId(){
      $articleData = array();
      $query = "SELECT `AUTO_INCREMENT`
                  FROM  INFORMATION_SCHEMA.TABLES
                  WHERE TABLE_SCHEMA = 'fedugalher_blog'
                  AND   TABLE_NAME   = 'articles'";
      $this->connect();
      $select = $this->mysqli->query($query);     
      $this->disconnect(); 

      while($row = $select->fetch_assoc()){
         $articleData['next_id'] = $row['AUTO_INCREMENT'];
      }

      return $articleData; //Retorna arreglo
   }

   public function selectLimit($limit){
      $data = array();
      $articleData = array();
      $query = "SELECT * FROM `articles` WHERE status = 'published' ORDER BY created_at DESC LIMIT $limit";
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
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'user_id' => $row['user_id'],
         ]);
      }
      $data = [
         'data' => $articleData,
         'messages' => $this->message
      ];
      return json_encode($data);
   }

   public function deletePastImages($id, $currentImage){
      $directory = "../images/articles/$id/";
      $files = scandir($directory);
      foreach ($files as $key => $value) {
         if(!is_dir($value)){
            if($value !== $currentImage){
               if(unlink($directory.$value)){
                  array_push($this->message, ['article-msg'=>"Se eliminó la imagen: $value", 'msgType'=>'succes']);
               }else{
                  array_push($this->message, ['article-msg'=>"Error al eliminar la imagen: $value", 'msgType'=>'error']);
               }
            }            
         }                
      }
   }

}

// Pruebas
// $article = new Article();
// $article->searchImg();
// $article->createTable();
// $article->alterTable();
// $article->set(null, '$title', '$body', '$category', '$image', '$video');
// echo $article->set('Publicación 1', 'Texto Publicación 1', 'gameplays', 'imagen.jpg', 'video.mp4');
// echo $article->create();
// $article->delete(4);
// $article->update(3, 'Prueba update', 'prueba update body', 'prueba update category', date('Y-m-d H:i:s'));
// $article->selectAll();
// $article->last()['id']; //ejemplo mostrar ultimo id
// $article->show(1);
// $article->selectLimit(10);

?>