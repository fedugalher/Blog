<?php

require('database.php');

class Comment extends Database{
   public $id;
   public $commenter;
   public $comment;   
   public $date;  
   public $article_id;
   public $arrayPrueba = [1,2,3,4,5,6];

   public function set($id, $commenter, $comment, $article_id){   
      $this->id = $id != null ? $id : null;   
      $this->commenter = $commenter;
      $this->comment = $comment;     
      date_default_timezone_set('America/Chihuahua');
      $this->date = date('Y-m-d H:i:s');
      $this->article_id = $article_id;
      
   }


   public function createTable(){
      $this->connect();
      if($this->mysqli->query(
         "CREATE TABLE IF NOT EXISTS `comments` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `name` VARCHAR(100) NOT NULL , 
            `comment` VARCHAR(1000) NOT NULL ,
            `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            `article_id` INT(11) NOT NULL ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin"
         )
      ){
         array_push($this->message, ['msg'=>"Se creó la tabla comments", 'msgType'=>'succes']);
      }
      else{
         array_push($this->message, ['msg'=>"Erorr al crear la tabla articles", 'msgType'=>'error']);
      }   
      $this->disconnect();
   }

   public function alterTable(){
      $query = "ALTER TABLE `comments` ADD FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
      $this->connect();
      if($this->mysqli->query($query)){
         array_push($this->message, ['msg'=>"Se creo la relación de la tabla comments con articles", 'msgType'=>'succes']);
      }
      else{
         array_push($this->message, ['msg'=>"Error al crear la relacion de la tabla comments con articles", 'msgType'=>'error']);
      }   
      $this->disconnect();
   }


   public function dropTable(){
      $this->connect();
      if($this->mysqli->query("DROP TABLE `comments`")){
         echo "Se eliminó la tabla comments";
      }
      else{
         echo "Error al eliminar la tabla comments";
      }   
      $this->disconnect();
   }

   public function create(){
      $query = "INSERT INTO `comments` 
         (`id`, `name`, `comment`, `date`, `article_id`) 
         VALUES (NULL, '{$this->commenter}', '{$this->comment}', '{$this->date}', '{$this->article_id}')";
      
      $this->connect();
      $this->executeQuery($query, 'Comentario guardado', 'Error al guardar comentario');
      $this->disconnect();

      if($this->message[1]['msgType'] == 'succes'){
         return true;
      }else{
         return false;
      }

   }


   public function selectAll($id){      
      $query = "SELECT * FROM `comments` WHERE article_id = $id ORDER BY id DESC";
      $this->connect();
      $select = $this->mysqli->query($query);
      $this->disconnect();
      $commentsData = [];
      while($row = $select->fetch_assoc()){
         array_push($commentsData, [
            'id' => $row['id'], 
            'name' => $row['name'], 
            'comment' => $row['comment'],
            'date' => $row['date']
         ]);
         
      }

      return json_encode($commentsData);     
   }


   public function show($id){
      $query = "SELECT * FROM comments WHERE id = $id";
      $this->connect();
      $select = $this->mysqli->query($query);
      $this->disconnect();
      
      while($row = $select->fetch_assoc()){
         $commentData = [
            'id' => $row['id'], 
            'name' => $row['name'], 
            'comment' => $row['comment'], 
            'date' => $row['date'],
            'article_id' => $row['article_id'],
         ];

      }
      return json_encode($commentData);      
   }


   public function delete($id){
      $query = "DELETE FROM comments WHERE `comments`.`id` = {$id}";
      $this->connect();
      $this->executeQuery($query, 'Comentario eliminado', 'No se puede eliminar el comentario');
      $this->disconnect();

      return json_encode($this->message);
   }

   

   public function update(){
     
         $query = "UPDATE `comments` SET 
         `name` = '{$this->name}', 
         `comment` = '{$this->comment}', 
         `date` = '{$this->date}',
         `article_id` = '{$this->article_id}'
         WHERE `comments`.`id` = {$this->id}";
         
       $this->connect();
       $this->executeQuery($query, 'Comentario actualizado', 'No se puede actualizar el comentario');
       $this->disconnect();
         
      if($this->message[2]['msgType'] == 'succes'){
         return true;
      }else{
         return false;
      } 
   }


   //Funciones de ayuda   
   public function selectLimit($limit){
      $data = array();
      $commentData = array();
      $query = "SELECT * FROM `comments` LIMIT $limit";
      $this->connect();
      $select = $this->mysqli->query($query);      
      $this->disconnect();

      while($row = $select->fetch_assoc()){
         array_push($commentData,[
            'id' => $row['id'], 
            'name' => $row['name'], 
            'comment' => $row['comment'], 
            'date' => $row['date'],
            'article_id' => $row['article_id'],
         ]);
      }
      $data = [
         'data' => $commentData,
         'messages' => $this->message
      ];
      return json_encode($data);
   }
}

// Pruebas
// $article = new Article();
// $article->createTable();
// $article->alterTable();
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