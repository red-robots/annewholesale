<?php
/**
 * The template for displaying the footer for the login page.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ACStarter
 */

?>
<footer id="colophonlogin" role="contentinfo">
	<div class="footer-inside clear-bottom">
		<p class="social banner-text">Get Social</p>
		<div id="social"><?php acc_social_links() ?></div><!-- social -->
		<div class="bellaworks">
			<a href="http://bellaworksweb.com" target="_blank">Site by Bellaworks</a>
		</div><!--.bellaworks-->
		<div class="copyright">
			&copy; Anne Neilson Home <?php echo date( 'Y' ); ?>
		</div><!-- copyright -->
	</div><!-- footer inside -->
</footer><!-- #colophonlogin -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
