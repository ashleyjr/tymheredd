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

   function getTableDay() {
      $day = strtotime("today");  
      $sql = "SELECT TIME_THEN, TEMP FROM data WHERE TIME_THEN > ".$day;
      $result = $this->db->query($sql);  
	   while ($row = $result->fetch_assoc()) {
		   $timestamp = $row["TIME_THEN"];
         $offset = ($timestamp - $day) / 3600;
         echo "[".$offset.",".$row['TEMP']."],";
      }
      return json_encode(["Test",1]);
   }

   function getTableWeek() { 
      echo "data.addColumn('datetime', 'time');\n";
      echo "data.addColumn('number', 'temprature');\n";
      echo "data.addRows([";
      $day = strtotime("today -6 days");  
      $sql = "SELECT TIME_THEN, TEMP FROM data WHERE TIME_THEN > ".$day;
      $result = $this->db->query($sql);  
	   while ($row = $result->fetch_assoc()) {
		   $timestamp = $row["TIME_THEN"];
         $y = gmdate("Y", $timestamp); 
         $m = gmdate("m", $timestamp); 
         $d = gmdate("d", $timestamp); 
         $h = gmdate("h", $timestamp); 
         echo "[new Date(".$y.",".$d.",".$m.",".$h."),".$row['TEMP']."],\n";
      }
      echo "]);";
      echo "var options = {";
      echo "      hAxis: {";
      echo "         title: 'Time',";
      echo "         viewWindow: {";
      echo "            min: 0,";
      echo "            max: 24*7*2";
      echo "         },";
      echo "      },";
      echo "      gridlines: {";
      echo "         count: -1,";
      echo "         units: {";
      echo "            days: {format: ['MMM dd']},";
      echo "            hours: {format: ['HH:mm', 'ha']},";
      echo "         }";
      echo "      },";
      echo "      vAxis: {";
      echo "         title: 'Temprature (C)'";
      echo "      }";
      echo "   };";
   }

   function getTableMonth() {
      $day = strtotime("last month"); 
      $this->__getTable($day); 
   }

   function __getTable($from) {
      $sql = "SELECT TIME_THEN, TEMP FROM data WHERE TIME_THEN > ".$from;
      $result = $this->db->query($sql);  
	   while ($row = $result->fetch_assoc()) {
		   $timestamp = $row["TIME_THEN"];
         $offset = ($timestamp - $from) / 3600;
         echo "[".$offset.",".$row['TEMP']."],";
		}
   }
}
?>
