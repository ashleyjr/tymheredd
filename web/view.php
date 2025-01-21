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
         style="width: 1200px; height: 600px">
      </div>
      <input type="button" style="width: 200px; height: 50px;" id="hour"   value="Hour"/><br><br>
      <input type="button" style="width: 200px; height: 50px;" id="day"    value="Day" /><br><br>
      <input type="button" style="width: 200px; height: 50px;" id="week"   value="Week" /><br><br>
      <input type="button" style="width: 200px; height: 50px;" id="month"  value="Month" /> 
   </body>
</html>

