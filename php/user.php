<?php
   include('database.php');

   class User extends Database{
      public $id;
      public $username;
      public $passwordUser;
      public $role;
      public $image;
      public $regDate;
      public $updated_at;

      public function set($id, $username, $passwordUser, $role, $image){
         $this->id = $id;
         $this->username = $username;
         $this->passwordUser = $passwordUser;
         $this->role = $role;
         $this->image = $image;
         date_default_timezone_set('America/Chihuahua');
         $this->regDate = date('Y-m-d H:i:s');
         $this->updated_at = date('Y-m-d H:i:s');
      }

      public function createTable(){
         $query = "CREATE TABLE IF NOT EXISTS `fedugalher_blog`.`users` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `username` VARCHAR(50) NOT NULL , 
            `password` VARCHAR(100) NOT NULL , 
            `role` VARCHAR(20) NOT NULL DEFAULT 'usuario' , 
            `image` VARCHAR(100) NOT NULL DEFAULT 'no-image.png' , 
            `reg_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
         
         $this->connect();
         if($this->mysqli->query($query)){
            array_push($this->message, ['msg'=>"Se creó la tabla users", 'msgType'=>'succes']);
         }else{
            array_push($this->message, ['msg'=>"Error al crear la tabla users", 'msgType'=>'error']);
         }
         $this->disconnect();
         echo json_encode($this->message);
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
               'reg_date' => $row['reg_date'],
               'updated_at' => $row['updated_at']
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
               'reg_date' => $row['reg_date'],
               'updated_at' => $row['updated_at']
            ];
   
         }
         return json_encode($userData);      
      }
   

      public function create(){
         $query = "INSERT INTO `users` 
            (`id`, `username`, `password`, `role`, `image`, `reg_date`, `updated_at`) 
            VALUES (NULL, '{$this->username}', MD5('{$this->passwordUser}'), '{$this->role}', '{$this->image}', '{$this->regDate}', '{$this->updated_at}')";
         
         $this->connect();
         $this->executeQuery($query, 'Usuario registrado correctamente', 'Error al registrar usuario');
         $this->disconnect();

         if($this->message[1]['msgType'] == 'succes'){
            return true;
         }else{
            return false;
         }

      }


      public function update(){         
         $query = "UPDATE `users` SET ";
         $userParams = [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->passwordUser,
            'role' => $this->role,
            'image' => $this->image,
            'updated_at' => $this->updated_at
         ];
         foreach ($userParams as $key => $value) {
            if($key != 'id' && $value != ''){
               if($key != 'password'){
                  $query .= "`{$key}` = '{$value}', ";
               }else{
                  $query .= "`{$key}` = MD5('{$value}'), ";
               }
            }
         }
         $query = substr($query, 0, -2);
         $query .= " WHERE id = {$userParams['id']}";

         $this->connect();
         $this->executeQuery($query, 'Datos de usuario actualizados', 'No se puede actualizar el usuario');
         $this->disconnect();
         
         if($this->message[1]['msgType'] == 'succes'){
            return true;
         }else{
            return false;
         }         
      }

      public function delete($id){
         $query = "DELETE FROM `users` WHERE `id` = $id";
         
         $this->connect();
         $this->executeQuery($query, 'Usuario eliminado', 'Error al eliminar el usuario');
         $this->disconnect();

         return json_encode($this->message);

      }
   }

   // $user = new User();
   // $user->set(1,'eduardo','','admin','');
   // $user->update();
   
?>