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
         $query = "SELECT * FROM users WHERE username = '{$this->username}' AND password = '{$this->userPassword}' AND role = 'admin'";
         $this->connect();
         $select = $this->mysqli->query($query);
         if(mysqli_num_rows($select) !== 0){
            $_SESSION['started'] = 1;
            $userData = ['username' => $this->username, 'password' => $this->userPassword, 'role'=>'admin'];
            array_push($this->message, ['msg'=>"Datos Correctos", 'msgType'=>'succes']);
         }else{            
            $userdata = ['username'=>'', 'password'=>'', 'role'=>''];
            array_push($this->message, ['msg'=>"Datos Inorrectos", 'msgType'=>'error']);
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
            array_push($this->message, ['msg'=>"Se ha cerrado la sesión", 'msgType'=>'succes']);            
         }else{
            array_push($this->message, ['msg'=>"Error al cerrar la sesión", 'msgType'=>'error']);
         }    
         
         return json_encode($this->message);
      }

   }

   // $sesion = new Sesion();
   // $sesion->set('fedugalher', 123);
   // $sesion->startSesion();
   // $sesion->closeSesion();

?>