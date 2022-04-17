<?php
   include('database.php');

   class User extends Database{
      public $id;
      public $username;
      public $password;
      public $role;
      public $image;
      public $regDate;

      public function set($id, $username, $password, $role, $image){
         $this->id = $id;
         $this->username = $username;
         $this->password = $password;
         $this->role = $role;
         $this->image = $image;
         date_default_timezone_set('America/Chihuahua');
         $this->regDate = date('Y-m-d H:i:s');
      }

      public function createTable(){
         $query = "CREATE TABLE IF NOT EXISTS `fedugalher_blog`.`users` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `username` VARCHAR(50) NOT NULL , 
            `password` VARCHAR(100) NOT NULL , 
            `role` VARCHAR(20) NOT NULL DEFAULT 'usuario' , 
            `image` VARCHAR(100) NOT NULL DEFAULT 'no-image.png' , 
            `reg_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
         
         $this->connect();
         if($this->mysqli->query($query)){
            echo "Se creó la Tabla users";
         }else{
            echo "Error al crear la tabla users";
         }
         $this->disconnect();
      }

      public function dropTable(){
         $query = "DROP TABLE `users`";

         $this->connect();
         if($this->mysqli->query($query)){
            echo "Se eliminó la tabla users";
         }
         else{
            echo "Error al eliminar la tabla users";
         } 
         $this->disconnect(); 
      }

      public function create(){

      }
   }

   // $user = new User();
   // $user->createTable();
   
?>