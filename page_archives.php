<?php
/**
 * 页面存档
 * @package custom 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<?php $this->need('header.php'); ?>
<div id="container">
	<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/doc.css'); ?>" />
	<input type="hidden" id="isPage" value="<?=$this->is('page');?>" />
	<div class="doc_wrapper">
	   <h2 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title(); ?></a></h2>
	   <div class="post-content">
			<?php $this->content(); ?>
			<div id="" class="" style="font-size:12pt;">
				<h3>标签</h3>
				<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1')->to($tags); ?>
				<ul id="">
				<?php while($tags->next()): ?>
					<li class="" style="float:left;list-style:none;margin-right:20px;"><a href="<?php $tags->permalink(); ?>" target="_blank"><?php $tags->name(); ?></a></li>
				<?php endwhile; ?>
				</ul>
			</div>
			<div style="clear:both;"></div><p></p>
			<div id="" class="" style="font-size:12pt;">
				<h3>分类</h3>
				<?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
				<ul id="">
					<?php while ($category->next()): ?>
					<li class="" style="float:left;list-style:none;margin-right:20px;"><a href="<?php $category->permalink(); ?>" target="_blank"><?php $category->name(); ?></a></li>
					<?php endwhile; ?>
				</ul>
			</div>
			<div style="clear:both;"></div><p></p>
			<div class="" id="" style="font-size:12pt;">
			  <h3>归档</h3>
			  <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($archives);?>
			  <?php
				$i=1;$year=0; $mon=0;
				$output = "";
				while($archives->next()):
				$year_tmp = date('Y',$archives->created);
				$mon_tmp = date('m',$archives->created);
				if ($mon != $mon_tmp && $mon > 0){
					$output .= '
								</ul>
							</div>
						</div>
					</div>
					';  //结束拼接
				}
				if ($year != $year_tmp && $year > 0){
				}
				if ($year != $year_tmp) {
					$year = $year_tmp;
				}
				if ($mon != $mon_tmp) {
					$mon = $mon_tmp;
					$output .= "
						<div class=\"\">
							<div class=\"\">
								<h4 class=\"\">".$year."年".$mon."月</h4>
							</div>
							<div id=\"\" class=\"\">
								<div class=\"\">
									<ul>
					";
				}
				$output .= "
					<li>时间：<time>".date('d日',$archives->created)."</time>&nbsp;&nbsp;标题：<a href=\"".$archives->permalink."\">".$archives->title."</a>&nbsp;&nbsp;评论数：(".$archives->commentsNum.")</li>
				";
				$i++;
				endwhile;
				echo $output.'
							</ul>
						</div>
					</div>
				</div>
				';
			  ?>
			</div>
		</div>
	</div>
</div>

<?php $this->need('footer.php'); ?>