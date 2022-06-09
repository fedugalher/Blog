<?php
session_start();

require('user.php');

$user = new User();

$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 0;


if(isset($_GET['method'])){
   $method = $_GET['method'];
}elseif (isset($_POST['method'])) {
   $method = $_POST['method'];
}else {
   $method = 'No se recibió ningun metodo';
}
if($userRole === 'admin'){
   switch ($method) {
      case 'usersTable':
         $user->createTable();
         break;
      case 'selectAll':
         echo $user->selectAll();
         break;
      case 'show':
         echo $user->show($user_id);
         break;
      case 'selectLimit':
         echo $user->selectLimit($limit);
         break;
      case 'new':
         setNew();
         break;
      case 'edit':
         echo $user->show($user_id);
         break;
      case 'update':
         setUpdateAdmin();
         break;
      case 'delete':
         echo $user->delete($id);
         break;
      case 'activate':
         activate();;
         break;
      
      // default:
      //    echo $user->selectAll();
      //    break;
   }
}else{
   switch ($method) {      
      case 'new':
         setNew();
         break;
      case 'edit':
         echo $user->show($id);
         break;
      case 'update':
         setUpdate();
         break;
      case 'show':
         echo $user->show($user_id);
         break;
      case 'activate':
         activate();;
         break;
      case 'passwordRequest':
         passwordRequest();
         break;
      case 'passwordReset':
         passwordReset();
         break;
   }
}

function setNew(){
   
   $user = new User();
   $email = isset($_POST['email']) ? $_POST['email'] : 'No hay email';
   $username = isset($_POST['username']) ? $_POST['username'] : 'No hay username';
   $passwordUser = isset($_POST['password']) ? $_POST['password'] : 'No hay Password';
   $role = isset($_POST['role']) ? $_POST['role'] : 'No hay Rol';
   $status = 'inactivo';
   $token = rand(100000, 999999);
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'no-image.png';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
   $imgPath = '../images/users/';

   $userArray = [
      'email' => $email,
      'username' => $username,
      'password' => $passwordUser,
      'role' => $role,
      'image' => $image,
      'status' => $status,
      'token' => $token,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->set(null, $email, $username, $passwordUser, $role, $image, $imageTmp, $status, $token);   
   $user->create();
   echo json_encode($user->message);
  
}

function setUpdate(){
   $user = new User();
   $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
   $email = isset($_POST['email']) ? $_POST['email'] : 'No hay email';
   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $passwordUser = isset($_POST['password']) ? $_POST['password'] : '';
   $passwordNew = isset($_POST['password-new']) ? $_POST['password-new'] : '';
   $role = isset($_POST['role']) ? $_POST['role'] : '';
   $status = isset($_POST['status']) ? $_POST['status'] : '';
   $token = isset($_POST['token']) ? $_POST['token'] : '';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
   $imgPath = '../images/users/';
   

   $userArray = [
      'id' => $user_id,
      'email' => $email,
      'username' => $username,
      'password' => $passwordUser,  
      'password-new' => $passwordNew, 
      'role' => $role,   
      'status' => $status, 
      'token' => $token, 
      'image' => $image,     
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->passwordNew = $passwordNew;
   $user->set($user_id, $email, $username, $passwordUser, $role, $image, $imageTmp, $status, $token);
   $user->update();   
   echo json_encode($user->message);

}

function setUpdateAdmin(){
   
   $user = new User();
   $userId = isset($_POST['id']) ? $_POST['id'] : 0;
   $email = isset($_POST['email']) ? $_POST['email'] : 'No hay email';
   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $passwordUser = isset($_POST['password']) ? $_POST['password'] : '';
   $role = isset($_POST['role']) ? $_POST['role'] : '';
   $status = isset($_POST['status']) ? $_POST['status'] : '';
   $token = isset($_POST['token']) ? $_POST['token'] : '';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
   $imgPath = '../images/users/';
   

   $userArray = [
      'id' => $userId,
      'email' => $email,
      'username' => $username,
      'password' => $passwordUser,
      'role' => $role,
      'image' => $image,
      'status' => $status,
      'token' => $token,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->set($userId, $email, $username, $passwordUser, $role, $image, $imageTmp, $status, $token);
   $user->updateAdmin();
   echo json_encode($user->message);
   
}

function activate(){
   $user = new User();
   $email = isset($_GET['email']) ? $_GET['email'] : '';
   $token = isset($_GET['token']) ? $_GET['token'] : 0;
   echo $user->activate($email, $token);
}

function passwordRequest(){
   $user = new User();
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $username = isset($_POST['username']) ? $_POST['username'] : 0;
   echo $user->passwordRequest($email, $username);
}

function passwordReset(){
   $user = new User();
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $token = isset($_POST['token']) ? $_POST['token'] : 0;
   $password = isset($_POST['password']) ? $_POST['password'] : 'No hay password';
   echo $user->passwordReset($email, $token, $password);
}



?>