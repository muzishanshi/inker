<?php
/**
 * inker - A InkerForTypecho Template From tongleer.com
 * 这是一个来自同乐儿的Typecho版本的映客主题模板。<br /><div class="inkerset"><br /><a href="javascript:;" title="插件因兴趣于闲暇时间所写，故会有代码不规范、不专业和bug的情况，但完美主义促使代码还说得过去，如有bug或使用问题进行反馈即可。">鼠标轻触查看备注</a>&nbsp;<a href="http://club.tongleer.com" target="_blank">论坛</a>&nbsp;<a href="https://www.tongleer.com/api/web/pay.png" target="_blank">打赏</a>&nbsp;<a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=diamond0422@qq.com" target="_blank">反馈</a></div><style>.inkerset a{background: #4DABFF;padding: 5px;color: #fff;}</style>
 * @package inker for typecho 映客主题模板
 * @author 二呆
 * @version 1.0.5&nbsp;<span id="inkerupdateinfo"></span><script>inkerXmlHttp=new XMLHttpRequest();inkerXmlHttp.open("GET","https://www.tongleer.com/api/interface/inker.php?action=update&version=5",true);inkerXmlHttp.send(null);inkerXmlHttp.onreadystatechange=function () {if (inkerXmlHttp.readyState ==4 && inkerXmlHttp.status ==200){var data=JSON.parse(inkerXmlHttp.responseText);if(data.code==1){document.getElementById("inkerupdateinfo").innerHTML='<a href="'+data.url+'" title="有新版本可下载，更新信息可点击主题外观介绍处查看">有更新</a>';}else if(data.code==0){document.getElementById("inkerupdateinfo").innerHTML='<a href="javascript:;" title="'+data.message+'">无更新</a>';}}}</script>
 * @link http://www.tongleer.com/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
	<div id="container">
		<div class="hotlive_wrapper">
			<div class="list_panel">
				<div class="list_panel_hd">
					<h3>最新文章</h3>
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
									<?php
									$host = 'https://secure.gravatar.com';
									$url = '/avatar/';
									$size = '50';
									$rating = 'g';
									$hash = md5(strtolower($this->author->mail));
									$avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d=mm';
									?>
									<span class="list_user_head" style="background-image: url(<?php echo $avatar; ?>"></span>
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