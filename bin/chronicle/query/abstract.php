<?php namespace Chronicle\Query;

abstract class AbstractQuery {

  abstract public function execute();
  abstract public function toSQL();


}
