<?php
  require_once $_SERVER["DOCUMENT_ROOT"].'/bin/init.php';

  Chronicle\Base::setup_connection([
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'make_it_all'
  ]);

  $name = rand().' - ' . rand();
  $email = rand() . '@gmail.com';
  $password = rand();
  // print_r(User::create(['email'=>$name, 'name'=>$name, 'password'=>$password]));

  $rs = new Chronicle\RecordArray('User');
  $rs->from_ids([1,2,3]);

  echo '<pre>'. print_r($rs, true) . '</pre>';


  $rs->load();


  echo "<br>";
  echo "<br>";
  echo '<pre>'. print_r($rs, true) . '</pre>';
  echo "<br>";
  echo "<br>";
  print_r($rs->ids());


  if (current_user() == null) {
    require 'sessions/new.php';
  } else {
    current_user_root().'dashboard.php';
  }
?>


User::find_by(['id'=>2])
