<?php
$week_cn = ['日','一','二','三','四','五','六'];

function output($data){
  echo json_encode(['code'=>200,'data'=>$data]);
  exit;
}
function error($msg){
  echo json_encode(['code'=>400,'error'=>$msg]);
  exit;
}
function encrypt($input){
  $hash = md5($input);
  return password_hash($hash,PASSWORD_DEFAULT);
}

function decrypt($input,$password){
  return password_verify(md5($input),$password);
}

function curl($url,$post=''){
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
  if($post) {
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
  }
  curl_setopt($curl, CURLOPT_HEADER, 0);
  curl_setopt($curl, CURLOPT_TIMEOUT, 10);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

  $data = curl_exec($curl);
  if (curl_errno($curl)) {
      return curl_error($curl);
  }
  curl_close($curl);
  return $data;
}

function getNowTime(){
  return date('Y-m-d H:i:s',time());
}

function getNowDate(){
  return date('Y-m-d',time());
}

//生成签到二维码
function createQrcode($url,$name){
  if(!isset($url)) error('url is null');
  if(!isset($name)) error('name is null');

  require_once _APIURL . '/core/phpqrcode.php';

  $value = $url;          //二维码内容  
  $errorCorrectionLevel = 'H';  //容错级别  
  $matrixPointSize = 6;     //生成图片大小  
  //生成二维码图片
  $filename =  _ASSETS . '/QrCode/'.$name.'_'.time().'.png';
  QRcode::png($value, $filename , $errorCorrectionLevel, $matrixPointSize, 2);  
  
  $logo = _ASSETS . '/images/logo.png';  //准备好的logo图片   
  $QR = $filename;      //已经生成的原始二维码图  
 
  if (file_exists($logo)) {
    $QR = imagecreatefromstring(file_get_contents($QR));      //目标图象连接资源。
    $logo = imagecreatefromstring(file_get_contents($logo));    //源图象连接资源。
    $QR_width = imagesx($QR);     //二维码图片宽度   
    $QR_height = imagesy($QR);      //二维码图片高度   
    $logo_width = imagesx($logo);   //logo图片宽度   
    $logo_height = imagesy($logo);    //logo图片高度   
    $logo_qr_width = $QR_width / 4;     //组合之后logo的宽度(占二维码的1/5)
    $scale = $logo_width/$logo_qr_width;    //logo的宽度缩放比(本身宽度/组合后的宽度)
    $logo_qr_height = $logo_height/$scale;  //组合之后logo的高度
    $from_width = ($QR_width - $logo_qr_width) / 2;   //组合之后logo左上角所在坐标点
    
    //重新组合图片并调整大小
    /*
     *  imagecopyresampled() 将一幅图像(源图象)中的一块正方形区域拷贝到另一个图像中
     */
    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height); 
  }   
  
  //输出图片
  $final = _ASSETS . '/QrCode/'.$name.'_'.time().'.png';
  imagepng($QR, $final);
  //unlink($filename);
  //return '<img src="qrcode.png" alt="使用微信扫描支付">';
  return $final;
}