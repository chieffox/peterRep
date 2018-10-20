<?php

include_once _APIURL . '/core/db.php';
include_once _APIURL . '/core/config.php';
include_once _APIURL . '/core/common.php';
include_once _APIURL . '/core/wxBizDataCrypt.php';

class Member {

  public function login(){
    $code = $_GET['code'];
    $encryptedData = $_GET['encryptedData'];
    $iv = $_GET['iv'];
    $pid = isset($_GET['pid']) ? $_GET['pid'] : 0;

    $url = 'https://api.weixin.qq.com/sns/jscode2session';
    $type = 'authorization_code';
    $scope = 'snsapi_userinfo';
    $url .= '?appid='.APPID.'&secret='.APPSECRET.'&js_code='.$code.'&grant_type='.$type.'scope='.$scope;
    $res = curl($url);
    
    $info = json_decode($res,true);
    $sessionkey = $info['session_key'];

    $pc = new WXBizDataCrypt(APPID, $sessionkey);
    $errCode = $pc->decryptData($encryptedData, $iv, $data );

    if($errCode == 0){
      $data = json_decode($data,true);
      $this->validateUser($data,$pid);
    }
    else{
      error($errCode);
    }
    //$uid = $this->register($info['openid'],$userinfo);
  }

  public function validateUser($data,$pid){
    $db = new DB();
    $res = $db->query('SELECT * FROM @table WHERE uniacid=13 AND unionid=:unionid',array('@table'=>'member',':unionid'=>$data['unionId']));

    if(empty($res)){
      $uid = $db->insert('INSERT INTO @table (uniacid, headimgurl, open_lite, unionid, nickname, pid, subscribe, status, createtime) VALUES (13,:avatarUrl,:openid,:unionid,:nickname,:pid,0,0,:time);',array('@table'=>'member',':avatarUrl'=>$data['avatarUrl'],':openid'=>$data['openId'],':unionid'=>$data['unionId'],':nickname'=>$data['nickName'],':pid'=>$pid,':time'=>time()));
      $data['uid'] = $uid;
      $data['limit_start'] = 0;
      $data['order'] = array();
      $data['subscribe'] = 0;
      $data['status'] = 0;
      $data['pid'] = $pid;
    } else {

      $order = $db->query('SELECT a.class_id FROM @table1 a,@table2 b WHERE a.openid=b.openid AND a.uniacid=13 AND a.status=1 AND b.id=:uid',array('@table1'=>'member_class','@table2'=>'member',':uid'=>$res[0]['id']));

      if($order){
        $course = array();
        foreach($order as $class){
          array_push($course,$class['class_id']);
        }
        $data['order']['course'] = $course;
      } else {
        $data['order']['course'] = array();
      }

      if(empty($res[0]['open_lite'])){
        $db->update('UPDATE @table SET open_lite=:openid WHERE uniacid=13 AND unionid=:unionid',array('@table'=>'member',':openid'=>$data['openId'],':unionid'=>$data['unionId']));
      }

      $data['uid'] = $res[0]['id'];
      $data['limit_start'] = $res[0]['limit_buy_start'];
    }
    $data['subscribe'] = $res[0]['subscribe'];
    $data['status'] = $res[0]['status'];
    $data['pid'] = $res[0]['pid'];
    $data['limit_expired'] = LIMIT_EXPIRED;
    output($data);
  }

  public function checkLimitBuy(){
    if(!isset($_GET['unionid'])){
      error('非法参数');
    }
    $unionid = $_GET['unionid'];

    $db = new DB();
    $res = $db->query('SELECT limit_buy_start FROM @table WHERE unionid=:unionid',array('@table'=>'member',':unionid'=>$unionid));
    if($res){
      if($res[0]['limit_buy_start']){
        $rest = LIMIT_EXPIRED - (time() - $res[0]['limit_buy_start']);
        if($rest >= LIMIT_EXPIRED){
          output(0);
        } else {
          output($rest);
        }
      } else {
        $db->update('UPDATE @table SET limit_buy_start=:start WHERE unionid=:unionid',array('@table'=>'member',':unionid'=>$unionid,':start'=>time()));
        output(LIMIT_EXPIRED);
      }
    } else {
      error('unionid error');
    }
  }

