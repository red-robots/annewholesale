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
		<?php $sub_heading_1 = get_field("sub_heading_1");
		if($sub_heading_1):?>
			<h2 class="cat-title"><?php echo $sub_heading_1;?></h2>
		<?php endif;?>
		<?php if(isset($_GET['login'])&&$_GET['login']==="failed"):?>
			<div class="messages">
				<p>We're sorry that combination isn't valid!</p>
			</div>
		<?php endif;?>
		<?php anne_wp_login_form( array('redirect' => home_url()) ); ?>
        <h2 class="center">Lost Password</h2>
		<?php if(isset($_GET['login'])&&$_GET['login']==="email"):?>
            <div class="messages">
                <p>We just sent you an email that will allow you to reset your password!</p>
            </div>
		<?php endif;?>
        <form id="forgotform" method="post" action="<?php bloginfo( 'wpurl' ); ?>/wp-login.php?action=lostpassword">
            <p>
                <label>Username or E-mail: </label><input type="text" style="margin:10px 0;" size="20" name="user_login"/><br/>
                <input type="submit" value="Submit" name="Submit"/>
                <input type="hidden" value="<?php echo home_url('/login/').'?login=email';?>" name="redirect_to"/>
            </p>
        </form>
		<?php $sub_heading_2 = get_field("sub_heading_2");
		if($sub_heading_2):?>
			<h2 class="cat-title"><?php echo $sub_heading_2;?></h2>
		<?php endif;
		echo do_shortcode('[gravityform id="1" title="false" description="false" ajax=true]');?>
        <div class="wholesale-signup-hidden">
            <div id="wholesale-signup">
                <h2>Thank You</h2>
                <p>Thank you for your request to be a wholesaler. Please check you email and within 24 hours your will be approved.</p>
            </div>
        </div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
