<?php namespace Chronicle\Connection;

use PDO;

trait Connection {

  private static $active_connection_settings;
  private static $active_connection;
  private static $active_adapter;

  public static function setup_connection($settings) {
    self::$active_connection_settings = $settings;
  }

  private static function connect() {
    extract(self::settings_to_dsn());
    $options = self::pdo_options();
    self::$active_connection = new PDO($dsn, $username, $password, $options);
    self::$active_adapter = new Adapter(self::$active_connection);
  }

  private static function settings_to_dsn() {
    extract(self::$active_connection_settings);
    $charset = $charset ?? 'utf8';
    return [
      'dsn' => "$driver:host=$host;dbname=$database;charset=$charset",
      'username' => $username,
      'password' => $password
    ];
  }

  private static function pdo_options() {
    return [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
  }

  public static function connection() {
    if (self::$active_connection==null) {
      self::connect();
    }
    return self::$active_adapter;
  }

  public static function disconnect() {
    self::$active_connection = null;
  }


}
