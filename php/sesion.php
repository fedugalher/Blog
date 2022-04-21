<?php
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
   }

   // $sesion = new Sesion();
   // $sesion->set('fedugalher', 123);
   // $sesion->startSesion();

?>