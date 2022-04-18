<?php
   include('database.php');

   class User extends Database{
      public $id;
      public $username;
      public $passwordUser;
      public $role;
      public $image;
      public $regDate;

      public function set($id, $username, $passwordUser, $role, $image){
         $this->id = $id;
         $this->username = $username;
         $this->passwordUser = $passwordUser;
         $this->role = $role;
         $this->image = $image;
         date_default_timezone_set('America/Chihuahua');
         $this->regDate = date('Y-m-d H:i:s');
      }

      public function createTable(){
         $query = "CREATE TABLE IF NOT EXISTS `fedugalher_blog`.`users` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `username` VARCHAR(50) NOT NULL , 
            `passwordUser` VARCHAR(100) NOT NULL , 
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


      public function selectAll(){
         $data;
         $userData = array();      
         $query = "SELECT * FROM `users` ORDER BY id";
         
         $this->connect();
         $select = $this->mysqli->query($query);      
         $this->disconnect();
   
         for ($rows = $select->num_rows - 1; $rows >= 0; $rows--) {
            $row = $select->fetch_assoc();
            array_push($userData,[
               'id' => $row['id'], 
               'username' => $row['username'], 
               'password' => $row['password'], 
               'role' => $row['role'], 
               'image' => $row['image'],
               'reg_date' => $row['reg_date']
            ]);
   
         }
   
         $data = [
            'data' => $userData,
            'messages' => $this->message
         ];
   
         return json_encode($data);     
      }
   
   
      public function show($id){
         $query = "SELECT * FROM users WHERE id = $id";
         $this->connect();
         $select = $this->mysqli->query($query);
         $this->disconnect();
         
         while($row = $select->fetch_assoc()){
            $userData = [
               'id' => $row['id'], 
               'username' => $row['username'], 
               'password' => $row['password'], 
               'role' => $row['role'], 
               'image' => $row['image'],
               'reg_date' => $row['reg_date']
            ];
   
         }
         return json_encode($userData);      
      }
   

      public function create(){
         $query = "INSERT INTO `users` 
            (`id`, `username`, `password`, `role`, `image`, `reg_date`) 
            VALUES (NULL, '{$this->username}', '{$this->passwordUser}', '{$this->role}', '{$this->image}', '{$this->regDate}')";
         
         $this->connect();
         $this->executeQuery($query, 'Usuario registrado correctamente', 'Error al registrar usuario');
         $this->disconnect();

         if($this->message[1]['msgType'] == 'succes'){
            return true;
         }else{
            return false;
         }

      }
   }

   // $user = new User();
   // $user->createTable();
   
?>