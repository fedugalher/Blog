<?php


class Database{
   public $host;
   public $user;
   public $password;
   public $dbName;
   public $mysqli = '';
   public $message = array();

   public function __construct(){
      //Local
      require('C:\xampp\htdocs\FedugalherBlog/vendor/autoload.php');
      $dotenv = Dotenv\Dotenv::createImmutable('C:\xampp\htdocs\FedugalherBlog');

      //Production
      // require('/home2/fedugalh/vendor/autoload.php');
      // $dotenv = Dotenv\Dotenv::createImmutable('/home2/fedugalh/');

      $dotenv->load();
      $this->host     = $_ENV['DB_HOST'];
      $this->user     = $_ENV['DB_USER'];
      $this->password = $_ENV['DB_PASSWORD'];
      $this->dbName   = $_ENV['DB_NAME'];
   }

   public function connect(){     
      $this->mysqli = new mysqli("$this->host", "$this->user", "$this->password", "$this->dbName");
      if ($this->mysqli->connect_errno) {
         array_push($this->message, ['db-msg'=>"Falló la conexión a la base de datos {$this->dbName}", 'msgType'=>'error']);
      }
      array_push($this->message, ['db-msg'=>"Conexión exitosa a la base de datos {$this->dbName}", 'msgType'=>'succes']);
   }

   public function disconnect(){
      $this->mysqli->close();
      array_push($this->message, ['db-msg'=>"Se ha desconectado de la base de datos", 'msgType'=>'succes']);
   }

   public function createDB($dbName){
      $this->mysqli = new mysqli("$this->host", "$this->user", "$this->password", "");
      if($this->mysqli->query("CREATE DATABASE IF NOT EXISTS {$dbName} CHARACTER SET utf8 COLLATE utf8_bin ")){
         // echo "Se creo la base de datos {$dbName}";  
         array_push($this->message, ['db-msg'=>"Se creó la base de datos {$this->dbName}", 'msgType'=>'succes']);        
      }
      else{
         // echo 'Error al crear la base de datos';
         array_push($this->message, ['db-msg'=>"Error al crear la base de datos {$this->dbName}", 'msgType'=>'error']);
      }
   }

   public function dropDB($dbName){
      $this->mysqli = new mysqli("$this->host", "$this->user", "$this->password", "");
      if($this->mysqli->query("DROP DATABASE IF EXISTS {$dbName}")){
         // echo "Se creo la base de datos {$dbName}";  
         array_push($this->message, ['db-msg'=>"Se eliminó la base de datos {$this->dbName}", 'msgType'=>'succes']);        
      }
      else{
         // echo 'Error al crear la base de datos';
         array_push($this->message, ['db-msg'=>"Error al eliminar la base de datos {$this->dbName}", 'msgType'=>'error']);
      }
   }
  

   public function executeQuery($query, $succes, $error){
      if($this->mysqli->query($query)){
         array_push($this->message, ['db-msg'=>$succes, 'msgType'=>'succes']);
      }else{
         array_push($this->message, ['db-msg'=>$error, 'msgType'=>'error']);
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