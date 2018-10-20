<?php
if(!isset($_SESSION))
  session_start();

define('DB_HOST',           'localhost');
define('DB_USERNAME',       'root');
define('DB_PASSWORD',       'root');
define('DB_PORT',           '3306');
define('DB_DATABASE',       'test');
define('DB_PREFIX',         '');
define('DB_CHARSET',        'utf8');

//$config['system']['apiUrl']  = 'api';





define('_SERVERURL', '');
define('_APIURL', 'api');
define('_ASSETS', 'assets');

//小程序APPID / APPSECRET
define('APPID',                 'wx63243c9f16c0abbe');
define('APPSECRET',             '2a8b6597762aac1133da308f10301b48');

//公众号APPID / APPSECRET
define('UNION_APPID',           'wxd1d49ce6500e03e8');
define('UNION_APPSECRET',       '2092885ac22a7169f6f3ea3db2727a3e');

//商户号MCHID / MCHKEY
define('MCHID',                 '1480095002');
define('MCHKEY',                '123456789012345678901234567890aa');
