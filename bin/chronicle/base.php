<?php namespace Chronicle;

require 'connection/database_statements.php';
require 'connection/adapter.php';
require 'connection/connection.php';
require 'connection/column.php';

require 'query/abstract.php';
require 'query/select.php';

require 'record_array.php';

require 'attribute.php';
require 'finders.php';



class Base {

  use Connection\Connection;
  use Attribute;
  use Finders;

  public static $table_name;
  public static $columns;
  public static $columns_names;

  public $new_record;

  function __construct($attributes=[]) {
    $this->attributes = $this->defaults_from_columns();

    $this->new_record = true;
    $this->assign_attributes($attributes);
    #run init callbacks
  }

  public static function table_exists() {
    return self::connection()->table_exists(static::$table_name);
  }

  public function defaults_from_columns() {
    return array_reduce($this->columns(), function($attributes, $column){
      $attributes[$column->name] = $column->default;
      return $attributes;
    }, []);
  }

  public static function columns() {
    if (!isset(self::$columns)) {
      static::$columns = self::connection()->columns(static::$table_name);
    }
    return self::$columns;
  }

  public static function column_names() {
    return array_map(self::columns(), function($column_names, $column){
      $column_names[] = $column->name;
      return $column_names;
    }, []);
  }

  public static function create(...$attrs) {
    $records = new RecordArray(get_called_class());
    $records->from_attrs($attrs);
  }


  function __toString() {
    $cls = get_class($this);

    if (get_class($this) == 'Base') {
      return 'Base';
    } elseif (static::table_exists()) {
      $attrs = array_map(function($c){return "$c->name: $this->read_attribute($c->name)";}, $this->columns());
      $attrs_str = implode(', ', $attrs);
      return "<$cls($attrs_str)>\n";
    } else {
      return "<$cls(Table doesnt exist)>\n";
    }
  }

}
