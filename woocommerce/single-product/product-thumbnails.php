<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {	?>
	<div class="productslider">
		<ul class="slides">
			<?php

			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 1 );

			foreach ( $attachment_ids as $attachment_id ) {

				$classes = array( 'zoom' );

				if ( $loop == 0 || $loop % $columns == 0 )
					$classes[] = 'first';

				if ( ( $loop + 1 ) % $columns == 0 )
					$classes[] = 'last';

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image       = wp_get_attachment_image( $attachment_id, 'large' );
				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) ); ?>

				<li>

					<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s',  $image ), $attachment_id, $post->ID, $image_class ); ?>
				</li>


				<?php

				$loop++;
			}

			?></ul>
	</div><!-- flex slider -->

	<div id="carousel" class="productlider">
		<ul class="slides">
			<?php

			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 1 );

			foreach ( $attachment_ids as $attachment_id ) {

				$classes = array( 'zoom' );

				if ( $loop == 0 || $loop % $columns == 0 )
					$classes[] = 'first';

				if ( ( $loop + 1 ) % $columns == 0 )
					$classes[] = 'last';

				$image_link = wp_get_attachment_url( $attachment_id );



				if ( ! $image_link )
					continue;

				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

				/*echo '<pre>';
				print_r($image);*/

				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) ); ?>


				<li>
					<?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '%s',  $image ), $attachment_id, $post->ID, $image_class ); ?>
				</li>


				<?php

				$loop++;
			}

			?>
		</ul>
	</div><!-- carousel -->
	<?php
}
