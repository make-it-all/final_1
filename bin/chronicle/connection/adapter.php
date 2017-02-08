<?php namespace Chronicle\Connection;

class Adapter {
  use DatabaseStatements;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function select($sql) {
    return $this->execute($sql);
  }

  public function insert($sql) {
    return $this->execute($sql);
  }

  public function update($sql) {
    return $this->execute($sql);
  }

  public function delete($sql) {
    return $this->execute($sql);
  }

  public function select_all($table_name) {
    $sql = "SELECT * FROM $table_name";
    return $this->select($sql);
  }

  public function select_one() {

  }

  public function table_exists($table_name) {
    $sql = "SHOW TABLES LIKE '$table_name'";
    return $this->execute($sql)->rowCount() > 0;
  }

  public function columns($table_name) {
    $sql = "SHOW FIELDS FROM $table_name";
    $columns = [];
    foreach($this->execute($sql) as $field) {
      $columns[] = new Column($field['Field'], $field['Type'], $field['Default'], $field['Null'] == 'YES');
    }
    return $columns;
  }

  public function execute($sql) {
    return $this->connection->query($sql);
  }

}
