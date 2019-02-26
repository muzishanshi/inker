<?php if(!defined( '__TYPECHO_ROOT_DIR__'))exit;?>
<?php include "oauth.php";?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
		<meta charset="<?php $this->options->charset(); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" itemprop="description" content="<?php $this->options->description(); ?>">
		<meta name="keywords" content="<?php $this->options->keywords(); ?>">
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?> - <?php $this->options->description(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=$this->options->head_favicon;?>">
		<link href="<?php $this->options->themeUrl('assets/css/iconfont.css'); ?>" rel="stylesheet" >
		<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/normalize.min.css'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/base.css'); ?>">
		<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/live.css'); ?>">
		<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/gift-show.css'); ?>">
		<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css'); ?>">
		<script src="https://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
		<?php $this->header("generator=&commentReply="); ?>
		<?php
		if ($this->is('post')){
			$murl="article.php?cid=".$this->cid;
		}else if($this->is('category')){
			$murl="category.php?mid=".$this->categories[0]["mid"];
		}else if($this->is('index')){
			$murl="index.php";
		}
		if ($this->is('post')||$this->is('category')||$this->is('index')){
		?>
		<meta http-equiv="mobile-agent" content="format=xhtml; url=<?=$this->options ->siteUrl();?>m/<?=$murl;?>">
		<meta http-equiv="mobile-agent" content="format=html5; url=<?=$this->options ->siteUrl();?>m/<?=$murl;?>">
		<meta http-equiv="mobile-agent" content="format=wml; url=<?=$this->options ->siteUrl();?>m/<?=$murl;?>">
		<script>
			function goPage() {
				if (navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i)) {
					window.location.href = '<?=$this->options ->siteUrl();?>m/<?=$murl;?>';
				}
			}
			goPage();
		</script>
		<?php
		}
		?>
    </head>
    <body>
		<div id="header">
            <div class="header_wrapper clearfix">
                <a href="<?=$this->options ->siteUrl();?>" class="inke_logo fl" title="<?php $this->options->title();?>">
                    <img src="<?=$this->options->head_logo_img;?>" width="250" height="40" alt="<?php $this->options->title();?>">
				</a>
                <ul class="nav fl clearfix">
                    <li><a href="<?=$this->options ->siteUrl();?>">首页</a></li>
					<?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
					<?php
					while($category->next()){
						if($category->parent!=0){continue;}
						?>
						<li>|<a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a></li>
						<?php
					}
					?>
                </ul>
				<div class="searchDiv">
					<a class="searchButton"  id="sousuo" onclick="$.Sousuo()"><i class="iconfont icon-aria-search" id="nav-search-btn"></i></a>
					<form class="js-search search-form search-form--modal" method="get" role="search">
						<div class="search-form__inner">
							<div>
								<p class="micro mb-">输入后按回车搜索 ...</p>
								<i class="icon-search"></i>
								<input id="keyword" class="text-input" type="search" name="s" placeholder="Search" required="">
							</div>
						</div>
						<div class="search_close" onclick="$.Close()"></div>
					</form>
					<script>
					$.extend({
						Sousuo: function() {
							$('.js-toggle-search').toggleClass('is-active');
							$('.js-search').toggleClass('is-visible');
						},
						Close: function(){
							if($('.js-search').hasClass('is-visible')){
								$('.js-toggle-search').toggleClass('is-active');
								$('.js-search').toggleClass('is-visible');
							}
						},
					});
					</script>
				</div>
				<?php if(!$this->user->hasLogin()){ ?>
					<?php if(!empty($this->options->switch) && in_array('isLogin', $this->options->switch)){?>
					<div class="header_rg fr" style="display: block;">
						<span class="login">登录</span>|<span class="regist">注册</span>
					</div>
					<?php }?>
				<?php }else{?>
                <div class="user_box fr">
					<?php
					$nick=$this->user->screenName!=""?$this->user->screenName:$this->user->name;
					$host = 'https://secure.gravatar.com';
					$url = '/avatar/';
					$size = '50';
					$rating = 'g';
					$hash = md5(strtolower($this->user->mail));
					$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
					?>
                    <a href="<?php $this->options->adminUrl('profile.php'); ?>" target="_blank"><img src="<?=$avatar;?>" alt="<?=$nick;?>"><span class="user_name"><?=$nick;?></span></a>
					<span class="logout_btn">退出登录</span>
                </div>
				<?php }?>
				<!--
				<?php if($this->options->allowRegister&&!empty($this->options->switch) && in_array('isLogin', $this->options->switch)){?>
				<div class="header_rg fr" style="display: block;">
					<span class="login">登录</span>|<span class="regist">注册</span>
				</div>
				<?php }?>
                <div class="user_box fr">
                    <a href="<?php $this->options->adminUrl('profile.php'); ?>" target="_blank"><img src="" alt=""><span class="user_name"></span></a>
					<span class="logout_btn">退出登录</span>
                </div>
				-->
            </div>
        </div>