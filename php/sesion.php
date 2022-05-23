<?php
   session_start();
   require('database.php');

   class Sesion extends Database{
      public $username;
      public $userPassword;
      public $userRole;

      public function set($username, $userPassword){
         $this->username = $username;
         $this->userPassword = $userPassword;
      }

      public function startSesion(){
         $userData = [];
         $query = "SELECT * FROM users 
            WHERE (username = '{$this->username}' OR email = '{$this->username}' ) 
            AND password = MD5('{$this->userPassword}')";
         $this->connect();
         $select = $this->mysqli->query($query);
         
         if(mysqli_num_rows($select) !== 0){            
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
            if($userData['status'] === 'activo'){
               $_SESSION['started'] = true;
               $_SESSION['id'] = $userData['id'];
               $_SESSION['username'] = $userData['username'];
               $_SESSION['email'] = $userData['email'];
               $_SESSION['role'] = $userData['role'] === 'admin' ? 'admin' : 'usuario';
               $_SESSION['image'] = $userData['image'];             
               array_push($this->message, ['session-msg'=>"Datos Correctos", 'msgType'=>'succes']);
            }else{
               $userdata = ['username'=>'', 'password'=>'', 'role'=>''];
               array_push($this->message, ['session-msg'=>"Cuenta inactiva", 'msgType'=>'error']);
            }
         }else{            
            $userdata = ['username'=>'', 'password'=>'', 'role'=>''];
            array_push($this->message, ['session-msg'=>"Datos Inorrectos", 'msgType'=>'error']);
         }
         $this->disconnect();

         $data = [
            'data' => $userData,
            'messages' => $this->message
         ];
   
         return json_encode($data);      
      }

      public function closeSesion(){
         if(session_destroy()){
            session_unset();
            array_push($this->message, ['session-msg'=>"Se ha cerrado la sesión", 'msgType'=>'succes']);            
         }else{
            array_push($this->message, ['session-msg'=>"Error al cerrar la sesión", 'msgType'=>'error']);
         }             
         return json_encode($this->message);
      }

   }

   // $sesion = new Sesion();
   // $sesion->set('fedugalher', 123);
   // $sesion->startSesion();
   // $sesion->closeSesion();

?>