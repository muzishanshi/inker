<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';  //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $commentClass .= ' comment-by-user';  //如果是评论作者的添加 .comment-by-user 样式
        }
    } 
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
?>
<ul>
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>">
		<a class="comment-avatar" href="<?php $comments->permalink(); ?>">
			<?php $comments->gravatar('15', ''); ?>
		</a>
		<div class="comment-content">
			<div class="comment-text"><span class="comment-reply" style="float:right"><?php $comments->reply('<i class="iconfont icon-aria-reply"></i>'); ?></span>
			<p><?php showCommentContent($comments->coid); ?></p>
			</div>
<p class="comment-meta"><span><?php echo "<a href=\"$comments->url\" rel=\"external nofollow\" target=\"_blank\">$comments->author</a>"; ?></span> 发表于 <?php $comments->date(); ?>. <span class="comment-ua"><?php echo parseUserAgent($comments->agent); ?></span></p>
		</div>
    </div><!-- 单条评论者信息及内容 -->
    <?php if ($comments->children) { ?> 
	<div class="comment-children">
		<?php $comments->threadedComments($options); ?> 
	</div>
	<?php } ?> 
</li>
</ul>
<?php } ?>

<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>


<?php commentReply($this); ?>
<div class="comments">
	<?php if($this->allow('comment')): ?>
	<?php $this->comments()->to($comments); ?>
		
		<?php if ($comments->have()): ?>
	
	<div class="comments_list">

		<?php $comments->listComments(); ?>

	</div>
		<div id="page-nav">
			<?php $comments->pageNav('<', '>',1,'...',array('wrapTag' => 'ul', 'wrapClass' => '','itemTag' => 'li','currentClass' => 'page-current',)); ?>
		</div>

		<?php endif; ?>
	<div id="<?php $this->respondId(); ?>" class="respond">
		<div class="cancel-comment-reply">
			<?php $comments->cancelReply('<i class="iconfont icon-aria-cancel"></i>'); ?>
		</div>
		
		<!-- New Comments begin -->
		<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
			<p class="comment-input">
				<input type="text" name="text" placeholder="你要说点什么...回车键发送" style="position: absolute;left: 0;bottom: 0;">
			</p>
		</form>
	</div>
	<?php else: ?>
        <style>.comment-reply {display:none;}</style>
    <span style="font-size: 20px;display: block;user-select: none;"><i class="iconfont icon-aria-close" sytle="font-size:20px"></i> 评论关闭了哟</span>
    <?php endif; ?>
</div>