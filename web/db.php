<?php
class Db {
   private $db;
   
   function __construct($password) {
      // Connect
      $this->db = new mysqli(
         "localhost",
         "esp",
         $password, 
         "db"
      );
   
      // Error on bad connection
      if ($this->db->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
      }

      // Create the table
      $sql = "CREATE TABLE IF NOT EXISTS data (
         TIME_NOW timestamp DEFAULT CURRENT_TIMESTAMP, 
         TEMP float,
         TIME_THEN int(11) 
      )";
      if ($this->db->query($sql) === FALSE) { 
        echo "Error: ".$sql ;
      } 
   }

   function submit($time, $temp) {  
      $sql = "INSERT INTO data (TIME_THEN, TEMP)
      VALUES (
         '".$time."',
         '".$temp."'
      )";    
      if ($this->db->query($sql) === FALSE) { 
        echo "Error: ".$sql ;
      }
   }
   
   function clear() {  
      $sql = "DROP TABLE data";    
      if ($this->db->query($sql) === FALSE) { 
        echo "Error: ".$sql ;
      }
   }

   function __getTime($time) {
      $sql = "SELECT TIME_NOW, TEMP FROM data WHERE TIME_NOW > ".$time;
      $result = $this->db->query($sql);  
      $data = [];
      while ($row = $result->fetch_assoc()) {
         $data[] = array($row["TIME_NOW"], (int)$row['TEMP']);
      }
      return json_encode($data);
   }
   
   function getHour() {
      return $this->__getTime(strtotime("now - 1 hour"));   
   }

   function getDay() {
      return $this->__getTime(strtotime("today"));   
   }

   function getWeek() {
      return $this->__getTime(strtotime("today - 6 days"));   
   }

   function getMonth() {
      return $this->__getTime(strtotime("today - 5 weeks"));   
   }
}
?>
