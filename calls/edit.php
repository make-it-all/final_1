<?php
require
  $call = Call::find($_GET['id'])
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>EDIT call $call->number</title>
  </head>
  <body>
    <form action="update.php" method="post">
      <div class="field">
        <label for="name_field">Name</label>
        <input type="text" name="name" value="<?php echo $call->name; ?>">
      </div>
    </form>
  </body>
</html>
