<?php

require('database.php');

class Article extends Database{
   public $id;
   public $title;
   public $body;
   public $category;
   public $image;
   public $video;
   public $status;
   public $date;  
   public $isSucces;
   public $arrayPrueba = [1,2,3,4,5,6];

   // public function __construct($title, $body, $category){
   //    $this->title = $title;
   //    $this->body = $body;
   //    $this->category = $category;
   //    date_default_timezone_set('America/Chihuahua');
   //    $this->date = date('Y-m-d H:i:s');
   // }

   public function set($id, $title, $body, $category, $image, $video, $status){   
      $this->id = $id != null ? $id : null;   
      $this->title = $title;
      $this->body = $body;
      $this->category = $category;    
      $this->image = $image;
      $this->video = $video; 
      $this->status = $status;
      date_default_timezone_set('America/Chihuahua');
      $this->date = date('Y-m-d H:i:s');

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
            `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`id`)) ENGINE = InnoDB"
         )
      ){
         echo "Se creo la Tabla articles";
      }
      else{
         echo 'Error al crear la Tabla';
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
      $query = "SELECT * FROM `articles` WHERE status = 'published' ORDER BY category";
      
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
            'status' => $row['status'],
            'date' => $row['date']
         ];

      }
      return json_encode($articleData);      
   }


   public function create(){
      $nextId = $this->nextId()['next_id'];
      $this->image = $this->image != '' ? "article-$nextId.jpg" : "no-image.png";
      $this->video = $this->video != '' ? "{$this->video}" : null;

      $query = "INSERT INTO `articles` (`id`, `title`, `body`, `category`, `image`, `video`, `status`, `date`) 
         VALUES (NULL, '{$this->title}', '{$this->body}', '{$this->category}', '{$this->image}',  '{$this->video}', '{$this->status}', '{$this->date}')";
      $this->connect();
      $this->executeQuery($query, 'Articulo agregado correctamente', 'Error al agregar el articulo');
      $this->disconnect();

      // echo json_encode($this->arrayPrueba);
      if($this->message[3]['msgType'] == 'succes'){
         return true;
      }else{
         return false;
      }    
   }



   public function delete($id){
      $query = "DELETE FROM articles WHERE `articles`.`id` = {$id}";
      $this->connect();
      $this->executeQuery($query, 'Articulo eliminado', 'No se puede eliminar el articulo');
      $this->disconnect();

      if($this->message[1]['msgType'] == 'succes'){
         if (unlink("../images/articles/article-{$id}.jpg")) {
            array_push($this->message, ['msg'=>'Se eliminó la imagen del articulo', 'msgType'=>'succes']);
         }else {
            array_push($this->message, ['msg'=>'No se pudo eliminarla imagen del articulo', 'msgType'=>'error']);
         }
      }

      return json_encode($this->message);
   }

   

   public function update(){
     if($this->image != '' || $this->video != ''){
         $this->image = $this->image != '' ? "article-{$this->id}.jpg" : "no-image.png";
         $this->video = $this->video != '' ? "{$this->video}" : null;
         $query = "UPDATE `articles` SET 
         `title` = '{$this->title}', 
         `body` = '{$this->body}', 
         `category` = '{$this->category}', 
         `image` = '{$this->image}', 
         `video` = '{$this->video}',
         `status` = '{$this->status}', 
         `date` = '{$this->date}' 
         WHERE `articles`.`id` = {$this->id}";
     }else{
         $query = "UPDATE `articles` SET 
         `title` = '{$this->title}', 
         `body` = '{$this->body}', 
         `category` = '{$this->category}',      
         `status` = '{$this->status}', 
         `date` = '{$this->date}' 
         WHERE `articles`.`id` = {$this->id}";
     }     
       $this->connect();
       $this->executeQuery($query, 'Articulo actualizado', 'No se puede actualizar el articulo');
       $this->disconnect();

       if($this->message[2]['msgType'] == 'succes'){
         return true;
      }else{
         return false;
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
      $query = "SELECT * FROM `articles` WHERE status = 'published' LIMIT $limit";
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
// $article->set(null, '$title', '$body', '$category', '$image', '$video');
// echo $article->set('Publicación 1', 'Texto Publicación 1', 'gameplays', 'imagen.jpg', 'video.mp4');
// echo $article->create();
// $article->delete(4);
// $article->update(3, 'Prueba update', 'prueba update body', 'prueba update category', date('Y-m-d H:i:s'));
// $article->selectAll();
// $article->last()['id']; //ejemplo mostrar ultimo id
// $article->show(10);
// $article->selectLimit(10);

?>