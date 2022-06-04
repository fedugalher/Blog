<?php
   //Requerir la libreria Dotenv instalada con composer para usar variables de entorno de archivo .env
   require('vendor/autoload.php');
   $dotenv = Dotenv\Dotenv::createImmutable('../');
   $dotenv->load();   
?>