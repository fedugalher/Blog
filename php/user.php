<?php
   include('database.php');

   class User extends Database{
      public $id;
      public $email;
      public $username;
      public $passwordUser;
      public $passwordNew;
      public $role;
      public $image;
      public $status;
      public $token;
      public $regDate;
      public $updated_at;

      public function set($id, $email, $username, $passwordUser, $role, $image, $status, $token){
         $this->id = $id;
         $this->email = $email;
         $this->username = $username;
         $this->passwordUser = $passwordUser;
         $this->role = $role;
         $this->image = $image;
         $this->status = $status;
         $this->token = $token;
         date_default_timezone_set('America/Chihuahua');
         $this->regDate = date('Y-m-d H:i:s');
         $this->updated_at = date('Y-m-d H:i:s');
      }

      public function createTable(){
         $query = "CREATE TABLE IF NOT EXISTS `fedugalher_blog`.`users` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `email` VARCHAR(100) NOT NULL , 
            `username` VARCHAR(50) NOT NULL , 
            `password` VARCHAR(100) NOT NULL , 
            `role` VARCHAR(20) NOT NULL DEFAULT 'usuario' , 
            `image` VARCHAR(100) NOT NULL DEFAULT 'no-image.png' , 
            `status` VARCHAR(20) NOT NULL , 
            `token` INT(11) NOT NULL , 
            `reg_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
         
         $this->connect();
         if($this->mysqli->query($query)){
            array_push($this->message, ['user-msg'=>"Se creó la tabla users", 'msgType'=>'succes']);
         }else{
            array_push($this->message, ['user-msg'=>"Error al crear la tabla users", 'msgType'=>'error']);
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
               'email' => $row['email'], 
               'username' => $row['username'], 
               'password' => $row['password'], 
               'role' => $row['role'], 
               'image' => $row['image'],
               'status' => $row['status'],
               'token' => $row['token'],
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
         $userData = [];
         $this->connect();
         $select = $this->mysqli->query($query);
         $this->disconnect();
         
         while($row = $select->fetch_assoc()){
            $userData = [
               'id' => $row['id'], 
               'email' => $row['email'], 
               'username' => $row['username'], 
               'password' => $row['password'], 
               'role' => $row['role'], 
               'image' => $row['image'],
               'status' => $row['status'],
               'token' => $row['token'],
               'reg_date' => $row['reg_date'],
               'updated_at' => $row['updated_at']
            ];   
         }
         return json_encode($userData);      
      }
   

      public function create(){         
         if(!$this->emailExists() && !$this->usernameExists()){
            $query = "INSERT INTO `users` 
               (`id`, `email`, `username`, `password`, `role`, `image`, `status`, `token`, `reg_date`, `updated_at`) 
               VALUES (
                  NULL, 
                  '{$this->email}', 
                  '{$this->username}', 
                  MD5('{$this->passwordUser}'), 
                  '{$this->role}', 
                  '{$this->image}', 
                  '{$this->status}', 
                  '{$this->token}', 
                  '{$this->regDate}', 
                  '{$this->updated_at}'
               )";
            
            $this->connect();
            $this->executeQuery($query, 'Usuario registrado correctamente', 'Error al registrar usuario');
            $this->disconnect();
   
            if($this->message[1]['msgType'] == 'succes'){    
               require_once('mailer/email.php');        
               return true;
            }else{
               return false;
            }
         }else{
            return false;
         }
      }


      public function updateAdmin(){         
         $query = "UPDATE `users` SET ";
         $userParams = [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->passwordUser,
            'role' => $this->role,
            'image' => $this->image,
            'status' => $this->status,
            'token' => $this->token,
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

      public function update(){
         $userData = [];
         $userParams = [];  
         $userUpdated = false;       
         $query = "SELECT * FROM `users` WHERE id = {$this->id} AND password = MD5('{$this->passwordUser}')";         
        
         $this->connect();
         $select = $this->mysqli->query($query);       
         $this->disconnect();

         if($select->num_rows === 1){
            array_push($this->message, ['user-msg'=>'Contraseña Correcta', 'msgType'=>'succes']); 
            
            for ($rows = $select->num_rows - 1; $rows >= 0; $rows--) {
               $row = $select->fetch_assoc();
               array_push($userData,[
                  'id' => $row['id'], 
                  'email' => $row['email'], 
                  'username' => $row['username'], 
                  'password' => $row['password'], 
                  'role' => $row['role'], 
                  'image' => $row['image'],
                  'status' => $row['status'],
                  'token' => $row['token'],
                  'reg_date' => $row['reg_date'],
                  'updated_at' => $row['updated_at']
               ]);      
            }
            
            if($userData[0]['username'] !== $this->username){
              if(!$this->usernameExists()){
               $userParams['username'] = $this->username;
              } 
            }

            if($userData[0]['email'] !== $this->email){
               if(!$this->emailExists()){
                  $userParams['email'] = $this->email;
                  $userParams['status'] = 'inactivo';
               } 
            }

            if($userData[0]['password'] !== md5($this->passwordNew)){
               if($this->passwordNew !== ''){
                  $userParams['password'] = $this->passwordNew;
               }
            }else{
               array_push($this->message, ['user-msg'=>'Tu nueva contraseña no puede ser igual a la actual', 'msgType'=>'error']); 
               return false;
            }

            if($userData[0]['image'] !== $this->image && $this->image !== ''){
               $userParams['image'] = $this->imagew;
            }
            
            if(count($userParams) > 0){
               $newToken = rand(100000, 999999);
               $this->token = $newToken;
               $userParams['token'] = $newToken;
               $userParams['updated_at'] = $this->updated_at;
            }

            if(count($userParams) > 0){
               $query = "UPDATE `users` SET ";
   
               foreach ($userParams as $key => $value) {
                  if($value != ''){
                     if($key != 'password'){
                        $query .= "`{$key}` = '{$value}', ";
                     }else{
                        $query .= "`{$key}` = MD5('{$value}'), ";
                     }
                  }
               }
               $query = substr($query, 0, -2);
               $query .= " WHERE id = {$this->id}";
   
               $this->connect();
               $this->executeQuery($query, 'Datos de usuario actualizados', 'Error al actualizar tus datos');
               $this->disconnect();

               for ($i=0; $i < count($this->message); $i++) { 
                  foreach ($this->message[$i] as $key => $value) {
                     if($value === 'Datos de usuario actualizados'){
                       $userUpdated = true;
                     }
                  }
               }

               if($userUpdated){
                  if(array_key_exists('email', $userParams)){
                     require_once('mailer/email.php'); 
                  }
                  return true;
               }else{
                  return false;
               }             
               
            }else{
               array_push($this->message, ['user-msg'=>'No hay datos a actualizar', 'msgType'=>'error']);
               return false;
            }
                  
         }else{
            array_push($this->message, ['user-msg'=>'Contraseña incorrecta', 'msgType'=>'error']);            
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

      public function activate($email, $token){
         $query = "SELECT * FROM users WHERE email = '$email' AND token = $token";
         $this->connect();
         $select = $this->mysqli->query($query);

         if($select->num_rows){
            $newToken = rand(100000, 999999);
            $query = "UPDATE `users` SET `status` = 'activo', `token` = $newToken 
                     WHERE `email` = '$email' AND `token` = $token";
            $this->executeQuery($query, 'Cuenta activada', 'No se puede activar tu cuenta');
            $this->disconnect();
         }else{
            array_push($this->message, ['user-msg'=>'No existe la cuenta', 'msgType' => 'error']);
         }
         return json_encode($this->message);
      }

      public function passwordRequest($email, $username){
         $query = "SELECT * FROM users WHERE email = '$email' AND username = '$username'";
         $this->connect();
         $select = $this->mysqli->query($query);
         $this->disconnect();
         
         if($select->num_rows){
            while($row = $select->fetch_assoc()){
               $token = $row['token'];   
            }            
            require_once('mailer/passwordRequest.php');             
         }else{
            array_push($this->message, ['user-msg'=>'No existe la cuenta', 'msgType' => 'error']);
         }
         
         return json_encode($this->message);
      }

      public function passwordReset($email, $token, $password){
         $token = intval($token);
         $query = "SELECT * FROM users WHERE email = '$email' AND token = $token";
         $this->connect();
         $select = $this->mysqli->query($query);

         if($select->num_rows){
            $newToken = rand(100000, 999999);
            date_default_timezone_set('America/Chihuahua');
            $updated_at = date('Y-m-d H:i:s');
            $query = "UPDATE `users` 
                     SET `password` = MD5('{$password}'), 
                     `token` = $newToken,
                     `updated_at` = '$updated_at'
                     WHERE `email` = '$email' AND `token` = $token";
            $this->executeQuery($query, 'El password ha sido cambiado correctamente', 'Error al cambiar el password');
            $this->disconnect();
         }else{
            array_push($this->message, ['user-msg'=>'Lo siento, no hay ninguna cuenta asociada a los datos que ingresaste', 'msgType' => 'error']);
         }
         return json_encode($this->message);
      }

      public function usernameExists(){
         $query = "SELECT username FROM users WHERE username = '{$this->username}'";
         $this->connect();
         $select = $this->mysqli->query($query);
         $this->disconnect();
         
         if($select->num_rows){  
            array_push($this->message, ['user-msg'=>'El usuario que ingresaste ya está en uso', 'msgType' => 'error']);
            return true;
         }else{
            return false;
         }     
      }

      public function emailExists(){
         $query = "SELECT email FROM users WHERE email = '{$this->email}'";
         $this->connect();
         $select = $this->mysqli->query($query);
         $this->disconnect();
         
         if($select->num_rows){  
            array_push($this->message, ['user-msg'=>'El correo que ingresaste ya está en uso', 'msgType' => 'error']);
            return true;
         }else{
            return false;
         } 
      }



      
   }

   // $user = new User();
   // $user->set(1,'eduardo','','admin','');
   // $user->update();
   // echo $user->activate('fedugalher', 702983);
  
 
   
   
?>