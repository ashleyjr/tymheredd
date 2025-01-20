<?php
   require __DIR__ . '/db.php';
   date_default_timezone_set('UTC');
   $time_then = time();
   $db = new Db($_GET['password']);
   $db->submit(
      $time_then,
      $_GET['temp']
   );
?>
<html>
   <body>
      time: <?php echo $time_then; ?><br>
      temp: <?php echo $_GET['temp']; ?>
   </body>
</html>
