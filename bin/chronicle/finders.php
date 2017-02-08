<?php namespace Chronicle;

trait Finders {

  public static function all() {
    $rows = self::connection()->select_all(static::$table_name);
    $record_array = new RecordArray(get_called_class());
    $record_array->from_pdo_results($rows);
    return $record_array;
  }

  public static function first() {
    // TODO: implement
    return static::all()->first();
  }

  public static function last() {
    // TODO: implement
    return static::all()->last();
  }

  public static function find(...$ids) {
    // TODO: implement
  }

  public static function find_by($attrs) {

    $query = new Query\Select(get_called_class());
    $query->where('id = 2')->limit(1)->order('created_at asc');

    echo $query->toSQL();
    exit();
    return $query->first();

  }

}



User::where(['email'=>'henry@gmail.com', 'password'=>'pass123'])->order('created_at asc');
User::first(20)->joins('calls')
