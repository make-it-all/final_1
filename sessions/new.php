<?php
  require_once $_SERVER["DOCUMENT_ROOT"].'/bin/init.php';
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form action="sessions/create.php" method="post">
      <div class="field">
        <label for="email_field">Email</label>
        <input type="email" name="session[email]" id="email_field">
      </div>
      <div class="field">
        <label for="password_field">Password</label>
        <input type="password" name="session[password]" id="password_field">
      </div>
      <div class="actions">
        <input type="submit" name="session[commit]" value="Log in">
      </div>
    </form>
  </body>
</html>
