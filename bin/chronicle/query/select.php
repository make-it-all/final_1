<?php namespace Chronicle\Query;

class Select extends AbstractQuery {

  private $columns = [];
  private $where = [];
  private $limit;
  private $order = [];

  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
  }

  public function select(...$columns) {
    $this->columns .= $columns;
    return $this;
  }

  public function where($where) {
    $this->where[] = $where;
    return $this;
  }
  public function order($order) {
    $this->order[] = $order;
    return $this;
  }
  public function limit($limit) {
    $this->limit = $limit;
    return $this;
  }

  public function first() {
    $this->limit(1);
    return $this->execute();
  }

  public function toSQL() {
    $columns = empty($this->columns)? '*' : implode(', ', $this->columns);
    $where = empty($this->where)? '' : 'WHERE ' .implode(' AND ', $this->where);
    $order = empty($this->order)? '' : 'ORDER BY '.implode(', ', $this->order);
    $limit = ($this->limit == null)? '' : "LIMIT $this->limit";
    return "SELECT $columns $where $order $limit";
  }

  public function execute() {
    return \Chronicle\Base::connection()->select($this->toSQL());
  }

}
