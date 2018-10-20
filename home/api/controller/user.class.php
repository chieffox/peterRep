<?php

include_once _APIURL . '/core/db.php';
include_once _APIURL . '/core/config.php';
include_once _APIURL . '/core/common.php';
include_once _APIURL . '/core/wxBizDataCrypt.php';

class User {

  //登录
  public function login(){
    $code = isset($_GET['code']) ? $_GET['code'] : error('code is null');

    $url = 'https://api.weixin.qq.com/sns/jscode2session';
    $appid = APPID;
    $appsecret = APPSECRET;
    $type = 'authorization_code';
    $url .= '?appid='.$appid.'&secret='.$appsecret.'&js_code='.$code.'&grant_type='.$type;
    $curl_res = curl($url);
    
    $info = json_decode($curl_res,true);
    $openid = $info['openid'];
    if(empty($openid)){
      error('openid error');
    }
    //echo $openid; exit;
    $db = new DB();
    $res = $db->query('SELECT a.id AS uid,a.truename,a.nickname,a.avatar,a.mobile,a.card,a.classid,b.name AS classname,a.type,a.status,a.mail,a.address,a.receiver,a.receive_tel,a.receive_time,a.receive_location,a.receive_car,a.receive_remark,a.sender,a.send_tel,a.send_time,a.send_location,a.send_car,a.send_remark FROM @table1 AS a,@table2 AS b WHERE a.classid=b.id AND a.openid=:openid AND b.status=1',['@table1'=>'user','@table2'=>'tclass',':openid'=>$openid]);

    if($res){
      output($res[0]);
    } else {
      error($openid);
    }
  }


  //用户绑定
  public function bind(){
    $openid = isset($_GET['openid']) ? $_GET['openid'] : error('openid is null');
    $tel = isset($_GET['tel']) ? $_GET['tel'] : error('tel is null');
    $nickname = $_GET['nickname'];
    $avatar = $_GET['avatar'];
    //echo 'openid:'.$openid.'<br>'.'tel:'.$tel.'<br>'.'nickname:'.$nickname.'<br>'.'avatar:'.$avatar;exit;
    $db = new DB();
    $res = $db->query('SELECT a.id AS uid,a.truename,b.id AS classid,b.name AS classname,a.mobile,a.card,a.status,a.type,a.mail,a.address,a.receiver,a.receive_tel,a.receive_time,a.receive_location,a.receive_car,a.receive_remark,a.sender,a.send_tel,a.send_time,a.send_location,a.send_car,a.send_remark FROM @table1 AS a,@table2 AS b WHERE a.mobile=:tel AND a.classid=b.id AND b.status=1',['@table1'=>'user','@table2'=>'tclass',':tel'=>$tel]);

    if($res){
      //已经绑定过
      if($res[0]['status'] > 0){
        //error('请勿重复绑定');
        $binded = $db->query('SELECT a.id AS uid,a.truename,b.name AS classname,a.mobile,a.card,a.status,a.type,a.mail,a.address,a.openid,a.nickname,a.avatar,a.receiver,a.receive_tel,a.receive_time,a.receive_location,a.receive_car,a.receive_remark,a.sender,a.send_tel,a.send_time,a.send_location,a.send_car,a.send_remark FROM user a,tclass b WHERE id=:uid',[':uid'=>$res[0]['uid']]);
        output($binded);
      }
      if($res[0]['type'] == 1){
        //绑定--更新openid
        $update = $db->update('UPDATE @table SET openid=:openid,nickname=:nickname,avatar=:avatar,status=2,updateAt=:time WHERE id=:uid',['@table'=>'user',':openid'=>$openid,':nickname'=>$nickname,':avatar'=>$avatar,':time'=>time(),':uid'=>$res[0]['uid']]);
      } else if($res[0]['type'] == 2){
        //管理员模式
        $admin_update = $db->update('UPDATE @table SET openid=:openid,nickname=:nickname,avatar=:avatar,status=1,updateAt=:time WHERE id=:uid',['@table'=>'user',':openid'=>$openid,':nickname'=>$nickname,':avatar'=>$avatar,':time'=>time(),':uid'=>$res[0]['uid']]);
      }
      $userinfo = $res[0];
      $userinfo['openid'] = $openid;
      $userinfo['nickname'] = $nickname;
      $userinfo['avatar'] = $avatar;
      output($userinfo);
    } else {
      error('查无此人，请查证后重试');
    }
  }

  public function register(){
    
  }


  //扫码报到
  public function checkin(){
    if(!isset($_GET['scanFrom']) || $_GET['scanFrom'] !='JD_Online'){
      echo '请使用“嘉德教育Online”小程序扫描，您可以在微信中搜索“嘉德教育Online”小程序，或找管理员索要小程序码';
      exit;
    }
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid is null');

    $db = new DB();
    $res = $db->query('SELECT status FROM @table WHERE id=:uid',['@table'=>'user',':uid'=>$uid]);

    if($res){
      if($res[0]['status'] == 2){
        $update = $db->update('UPDATE @table SET status=1,updateAt=:time WHERE id=:uid',['@table'=>'user',':uid'=>$uid,':time'=>time()]);
        if($update){
          output('success');
        } else {
          error('check in failed');
        }
      } else {
        error('请先完成登录');
      }
    } else {
      error('查无此人，请查证后重试');
    }
  }

