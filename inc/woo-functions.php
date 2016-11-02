<?php
/**
 * Created by PhpStorm.
 * User: fritz
 * Date: 11/2/16
 * Time: 3:08 PM
 */

// Show another pic instead of featured iamges
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');

function change_image_shown( $args ) {
	$product_title = sanitize_title_with_dashes(get_the_title());
	if(get_field('alternate_featured_image')!="") {
		// Get field Name
		$image = get_field('alternate_featured_image');
		$url = $image['url'];
		$title = $image['title'];
		$alt = $image['alt'];
		$caption = $image['caption'];
		$size = 'medium';
		$thumb = $image['sizes'][ $size ];
		$width = $image['sizes'][ $size . '-width' ];
		$height = $image['sizes'][ $size . '-height' ];


		echo '<div class="image-wrapper"><img src="' . $thumb . '" /><div class="overlay"><a class="surrounding quickview" href="#'.$product_title.'-popup">Quick View</a></div><!--.overlay--></div><!--.image-wrapper-->';

	} elseif ( has_post_thumbnail() ) {
		echo '<div class="image-wrapper">';
		the_post_thumbnail();
		echo '<div class="overlay"><a class="surrounding quickview" href="#'.$product_title.'-popup">Quick View</a></div><!--.overlay--></div><!--.image-wrapper-->';
	}
}
add_filter('woocommerce_before_shop_loop_item_title','change_image_shown', 10);

function bella_popup_view( ){?>
	<div style="display:none;">
		<article class="popup-view" id="<?php echo sanitize_title_with_dashes(get_the_title()).'-popup';?>">
			<div class="top-bar">
			</div><!--.top-bar-->
			<div id="product-<?php the_ID(); ?>" class="product">
				<div class="images">
					<?php if(get_field("popup_image")){
						$alt = (get_post(get_field("popup_image"))!==null)?get_post(get_field("popup_image"))->post_title:"";
						echo '<img src="'.wp_get_attachment_image_src(get_field("popup_image"),"full")[0].'" alt="'.$alt.'">';
					} elseif(get_field('alternate_featured_image')!="") {
						// Get field Name
						$image = get_field('alternate_featured_image');
						$url = $image['url'];
						$title = $image['title'];
						$alt = $image['alt'];
						$caption = $image['caption'];
						$size = 'medium';
						$thumb = $image['sizes'][ $size ];
						$width = $image['sizes'][ $size . '-width' ];
						$height = $image['sizes'][ $size . '-height' ];

						echo '<img src="' . $thumb . '" />';

					} elseif ( has_post_thumbnail() ) {
						the_post_thumbnail();
					}?>
				</div><!--.images-->
				<div class="summary entry-summary">
					<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					remove_filter('woocommerce_single_product_summary','return_the_description',6);
					do_action( 'woocommerce_single_product_summary' );
					add_action( 'woocommerce_single_product_summary', 'return_the_description', 6 );
					?>
				</div><!-- .summary -->
			</div><!-- #product-<?php the_ID(); ?> -->
		</article><!--.popup-product-->
	</div><!--.display-none-->
<?php }
add_action('woocommerce_after_shop_loop_item' , 'bella_popup_view');

add_action( 'wp_ajax_bella_add_cart', 'bella_ajax_add_cart' );
add_action( 'wp_ajax_nopriv_bella_add_cart', 'bella_ajax_add_cart' );
function bella_ajax_add_cart() {
	if(isset($_POST['id'])&&isset($_POST['qty'])){
		$id = intval( $_POST['id'] );
		$qty = intval ( $_POST['qty']);
		if(WC()->cart->add_to_cart( $id , $qty)!==false){
			$status = 1;
		} else {
			$status = 0;
		}
	} else {
		$status = 0;
	}
	$response = array(
		'what'=>'cart',
		'action'=>'add_cart',
		'id'=>$status,
	);
	$xmlResponse = new WP_Ajax_Response($response);
	$xmlResponse->send();
	die(0);
}
add_action( 'wp_ajax_bella_get_cart_count', 'bella_ajax_get_cart_count' );
add_action( 'wp_ajax_nopriv_bella_get_cart_count', 'bella_ajax_get_cart_count' );
function bella_ajax_get_cart_count() {
	$response = array(
		'what'=>'cart',
		'action'=>'get_cart_count',
		'id'=>$status,
		'data'=>WC()->cart->get_cart_contents_count(),
	);
	$xmlResponse = new WP_Ajax_Response($response);
	$xmlResponse->send();
	die(0);
}

add_action( 'wp_ajax_bella_get_cart', 'bella_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_bella_get_cart', 'bella_ajax_get_cart' );
function bella_ajax_get_cart() {
	$return = do_action( 'woocommerce_before_cart_contents' );
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			$return.='<div class="product-box"><div class="product-thumbnail">';
			$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
			if ( ! $_product->is_visible() ) {
				$return.=$thumbnail;
			} else {
				$return.=sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
			}
			$return.='</div><!--.product-thumbnail--><div class="product-info"><div class="product-name">';
			if ( ! $_product->is_visible() ) {
				$return.=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
			} else {
				$return.=apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
			}
			$return.='</div><!--.product-name--><div class="product-quantity">';
			$return.="Quantity: ".$cart_item['quantity'].'</div><!--.product-quantity--><div class="product-price">';
			$return.="Price: ".apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).'</div><!--.product-price--></div><!--.product-info--></div><!--.product-box-->';
		}
	}
	$return.=do_action( 'woocommerce_cart_contents' );
	$return.=do_action( 'woocommerce_after_cart_contents' );
	$return.='<div class="totals-checkout"><div class="subtotal">Subtotal - '.WC()->cart->get_cart_total().'</div><!--.subtotal-->';
	$return.='<div class="checkout button">Checkout<a class="surrounding" href="'.WC()->cart->get_checkout_url().'"></a></div><!--.checkout .button--></div><!--.totals-checkout-->';
	$response = array(
		'what'=>'cart',
		'action'=>'get_cart',
		'id'=>'1',
		'data'=>$return
	);
	$xmlResponse = new WP_Ajax_Response($response);
	$xmlResponse->send();
	die(0);
}


