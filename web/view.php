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
   <body style="font-family: monospace" > 
      <div  
         id="chart" 
         style="width: 1200px; height: 600px">
      </div>
      <input type="button" style="width: 400px; height: 100px;" id="hour"   value="Hour"/><br><br>
      <input type="button" style="width: 400px; height: 100px;" id="day"    value="Day" /><br><br>
      <input type="button" style="width: 400px; height: 100px;" id="week"   value="Week" /><br><br>
      <input type="button" style="width: 400px; height: 100px;" id="month"  value="Month" />
      <p>
      <table border="1">
         <tr>  <th>Data</th>           <th>Value</th>                               </tr>
         <tr>  <td>Rows</td>           <td><?php echo $db->getNumEntries()?></td>   </tr>
         <tr>  <td>First Entry</td>    <td><?php echo $db->getFirstEntry()?></td>   </tr>
         <tr>  <td>Last Entry</td>     <td><?php echo $db->getLastEntry()?></td>    </tr>        
         <tr>  <td>Server Time</td>    <td><?php echo $db->getTimeNow()?></td>      </tr>        
         <tr>  <td>Client Time</td>    <td id="time"></td>                          </tr>             
      </table>
      <script>
         document.getElementById('time').innerHTML = new Date(); 
      </script>
   </body>
</html>