  public function updateUserInfo(){
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid is null');
    $card = $_GET['card'];
    $address = $_GET['address'];
    $mail = $_GET['mail'];

    $db = new DB();
    $res = $db->update('UPDATE @table SET card=:card,address=:address,mail=:mail WHERE id=:uid',['@table'=>'user',':card'=>$card,':address'=>$address,':mail'=>$mail,':uid'=>$uid]);
    if($res) output('update success');
    else error('update failed');
  }

  //=============================管理员用==================================

  public function getCheckinByClass(){
    $classid = isset($_GET['classid']) ? $_GET['classid'] : error('classid is null');
    $search = isset($_GET['search']) ? $_GET['search'] : 2;

    if($search == 2){
      $condition = '';
    } else if($search == 1) {
      $condition = ' AND a.status=1';
    } else if($search == 0){
      $condition = ' AND a.status!=1';
    }

    $db = new DB();
    $res = $db->query('SELECT a.id,a.truename,a.mobile,b.name AS classname,a.status FROM @table1 AS a RIGHT JOIN @table2 AS b ON a.classid=b.id WHERE b.id=:classid AND a.type=1' . $condition,['@table1'=>'user','@table2'=>'tclass',':classid'=>$classid]);

    if($res){
      $count = 0;
      foreach($res as $item){
        if($item['status'] == 1){
          $count ++;
        }
      }
      output(array('users'=>$res,'total'=>count($res),'checked'=>$count,'classname'=>$res[0]['classname']));
    } else {
      output(array('users'=>array(),'total'=>0,'checked'=>0,'classname'=>''));
    }
    
  }

  public function getUserInfo(){
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid is null');

    $db = new DB();
    $res = $db->query('SELECT id AS uid,truename,mobile,card,mail,address,status FROM @table WHERE id=:uid',['@table'=>'user',':uid'=>$uid]);
    if($res) output($res[0]);
    else error('查无此人');
  }

  public function checkinByAdmin(){
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid is null');

    $db = new DB();
    $res = $db->update('UPDATE @table SET status=1 WHERE id=:uid',['@table'=>'user',':uid'=>$uid]);
    if($res) output('success');
    else error('fail');
  }

  //批量导入学生名单
  public function importIntoUser($data,$classid){
    if(empty($data)){
      error('data is null');
    }

    array_splice($data, 0, 1);
    $sql = 'INSERT INTO user (classid,truename,gender,mobile,card,mail,address,type,createAt,hotel,hotelLocation,roomid,roomType,roomerNum,roomRemark,receiver,receive_tel,receive_time,receive_location,receive_car,receive_remark,sender,send_tel,send_time,send_location,send_car,send_remark) VALUES ';
    
    foreach($data as $user){
      $sql .= '('.$classid.',"'.$user[0][0].'","'.($user[0][2]=='女'?2:1).'","'.$user[0][1].'","'.$user[0][3].'","'.$user[0][4].'","'.$user[0][5].'",'.$user[0][6].','.time().',"'.$user[0][7].'","'.$user[0][8].'","'.$user[0][9].'","'.$user[0][10].'","'.$user[0][11].'","'.$user[0][12].'","'.$user[0][13].'","'.$user[0][14].'","'.$user[0][15].'","'.$user[0][16].'","'.$user[0][17].'","'.$user[0][18].'","'.$user[0][19].'","'.$user[0][20].'","'.$user[0][21].'","'.$user[0][22].'","'.$user[0][23].'","'.$user[0][24].'"),';
    }

    $sql = substr($sql, 0, strlen($sql) - 1) . ';';
    //echo $sql; exit;
    $db = new DB();
    $res = $db->insert($sql);
    if($res){
      output('生成班级成功，并导入学生名单成功！');
    }
    else{
      $db->delete('DELETE FROM tclass WHERE id='.$classid);
      $db->delete('DELETE FROM meal WHERE classid='.$classid);
      $db->delete('DELETE FROM sign WHERE classid='.$classid);
      error('更新用户表失败,请查证是否有重复手机号');
    }
  }

  function getDataCount(){
    $year = isset($_GET['year']) ? $_GET['year'] : error('year missed');
    $month = isset($_GET['month']) ? $_GET['month'] : error('month missed');

    if($year == '全部' && $month == '全部'){
      //历史全部
      $sql = 'SELECT count(id) AS count FROM user WHERE type=1 AND status=1 GROUP BY id';
    } else if($year != '全部' && $month == '全部' ){
      //全年
      $start = strtotime($year . '-1-1');
      $end = strtotime(intval($year+1). '-1-1');
      $sql = 'SELECT count(id) AS count FROM user WHERE type=1 AND status=1 AND createAt>'.$start.' AND createAt<'.$end;
    } else if($year != '全部' && $month != '全部'){
      $start = strtotime($year . '-' .$month. '-1');
      if($month == 12){
        $end = strtotime(intval($year+1). '-1-1');
      } else {
        $end = strtotime($year .'-'.intval($month+1).'-1');
      }
      $sql = 'SELECT count(id) AS count FROM user WHERE type=1 AND status=1 AND createAt>'.$start.' AND createAt<'.$end;
    }

    $db = new DB();
    $res = $db->query($sql);
    if($res) output($res);
    else error('error');
  }
}