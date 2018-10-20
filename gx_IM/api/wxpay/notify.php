<?php
include_once '../core/db.php';
include_once '../core/config.php';
// require_once ('WxPay.Api.php');
// require_once ('WxPay.Notify.php');

// class PayNotifyCallBack extends WxPayNotify{
//     //查询订单
//     public function Queryorder($transaction_id){
//         $input = new WxPayOrderQuery();
//         $input->SetTransaction_id($transaction_id);
//         $result = WxPayApi::orderQuery($input);
//         if(array_key_exists("return_code", $result)
//             && array_key_exists("result_code", $result)
//             && $result["return_code"] == "SUCCESS"
//             && $result["result_code"] == "SUCCESS")
//         {
//             return true;
//         }
//         return false;
//     }
 
//     //重写回调处理函数
//     public function NotifyProcess($data, &$msg){
//         $notfiyOutput = array();
 
//         if(!array_key_exists("transaction_id", $data)){
//             $msg = "输入参数不正确";
//             return false;
//         }
//         //查询订单，判断订单真实性
//         if(!$this->Queryorder($data["transaction_id"])){
//             $msg = "订单查询失败";
//             return false;
//         }
//         return true;
//     }
// }







// $notify = new PayNotifyCallBack();
// $notify->Handle(false);


// $data = $notify->returnData();

$xml = $_REQUEST;
if(empty($xml)){
    $xml = file_get_contents("php://input");
}
if(empty($xml)){
    $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
}
if(empty($xml)){
    echo 'nodata';exit;
}
libxml_disable_entity_loader(true);
$data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);


if(isset($data['result_code'])){
    if($data['result_code'] == 'SUCCESS'){
      $status = 1;
    }
    else{
      $status = 0;
    }
} else {
    $status = 2;
}

$params = explode('&', $data['attach']);
$unionid = $params[0];
$ordertype = $params[1];
$courseid = $params[2];
$pid = $params[3];

$class_id = 0;
$class_name = '全部订阅';
if($ordertype == 2){
    $class_id = $courseid;
    $class_name = '课程';
}

$db = new DB();
//$order_id = $db->insert('INSERT INTO @table (order_sn,wxpay_sn,openid,unionid,fee,trade_type,bank_type,trade_time,status,ordertype,courseid) VALUES (:order_sn,:wxpay_sn,:openid,:unionid,:fee,:trade_type,:bank_type,:trade_time,:status,:ordertype,:courseid)',array('@table'=>'order',':order_sn'=>$data['out_trade_no'],':wxpay_sn'=>$data['transaction_id'],':openid'=>$data['openid'],':unionid'=>$unionid,':fee'=>$data['total_fee'],':trade_type'=>$data['trade_type'],':bank_type'=>$data['bank_type'],':trade_time'=>$data['time_end'],':status'=>$status,':ordertype'=>$ordertype,':courseid'=>$courseid));


$user = $db->query('SELECT id,openid,nickname,headimgurl,pid FROM @table WHERE unionid=:unionid AND uniacid=13',array('@table'=>'member',':unionid'=>$unionid));
$db->insert('INSERT INTO @table (uniacid,member_id,openid,headimgurl,nickname,fee,ordersn,wx_ordersn,is_pay,createtime,class_id,class_name) VALUES (13,:uid,:openid,:headimgurl,:nickname,:fee,:ordersn,:wx_ordersn,:status,:createtime,:class_id,:class_name)',array('@table'=>'pay',':uid'=>$user[0]['id'],':openid'=>$user[0]['openid'],':headimgurl'=>$user[0]['headimgurl'],':nickname'=>$user[0]['nickname'],':fee'=>$data['total_fee']/100,':ordersn'=>$data['out_trade_no'],':wx_ordersn'=>$data['transaction_id'],':status'=>$status,':createtime'=>time(),':class_id'=>$class_id,':class_name'=>$class_name));

if($ordertype == 1){
    $db->update('UPDATE @table SET status=1 WHERE unionid=:unionid AND uniacid=13',array('@table'=>'member',':unionid'=>$unionid));
} else {
    $db->insert('INSERT INTO @table (uniacid,headimgurl,openid,nickname,class_id,class_name,status,createtime) VALUES (13,:avatar,:openid,:nickname,:class_id,:class_name,1,:time)',['@table'=>'member_class',':avatar'=>$user[0]['headimgurl'],':openid'=>$user[0]['openid'],':nickname'=>$user[0]['nickname'],':class_id'=>$class_id,':class_name'=>$class_name,':time'=>time()]);
}

if($user[0]['pid'] > 0){
    
    //$db->insert('INSERT INTO @table (nickname,unionid,avatar,from_order_id,amount,createAt) VALUES (:nickname,:unionid,:avatar,:from_order_id,:amount,:time)',array('@table'=>'commission',':nickname'=>$user[0]['nickname'],':unionid'=>$pid,':avatar'=>$user[0]['headimgurl'],':from_order_id'=>$order_id,':amount'=>COMMISSION_RATE*$data['total_fee'],':time'=>time()));
    $ppp = $db->query('SELECT id,openid,nickname,headimgurl FROM @table WHERE id=:pid AND uniacid=13',array('@table'=>'member',':pid'=>$user[0]['pid']));
    $db->insert('INSERT INTO @table (uniacid,member_id,openid,headimgurl,nickname,remark,money,createtime) VALUES (13,:uid,:openid,:avatar,:nickname,:remark,:money,:createtime)',array('@table'=>'income_log',':uid'=>$ppp[0]['id'],':openid'=>$ppp[0]['openid'],':avatar'=>$ppp[0]['headimgurl'],':nickname'=>$ppp[0]['nickname'],':remark'=>'分销',':money'=>COMMISSION_RATE*$data['total_fee']/100,':createtime'=>time()));
}

echo 'SUCCESS';