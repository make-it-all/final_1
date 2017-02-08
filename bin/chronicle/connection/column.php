<?php namespace Chronicle\Connection;

class ColumnTypeUnknown extends \Exception {}

class Column {

  function __construct($name, $native_type=null, $default=null, $null=true) {
    $this->name = $name;
    $this->native_type = $native_type;
    $this->type = $this->convert_type($native_type);
    $this->default = $this->cast_value($default);
    $this->limit = $this->get_limit();
    $this->null = $null;
    $this->primary = null;

  }

  private function cast_value($value) {
    if (is_null($value)) return null;
    switch($this->type) {
      case 'string':    return $value;
      case 'text':      return $value;
      case 'integer':   return is_numeric($value)? (int)$value : ($value)? 1 : 0;
      case 'float':     return (float)$value;
      case 'datetime':  return self::string_to_time($value);
      case 'timestamp': return self::string_to_time($value);
      case 'date':      return self::string_to_time($value);
      case 'time':      return self::string_to_time($value);
      case 'boolean':   return self::value_to_boolean($value);
      default: return $value;
    }
  }

  private function get_limit() {
    if (preg_match('/\((.*)\)/', $this->native_type, $limit)) {
      return (int)$limit[1];
    }
  }

  private function convert_type($type) {
    switch(true) {
      case strrpos(strtolower($type), 'tinyint(1)') > -1:
        return 'boolean';
      case preg_match('/int/i', $type):
        return 'integer';
      case preg_match('/decimal|numeric|float|double/i', $type):
        return 'float';
      case preg_match('/datetime/i', $type):
        return 'datetime';
      case preg_match('/date/i', $type):
        return 'date';
      case preg_match('/timestamp/i', $type):
        return 'timestamp';
      case preg_match('/time/i', $type):
        return 'time';
      case preg_match('/text/i', $type):
        return 'text';
      case preg_match('/char/i', $type):
        return 'string';
      default:
        throw new ColumnTypeUnknown;
    }
  }

  private static function string_to_time($time) {
    try {
      return new \DateTime($time);
    } catch(\Exception $e) {
      return null;
    }
  }

  private static function value_to_boolean($value) {
    if (is_bool($value)) {
      return $value;
    }
    return !in_array(strtolower($value), ['false', 'f', '0']);
  }

  public function human_name() {
    if (!isset($this->human_name)) {
      $human_name = preg_replace('/([\\w])([A-Z])/', '$1 $2', $this->name); #space before all capital letters
      $human_name = preg_replace('/_/', ' ', $human_name); #replace underscores with spaces
      $human_name = strtolower($human_name); #un-camelizes name
      $human_name = ucfirst($human_name); #capitalizes first letter
      $this->human_name = $human_name;
    }
    return $this->human_name;
  }

}
