<?php
if(!isset($_SESSION)) session_start();

require 'ValidateCode.class.php';  //�Ȱ������������ʵ��·������ʵ����������޸ġ�
$_vc = new ValidateCode();		//ʵ����һ������
$_vc->doimg();
$_SESSION['captcha'] = $_vc->getCode();//��֤�뱣�浽SESSION��
?>