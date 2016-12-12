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
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
		<?php if(isset($_GET['login'])&&$_GET['login']==="failed"):?>
			<div class="messages">
				<p>We're sorry that combination isn't valid!</p>
			</div>
		<?php endif;?>
		<?php anne_wp_login_form( array('redirect' => home_url()) ); ?>
		<?php $sub_heading = get_field("sub_heading");
		if($sub_heading):?>
			<h2><?php echo $sub_heading;?></h2>
		<?php endif;
		echo do_shortcode('[gravityform id="1" title="false" description="false"]');?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
