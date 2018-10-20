<?php
require_once "config.php";
require_once "common.php";

class DB {
  public $con;

  public function __construct(){
    $this->con = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DATABASE,DB_PORT);

    if(!$this->con){
      printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
      exit;
    }

    $this->con->query('set name utf8');
  }

  public function query($sql='',$params=array()){
    if(count($params)>0){
      foreach($params as $key=>$val){
        if(substr($key,0,1) == '@'){
          $sql = str_replace($key , DB_PREFIX.$val, $sql);
        }
        else $sql = str_replace($key , '"'.$val.'"' , $sql);
      }
    }
    //echo $sql;exit;
    $res = $this->con->query($sql);
    $list = array();
    if($res){
	    while($row = $res->fetch_assoc()){
        $list[]=$row;
      }
    }
    
    return $list;
    
  }

  public function insert($sql='',$params=array()){
    if(count($params)>0){
      foreach($params as $key=>$val){
        if(substr($key,0,1) == '@'){
          $sql = str_replace($key , DB_PREFIX.$val, $sql);
        }
        else $sql = str_replace($key , '"'.$val.'"' , $sql);
      }
    }
    //echo $sql;exit;
    $res = $this->con->query($sql);
    return mysqli_insert_id($this->con);
  }

  public function update($sql='',$params=array()){
    if(count($params)>0){
      foreach($params as $key=>$val){
        if(substr($key,0,1) == '@'){
          $sql = str_replace($key , DB_PREFIX.$val, $sql);
        }
        else $sql = str_replace($key , '"'.$val.'"' , $sql);
      }
    }
    //echo $sql;exit;
    $res = $this->con->query($sql);
    return $res;
  }

  public function delete($sql='',$params=array()){
    if(count($params)>0){
      foreach($params as $key=>$val){
        if(substr($key,0,1) == '@'){
          $sql = str_replace($key , DB_PREFIX.$val, $sql);
        }
        else $sql = str_replace($key , '"'.$val.'"' , $sql);
      }
    }
    //echo $sql;exit;
    $res = $this->con->query($sql);
    return $res;
  }

  public function transaction($sql = array()){
    if(empty($sql)){
      return false;
    }
    $mysqli->autocommit(false);

    for($i=0;$i<count($sql);$i++){
      $temp = $this->con->query($sql[$i]);
      if($temp){
        
      } else {
        $mysqli->rollback();
        return false;
      }
    }

    $mysqli->commit();
  }
  
}