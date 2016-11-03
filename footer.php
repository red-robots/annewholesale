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
			<a href="<?php the_field('sitemap' , 'option'); ?>">Sitemap</a> |
			Site by <a href="http://bellaworksweb.com" target="_blank">Bellaworks</a>

			<div class="copyright">
				&copy; Anne Neilson Home <?php echo date('Y'); ?>
			</div><!-- copyright -->
		</div><!-- footer left -->

		<div class="footer-middle">
			<form action="//anneneilsonfineart.us3.list-manage.com/subscribe/post?u=33908336d7b67e6ca5c33dfc7&amp;id=37f8f6f238" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div id="mc_embed_signup_scroll">

					<div class="newscenter">
						<p>Subscribe Via Email</p>
					</div>

					<!--<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>-->
					<div class="formwrapper">


						<div class="mc-field-group">

							<div class="name-field">
								<input type="text" value="" name="NAME" class="" id="mce-NAME">
								<div class="thelabel label-name label-left">
									<label for="mce-NAME">NAME</label>
								</div>
							</div>



							<div class="bday-field">

								<div class="datefield ">
									<div class="subfield monthfield birthday-field">
										<input class="birthday " type="text" pattern="[0-9]*" value="" placeholder="MM" size="2" maxlength="2" name="MMERGE3[month]" id="mce-MMERGE3-month">
										<input class="birthday " type="text" pattern="[0-9]*" value="" placeholder="DD" size="2" maxlength="2" name="MMERGE3[day]" id="mce-MMERGE3-day">

									</div> <!-- birthday-field -->
									<div class="thelabel label-name label-left">
										<label for="mce-MMERGE3-month">BIRTHDAY </label>
									</div>
								</div><!-- date field -->
							</div>


						</div><!-- mc field group -->




						<div class="mc-field-group">
							<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
							<div class="thelabel label-name"><label for="mce-EMAIL">EMAIL  <span class="asterisk">*</span></label></div>
						</div>

						<div class="mc-list-group">
							<ul>
								<li class="right"><input type="checkbox" value="1" name="group[6385][1]" id="mce-group[6385]-6385-0"><label for="mce-group[6385]-6385-0">Blog</label></li>
								<li class="left"><input type="checkbox" value="2" name="group[6385][2]" id="mce-group[6385]-6385-1"><label for="mce-group[6385]-6385-1">Products + Promotions</label></li>
							</ul>
							<!-- <div class="thelabel label-name"><label for="mce-group">INTERESTS</label> -->
						</div><!-- mc-field-group -->

						<div class="clear"><input type="submit" value="subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>

						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;"><input type="text" name="b_33908336d7b67e6ca5c33dfc7_37f8f6f238" tabindex="-1" value=""></div>
					</div><!-- form wrapper -->


				</div>
			</form>
		</div><!-- footer middle -->

		<div class="footer-right">
			<div class="button wrapper"><a class="buttn" href="http://anneneilsonfineart.com" target="_blank">Gallery</a></div>
			<div class="button wrapper"><a class="buttn" href="<?php the_field('wholesaler_link' , 'option'); ?>">Request Wholesale Information</a></div>
			<div class="button wrapper"><a class="buttn" href="<?php bloginfo('url'); ?>/store-location">Store Locators</a></div>
			<div class="clear"></div>
		</div><!-- footer right -->

	</div><!-- footer inside -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