  function userLogin(){
    $userinfo = isset($_GET['userinfo']) ? $_GET['userinfo'] : error('用户信息为空');
    $pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
    $free_course = isset($_GET['free_course']) ? $_GET['free_course'] : 0;
    $userinfo = json_decode($userinfo, true);
    //output($free_course);
    $db = new DB();
    $res = $db->query('SELECT * FROM @table WHERE uniacid=13 AND unionid=:unionid',array('@table'=>'member',':unionid'=>$userinfo['unionid']));

    if(empty($res)){
      $uid = $db->insert('INSERT INTO @table (uniacid, headimgurl, openid, unionid, nickname, subscribe, status, createtime, pid) VALUES (13,:avatarUrl,:openid,:unionid,:nickname,:subscribe,0,:time,:pid);',array('@table'=>'member',':avatarUrl'=>$userinfo['headimgurl'],':openid'=>$userinfo['openid'],':unionid'=>$userinfo['unionid'],':nickname'=>$userinfo['nickname'],':subscribe'=>$userinfo['subscribe'],':time'=>time(),':pid'=>$pid));

      if($free_course > 0){
        //帮好友开通免费通道
        $free_id = $db->insert('INSERT INTO @table (creator,course_id,inviter,inviter_nickname,inviter_avatar,createAt) VALUES (:creator,:courseid,:inviter,:inviter_nickname,:inviter_avatar,:time)',array('@table'=>'free_channel',':creator'=>$pid,':courseid'=>$free_course,':inviter_nickname'=>$userinfo['nickname'],':inviter_avatar'=>$userinfo['headimgurl'],':inviter'=>$userinfo['unionid'],':time'=>time()));
        if(!$free_id) echo 'free_channel fail';
      }

      if($uid>0) echo 'success';
      else echo 'insert fail';

    }else {
     $update = $db->update('UPDATE @table SET subscribe=:subscribe WHERE unionid=:unionid',array('@table'=>'member',':subscribe'=>$userinfo['subscribe'],':unionid'=>$userinfo['unionid']));
      
     if($update) echo 'success';
     else echo 'update fail';
    }
  }


  function getMemberInfo(){
    $unionid = isset($_GET['unionid']) ? $_GET['unionid'] : error('unionid null');

    $db = new DB();
    $res = $db->query('SELECT id AS uid,nickname,headimgurl,limit_buy_start AS limit_start,subscribe,unionid,openid,pid,is_commission FROM @table WHERE uniacid=13 AND unionid=:unionid',array('@table'=>'member',':unionid'=>$unionid));

    $data = $res[0];

    $order = $db->query('SELECT ordertype,courseid FROM @table WHERE unionid=:unionid AND status=1 AND (end_time>:time OR end_time=0)',array('@table'=>'order',':unionid'=>$unionid,':time'=>time()));
    if($order){
        $course = array();
        foreach($order as $buy){
          if($buy['ordertype'] == 1){
            $data['order']['is_buy_all'] = 1;
            break;
          } else {
            array_push($course, $buy['courseid']);
          }
        }
        $data['order']['course'] = $course;
      } else {
        $data['order'] = array();
      }
    
    $data['limit_expired'] = LIMIT_EXPIRED;
    output($data);
  }

  function getLiteOpenid(){
    $code = $_GET['code'];
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.APPID.'&secret='.APPSECRET.'&js_code='.$code.'&grant_type=authorization_code';
    $res = curl($url);
    $res = json_decode($res, true);
    output($res);
  }

