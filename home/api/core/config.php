<?php
if(!isset($_SESSION))
  session_start();

define('DB_HOST',           '127.0.0.1');
define('DB_USERNAME',       'root');
define('DB_PASSWORD',       'root');
define('DB_PORT',           '3306');
define('DB_DATABASE',       'jd_cms');
define('DB_PREFIX',         '');
define('DB_CHARSET',        'utf8');

//$config['system']['apiUrl']  = 'api';

define('_APIURL', 'api');
define('_ASSETS', 'assets');

define('APPID',                 'wx3fa4d5b9898f3862');
define('APPSECRET',             '2fbad1dc9bca222b8fb84a7fb55b9dab');