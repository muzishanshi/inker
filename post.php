<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div id="container">
	<input type="hidden" id="isPage" value="<?=$this->is('page');?>" />
	<div class="live_wrapper">
		<div class="live_content clearfix">
			<div class="live_cont_lf pr fl">
				<div id="liveMedia" class="live_media">
					<?php if($this->fields->video!=""){?>
					<video src="<?=$this->fields->video;?>" width="100%" height="100%" controls="controls">您的浏览器不支持 video 标签。</video>
					<?php }?>
					<?php $this->content(); ?>
					<?=$this->options->ad_article_bottom;?>
				</div>
				<h2 id="live_room_name"></h2>
				<div class='toc-tit'></div>
				<ul class="live_info pa">
					<li><span><?php $this->title(); ?></span></li>
					<li><i class="addr"></i><span><a href="<?php $this->author->permalink(); ?>" rel="author"><font color="#fff"><?php $this->author(); ?></font></a></span></li>
					<li><i class="num"></i><span><font color="#fff"><?php get_post_view($this); ?></font></span></li>
				</ul>
				
			</div>
			<div class="live_cont_rg fr">
				<div class="host_info">
					<div class="host_name">
						<span><?php $this->author();?></span>
						<i class="sex"></i>
						<i class="level"></i>
					</div>
					<p class="host_code"><?php echo $this->author->mail;?></span></p>
					<p class="host_slogan"><?php echo $this->author->url;?></p>
					<a href="<?php $this->author->permalink(); ?>">
						<?php
						$queryAuthor= $this->db->select('mail')->from('table.users')->where('uid = ?', $this->authorId); 
						$rowAuthor = $this->db->fetchRow($queryAuthor);
						$host = 'https://secure.gravatar.com';
						$url = '/avatar/';
						$size = '50';
						$rating = 'g';
						$hash = md5(strtolower($rowAuthor["mail"]));
						$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
						?>
						<img class="host_portrait" src="<?=$avatar;?>" alt="">
					</a>
					<span class="host_focus_done">打赏</span>
					<span class="host_focus">网址</span>
				</div>
				<?php $this->need('comments_inker.php'); ?>
			</div>
		</div>

		<div id="live_hot" class="list_panel">
			<div class="list_panel_hd">
				<h3>热门文章</h3>
				<a href="<?=$this->options ->siteUrl();?>">更多</a>
			</div>
			<div class="list_panel_bd clearfix">
					<?php
					$hotpost=getHotCommentsArticle(3);
					if($hotpost){
						foreach($hotpost as $val){
							$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
							$post_title = htmlspecialchars($val['title']);
							$permalink = $val['permalink'];
							$match_str = "/((http)+.*?((.gif)|(.jpg)|(.bmp)|(.png)|(.GIF)|(.JPG)|(.PNG)|(.BMP)))/";
							preg_match_all ($match_str,$val['text'],$matches,PREG_PATTERN_ORDER);
							$img=$this->options->themeUrl.'/assets/images/thumbnail.png';
							if(count($matches[1])>0){
								$img=$matches[1][0];
							}
							$users = $this->db->fetchRow($this->db->select()->from('table.users')->where('uid = ?',$val["authorId"]));
							?>
							<div class="list_box">
								<div class="list_pic">
									<a href="<?php echo $permalink; ?>">
										<img src="<?php echo $img; ?>" alt="<?php echo $users["screenName"]!=""?$users["screenName"]:$users["name"];?>" alt="<?php echo $post_title; ?>" class="">
										<p class="num"><span><?php echo date('Y年m月d日 H:i',$val["created"]); ?></span></p><span class="tag"><?php echo $val["commentsNum"];?></span>
										<span class="play_layer"><i></i></span>
									</a>
									<div class="list_intro"><p><?php echo $post_title; ?></p></div>
								</div>
								<div class="list_user_info">
									<span class="list_user_head" style="background-image: url(<?php echo gravatarUrl($users["mail"],30,"X","",true); ?>"></span>
									<span class="list_user_name"><?php echo $users["screenName"]!=""?$users["screenName"]:$users["name"];?></span>
								</div>
								<div class="list_tag"></div>
							</div>
							<?php
						}
					}
					?> 
			</div>
		</div>
	</div>
	<?php
	$queryPostCountOfAuthor= $this->db->select('count(*) as num')->from('table.contents')->where('type = ?', 'post')->where('status = ?', 'publish')->where('authorId = ?', $this->authorId); 
	$rowPostCountOfAuthor = $this->db->fetchRow($queryPostCountOfAuthor);
	?>
	<script>
	$(function(){
		layui.use('layer', function(){
			var $ = layui.jquery, layer = layui.layer;
			$(".host_focus_done").click(function(){
				layer.confirm('<center><font color="#aaa"><div>站长为作者贡献了<?=$rowPostCountOfAuthor["num"];?>篇文章</div><img src="<?=$this->options->dashang_qrcode;?>" alt="" width="200"><div>您的鼓励将是站长及作者前行的动力</div><div>谢谢打赏</div></font></center>', {
					title:"打赏",
					btn: ['关闭']
				},function(index){
					layer.close(index);
				});
			});
		});
	});
	</script>
</div>
<?php $this->need('footer.php'); ?>