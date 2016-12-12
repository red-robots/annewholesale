<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("template-login"); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php $sub_heading_1 = get_field("sub_heading_1");
		if($sub_heading_1):?>
			<h2><?php echo $sub_heading_1;?></h2>
		<?php endif;
		<?php if(isset($_GET['login'])&&$_GET['login']==="failed"):?>
			<div class="messages">
				<p>We're sorry that combination isn't valid!</p>
			</div>
		<?php endif;?>
		<?php anne_wp_login_form( array('redirect' => home_url()) ); ?>
		<?php $sub_heading_2 = get_field("sub_heading_2");
		if($sub_heading_2):?>
			<h2><?php echo $sub_heading_2;?></h2>
		<?php endif;
		echo do_shortcode('[gravityform id="1" title="false" description="false"]');?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
