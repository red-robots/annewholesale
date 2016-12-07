<?php
/**
 * Template Name: Sitemap
 */

/**
 * Created by PhpStorm.
 * User: fritz
 * Date: 11/8/16
 * Time: 9:57 AM
 */


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class( "template-sitemap" ); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php echo get_the_title(); ?></h1>
				</header><!-- .page-header -->
				<div class="entry-content">
					<nav class="sitemap">
						<?php wp_nav_menu( array(
							'theme_location' => 'sitemap',
						) ); ?>
					</nav><!-- sitemap -->
				</div><!--.entry-content-->
			</article><!-- #post-## -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
