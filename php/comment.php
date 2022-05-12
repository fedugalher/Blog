<?php

require('database.php');

class Comment extends Database{
   public $id;
   public $comment;   
   public $date;  
   public $article_id;
   public $user_id;
   public $arrayPrueba = [1,2,3,4,5,6];

   public function set($id, $comment, $article_id, $user_id){   
      $this->id = $id != null ? $id : null;        
      $this->comment = $comment;     
      date_default_timezone_set('America/Chihuahua');
      $this->date = date('Y-m-d H:i:s');
      $this->article_id = $article_id;
      $this->user_id = $user_id;
      
   }


   public function createTable(){
      $this->connect();
      if($this->mysqli->query(
         "CREATE TABLE IF NOT EXISTS `comments` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `comment` VARCHAR(500) NOT NULL,
            `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            `article_id` INT(11) NOT NULL ,
            `user_id` INT(11) NOT NULL ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin"
         )
      ){
         array_push($this->message, ['msg'=>"Se creó la tabla comments", 'msgType'=>'succes']);
         $this->alterTable();
      }
      else{
         array_push($this->message, ['msg'=>"Erorr al crear la tabla articles", 'msgType'=>'error']);
      }   
      $this->disconnect();
   }

   public function alterTable(){
      $FK = ['article_id', 'user_id'];
      $reference = ['articles', 'users'];
      $this->connect();
      for ($i=0; $i < 2; $i++) { 
         $query = "ALTER TABLE `comments` ADD FOREIGN KEY (`$FK[$i]`) REFERENCES `$reference[$i]`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
         
         if($this->mysqli->query($query)){
            array_push($this->message, ['msg'=>"Se creo la relación de la tabla comments con $reference[$i]", 'msgType'=>'succes']);
         }
         else{
            array_push($this->message, ['msg'=>"Error al crear la relacion de la tabla comments con $reference[$i]", 'msgType'=>'error']);
         }   
         
      }
      // $this->disconnect();   //Se desconecta en create table   
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
         (`id`, `comment`, `date`, `article_id`, `user_id`) 
         VALUES (NULL, '{$this->comment}', '{$this->date}', '{$this->article_id}', '{$this->user_id}')";
      
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
      $query = "SELECT `comments`.*, `users`.`username`, `users`.`image` FROM `comments` 
               INNER JOIN `users` WHERE `comments`.article_id = $id 
               AND `comments`.`user_id` = `users`.`id`
               ORDER BY `comments`.`date` DESC";
      $this->connect();
      $select = $this->mysqli->query($query);
      $this->disconnect();
      $commentsData = [];
      while($row = $select->fetch_assoc()){
         array_push($commentsData, [
            'id' => $row['id'], 
            'comment' => $row['comment'],
            'date' => $row['date'],
            'article_id' => $row['article_id'],
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            'image' => $row['image']
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
            'comment' => $row['comment'], 
            'date' => $row['date'],
            'article_id' => $row['article_id'],
            'user_id' => $row['user_id']
         ];

      }
      return json_encode($commentData);      
   }


   public function delete($id, $user_id){
      $query = "DELETE FROM comments WHERE `comments`.`id` = {$id} AND `comments`.`user_id`";
      $this->connect();
      $this->executeQuery($query, 'Comentario eliminado', 'No se puede eliminar el comentario');
      $this->disconnect();

      return json_encode($this->message);
   }

   

   public function update(){
     
         $query = "UPDATE `comments` SET          
         `comment` = '{$this->comment}',
         `user_id` = '{$this->user_id}'
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
            'comment' => $row['comment'], 
            'date' => $row['date'],
            'article_id' => $row['article_id'],
            'user_id' => $row['user_id']
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