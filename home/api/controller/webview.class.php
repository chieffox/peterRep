<?php

include_once _APIURL . '/core/db.php';
include_once _APIURL . '/core/config.php';
include_once _APIURL . '/core/common.php';

class Webview {
  function index(){
    if(!empty($_GET['page'])){
      include('webview/'.$_GET['page'].'.html');
      exit;
    }
    include('webview/index.html');
  }
}