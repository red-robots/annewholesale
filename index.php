<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>

	<div id="primary" class="content-area woocommerce template-index">
		<main id="main" class="site-main" role="main">
			<div id="content">
				<?php $args = array(
					'taxonomy'   => "product_cat",
					'order'      => 'ASC',
					'orderby'    => 'term_order',
					'hide_empty' => 0
				);
				$terms      = get_terms( $args );
				if ( ! is_wp_error( $terms ) && is_array( $terms ) && ! empty( $terms ) ):?>
					<?php $count = count( $terms );
					for ( $i = 0; $i < $count; $i ++ ):
						$term = $terms[ $i ]; ?>
						<section class="product-cat">
						<?php
						/**
						 * woocommerce_before_main_content hook.
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						//do_action( 'woocommerce_before_main_content' );
						?>

						<a name="<?php echo $term->slug; ?>"></a>
						<h2 class="cat-title"><?php echo $term->name; ?></h2>

						<?php
						/**
						 * woocommerce_archive_description hook.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						do_action( 'woocommerce_archive_description', $term->term_id );
						?>
						<?php $bella_args = array(
						'post_type'      => 'product',
						'posts_per_page' => - 1,
						'tax_query'      => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'id',
								'terms'    => $term->term_id
							)
						)
					);
						$bella_query      = new WP_Query( $bella_args ); ?>
						<?php if ( $bella_query->have_posts() ) : ?>

						<?php
						/**
						 * woocommerce_before_shop_loop hook.
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						//do_action( 'woocommerce_before_shop_loop' );
						?>

						<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

						<?php while ( $bella_query->have_posts() ) : $bella_query->the_post(); ?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php endwhile; // end of the loop. ?>

						<?php woocommerce_product_loop_end(); ?>

						<?php
						/**
						 * woocommerce_after_shop_loop hook.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						//do_action( 'woocommerce_after_shop_loop' );
						?>

					<?php elseif ( ! woocommerce_product_subcategories( array(
						'before' => woocommerce_product_loop_start( false ),
						'after'  => woocommerce_product_loop_end( false )
					) )
					) : ?>

						<?php wc_get_template( 'loop/no-products-found.php' ); ?>

					<?php endif; ?>

						<?php
						/**
						 * woocommerce_after_main_content hook.
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						//do_action( 'woocommerce_after_main_content' );
						?>

						<?php
						/**
						 * woocommerce_sidebar hook.
						 *
						 * @hooked woocommerce_get_sidebar - 10
						 */
						//do_action( 'woocommerce_sidebar' );
						?>
						</section>
					<?php endfor;//for for categories query
					?>
				<?php endif;//if for categories query?>
			</div><!--#content-->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
