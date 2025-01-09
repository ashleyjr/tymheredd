<?php
   require __DIR__ . '/db.php';
   $db = new Db($_GET['password']); 
?>

<html>
   <head> 
      <script>
         var hour = <?php echo $db->getHour()?>;
         var day  = <?php echo $db->getDay()?>;
         var week = <?php echo $db->getWeek()?>;
         var month= <?php echo $db->getMonth()?>;
      </script>
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
         id="chart" 
         style="width: 900px; height: 500px">
      </div>
      <input type="button" id="hour"   value="Hour" />
      <input type="button" id="day"    value="Day" />
      <input type="button" id="week"   value="Week" />
      <input type="button" id="month"  value="Month" /> 
   </body>
</html>

