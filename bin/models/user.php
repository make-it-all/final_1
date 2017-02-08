<?php

class User extends Chronicle\Base {

  public static $table_name='users';

  public function authenticate($password) {
    return $this->password == md5($password);
  }

}
