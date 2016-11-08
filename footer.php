<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ACStarter
 */

?>

<footer id="colophon" role="contentinfo">
	<div class="footer-inside">
		<p class="social banner-text">Get Social</p>
		<div id="social"><?php acc_social_links() ?></div><!-- social -->

		<div class="footer-left">
			<?php wp_nav_menu( array(
				'theme_location' => 'footer' ,
				'container'       => 'div',
				'container_class' => 'footer-nav',
			) ); ?>
			<?php $sitemap_link = get_the_permalink(158);
			if($sitemap_link):?>
				<a href="<?php echo $sitemap_link; ?>">
			<?php endif;?>
				Sitemap
			<?php if($sitemap_link):?>
				</a>
			<?php endif;?>
			| <a href="http://bellaworksweb.com" target="_blank">Site by Bellaworks</a>

			<div class="copyright">
				&copy; Anne Neilson Home <?php echo date('Y'); ?>
			</div><!-- copyright -->
		</div><!-- footer left -->

		<div class="footer-right clear-bottom">
			<?php $questions_text = get_field( "questions_text", "option" );
			$questions_link       = get_field( "questions_link", "option" );
			if ( $questions_text && $questions_link ):?>
				<div class="button wrapper">
					<a class="buttn" href="<?php echo $questions_link;?>"><?php echo $questions_text;?></a>
				</div>
			<?php endif; ?>
			<?php $account_text = get_field( "account_text", "option" );
			$account_link       = get_field( "account_link", "option" );
			if ( $account_text && $account_link ):?>
				<div class="button wrapper">
					<a class="buttn" href="<?php echo $account_link;?>"><?php echo $account_text;?></a>
				</div>
			<?php endif; ?>
			</div><!-- footer right -->
	</div><!-- footer inside -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
