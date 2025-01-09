<?php
   require __DIR__ . '/db.php';
   $db = new Db($_GET['password']);
   $db->submit(
      $_GET['time'],
      $_GET['temp']
   );
?>
<html>
   <body>
      time: <?php echo $_GET['time']; ?><br>
      temp: <?php echo $_GET['temp']; ?>
   </body>
</html>
