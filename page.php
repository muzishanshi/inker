<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="container">
	<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/doc.css'); ?>" />
	<input type="hidden" id="isPage" value="<?=$this->is('page');?>" />
	<div class="doc_wrapper">
	   <h2 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title(); ?></a></h2>
	   <div class="post-content">
			<?php $this->content(); ?>
		</div>
		<?php $this->need('comments.php'); ?>
	</div>
</div>

<?php $this->need('footer.php'); ?>