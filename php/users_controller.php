<?php

require('user.php');

$user = new User();

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 0;



if(isset($_GET['method'])){
   $method = $_GET['method'];
}elseif (isset($_POST['method'])) {
   $method = $_POST['method'];
}else {
   $method = 'No se recibió ningun metodo';
}

switch ($method) {
   case 'usersTable':
      $user->createTable();
      break;
   case 'selectAll':
      echo $user->selectAll();
      break;
   case 'show':
      echo $user->show($id);
      break;
   case 'selectLimit':
      echo $user->selectLimit($limit);
      break;
   case 'new':
      setNew();
      break;
   case 'edit':
      echo $user->show($id);
      break;
   case 'update':
      setUpdate();
      break;
   case 'delete':
      echo $user->delete($id);
      break;
   
   // default:
   //    echo $user->selectAll();
   //    break;
}

function setNew(){
   
   $user = new User();
   $email = isset($_POST['email']) ? $_POST['email'] : 'No hay email';
   $username = isset($_POST['username']) ? $_POST['username'] : 'No hay username';
   $passwordUser = isset($_POST['password']) ? $_POST['password'] : 'No hay Password';
   $role = isset($_POST['role']) ? $_POST['role'] : 'No hay Rol';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'no-image.png';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
   $imgPath = '../images/users/';

   $userArray = [
      'email' => $email,
      'username' => $username,
      'password' => $passwordUser,
      'role' => $role,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->set(null, $email, $username, $passwordUser, $role, $image);
   
   if($user->create()){
      if (move_uploaded_file($imageTmp, $imgPath.$user->image)) {
         $userArray['img-msg'] = 'Imagen Cargada';
      }else {
         $userArray['img-msg'] = 'No se cargó una imagen';
      }
      $userArray['user-msg'] = 'Usuario Registrado';
      echo json_encode($userArray);
   }  
}

function setUpdate(){
   
   $user = new User();
   $userId = isset($_POST['id']) ? $_POST['id'] : 0;
   $email = isset($_POST['email']) ? $_POST['email'] : 'No hay email';
   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $passwordUser = isset($_POST['password']) ? $_POST['password'] : '';
   $role = isset($_POST['role']) ? $_POST['role'] : '';
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
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->set($userId, $email, $username, $passwordUser, $role, $image);
   
   if($user->update()){
      if ($image != '') {
         if (move_uploaded_file($imageTmp, $imgPath.$user->image)) {
            $userArray['img-msg'] = 'Se actualizó la imagen';
         }else {
            $userArray['img-msg'] = 'No se pudo actualizar la imagen';
         }
      }    
      $userArray['user-msg'] = 'Usuario actualizado'; 
      echo json_encode($userArray);
   }  
}


?>