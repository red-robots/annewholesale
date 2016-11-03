<?php
/**
 * The header for theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ACStarter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header" role="banner">

		<?php if(is_home()) { ?>
			<h1 class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
		<?php } else { ?>
			<div class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></div>
		<?php } ?>


		<div class="head-right">
			<div id="socialheader">
				<ul>
					<li class="cart"><a href="<?php bloginfo('url'); ?>/cart"><?php echo WC()->cart->get_cart_contents_count();?></a></li>
				</ul>
			</div><!-- social header -->
			<div id="sb-search" class="sb-search">
				<?php get_search_form(); ?>
			</div><!-- search -->
			<?php $account_text = get_field("account_text","option");
			$account_link = get_permalink();
			if($account_text&&$account_link):?>
				<div class="account-link">
					<a href="<?php echo $account_link;?>"><?php echo $account_text;?></a>
				</div><!--.account-link-->
			<?php endif;?>
			<div class="popup-cart">
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) { ?>
						<div class="product-box">
							<div class="product-thumbnail">
								<?php	$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() ) {
									echo $thumbnail;
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
								}
								?>
							</div><!--.product-thumbnail-->
							<div class="product-info">
								<div class="product-name">
									<?php
									if ( ! $_product->is_visible() ) {
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
									} else {
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
									} ?>
								</div><!--.product-name-->
								<div class="product-quantity">
									<?php echo "Quantity: ".$cart_item['quantity'];?>
								</div><!--.product-quantity-->
								<div class="product-price">
									<?php
									echo "Price: ".apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
								</div><!--.product-price-->
							</div><!--.product-info-->
						</div><!--.product-box-->
						<?php
					}
				}

				do_action( 'woocommerce_cart_contents' );
				?>
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				<div class="totals-checkout">
					<div class="subtotal">Subtotal - <?php echo WC()->cart->get_cart_total(); ?></div><!--.subtotal-->
					<div class="checkout button">Checkout<a class="surrounding" href="<?php echo WC()->cart->get_checkout_url() ?>"></a></div><!--.checkout .button-->
				</div><!--.totals-checkout-->
			</div><!--.popup-cart-->
		</div><!-- head right -->


		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Navigation', 'twentytwelve' ); ?></h3>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

	</header><!-- #masthead -->