  function startCommission(){
    $unionid = isset($_GET['unionid']) ? $_GET['unionid'] : error('unionid null');

    $db= new DB();
    $res = $db->update('UPDATE @table SET is_commission=1 WHERE unionid=:unionid AND uniacid=13',array('@table'=>'member',':unionid'=>$unionid));
    if($res) output('success');
    else error('fail');
  }

  function clearExpiredOrder(){
    $unionid = $_GET['unionid'];

    $db = new DB();
    //$res = $db->delete('DELETE FROM @table WHERE fee=0 AND trade_type="free_channel" AND end_time>0 AND end_time<:time AND unionid=:unionid',array('@table'=>'order',':time'=>time(),':unionid'=>$unionid));
    $res = $db->update('UPDATE @table SET status=2 WHERE fee=0 AND trade_type="free_channel" AND end_time>0 AND end_time<:time AND unionid=:unionid',array('@table'=>'order',':time'=>time(),':unionid'=>$unionid));
    if($res){
      output('success');
    } else {
      error('fail');
    }

  }

  function startLimitBuy(){
    $unionid = isset($_GET['unionid']) ? $_GET['unionid'] : error('unionid null');
    $db = new DB();
    $res = $db->update('UPDATE @table SET limit_buy_start=:time WHERE unionid=:unionid',array('@table'=>'member',':time'=>time(),':unionid'=>$unionid));
    if($res) output('success');
    else error('fail');
  }

  function getCommission(){
    $unionid = isset($_GET['unionid']) ? $_GET['unionid'] : error('unionid null');
    $db = new DB();
    $res = $db->query('SELECT id,tx_amount FROM @table WHERE unionid=:unionid',array('@table'=>'member',':unionid'=>$unionid));
    $team = $db->query('SELECT a.remark,a.money,a.createtime,b.headimgurl,b.nickname FROM @table1 AS a,@table2 AS b WHERE a.fromid=b.id AND a.member_id=:uid',array('@table1'=>'income_log','@table2'=>'member',':uid'=>$res[0]['id']));

    $total = $res[0]['tx_amount'];
    $total_today = 0;
    $data = array();
    $start = strtotime('today');

    if($team){
      for($i=0;$i<count($team);$i++){
        if($team[$i]['createtime'] > $start){
          $total_today += $item['money'];
        }
        $team[$i]['createtime'] = date('Y-m-d',$team[$i]['createtime']);
      }
    }
    

    $data['total'] = $total;
    $data['total_today'] = $total_today;
    $data['list'] = $team;
    
    output($data);
  }

  function reloadMemberInfo(){
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid null');
    
    $data = array();

    $db = new DB();
    $res = $db->query('SELECT status FROM @table WHERE id=:uid',['@table'=>'member',':uid'=>$uid]);

    $data['status'] = $res[0]['status'];

    $order = $db->query('SELECT a.class_id FROM @table1 a,@table2 b WHERE a.openid=b.openid AND a.uniacid=13 AND a.status=1 AND b.id=:uid',array('@table1'=>'member_class','@table2'=>'member',':uid'=>$uid));

    if($order){
      $course = array();
      foreach($order as $class){
        array_push($course,$class['class_id']);
      }
      $data['course'] = $course;
    } else {
      $data['course'] = array();
    }
    
    output($data);
  }

  function getTeamByUid(){
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid null');

    $db = new DB();
    $res = $db->query('SELECT a.id AS uid,a.headimgurl,a.nickname,a.createtime,sum(b.fee) AS total_fee FROM @table1 AS a JOIN @table2 AS b ON a.id=b.member_id WHERE a.uniacid=13 AND a.pid=:uid GROUP BY b.member_id',array('@table1'=>'member','@table2'=>'pay',':uid'=>$uid));

    if($res){
      for($i=0;$i<count($res);$i++){
        $res[$i]['createtime'] = date('Y-m-d',$res[$i]['createtime']);
      }
    }
    
    output($res);
  }