add_action( 'wp_ajax_bella_get_checkout_popup', 'bella_ajax_get_checkout_popup' );
add_action( 'wp_ajax_nopriv_bella_get_checkout_popup', 'bella_ajax_get_checkout_popup' );
function bella_ajax_get_checkout_popup() {
	if(isset($_POST['id'])){
		$id = intval( $_POST['id'] );
		$return = '<div class="popup-checkout"><div class="top-bar"><div class="title">Item Added to Shopping Cart</div></div><!--.top-bar-->';
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			if(intval($cart_item['product_id'])===$id){
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$return.='<div class="product-box"><div class="product-thumbnail">';
					$thumbnail = get_the_post_thumbnail($_product->id);//apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					if ( ! $_product->is_visible() ) {
						$return.=$thumbnail;
					} else {
						$return.=sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
					}
					$return.='</div><!--.product-thumbnail--><div class="product-info"><div class="product-name">';
					if ( ! $_product->is_visible() ) {
						$return.=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
					} else {
						$return.=apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
					}
					$return.='</div><!--.product-name--><div class="product-quantity">';
					$return.="Quantity: ".$cart_item['quantity'].'</div><!--.product-quantity--><div class="product-price">';
					$return.="Price: ".apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).'</div><!--.product-price-->';
					$return.='<div class="buttons"><div class="continue button">Continue Shopping</div><!--.continue.button-->';
					$return.='<div class="checkout button">Checkout<a class="surrounding" href="'.WC()->cart->get_checkout_url().'"></a></div><!--.checkout .button--></div><!--.buttons-->';
					$return.='</div><!--.product-info--></div><!--.product-box-->';
				}
				break;
			}
		}
		$return.=do_action( 'woocommerce_cart_contents' );
		$return.=do_action( 'woocommerce_after_cart_contents' );
		$return.='<div class="bottom-bar">';
		$return.='<div class="quantity">'.WC()->cart->get_cart_contents_count().' Item';
		if(WC()->cart->get_cart_contents_count()>1){
			$return.='s';
		}
		$return.=' in Shopping Cart</div>';
		$return.='<div class="subtotal">Subtotal: '.WC()->cart->get_cart_total().'</div><!--.subtotal-->';
		$return .= '</div><!--.bottom-bar--></div><!--.popup-checkout-->';
	} else {
		$return = "<p>Couldn't find cart item</p>";
	}
	$response = array(
		'what'=>'cart',
		'action'=>'add_cart',
		'id'=>1,
		'data'=>$return,
	);
	$xmlResponse = new WP_Ajax_Response($response);
	$xmlResponse->send();
	die(0);
}


add_action( 'woocommerce_product_meta_end', 'bella_product_tabs' );
function bella_product_tabs(){
	if(is_archive())return;
	if(get_field("description")||get_field("details")||get_field("tips")){
		echo '<div class="product-tabs">';
		echo '<div class="top-bar">';
		if(get_field("description")){
			echo '<div class="title" data-type="desc">Description</div>';
		}
		if(get_field("details")){
			echo '<div class="title" data-type="details">Details</div>';
		}
		if(get_field("tips")){
			echo '<div class="title" data-type="tips">Tips</div>';
		}
		echo '</div><!--.top-bar-->';
		echo '<div class="viewport">';
		echo '<div class="copy" data-type="desc">';
		if(get_field("description")){echo get_field("description");}
		echo '</div><!--.copy-->';
		echo '<div class="copy" data-type="details">';
		if(get_field("details")){echo get_field("details");}
		echo '</div><!--.copy-->';
		echo '<div class="copy" data-type="tips">';
		if(get_field("tips")){echo get_field("tips");}
		echo '</div><!--.copy-->';
		echo '</div><!--.viewport-->';
		echo '</div><!--.product-tabs-->';
	}
}

add_action( 'woocommerce_product_meta_end', 'bella_add_see_more_cats' );
function bella_add_see_more_cats(){
	if(!is_archive()){
		$link = '';
		$cat_name = null;
		$terms = get_the_terms(get_the_ID(),'product_cat');
		if(!is_wp_error($terms)&&is_array($terms)&&!empty($terms)){
			$cat_name = $terms[0]->name;
			$tmp_link = get_term_link($terms[0]->term_id,'product_cat');
			if(!is_wp_error($link)){
				$link = $tmp_link;
			}
		}
		echo '<div class="return-button wrapper">';
		echo '<div class="return-to-cat button">See Other ';
		if(get_field("return_cat_name")){
			echo get_field("return_cat_name");
		} else {
			echo $cat_name;
		}
		echo '<a class="surrounding" href="'.$link.'"></a></div></div><!--.return-to-cat .button--></div><!--.return-button .wrapper-->';
	}
}

add_filter("woocommerce_stock_html","bella_stock_shower",20,3);
function bella_stock_shower($availability_html, $availability_availability, $variation ){
	if(get_field("show_stock",get_the_ID())==="none"){
		return "";
	} elseif(get_field("show_stock",get_the_ID())==="pre-order"){
		return '<p class="stock">Pre-Order</p>';
	} else {
		return $availability_html;
	}
}
