<?php namespace Chronicle;

class RecordArray implements \ArrayAccess {

  private $_ids;
  private $_records;

  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
    $this->loaded = false;
  }

  public function from_attrs($attrs) {
    $this->inflator = ['load_from_attrs', $attrs];
  }

  private function load_from_attrs($attrs) {
    $this->_records = array_map(function($attrs) {
      return new $this->class($attrs);
    }, $attrs);
  }

  public function from_ids($ids) {
    $this->_ids = $ids;
    $this->inflator = ['load_from_ids', $ids];
  }

  private function load_from_ids($ids) {
    $this->_records = array_map(function($id) {
      return ($this->class)::find_by(['id'=>$id])->first();
    }, $ids);
  }

  public function from_pdo_results($results) {
    $this->inflator = ['load_from_pdo_results', $results];
  }

  private function load_from_pdo_results($results) {
    $this->_records = [];
    foreach($results as $result) {
      $this->_records[] = new $this->class($result);
    }
  }

  public function load_ids() {
    if ($this->_ids == null) {
      $this->_ids = array_map(function($rec){
        return $rec->id;
      }, $this->records);
    }
    return $this->_ids;
  }

  public function ids() {
    return $this->_ids ?? $this->load_ids();
  }

  public function reload() {
    $this->loaded = false;
  }

  public function load() {
    if (!$this->loaded) {
      $function = $this->inflator[0];
      $args = array_slice($this->inflator, 1);
      call_user_func_array([$this, $function], $args);
      $this->loaded = true;
    }
  }

  public function records() {
    $this->load();
    return $this->_records;
  }



  public function first() {
    $records = $this->records();
    return reset($records);
  }

  public function last() {
    $records = $this->records();
    return end($records);
  }

  public function offsetExists($key) {
    return isset($this->records()[$key]);
  }

  public function offsetUnset($key) {
    unset($this->records()[$key]);
  }

  public function offsetSet($key, $value) {
    if (is_null($key)) {
      $this->records()[] = $value;
    } else {
      $this->records()[$key] = $value;
    }
  }

  public function offsetGet($key) {
    return isset($this->records()[$key]) ? $this->records()[$key] : null;
  }

}
