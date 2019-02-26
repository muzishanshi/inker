<?php
/**
 * 友情链接
 * @package custom 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php $this->need('header.php'); ?>
<div id="container">
	<style>
	.lists {padding:5px; margin:10px auto auto 0;}

	.link-content{list-style-type:none;clear:both;}
	.link-content li{margin-right:10px;float:left;height:24px;line-height:24px;font-size:12px;margin-bottom:15px;list-style-type:none !important;}
	.link-content li img{transition:0.6s;-webkit-transtion:0.6s;height:auto;vertical-align: middle;}
	.link-content li a{float:left;vertical-align: middle;}
	.link-content li:hover img{transform:scale(1.5);-webkit-transform:scale(1.5);}
	</style>
	<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/doc.css'); ?>" />
	<input type="hidden" id="isPage" value="<?=$this->is('page');?>" />
	<div class="doc_wrapper">
	   <h2 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title(); ?></a></h2>
	   <div class="post-content">
			<?php $this->content(); ?>
			<div class="lists">
			<?php
				$friendlink=json_decode($this->options->foot_friendlink,true);
				if(isset($friendlink)){
					?>
					<div class="link-content"><h3>首页链接</h3>
						<ul>
							<?php
							foreach ($friendlink as $link) {
								if($link["name"]!=null&&$link["link"]!=null&&$link["type"]=="home"){
									$icon=$link["icon"]!=""?$link["icon"]:"0";
									$iconlink=is_numeric($icon)?'https://wpa.qq.com/msgrd?v=3&uin='.$icon.'&site=qq&menu=yes':$link["link"];
									$iconimg=is_numeric($icon)?'https://q1.qlogo.cn/g?b=qq&nk='.$icon.'&s=100':$icon;
									?>
									<li>
										<a href=javascript:open("<?=$iconlink;?>");>
											<img src="<?=$iconimg;?>" width="20" />
										</a>
										<a href="<?=$iconlink;?>" rel="<?=$link["rel"];?>" title="<?=$link["detail"];?>" target="<?=$link["target"];?>">
											<?=$link["name"];?>
										</a>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<div class="link-content"><h3>内页链接</h3>
						<ul>
							<?php
							foreach ($friendlink as $link) {
								if($link["name"]!=null&&$link["link"]!=null&&$link["type"]=="page"){
									$icon=$link["icon"]!=""?$link["icon"]:"0";
									$iconlink=is_numeric($icon)?'https://wpa.qq.com/msgrd?v=3&uin='.$icon.'&site=qq&menu=yes':$link["link"];
									$iconimg=is_numeric($icon)?'https://q1.qlogo.cn/g?b=qq&nk='.$icon.'&s=100':$icon;
									?>
									<li>
										<a href=javascript:open("<?=$iconlink;?>");>
											<img src="<?=$iconimg;?>" width="20" />
										</a>
										<a href="<?=$iconlink;?>" rel="<?=$link["rel"];?>" title="<?=$link["detail"];?>" target="<?=$link["target"];?>">
											<?=$link["name"];?>
										</a>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<div class="link-content"><h3>文本链接</h3>
						<ul>
							<?php
							foreach ($friendlink as $link) {
								if($link["name"]!=null&&$link["link"]!=null&&$link["type"]=="text"){
									$icon=$link["icon"]!=""?$link["icon"]:"0";
									$iconlink=is_numeric($icon)?'https://wpa.qq.com/msgrd?v=3&uin='.$icon.'&site=qq&menu=yes':$link["link"];
									$iconimg=is_numeric($icon)?'https://q1.qlogo.cn/g?b=qq&nk='.$icon.'&s=100':$icon;
									?>
									<li>
										<a href=javascript:open("<?=$iconlink;?>");>
											<img src="<?=$iconimg;?>" width="20" />
										</a>
										<a href="javascript:;" rel="<?=$link["rel"];?>" title="<?=$link["detail"];?>" target="<?=$link["target"];?>">
											<?=$link["name"];?>
										</a>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<?php
				}
			?>
			</div>
		</div>
		<?php $this->need('comments.php'); ?>
	</div>
</div>

<?php $this->need('footer.php'); ?>