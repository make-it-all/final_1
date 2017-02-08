<?php namespace Chronicle;

trait Persistence {

  public function is_new_record(){
    return $this->new_record;
  }

  public function is_destroyed() {
      return $this->destroyed;
  }

  public function is_persisted() {
    return !($this->is_new_record() || $this->is_destroyed());
  }

}
