<?php namespace Chronicle\Connection;

trait DatabaseStatements {

  public abstract function table_exists();
  
  public abstract function columns();

  public abstract function select_all();
  public abstract function select_one();

  public abstract function execute($sql);

}
