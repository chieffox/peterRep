<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 18:46
 */
defined('IN_IA') or exit('Access Denied');
//http://prox.we7.com/app/index.php?c=entry&a=wxapp&m=ewei_shopping&do=list
class Ewei_shoppingModuleWxapp extends WeModuleWxapp {
	public function doPageList() {
		$s = tomedia('l/l');

		echo $s;die;
	}
}