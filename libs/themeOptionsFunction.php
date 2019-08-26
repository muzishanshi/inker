<?php
/**
 * 主题设置
 */
function themeConfig($form) {
	$options=Typecho_Widget::widget('Widget_Options');
    $tools = new themeOptions;
	
	echo "<style>
	body{background-color:#F5F5F5}@media screen and (min-device-width:1024px){::-webkit-scrollbar-track{background-color:rgba(255,255,255,0)}::-webkit-scrollbar{width:6px;background-color:rgba(255,255,255,0)}::-webkit-scrollbar-thumb{border-radius:3px;background-color:rgba(193,193,193,1)}}.typecho-head-nav{}#typecho-nav-list .focus .parent a,#typecho-nav-list .parent a:hover,#typecho-nav-list .root:hover .parent a{background:RGBA(255,255,255,0);}#typecho-nav-list{display:block}.typecho-head-nav .operate a{border:0;color:rgba(255,255,255,.6)}.typecho-head-nav .operate a:focus,.typecho-head-nav .operate a:hover{color:rgba(255,255,255,.8);background-color:#673AB7;outline:0}.body.container{min-width:100%!important;padding:0}.row{margin:0}.col-mb-12{padding:0!important}.typecho-page-title{height:100px;padding:10px 40px 20px 40px;background-color:#00D8C9;color:#FFF;font-size:24px}.typecho-option-tabs{padding:0;margin:0;height:60px;background-color:#00BBAE;margin-bottom:40px!important;padding-left:25px}.typecho-option-tabs li{margin:0;border:none;float:left;position:relative;display:block;text-align:center;font-weight:500;font-size:14px;text-transform:uppercase}.typecho-option-tabs a{height:auto;border:0;color:rgba(255,255,255,.6);background-color:rgba(255,255,255,0)!important;padding:17px 24px}.typecho-option-tabs a:hover{color:rgba(255,255,255,.8)}.message{background-color:#673AB7!important;color:#fff}.success{background-color:#673AB7;color:#fff}.current{background-color:#FFF;height:4px;padding:0!important;bottom:0}.current a{color:#FFF}input[type=text],textarea{border:none;border-bottom:1px solid rgba(0,0,0,.6);outline:0;border-radius:0}.typecho-option span{margin-right:0}.typecho-option-submit{position:fixed;right:32px;bottom:32px}.typecho-option-submit button{float:right;background:#00BCD4;box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);color:#FFF}.typecho-page-main .typecho-option textarea{height:149px}.typecho-option label.typecho-label{font-weight:500;margin-bottom:20px;margin-top:10px;font-size:16px;padding-bottom:5px;border-bottom:1px solid rgba(0,0,0,.2)}#use-intro{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px;padding:8px;padding-left:20px;margin-bottom:40px}.typecho-foot{padding:16px 40px;color:#9e9e9e;margin-top:80px}button,form{display:none}
	</style>";

	echo '
		<script src="https://apps.bdimg.com/libs/jquery/1.7.1/jquery.min.js"></script>
		<link rel="stylesheet" href="//cdnjs.loli.net/ajax/libs/mdui/0.4.2/css/mdui.min.css">
		<script src="//cdnjs.loli.net/ajax/libs/mdui/0.4.2/js/mdui.min.js"></script>
	';
	echo "<script>mdui.JQ(function () { mdui.JQ('form').eq(0).attr('action', mdui.JQ('form').eq(1).attr('action')); });</script>";
	echo '
		<script>
			$.post("'.getSiteUrl().'/usr/themes/'.getThemeName().'/ajax/update.php",{action:"download",version:"'.INKER_VERSION.'"},function(data){
				var data=JSON.parse(data);
				if(data.code==0){
					$("#versionCode").html(data.message);
				}else if(data.code==1){
					$("#versionCode").html(data.message);
					$("#versionUpdate").html("<a href=javascript:update(\""+data.url+"\");>点击更新</a>");
				}
			});
			function update(url){
				if(confirm("您确定要更新此主题模板吗？")){
					$.post("'.getSiteUrl().'/usr/themes/'.getThemeName().'/ajax/update.php",{action:"update",url:url},function(data){
						var data=JSON.parse(data);
						alert(data.message);
					});
				}
			}
		</script>
	';
	echo '<form action="" method="post" enctype="application/x-www-form-urlencoded" style="display: block!important">
	<div class="mdui-panel" mdui-panel>
	  <div class="mdui-panel-item mdui-panel-item-open">
		<div class="mdui-panel-item-header">介绍</div>
		<div class="mdui-panel-item-body">';
	
	echo '<p style="font-size:14px;">
		<span style="display: block; margin-bottom: 10px; margin-top: 10px; font-size: 16px;">感谢您使用inker主题</span>
		<span style="margin-bottom:10px;display:block">关注 <a href="http://www.tongleer.com" target="_blank" style="color:#3384da;font-weight:bold;text-decoration:underline">同乐儿</a> 微信公众号或发送邮件进行<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=diamond0422@qq.com">bug提交</a>，同时可安装<a href="http://joke.tongleer.com/346.html" >Typecho应用商店</a>来关注更多主题插件。</span>
		<span style="margin-bottom:10px;display:block">
		注：该主题手机版不会显示WeMedia付费阅读插件中的内容，也不会显示CateFilter插件所隐藏的分类。
		</span>
		<a href="javascript:deleteCustomFields();" >清理无用自定义字段(可节省数据库空间)</a>&nbsp;
		<a href="javascript:installWap();" >安装手机版(可以自由绑定子域名)</a>&nbsp;<br />';
	echo '版本检查：<span id="versionCode"></span><span id="versionUpdate"></span>';
	echo '
		</p></div></div>
		<script>
			function deleteCustomFields(){
				if(confirm("您确定要清理无用自定义字段吗？")){
					$.post("'.getSiteUrl().'/usr/themes/'.getThemeName().'/ajax/deleteCustomFields.php",{},function(data){
						var data=JSON.parse(data);
						alert(data.msg);
					});
				}
			}
			function installWap(){
				if(confirm("您确定要安装手机版吗？")){
					$.post("'.getSiteUrl().'/usr/themes/'.getThemeName().'/ajax/installWap.php",{},function(data){
						var data=JSON.parse(data);
						alert(data.msg);
					});
				}
			}
		</script>
	';
	
	echo '
      <div class="mdui-panel-item">
        <div class="mdui-panel-item-header">功能设定</div>
        <div class="mdui-panel-item-body">';
	
	$tools->checkbox("功能开关",
    array(
        'isPjax' => _t('是否开启Pjax'),
		'isLogin' => _t('是否开启前台登陆'),
		'isPhoneLogin' => _t('是否开启前台手机号登陆'),
		'isMailLogin' => _t('是否开启前台邮箱登陆'),
		'isQQLogin' => _t('是否开启前台QQ登陆'),
		'isWeiboLogin' => _t('是否开启前台微博登陆'),
		'isShowImgCode' => _t('是否显示图片验证码'),
		'isShowSmsCode' => _t('是否显示短信验证码')
    ), "switch","启用手机登陆后如果有手机用户注册会在用户数据表中添加phone字段");
	
	$tools->input("打赏二维码图片地址","dashang_qrcode","在这里填入打赏二维码图片地址的地址");
	
	echo '</div></div>';
	
	echo '
      <div class="mdui-panel-item">
        <div class="mdui-panel-item-header">登陆配置</div>
        <div class="mdui-panel-item-body">';
		
	$tools->input("smtp服务器(已验证QQ企业邮箱和126邮箱可成功发送)","mailsmtp",_t("用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器地址，QQ企业邮箱：smtp.exmail.qq.com:465；QQ个人邮箱：smtp.qq.com:465/25；126邮箱：smtp.126.com:465/25"));
	
	$tools->input("smtp服务器端口","mailport","用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器端口");
	
	$tools->input("smtp服务器邮箱用户名","mailuser","用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器邮箱用户名");
	
	$tools->input("smtp服务器邮箱密码","mailpass","用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器邮箱密码");
	
	$tools->radio("smtp服务器安全类型",array("ssl"=>"SSL","tls"=>"TLS","none"=>"无"),"mailsecure");
		
	$tools->input("阿里云短信服务AccessKeyID","aliyun_accessKeyId","阿里云短信服务AccessKeyID");
	
	$tools->input("阿里云短信服务AccessKeySecret","aliyun_accessKeySecret","阿里云短信服务AccessKeySecret");
	
	$tools->input("阿里云短信服务模版CODE","aliyun_templatecode","阿里云短信服务模版CODE");
	
	$tools->input("阿里云短信服务签名名称","aliyun_signname","阿里云短信服务签名名称");
	
	$tools->input("QQ互联appid","qq_appid","填写在QQ互联申请的qq_appid");
	
	$tools->input("QQ互联qq_appkey","qq_appkey","填写在QQ互联申请的qq_appkey");
	
	$tools->input("QQ互联qq_callback","qq_callback","填写在QQ互联配置的qq_callback");
	
	$tools->input("微博开放平台App Key","wb_akey","填写在微博开放平台申请的App Key");
	
	$tools->input("微博开放平台App Secret","wb_skey","填写在微博开放平台申请的App Secret");
	
	$tools->input("微博开放平台授权回调接口地址","wb_callback_url","填写在微博开放平台配置的授权回调接口地址");
	
	echo '</div></div>';
	
	echo '
      <div class="mdui-panel-item">
        <div class="mdui-panel-item-header">顶部设置</div>
        <div class="mdui-panel-item-body">';
		
	$tools->input("网站favicon","head_favicon","在这里填入网站favicon图片地址");
		
	$tools->input("网站图片标志","head_logo_img","在这里填入网站的图片logo标志，优先显示图片logo。");
		
	$tools->input("二维码","head_qrcode","在这里填入二维码地址");
	
	$tools->input("二维码说明","head_qrcode_info","在这里填入二维码的说明信息，为空则不显示。");
	
	$tools->input("服务条款","head_serviceitem","在这里填入服务条款独立页面地址，为空则不显示。");
	
	$tools->input("隐私条款","head_privacyitem","在这里填入隐私条款独立页面地址，为空则不显示。");
	
	echo '</div></div>';
	
	echo '
      <div class="mdui-panel-item">
        <div class="mdui-panel-item-header">底部设置</div>
        <div class="mdui-panel-item-body">';
		
	$tools->textarea("友情链接","foot_friendlink","此处可以随意添加链接到导航栏的下拉菜单中，name=链接名，link=链接地址，target=打开方式，rel=链接关系，detail=链接描述，icon=链接图标，order=链接排序。注：target包括_blank、_self、_parent、_top；rel可以指定任意关系名称；icon可以是一个QQ号，也可以是链接图标的地址，如果是QQ号，那么既包含QQ链接也包含QQ头像；order的排序规则是越大越靠前。");
		
	$tools->textarea("底部信息","foot_info","在这里填入其他底部信息");
	
	$tools->input("备案号","foot_beian","在这里填入备案号");
	
	$tools->textarea("统计代码","foot_count","在这里填入统计代码");
	
	echo '</div></div>';
	
	echo '
      <div class="mdui-panel-item">
        <div class="mdui-panel-item-header">移动设置</div>
        <div class="mdui-panel-item-body">';
	
	$tools->input("畅言appid","changyan_appid","在这里填入畅言appid");
	
	$tools->input("畅言appkey","changyan_appkey","在这里填入畅言appkey");
	
	echo '</div></div>';
	
	echo '
      <div class="mdui-panel-item">
        <div class="mdui-panel-item-header">广告设置</div>
        <div class="mdui-panel-item-body">';
	
	$tools->textarea("文章底部广告位","ad_article_bottom","如需在文章底部添加广告，请在此处添加相关广告代码。");
	
	echo '</div></div>';
	
	echo '</div>
		<button class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-deep-purple-accent" style="display: block!important; position: fixed; right: 32px; bottom: 32px;">保存</button>
	</form>';
	
	$switch = new Typecho_Widget_Helper_Form_Element_Checkbox('switch',
    array(
        'isPjax' => _t('是否开启Pjax'),
		'isLogin' => _t('是否开启前台登陆'),
		'isPhoneLogin' => _t('是否开启前台手机号登陆'),
		'isMailLogin' => _t('是否开启前台邮箱登陆'),
		'isQQLogin' => _t('是否开启前台QQ登陆'),
		'isWeiboLogin' => _t('是否开启前台微博登陆'),
		'isShowImgCode' => _t('是否显示图片验证码'),
		'isShowSmsCode' => _t('是否显示短信验证码')
    ),
    array('isPjax','isLogin','isPhoneLogin','isMailLogin','isQQLogin','isWeiboLogin','isShowImgCode'), _t('功能开关')
    );
    $form->addInput($switch->multiMode());
	
	$dashang_qrcode = new Typecho_Widget_Helper_Form_Element_Text('dashang_qrcode', array("value"), 'https://ws3.sinaimg.cn/large/005V7SQ5ly1g03e2k3ms3j303w03wt8m.jpg', _t('打赏二维码图片地址'), _t('在这里填入打赏二维码图片地址的地址'));
	$form->addInput($dashang_qrcode);
	
	$mailsmtp = new Typecho_Widget_Helper_Form_Element_Text('mailsmtp', array("value"), 'smtp.exmail.qq.com', _t('smtp服务器(已验证QQ企业邮箱和126邮箱可成功发送)'), _t('用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器地址，QQ企业邮箱：smtp.exmail.qq.com:465；QQ个人邮箱：smtp.qq.com:465/25；126邮箱：smtp.126.com:465/25'));
	$form->addInput($mailsmtp);
	
	$mailport = new Typecho_Widget_Helper_Form_Element_Text('mailport', array("value"), '465', _t('smtp服务器端口'), _t('用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器端口'));
	$form->addInput($mailport);
	
	$mailuser = new Typecho_Widget_Helper_Form_Element_Text('mailuser', null, '', _t('smtp服务器邮箱用户名'), _t('用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器邮箱用户名'));
	$form->addInput($mailuser);
	
	$mailpass = new Typecho_Widget_Helper_Form_Element_Password('mailpass', null, '', _t('smtp服务器邮箱密码'), _t('用于邮箱注册发送邮箱验证码及其他邮件服务的smtp服务器邮箱密码'));
	$form->addInput($mailpass);
	
	$mailsecure = new Typecho_Widget_Helper_Form_Element_Radio('mailsecure', array(
		'ssl'=>_t('SSL'),
		'tls'=>_t('TLS'),
		'none'=>_t('无')
	), 'ssl', _t('smtp服务器安全类型'), _t(""));
	$form->addInput($mailsecure);
	
	$aliyun_accessKeyId = new Typecho_Widget_Helper_Form_Element_Text('aliyun_accessKeyId', array('value'), '', _t('阿里云短信服务AccessKeyID'), _t('阿里云短信服务AccessKeyID'));
    $form->addInput($aliyun_accessKeyId);
	
	$aliyun_accessKeySecret = new Typecho_Widget_Helper_Form_Element_Text('aliyun_accessKeySecret', array('value'), '', _t('阿里云短信服务AccessKeySecret'), _t('阿里云短信服务AccessKeySecret'));
    $form->addInput($aliyun_accessKeySecret);
	
	$aliyun_templatecode = new Typecho_Widget_Helper_Form_Element_Text('aliyun_templatecode', array('value'), '', _t('阿里云短信服务模版CODE'), _t('阿里云短信服务模版CODE'));
    $form->addInput($aliyun_templatecode);
	
	$aliyun_signname = new Typecho_Widget_Helper_Form_Element_Text('aliyun_signname', array('value'), '', _t('阿里云短信服务签名名称'), _t('阿里云短信服务签名名称'));
    $form->addInput($aliyun_signname);
	
	$qq_appid = new Typecho_Widget_Helper_Form_Element_Text('qq_appid', array('value'), '', _t('QQ互联appid'), _t('填写在QQ互联申请的qq_appid'));
    $form->addInput($qq_appid);
	
	$qq_appkey = new Typecho_Widget_Helper_Form_Element_Text('qq_appkey', array('value'), '', _t('QQ互联qq_appkey'), _t('填写在QQ互联申请的qq_appkey'));
    $form->addInput($qq_appkey);
	
	$qq_callback = new Typecho_Widget_Helper_Form_Element_Text('qq_callback', array('value'), getSiteUrl().'/?action=qqcallback', _t('QQ互联qq_callback'), _t('填写在QQ互联配置的qq_callback'));
    $form->addInput($qq_callback);
	
	$wb_akey = new Typecho_Widget_Helper_Form_Element_Text('wb_akey', array('value'), '', _t('微博开放平台App Key'), _t('填写在微博开放平台申请的App Key'));
    $form->addInput($wb_akey);
	
	$wb_skey = new Typecho_Widget_Helper_Form_Element_Text('wb_skey', array('value'), '', _t('微博开放平台App Secret'), _t('填写在微博开放平台申请的App Secret'));
    $form->addInput($wb_skey);
	
	$wb_callback_url = new Typecho_Widget_Helper_Form_Element_Text('wb_callback_url', array('value'), getSiteUrl().'/?action=weibocallback', _t('微博开放平台授权回调接口地址'), _t('wb_callback_url","填写在微博开放平台配置的授权回调接口地址'));
    $form->addInput($wb_callback_url);
	
	$head_favicon = new Typecho_Widget_Helper_Form_Element_Text('head_favicon', array('value'), getSiteUrl().'/usr/themes/'.getThemeName().'/assets/images/favicon.png', _t('网站favicon'), _t('在这里填入网站favicon图片地址'));
    $form->addInput($head_favicon);
	
	$head_logo_img = new Typecho_Widget_Helper_Form_Element_Text('head_logo_img', array('value'), getSiteUrl().'/usr/themes/'.getThemeName().'/assets/images/logo.png', _t('网站图片标志'), _t('在这里填入网站的图片logo标志，优先显示图片logo。'));
    $form->addInput($head_logo_img);
	
	$head_qrcode = new Typecho_Widget_Helper_Form_Element_Text('head_qrcode', array('value'), getSiteUrl().'/usr/themes/'.getThemeName().'/assets/images/code_img.png', _t('二维码'), _t('在这里填入二维码地址'));
    $form->addInput($head_qrcode);
	
	$head_qrcode_info = new Typecho_Widget_Helper_Form_Element_Text('head_qrcode_info', array('value'), '扫码关注微信公众号', _t('二维码说明'), _t('在这里填入二维码的说明信息'));
    $form->addInput($head_qrcode_info);
	
	$head_serviceitem = new Typecho_Widget_Helper_Form_Element_Text('head_serviceitem', array('value'), '', _t('服务条款'), _t('在这里填入服务条款独立页面地址，为空则不显示。'));
    $form->addInput($head_serviceitem);
	
	$head_privacyitem = new Typecho_Widget_Helper_Form_Element_Text('head_privacyitem', array('value'), '', _t('隐私条款'), _t('在这里填入隐私条款独立页面地址，为空则不显示。'));
    $form->addInput($head_privacyitem);
	
	$friendlinkvalue='
		[{
			"name":"同乐儿",
			"link":"http://www.tongleer.com",
			"target":"_blank",
			"rel":"friend",
			"detail":"共同分享快乐",
			"icon":"2293338477",
			"order":"1",
			"type":"home"
		},{
			"name":"同乐儿",
			"link":"http://www.tongleer.com",
			"target":"_blank",
			"rel":"friend",
			"detail":"共同分享快乐",
			"icon":"https://ws3.sinaimg.cn/large/ecabade5ly1fxqhk08iedj200s00s744.jpg",
			"order":"2",
			"type":"page"
		}]
	';
	$foot_friendlink = new Typecho_Widget_Helper_Form_Element_Textarea('foot_friendlink', array("value"), $friendlinkvalue, _t('友情链接'), _t('此处可以随意添加链接到导航栏的下拉菜单中，name=链接名，link=链接地址，target=打开方式，rel=链接关系，detail=链接描述，icon=链接图标，order=链接排序，type=类型。注：target包括_blank、_self、_parent、_top；rel可以指定任意关系名称；icon可以是一个QQ号，也可以是链接图标的地址，如果是QQ号，那么既包含QQ链接也包含QQ头像；order的排序规则是越大越靠前；type包括首页(home)、内页(page)、文本(text)类型。'));
	$form->addInput($foot_friendlink);
	
	$foot_info = new Typecho_Widget_Helper_Form_Element_Textarea('foot_info', array('value'), '<a href="">北京网络信息有限公司</a><span>客服热线：4000-180-160</span>', _t('底部信息'), _t('在这里填入其他底部信息'));
    $form->addInput($foot_info);
	
	$foot_beian = new Typecho_Widget_Helper_Form_Element_Text('foot_beian', array('value'), '京ICP备16012580号-1', _t('备案号'), _t('在这里填入备案号'));
    $form->addInput($foot_beian);
	
	$foot_count = new Typecho_Widget_Helper_Form_Element_Textarea('foot_count', array('value'), '', _t('统计代码'), _t('在这里填入统计代码'));
    $form->addInput($foot_count);
	
	$changyan_appid = new Typecho_Widget_Helper_Form_Element_Textarea('changyan_appid', array('value'), '', _t('畅言appid'), _t('在这里填入畅言appid'));
    $form->addInput($changyan_appid);
	
	$changyan_appkey = new Typecho_Widget_Helper_Form_Element_Textarea('changyan_appkey', array('value'), '', _t('畅言appkey'), _t('在这里填入畅言appkey'));
    $form->addInput($changyan_appkey);
	
	$ad_article_bottom = new Typecho_Widget_Helper_Form_Element_Textarea('ad_article_bottom', array('value'), '', _t('文章底部广告位'), _t('如需在文章底部添加广告，请在此处添加相关广告代码。'));
    $form->addInput($ad_article_bottom);
}

function themeFields($layout) {
	$src = new Typecho_Widget_Helper_Form_Element_Select('src', array(_t('内容'), _t('附件'), _t('附件+内容')), NULL, _t('图片源'), _t('选择前台展示的图片源（若选择[附件+内容]则内容图片在前）'));
	$layout->addItem($src);
	
	$thumb = new Typecho_Widget_Helper_Form_Element_Text('thumb', NULL, NULL, _t('封面图片'), _t('在这里填写封面图片的地址（留空将自动获取第一个附件或内容图片，且非本地附件须填写此处封面地址。）'));
	$layout->addItem($thumb);
	
	$video = new Typecho_Widget_Helper_Form_Element_Text('video', NULL, NULL, _t('视频地址'), _t('在这里填写视频的地址（留空不显示）'));
	$layout->addItem($video);
}