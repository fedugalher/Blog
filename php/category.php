<?php
   include('database.php');

   class Category extends Database{
      public $id;
      public $name;     
      public $created_at;
      public $updated_at;

      public function set($id, $name){
         $this->id = $id;
         $this->name = $name;
         date_default_timezone_set('America/Chihuahua');
         $this->created_at = date('Y-m-d H:i:s');
         $this->updated_at = date('Y-m-d H:i:s');
      }

      public function createTable(){
         $query = "CREATE TABLE IF NOT EXISTS `fedugalher_blog`.`categories` ( 
            `id` INT(11) NOT NULL AUTO_INCREMENT , 
            `name` VARCHAR(100) NOT NULL ,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            `updated_at` DATETIME NOT NULL ,
            PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
         
         $this->connect();
         if($this->mysqli->query($query)){
            array_push($this->message, ['user-msg'=>"Se creó la tabla categories", 'msgType'=>'succes']);
         }else{
            array_push($this->message, ['user-msg'=>"Error al crear la tabla categories", 'msgType'=>'error']);
         }
         $this->disconnect();
         echo json_encode($this->message);
      }

      public function dropTable(){
         $query = "DROP TABLE `categories`";

         $this->connect();
         if($this->mysqli->query($query)){
            echo "Se eliminó la tabla categories";
         }
         else{
            echo "Error al eliminar la tabla categories";
         } 
         $this->disconnect(); 
      }


      public function selectAll(){
         $data;
         $categoryData = array();      
         $query = "SELECT * FROM `categories` ORDER BY name";
         
         $this->connect();
         $select = $this->mysqli->query($query);      
         $this->disconnect();
   
         for ($rows = $select->num_rows - 1; $rows >= 0; $rows--) {
            $row = $select->fetch_assoc();
            array_push($categoryData,[
               'id' => $row['id'], 
               'name' => $row['name'],
               'created_at' => $row['created_at'],
               'updated_at' => $row['updated_at']
            ]);
   
         }
   
         $data = [
            'data' => $categoryData,
            'messages' => $this->message
         ];
   
         return json_encode($data);     
      }
   

      public function create(){        
            $query = "INSERT INTO `categories` 
               (`id`, `name`, `created_at`, `updated_at`) 
               VALUES (
                  NULL, 
                  '{$this->name}',
                  '{$this->created_at}', 
                  '{$this->updated_at}'
               )";
            
            $this->connect();
            $this->executeQuery($query, "Se agregó la categoría {$this->name}", "Error al agregar la categoría {$this->name}");
            $this->disconnect();
   
            if($this->message[1]['msgType'] == 'succes'){ 
               return true;
            }else{
               return false;
            }        
      }


      public function delete($id){
         $query = "DELETE FROM `categories` WHERE `id` = $id";
         
         $this->connect();
         $this->executeQuery($query, 'Categoría eliminada', 'Error al eliminar la categoria');
         $this->disconnect();

         return json_encode($this->message);

      }
     
   }

?>