  function getBillboard(){
    $uid = isset($_GET['uid']) ? $_GET['uid'] : error('uid null');
    $type = isset($_GET['type']) ? $_GET['type'] : error('type null');
    $start = strtotime('this week');
    $db = new DB();

    if($type == 1){
      $sql = 'SELECT a.pid AS user_id,COUNT(a.pid) AS total_fans,b.* FROM @table1 AS a join @table2 AS b ON a.pid=b.id WHERE a.uniacid=13 and a.pid>0 and a.createtime>=:start GROUP BY a.pid ORDER BY total_fans DESC';
    } else {
      $sql = 'SELECT a.pid AS user_id,COUNT(a.pid) AS total_fans,b.* FROM @table1 AS a join @table2 AS b ON a.pid=b.id WHERE a.uniacid=13 and a.pid>0 GROUP BY a.pid ORDER BY total_fans DESC';
    }
    $res = $db->query($sql,['@table1'=>'member','@table2'=>'member',':start'=>$start]);

    if($res){
      for($i=0;$i<count($res);$i++){
        $res[$i]['createtime'] = date('Y-m-d',$res[$i]['createtime']);
      }
    }
    output($res);
  }

  function tx(){
    //echo json_encode($_GET);exit;
    $unionid = !empty($_GET['unionid']) ? $_GET['unionid'] : error('unionid null');

    $db = new DB();
    $member = $db->query('SELECT * FROM @table WHERE uniacid=13 AND unionid=:unionid',['@table'=>'member',':unionid'=>$unionid]);
    
    $user = $member[0];

    if (date('G') < 8) {
        error('每天24点至次日8点期间暂停转账');
    }
    
    $money = $user['tx_amount'];
    
    if (empty($user['subscribe'])) {
        error('请先关注公众号');
    }
  
    if ($money < 1) {
        error('需要满1元才可以提现转微信零钱包，累积1元后提现。继续加油！好运！');
    }
    
    // 获取1分钟内提现的次数(避免时间误差，此处限值到55秒)
    $total_cnt = $db->query("select COUNT(id) as count from @table where uniacid=13 AND createtime>:createtime ", array('@table' => 'tx',':createtime' => (time() - 55)));
    if ($total_cnt[0]['count'] > 100) {
        echo json_encode($total_cnt[0]['count']);
        error('当前忙，请稍后再试');
    }
    $user_cnt = $db->query("select COUNT(id) as count from @table where uniacid=13 AND openid=:openid and createtime>:createtime ", array(
        '@table' => 'tx',
        ':openid' => $user['openid'],
        ':createtime' => (time() - 1800)
    ));
    
    if ($user_cnt[0]['count'] >= 1) {
        error('提现频率太高，休息一个小时在来操作吧。');
    }
    
    // 如果余额大于200元，则只转200元
    if ($money > 200) {
        $money = 200;
    }
    
    $tx_id = $db->insert('INSERT INTO @table (uniacid,mid,openid,nickname,headimgurl,money,money_before,money_after,status,createtime,updatetime,tx_time) VALUES (:uniacid,:mid,:openid,:nickname,:headimgurl,:money,:money_before,:money_after,:status,:time,:time,:time)', array(
        '@table' => 'tx',
        ':uniacid' => 13,
        ':mid' => $user['id'],
        ':openid' => $user['openid'],
        ':nickname' => $user['nickname'],
        ':headimgurl' => $user['headimgurl'],
        ':money_before' => $user['tx_amount'],
        ':money_after' => $user['tx_amount'] - $money,
        ':money' => $money,
        ':status' => 0,
        ':time' => time()
    ));

    if (empty($tx_id)) {
        error('操作失败，请重试');
    }

    $db->update('UPDATE @table SET tx_amount=tx_amount-:money,no_account_amount=no_account_amount+:money where id=:id', array('@table'=>'member',':id' => $user['id'],':money' => $money));
    output('你的提现已经在审核了，请耐心等待');
  }
}