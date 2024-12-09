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

   function getDay() {
      $day = strtotime("today");  
      $sql = "SELECT TIME_THEN, TEMP FROM data WHERE TIME_THEN > ".$day;
      $result = $this->db->query($sql);  
      $data = [];
      while ($row = $result->fetch_assoc()) {
		   $timestamp = $row["TIME_THEN"];
         $offset = ($timestamp - $day) / 3600; 
         $data[] = array($offset, (int)$row['TEMP']);
      }
      return json_encode($data);
   }

   function getWeek() {
      $day = strtotime("today - 6 days");  
      $sql = "SELECT TIME_THEN, TEMP FROM data WHERE TIME_THEN > ".$day;
      $result = $this->db->query($sql);  
      $data = [];
      while ($row = $result->fetch_assoc()) {
		   $timestamp = $row["TIME_THEN"];
         $offset = ($timestamp - $day) / (3600 * 24); 
         $data[] = array($offset, (int)$row['TEMP']);
      }
      return json_encode($data);
   }

   function getMonth() {
      $day = strtotime("today - 5 weeks");  
      $sql = "SELECT TIME_THEN, TEMP FROM data WHERE TIME_THEN > ".$day;
      $result = $this->db->query($sql);  
      $data = [];
      while ($row = $result->fetch_assoc()) {
		   $timestamp = $row["TIME_THEN"];
         $offset = ($timestamp - $day) / (3600 * 24); 
         $data[] = array($offset, (int)$row['TEMP']);
      }
      return json_encode($data);
   }

}
?>
