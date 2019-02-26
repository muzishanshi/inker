<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
	<div id="container">
		<div class="hotlive_wrapper">
			<div class="list_panel">
				<div class="list_panel_hd">
					<h3>
					<?php
					$this->archiveTitle(array(
						'category'  =>  _t('分类 %s 下的文章'),
						'search'    =>  _t('包含关键字 %s 的文章'),
						'tag'       =>  _t('标签 %s 下的文章'),
						'author'    =>  _t('%s 发布的文章')
					), '', '');
					?>
					</h3>
				</div>
				<?php
				if ($this->have()){
				?>
				<div class="list_panel_bd clearfix">
					<?php
						while($this->next()){
						?>
						<div class="list_box">
							<div class="list_pic">
								<a href="<?php $this->permalink(); ?>">
								<img src="<?php echo $this->fields->thumb != "" ? $this->fields->thumb : (isset(getPostImg($this)[0]['url'])?getPostImg($this)[0]['url']:$this->options->themeUrl.'/assets/images/thumbnail.png'); ?>" alt="<?php $this->author();?>" class="">
								<p class="num"><span><?php $this->date('Y年m月d日 H:i'); ?></span></p><span class="tag"><?php $this->commentsNum();?></span>
								<span class="play_layer"><i></i></span>
								</a>
								<div class="list_intro"><p><?php $this->title(); ?></p></div>
							</div>
							<div class="list_user_info">
								<a href="<?php $this->author->permalink(); ?>">
									<span class="list_user_head" style="background-image: url(<?php echo gravatarUrl($this->author->mail,30,"X","",true); ?>"></span>
								</a>
								<span class="list_user_name"><?php $this->author();?></span>
							</div>
							<div class="list_tag"><?php $this->excerpt(140, '...'); ?></div>
							<div class="list_tag">【<?php $this->category(','); ?>】<?php $this->tags(',', true, ''); ?></div>
						</div>
						<?php
						}
					?>
				</div>
				
				<div class="page">
					<?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;', 1, '...', array('wrapTag' => 'ul', 'wrapClass' => 'pagination', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'paginate_button active', 'prevClass' => 'paginate_button previous', 'nextClass' => 'paginate_button next')); ?>
				</div>
				<?php }else{?>
				<div class="nodata_wrapper"><span>暂无热门直播，请查看 <a href="<?=$this->options ->siteUrl();?>">首页</a></span></div>
				<?php }?>
			</div>
		</div>
	</div>
<?php $this->need('footer.php'); ?>