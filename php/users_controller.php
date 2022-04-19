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
   $username = isset($_POST['username']) ? $_POST['username'] : 'No hay username';
   $passwordUser = isset($_POST['password']) ? $_POST['password'] : 'No hay PasswordUser';
   $role = isset($_POST['user-role']) ? $_POST['user-role'] : 'No hay Rol';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'No hay Imagen';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
   $imgPath = '../images/users/';

   $userArray = [
      'username' => $username,
      'passwordUser' => $passwordUser,
      'role' => $role,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->set(null, $username, $passwordUser, $role, $image);
   
   if($user->create()){
      if (move_uploaded_file($imageTmp, $imgPath.$user->image)) {
         $userArray['user-msg'] = 'Usuario Registrado';
      }else {
         $userArray['user-msg'] = 'Error al registrar usuario';
      }
      echo json_encode($userArray);
   }  
}

function setUpdate(){
   
   $user = new User();
   $username = isset($_POST['username']) ? $_POST['username'] : 'No hay username';
   $passwordUser = isset($_POST['passwordUser']) ? $_POST['passwordUser'] : 'No hay PasswordUser';
   $role = isset($_POST['role']) ? $_POST['role'] : 'No hay Rol';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : 'No hay Imagen';
   $imageTmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : 'No hay Imagen';
  
   

   $userArray = [
      'username' => $username,
      'passwordUser' => $passwordUser,
      'role' => $role,
      'image' => $image,
      'imageTmp' => $imageTmp,
      'imgPath' => $imgPath
   ];

   $user->set($id, $username, $passwordUser, $role, $image);
   
   if($user->update()){
      if ($image != '') {
         if (move_uploaded_file($imageTmp, $imgPath.$user->image)) {
            $userArray['img-msg'] = 'Se actualizó la imagen';
         }else {
            $userArray['img-msg'] = 'No se pudo actualizar la imagen';
         }
      }    
      $userArray['user-msg'] = 'Usuario Registrado'; 
      echo json_encode($userArray);
   }  
}


?>