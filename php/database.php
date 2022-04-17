<?php

class Database{
   public $host = 'localhost';
   public $user = 'root';
   public $password = '';
   public $dbName = 'fedugalher_blog';
   public $mysqli = '';
   public $message = array();

   public function connect(){
      $this->mysqli = new mysqli("$this->host", "$this->user", "$this->password", "$this->dbName");
      if ($this->mysqli->connect_errno) {
         echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
        array_push($this->message, ['msg'=>"Conexión exitosa a la base de datos {$this->dbName}", 'msgType'=>'succes']);
   }

   public function disconnect(){
      $this->mysqli->close();
      array_push($this->message, ['msg'=>"Se ha desconectado de la base de datos", 'msgType'=>'succes']);
   }

   public function createDB($dbName){
      $this->mysqli = new mysqli("$this->host", "$this->user", "$this->password", "");
      if($this->mysqli->query("CREATE DATABASE IF NOT EXISTS {$dbName} CHARACTER SET utf8 COLLATE utf8_bin ")){
         echo "Se creo la base de datos {$dbName}";          
      }
      else{
         echo 'Error al crear la base de datos';
      }
   }
  

   public function executeQuery($query, $succes, $error){
      if($this->mysqli->query($query)){
         array_push($this->message, ['msg'=>$succes, 'msgType'=>'succes']);
      }else{
         array_push($this->message, ['msg'=>$error, 'msgType'=>'error']);
      }
   }
}

// $mysqli = new Database();
// $mysqli->createDB('fedugalher_blog');
// $mysqli->connect();
// $mysqli->createTable('articles');
// $mysqli->dropTable('articles');
// $mysqli->disconnect();


?>