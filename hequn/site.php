<?phpdefined("IN_IA") or exit("Access Denied");class GTF_cybModuleSite extends WeModuleSite {  //   public function doMobileindex() {  //       global $_GPC, $_W;  //       $uniacid = $_W['uniacid'];			// $item = pdo_fetch("SELECT * FROM ".tablename('hequn_test_setting')." WHERE uniacid = :uniacid ", array(':uniacid' => $uniacid));				// $date = array();				// $date['uniacid'] = $uniacid;		// $date['openid'] = $_W['fans']['from_user'];		// $date['realname'] = $_W['fans']['nickname'];		// $date['touxiang'] = $_W['fans']['headimgurl'];		// $date['zc_time'] = time();						// $re = pdo_fetch("SELECT * FROM ".tablename('hequn_test_user')." WHERE openid = :openid and uniacid = :uniacid ", array(':openid' => $date['openid'],':uniacid' => $uniacid));				// if(empty($re)){		// 	 pdo_insert('hequn_test_user', $date);		// }				// if($_GPC['op'] == 'jieshu'){		// 	$jilu = pdo_fetch("SELECT * FROM ".tablename('hequn_test_rank')." WHERE khid = :khid and uniacid = :uniacid ", array(':khid' => $re['id'],':uniacid' => $uniacid));					// 	$da = array(		// 		'uniacid' => $uniacid,		// 		'khid' => $re['id'],		// 		'realname' => $re['realname'],		// 		'num' => $_GPC['num']		// 	);					// 	if($jilu){		// 		pdo_update('hequn_test_rank',$da, array('uniacid' => $uniacid,'khid'=>$re['id']));		// 	}else{		// 		pdo_insert('hequn_test_rank', $da);		// 	}		// }		  //       include $this->template('index');  //   }	public function doWebsetting() {        global $_GPC, $_W;        $uniacid = $_W['uniacid'];				$item = pdo_fetch("SELECT * FROM ".tablename('hequn_test_setting')." WHERE uniacid = :uniacid ", array(':uniacid' => $uniacid));				if (checksubmit('submit')){						$data = array(				'uniacid' => $uniacid,				'fxtitle' => $_GPC['title'],				'fxneirong' => $_GPC['content'],				'fxtupian' => $_GPC['thumb'],				'uniacqrcode' => $_GPC['uniacqrcode'],        'uniacname' => $_GPC['uniacname']			);						if($item){				pdo_update('hequn_test_setting',$data, array('uniacid' => $uniacid));			}else{				pdo_insert('hequn_test_setting', $data);			}		} 							        include $this->template('setting');    }			public function doWebyonghu() {        global $_GPC, $_W;        $uniacid = $_W['uniacid'];				$yonghu = pdo_fetchall("SELECT * FROM ".tablename('hequn_test_user')." WHERE uniacid = :uniacid ", array(':uniacid' => $uniacid));				if($_GPC['op'] == 'lahei'){			pdo_update('hequn_test_rank',array('lh'=>1),array('khid'=>$_GPC['id']));		}		        include $this->template('yonghu');    }		public function doWebpaihang() {        global $_GPC, $_W;        $uniacid = $_W['uniacid'];				$paihang = pdo_fetchall("SELECT * FROM ".tablename('hequn_test_rank')." WHERE uniacid = :uniacid ", array(':uniacid' => $uniacid));		        include $this->template('paihangbang');    }    public function doMobileindex(){    	global $_GPC, $_W;        $uniacid = $_W['uniacid'];                $mc = mc_oauth_userinfo();        if(!empty($mc['unionid'])){        	$fans = pdo_fetch('SELECT follow FROM ims_mc_mapping_fans WHERE uniacid='.$uniacid.' AND unionid="'.$mc['unionid'].'"');        } else {        	$fans = pdo_fetch('SELECT follow FROM ims_mc_mapping_fans WHERE uniacid='.$uniacid.' AND openid="'.$mc['openid'].'"');        }        // if($uniacid == 21){        // 	echo $fans['follow'];        // }        $res = pdo_fetch('SELECT * FROM ims_gtf_cyb_hequn_test WHERE uniacid='.$uniacid.' AND openid="'.$mc['openid'].'"');        if($res){        	if($res['subscribe'] != $fans['follow']){        		pdo_query('UPDATE ims_gtf_cyb_hequn_test SET subscribe='.$fans['follow'].' WHERE uniacid='.$uniacid.' AND openid="'.$mc['openid'].'"');        	}        } else {        	$sql = 'INSERT INTO ims_gtf_cyb_hequn_test VALUES ("", '.$uniacid.', "'.$mc['openid'].'", "'.$mc['unionid'].'", "'.$mc['avatar'].'", "'.$mc['nickname'].'", '.time().', 0, '.$fans['follow'].')';        	pdo_query($sql);        }        $assets = '/addons/gtf_cyb/template/mobile';    	include $this->template('index');    }  public function doMobileHougongzhuan(){    	global $_GPC, $_W;        $uniacid = $_W['uniacid'];                $mc = mc_oauth_userinfo();        if(!empty($mc['unionid'])){        	$fans = pdo_fetch('SELECT follow FROM ims_mc_mapping_fans WHERE uniacid='.$uniacid.' AND unionid="'.$mc['unionid'].'"');        } else {        	$fans = pdo_fetch('SELECT follow FROM ims_mc_mapping_fans WHERE uniacid='.$uniacid.' AND openid="'.$mc['openid'].'"');        }             	include $this->template('hougongzhuan');    }}