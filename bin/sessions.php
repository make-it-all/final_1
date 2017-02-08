<?php

  session_start();

  function current_user() {
    if (isset($_SESSION['uid'])) {
      return User::find($_SESSION['uid']);
    }
  }

  function current_user_root() {
    
  }
