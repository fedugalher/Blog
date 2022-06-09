<?php
 
   if(!file_exists("./images/users/2")){
       
      $files = scandir("../images/users/2");

      foreach ($files as $file) {
        if(!is_dir($file) && $file !== '2022-06-09_103143_2.jpg'){
           unlink("../images/users/2/".$file);
        }        
      }
   }
   
   
?>