<?php
   require __DIR__ . '/db.php';
   $db = new Db($_GET['password']);
   echo $db->getTableDay();
?>

<html>
   <head>
      <script 
         type="text/javascript" 
         src="https://www.gstatic.com/charts/loader.js">
      </script>
      <script 
         type="text/javascript" 
         src="chart.js">
      </script>  
   </head>
   <body> 
      <div  
         id="line_top_x" 
         style="width: 900px; height: 500px">
      </div>  
   </body>
</html>

