<?php
   require __DIR__ . '/db.php';
   $db = new Db($_GET['password']);
   $db->submit(
      $_GET['time'],
      $_GET['temp']
   );
?>

