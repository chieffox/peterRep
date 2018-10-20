<?php
include_once 'config.php';
include_once 'common.php';

if(isset($_GET['act'])) $act = $_GET['act'];
  else $act = 'index';
if(isset($_GET['op'])) $op = $_GET['op'];
  else $op = 'indexOp';

$file = _APIURL.'/controller/'.$act.'.class.php';
unset($_GET['act']);
unset($_GET['op']);

if (file_exists($file)) {
  include_once $file;

  $obj_module = new $act();

  if (!method_exists($obj_module, $op)) {
      error("method doesn't exist!");
  } else {
    if (is_callable(array($obj_module, $op))) {             
      $obj_module -> $op();
    }
  }      
} else {
  echo $file;
  error("module doesn't exist!");
}