<?php namespace Chronicle;

trait Attribute {

  private $attributes = [];

  public function assign_attributes($new_attributes) {
    foreach($new_attributes as $new_attr => $new_value) {
      $this->write_attribute($new_attr, $new_value);
    }
  }

  public function is_attribute($attribute) {
    return array_key_exists($attribute, $this->attributes);
  }

  public function read_attribute($attribute) {
    if ($this->is_attribute($attribute)) {
      return $this->attributes[$attribute];
    }
  }

  public function write_attribute($attribute, $value) {
    if (self::is_attribute($attribute)) {
      $this->attributes[$attribute] = $value;
    }
  }

  public function attributes() {
    return $this->attributes;
  }

}
