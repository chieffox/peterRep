<?php

include_once _APIURL . '/core/db.php';
include_once _APIURL . '/core/config.php';
include_once _APIURL . '/core/common.php';
include_once _APIURL . '/core/wxBizDataCrypt.php';

class Index {
	function indexOp(){
		include '/view/html/index.html';
	}
}