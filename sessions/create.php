<?php
  require_once $_SERVER["DOCUMENT_ROOT"].'/bin/init.php';

  $user = User::find_by(['email' => strtolower($_POST['session']['email'])]);
  if (isset($user) && $user->authenticate($_POST['session']['password'])) {
    Session::log_in($user);
    redirect_to('/');
  } else {
    // flash.now[:danger] = 'Invalid email/password'
    require 'new.php';
  }
