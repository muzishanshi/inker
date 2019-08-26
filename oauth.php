<?php
include_once( 'libs/saetv2.ex.class.php' );
date_default_timezone_set('Asia/Shanghai');

$action = isset($_GET['action']) ? addslashes(trim($_GET['action'])) : '';
if($action=="weibocallback"){
	$o = new SaeTOAuthV2( $this->options->wb_akey , $this->options->wb_skey );

	if (isset($_REQUEST['code'])) {
		$keys = array();
		$keys['code'] = $_REQUEST['code'];
		$keys['redirect_uri'] = $this->options->wb_callback_url;
		try {
			$token = $o->getAccessToken( 'code', $keys ) ;
		} catch (OAuthException $e) {
		}
	}

	if (isset($token)) {
		setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
		//获得用户信息
		$c = new SaeTClientV2( $this->options->wb_akey , $this->options->wb_skey , $token['access_token'] );
		$ms  = $c->home_timeline(); // done
		$uid_get = $c->get_uid();
		$oauthid = $uid_get['uid'];
		$user_message = $c->show_user_by_id( $oauthid);//根据ID获取用户等基本信息
		$weibo_id=$user_message["id"];
		$name=$user_message["name"];
		$gender=$user_message["gender"];
		$figureurl=$user_message["profile_image_url"];
		$weibo_url="http://weibo.com/".$user_message["profile_url"];
		$weibo_description=$user_message["description"];
	} else {
		die("授权失败");
	}
	$oauthQuery= $this->db->select()->from('table.multi_oauthlogin')->where('oauthid = ?', $oauthid);
	$oauthUser = $this->db->fetchRow($oauthQuery);
	if($oauthUser){
		//微博登录
		/** 如果已经登录 */
		if ($this->user->hasLogin()) {
			/** 直接返回 */
			$this->response->redirect($this->options->index);
		}
		$query= $this->db->select()->from('table.users')->where('uid = ?', $oauthUser['oauthuid']);
		$user = $this->db->fetchRow($query);
		$authCode = function_exists('openssl_random_pseudo_bytes') ?
			bin2hex(openssl_random_pseudo_bytes(16)) : sha1(Typecho_Common::randString(20));
		$user['authCode'] = $authCode;

		Typecho_Cookie::set('__typecho_uid', $user['uid'], 0);
		Typecho_Cookie::set('__typecho_authCode', Typecho_Common::hash($authCode), 0);

		/*更新最后登录时间以及验证码*/
		$this->db->query($this->db
		->update('table.users')
		->expression('logged', 'activated')
		->rows(array('authCode' => $authCode))
		->where('uid = ?', $user['uid']));
		
		/*压入数据*/
		$this->push($user);
		$this->_user = $user;
		$this->_hasLogin = true;
		$this->pluginHandle()->loginSucceed($this, $user["name"], '', false);
		
		/*跳转验证后地址*/
		$this->response->redirect($this->options->index);
	}else{
		//微博注册
		/** 如果已经登录 */
		if ($this->user->hasLogin() || !$this->options->allowRegister) {
			/** 直接返回 */
			$this->response->redirect($this->options->index);
		}
		$hasher = new PasswordHash(8, true);
		$generatedPassword = Typecho_Common::randString(7);
		
		$nickname=$name;
		$queryName= $this->db->select()->from('table.users')->where('name = ?', $nickname)->orWhere('screenName = ?', $nickname);
		$rowName = $this->db->fetchRow($queryName);
		if($rowName){
			for($i=1;;$i++){
				$nickname=$name.$i;
				$queryName= $this->db->select()->from('table.users')->where('name = ?', $nickname)->orWhere('screenName = ?', $nickname);
				$rowName = $this->db->fetchRow($queryName);
				if(count($rowName)==0){
					break;
				}
			}
		}

		$mail=$nickname.'@'.$_SERVER['SERVER_NAME'];
		$dataStruct = array(
			'name'      =>  $nickname,
			'mail'      =>  $mail,
			'screenName'=>  $nickname,
			'password'  =>  $hasher->HashPassword($generatedPassword),
			'created'   =>  time(),
			'group'     =>  'subscriber'
		);
		
		$insert = $this->db->insert('table.users')->rows($dataStruct);
		$userId = $this->db->query($insert);
		
		$dataOAuth = array(
			'oauthid'      =>  $oauthid,
			'oauthuid'      =>  $userId,
			'oauthnickname'=>  $nickname,
			'oauthfigureurl'  =>  $figureurl,
			'oauthgender'   =>  $gender,
			'oauthtype'     =>  'weibo'
		);
		
		$insert = $this->db->insert('table.multi_oauthlogin')->rows($dataOAuth);
		$insertId = $this->db->query($insert);

		$this->pluginHandle()->finishRegister($this);

		$this->user->login($nickname, $generatedPassword);

		Typecho_Cookie::delete('__typecho_first_run');
		
		$this->response->redirect($this->options->index);
	}
}else if($action=="qqcallback"){
	session_start();
	$code = isset($_GET['code']) ? addslashes(trim($_GET['code'])) : '';
	$state = isset($_GET['state']) ? addslashes(trim($_GET['state'])) : '';
	if($code!=''&&$state!=''){
		$theme = new themeOptions;
		$themeOptions=$theme->getThemeOptions();
		if(!$state || $state != $_SESSION["qqstate"]){
			die('30001');
		}
		$tokenData=findQQAccessToken($themeOptions['qq_appid'],$themeOptions['qq_appkey'],$themeOptions['qq_callback'],$_GET['code']);
		$qqUserData=findQQOpenID($tokenData['access_token']);
		$oauthid=$qqUserData->openid;
		$userinfo=findQQUserInfo($tokenData['access_token'],$themeOptions['qq_appid'],$oauthid);
		
		$name=$userinfo['nickname'];
		$gender=$userinfo['gender'];
		$figureurl=$userinfo['figureurl_qq_2'];
		$oauthQuery= $this->db->select()->from('table.multi_oauthlogin')->where('oauthid = ?', $oauthid);
		$oauthUser = $this->db->fetchRow($oauthQuery);
		if($oauthUser){
			/*登录*/
			/** 如果已经登录 */
			if ($this->user->hasLogin()) {
				/** 直接返回 */
				$this->response->redirect($this->options->index);
			}
			$query= $this->db->select()->from('table.users')->where('uid = ?', $oauthUser['oauthuid']);
			$user = $this->db->fetchRow($query);
			$authCode = function_exists('openssl_random_pseudo_bytes') ?
				bin2hex(openssl_random_pseudo_bytes(16)) : sha1(Typecho_Common::randString(20));
			$user['authCode'] = $authCode;

			Typecho_Cookie::set('__typecho_uid', $user['uid'], 0);
			Typecho_Cookie::set('__typecho_authCode', Typecho_Common::hash($authCode), 0);

			/*更新最后登录时间以及验证码*/
			$this->db->query($this->db
			->update('table.users')
			->expression('logged', 'activated')
			->rows(array('authCode' => $authCode))
			->where('uid = ?', $user['uid']));
			
			/*压入数据*/
			$this->push($user);
			$this->_user = $user;
			$this->_hasLogin = true;
			$this->pluginHandle()->loginSucceed($this, $user["name"], '', false);
			
			/*跳转验证后地址*/
			$this->response->redirect($this->options->index);
		}else{
			/*注册*/
			/** 如果已经登录 */
			if ($this->user->hasLogin() || !$this->options->allowRegister) {
				/** 直接返回 */
				$this->response->redirect($this->options->index);
			}
			$hasher = new PasswordHash(8, true);
			$generatedPassword = Typecho_Common::randString(7);
			
			$nickname=$name;
			$queryName= $this->db->select()->from('table.users')->where('name = ?', $nickname)->orWhere('screenName = ?', $nickname);
			$rowName = $this->db->fetchRow($queryName);
			if($rowName){
				for($i=1;;$i++){
					$nickname=$name.$i;
					$queryName= $this->db->select()->from('table.users')->where('name = ?', $nickname)->orWhere('screenName = ?', $nickname);
					$rowName = $this->db->fetchRow($queryName);
					if(count($rowName)==0){
						break;
					}
				}
			}

			$mail=$nickname.'@'.$_SERVER['SERVER_NAME'];
			$dataStruct = array(
				'name'      =>  $nickname,
				'mail'      =>  $mail,
				'screenName'=>  $nickname,
				'password'  =>  $hasher->HashPassword($generatedPassword),
				'created'   =>  time(),
				'group'     =>  'subscriber'
			);
			
			$insert = $this->db->insert('table.users')->rows($dataStruct);
			$userId = $this->db->query($insert);
			
			$dataOAuth = array(
				'oauthid'      =>  $oauthid,
				'oauthuid'      =>  $userId,
				'oauthnickname'=>  $nickname,
				'oauthfigureurl'  =>  $figureurl,
				'oauthgender'   =>  $gender,
				'oauthtype'     =>  'qq'
			);
			
			$insert = $this->db->insert('table.multi_oauthlogin')->rows($dataOAuth);
			$insertId = $this->db->query($insert);

			$this->pluginHandle()->finishRegister($this);

			$this->user->login($nickname, $generatedPassword);

			Typecho_Cookie::delete('__typecho_first_run');
			
			$this->response->redirect($this->options->index);
		}
	}
}
?>