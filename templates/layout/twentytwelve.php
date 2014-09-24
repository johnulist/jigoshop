<?php
/**
 * @var $content string Content to display.
 */
get_header('shop');
?>
<div id="primary" class="site-content">
	<div id="content" role="main">
		<?php echo $content; ?>
	</div>
</div>
<?php do_action('jigoshop\sidebar'); ?>
<?php get_sidebar('shop'); // TODO: Remove on implementation of jigoshop\sidebar ?>
<?php get_footer('shop'); ?>
