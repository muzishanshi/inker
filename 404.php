<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php $this->need('header.php'); ?>
<style>
.state-error{height:100px;font-size:14px;padding-top:100px;color:#b4bacc;}.state-error .center{text-align:center;}.state-error b{color:#64aeff;}.state-error a{display:inline-block;*zoom:1;*display:inline;}.state-error a:hover{text-decoration:none;}.state-error a.back-btn{margin-top:7px;width:200px;height:27px;line-height:27px;border:2px solid #b4bacc;text-align:center;border-radius:14px;color:#b4bacc;overflow:hidden;}.state-error a.back-btn:hover{background:#dfefff;}
</style>
<div id="container">
	<div class="state-error">
		<div class="center"><a class="back-btn" href="<?=$this->options ->siteUrl();?>">页面没找到，返回首页</a></div>
	</div>
</div>
<?php $this->need('footer.php'); ?>