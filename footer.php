<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
		<input type="hidden" id="hasLogin" value="<?=$this->user->hasLogin();?>" />
		<div id="footer">
			<!-- 右侧二维码 -->
			<div class="code_panel"><img class="code_img pa" src="<?=$this->options->head_qrcode;?>" alt="<?=$this->options->head_qrcode_info;?>"></div>
            <div class="footer_menu">
				<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
				<?php
					while($pages->next()){
						if($pages->parent!=0){continue;}
						?>
						<span><a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></span>
						<?php
					}
				?>
			</div>
			<p><?php printFriends($this->options->foot_friendlink);?></p>
			<p>
				<?php
					Typecho_Widget::widget('Widget_Stat')->to($stat);
					echo "分类数&nbsp;".$stat->categoriesNum."&nbsp;文章数&nbsp;".$stat->PublishedPostsNum."&nbsp;页面数&nbsp;".$stat->PublishedPagesNum."&nbsp;评论数&nbsp;".$stat->PublishedCommentsNum;
				?>
			</p>
			<p><?=$this->options->foot_info;?></p>
			<!--尊重网站版权是每一个合法公民应尽的义务，请养成保留以下版权信息的习惯。-->
            <p>Copyright <?php echo date("Y")."-".date('Y', strtotime("+1 year"));?> <a href="<?=$this->options ->siteUrl();?>"><?php $this->options->title();?></a> Powered by <a href="http://typecho.org/" title="Typecho" target="_blank" rel="nofollow">Typecho</a> Theme By <a id="rightdetail" href="http://www.tongleer.com" target="_blank" title="同乐儿">Tongleer</a> All rights reserved.</p>
			<p><?=$this->options->foot_beian;?></p>
			<p style="display:none;"><?=$this->options->foot_count;?></p>
        </div>
		<script src="<?php $this->options->themeUrl('assets/js/ckplayer.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('assets/js/clipboard.min.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('assets/js/live.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('assets/js/gift-show.js'); ?>"></script>
		<script src="<?php $this->options->themeUrl('assets/js/util.js'); ?>"></script>
		<?php $this->footer(); ?>
		<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
		<?php include("assets/js/base.js.php");?>
		<?php include("assets/js/ajaxComment.js.php");?>
		<?php
		if (!empty($this->options->switch) && in_array('isPjax', $this->options->switch)){
			include("assets/js/pjax.js.php");
		}
		?>
    </body>
</html>