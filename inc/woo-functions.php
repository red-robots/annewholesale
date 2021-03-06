<?php
/**
 * Created by PhpStorm.
 * User: fritz
 * Date: 11/2/16
 * Time: 3:08 PM
 */

add_filter( 'woocommerce_enqueue_styles', 'bella_dequeue_styles' );
function bella_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-smallscreen'] );    // Remove the smallscreen optimisation
	return $enqueue_styles;
}

add_action( 'init', 'bella_remove_defunct_product_link' );
function bella_remove_defunct_product_link() {
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
}

add_action( 'init', 'bella_remove_default_loop_title' );
function bella_remove_default_loop_title() {
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
}

function bella_add_link_to_product() {
	woocommerce_template_loop_product_link_open();
	echo '<h3>';
	the_title();
	echo '</h3>';
	woocommerce_template_loop_product_link_close();
}

add_action( 'woocommerce_shop_loop_item_title', 'bella_add_link_to_product', 10 );

add_action( 'init', 'bella_remove_the_archive_add_to_cart' );
function bella_remove_the_archive_add_to_cart() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_add_to_cart', 10 );

add_action( 'init', 'bella_remove_the_archive_price' );
function bella_remove_the_archive_price() {
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}

function bella_archive_price_and_description() {
	global $product;
	$price              = $product->get_price_html();
	$product_box_line_1 = get_field( "product_box_line_1" );
	$product_box_line_2 = get_field( "product_box_line_2" );
	echo '<div class="price-description"><div class="row-1">';
	if ( $price ) {
		echo $price . ' ';
	}
	echo $product_box_line_1 . '</div><!--.row-1--><div class="row-2">' . $product_box_line_2 .
	     '</div><!--.row-2-->' .
	     '</div><!--.price-description-->';
}

add_action( 'woocommerce_after_shop_loop_item_title', 'bella_archive_price_and_description', 10 );


add_action( 'init', 'bella_remove_main_wrapper' );
function bella_remove_main_wrapper() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
}

function bella_output_content_wrapper_end() {
	echo '</article><!--#content--></main></div><!--#primary-->';
}

function bella_output_content_wrapper() {
	echo '<div id="primary" class="content-area woocommerce">' .
	     '<main id="main" class="site-main" role="main"><article id="content">';
}

add_action( 'woocommerce_before_main_content', 'bella_output_content_wrapper', 10 );
add_action( 'woocommerce_after_main_content', 'bella_output_content_wrapper_end', 10 );

add_action( 'init', 'bella_remove_the_excerpt' );
function bella_remove_the_excerpt() {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6 );

// Remove Breadcrumbs
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

// Disable Related Products
function wc_remove_related_products( $args ) {
	return array();
}

add_filter( 'woocommerce_related_products_args', 'wc_remove_related_products', 10 );
// Show another pic instead of featured iamges
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );

function change_image_shown( $args ) {
	global $product;
	$product_title = sanitize_title_with_dashes( preg_replace('/[^a-zA-Z0-9\s]/','',get_the_title()) );
	echo '<div class="image-wrapper">';
	woocommerce_template_loop_product_link_open();
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'large' );
	} else {
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $product->post->ID );
	}
	woocommerce_template_loop_product_link_close();
	echo '<div class="overlay"><a class="surrounding quickview" href="#' . $product_title . '-popup">Quick View</a></div><!--.overlay--></div><!--.image-wrapper-->';
}

add_filter( 'woocommerce_before_shop_loop_item_title', 'change_image_shown', 10 );

function bella_popup_view() {
	global $product;
	?>
    <div style="display:none;">
        <article class="popup-view woocommerce"
                 id="<?php echo sanitize_title_with_dashes( preg_replace('/[^a-zA-Z0-9\s]/','',get_the_title()) ) . '-popup'; ?>">
            <div class="top-bar">
            </div><!--.top-bar-->
            <div id="product-<?php the_ID(); ?>" class="product">
                <div class="images">
					<?php
					$image = get_field( "popup_image" );
					if ( $image ) {
						echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
					} elseif ( has_post_thumbnail() ) {
						the_post_thumbnail( 'full' );
					} else {
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $product->post->ID );
					} ?>
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
					remove_filter( 'woocommerce_single_product_summary', 'return_the_description', 6 );
					do_action( 'woocommerce_single_product_summary' );
					add_action( 'woocommerce_single_product_summary', 'return_the_description', 6 );
					?>
                </div><!-- .summary -->
            </div><!-- #product-<?php the_ID(); ?> -->
        </article><!--.popup-product-->
    </div><!--.display-none-->
<?php }

add_action( 'woocommerce_after_shop_loop_item', 'bella_popup_view' );

add_action( 'wp_ajax_bella_add_cart', 'bella_ajax_add_cart' );
add_action( 'wp_ajax_nopriv_bella_add_cart', 'bella_ajax_add_cart' );
function bella_ajax_add_cart() {
	if ( isset( $_POST['id'] ) && isset( $_POST['qty'] ) ) {
		$id  = intval( $_POST['id'] );
		$qty = intval( $_POST['qty'] );
		if ( WC()->cart->add_to_cart( $id, $qty ) !== false ) {
			$status = 1;
		} else {
			$status = 0;
		}
	} else {
		$status = 0;
	}
	$response    = array(
		'what'   => 'cart',
		'action' => 'add_cart',
		'id'     => $status,
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

add_action( 'wp_ajax_bella_get_cart_count', 'bella_ajax_get_cart_count' );
add_action( 'wp_ajax_nopriv_bella_get_cart_count', 'bella_ajax_get_cart_count' );
function bella_ajax_get_cart_count() {
	$response    = array(
		'what'   => 'cart',
		'action' => 'get_cart_count',
		'data'   => WC()->cart->get_cart_contents_count(),
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

add_action( 'wp_ajax_bella_get_cart', 'bella_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_bella_get_cart', 'bella_ajax_get_cart' );
function bella_ajax_get_cart() {
	$return = do_action( 'woocommerce_before_cart_contents' );
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			$return .= '<div class="product-box"><div class="product-thumbnail">';
			$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
			if ( ! $_product->is_visible() ) {
				$return .= $thumbnail;
			} else {
				$return .= sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
			}
			$return .= '</div><!--.product-thumbnail--><div class="product-info"><div class="product-name">';
			if ( ! $_product->is_visible() ) {
				$return .= apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
			} else {
				$return .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
			}
			$return .= '</div><!--.product-name--><div class="product-quantity">';
			$return .= "Quantity: " . $cart_item['quantity'] . '</div><!--.product-quantity--><div class="product-price">';
			$return .= "Price: " . apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . '</div><!--.product-price--></div><!--.product-info--></div><!--.product-box-->';
		}
	}
	$return .= do_action( 'woocommerce_cart_contents' );
	$return .= do_action( 'woocommerce_after_cart_contents' );
	$return .= '<div class="totals-checkout"><div class="subtotal">Subtotal - ' . WC()->cart->get_cart_total() . '</div><!--.subtotal-->';
	$return .= '<div class="checkout button"><a class="surrounding" href="' . WC()->cart->get_checkout_url() . '">Checkout</a></div><!--.checkout .button--></div><!--.totals-checkout-->';
	$response    = array(
		'what'   => 'cart',
		'action' => 'get_cart',
		'id'     => '1',
		'data'   => $return
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}


add_action( 'wp_ajax_bella_get_checkout_popup', 'bella_ajax_get_checkout_popup' );
add_action( 'wp_ajax_nopriv_bella_get_checkout_popup', 'bella_ajax_get_checkout_popup' );
function bella_ajax_get_checkout_popup() {
	if ( isset( $_POST['id'] ) ) {
		$id     = intval( $_POST['id'] );
		$return = '<div class="popup-checkout"><div class="top-bar"><div class="title">Item Added to Shopping Cart</div></div><!--.top-bar-->';
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			if ( intval( $cart_item['product_id'] ) === $id ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$return .= '<div class="product-box"><div class="product-thumbnail">';
					$thumbnail = get_the_post_thumbnail( $_product->id );//apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					if ( ! $_product->is_visible() ) {
						$return .= $thumbnail;
					} else {
						$return .= sprintf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
					}
					$return .= '</div><!--.product-thumbnail--><div class="product-info"><div class="product-name">';
					if ( ! $_product->is_visible() ) {
						$return .= apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
					} else {
						$return .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
					}
					$return .= '</div><!--.product-name--><div class="product-quantity">';
					$return .= "Quantity: " . $cart_item['quantity'] . '</div><!--.product-quantity--><div class="product-price">';
					$return .= "Price: " . apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . '</div><!--.product-price-->';
					$return .= '<div class="buttons"><div class="continue button">Continue Shopping</div><!--.continue.button-->';
					$return .= '<div class="checkout button"><a class="surrounding" href="' . WC()->cart->get_checkout_url() . '">Checkout</a></div><!--.checkout .button--></div><!--.buttons-->';
					$return .= '</div><!--.product-info--></div><!--.product-box-->';
				}
				break;
			}
		}
		$return .= do_action( 'woocommerce_cart_contents' );
		$return .= do_action( 'woocommerce_after_cart_contents' );
		$return .= '<div class="bottom-bar">';
		$return .= '<div class="quantity">' . WC()->cart->get_cart_contents_count() . ' Item';
		if ( WC()->cart->get_cart_contents_count() > 1 ) {
			$return .= 's';
		}
		$return .= ' in Shopping Cart</div>';
		$return .= '<div class="subtotal">Subtotal: ' . WC()->cart->get_cart_total() . '</div><!--.subtotal-->';
		$return .= '</div><!--.bottom-bar--></div><!--.popup-checkout-->';
	} else {
		$return = "<p>Couldn't find cart item</p>";
	}
	$response    = array(
		'what'   => 'cart',
		'action' => 'add_cart',
		'id'     => 1,
		'data'   => $return,
	);
	$xmlResponse = new WP_Ajax_Response( $response );
	$xmlResponse->send();
	die( 0 );
}

/**
 * This section adds custom purchase order number to the checkout process
 */
add_action( 'woocommerce_after_order_notes', 'bella_custom_checkout_field' );

function bella_custom_checkout_field( $checkout ) {

	echo '<div id="my_custom_checkout_field"><h2>' . __( 'PO#' ) . '</h2>';

	woocommerce_form_field( 'purchase_order_num', array(
		'type'        => 'text',
		'class'       => array( 'form-row-wide' ),
		'label'       => __( 'Fill in this field with purchase order number' ),
		'placeholder' => __( 'Enter purchase order num (optional)' ),
	), $checkout->get_value( 'purchase_order_num' ) );

	echo '</div>';
}

add_action( 'woocommerce_before_checkout_billing_form', 'bella_custom_checkout_field_2' );

function bella_custom_checkout_field_2( $checkout ) {

	echo '<div id="my_custom_checkout_field_2">';

	woocommerce_form_field( 'bella_contact_name', array(
		'type'        => 'text',
		'class'       => array( 'form-row-wide' ),
		'label'       => __( 'Contact Name' ),
		'placeholder' => __( 'Enter contact name (optional)' ),
	), $checkout->get_value( 'bella_contact_name' ) );

	echo '</div>';
}
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'bella_custom_checkout_field_update_order_meta' );

function bella_custom_checkout_field_update_order_meta( $order_id ) {
	if ( ! empty( $_POST['purchase_order_num'] ) ) {
		$po_num = $_POST['purchase_order_num'];
		if ( strlen( $po_num ) > 50 ) {
			$po_num = substr( $po_num, 0, 50 );
		}
		update_post_meta( $order_id, 'purchase_order_num', sanitize_text_field( $po_num ) );
	}
	if ( ! empty( $_POST['bella_contact_name'] ) ) {
		$contact = $_POST['bella_contact_name'];
		if ( strlen( $contact ) > 50 ) {
			$contact = substr( $contact, 0, 50 );
		}
		update_post_meta( $order_id, 'bella_conctact_name', sanitize_text_field( $contact ) );
	}
	$order = new WC_Order( $order_id );
	$user_id = $order->user_id;
	$associate = get_user_meta($user_id,'associate',true);
	if($user_id && $associate){
	    update_post_meta($order_id, 'bella_associate',sanitize_text_field($associate));
    }
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'bella_custom_checkout_field_display_admin_order_meta', 10, 1 );

function bella_custom_checkout_field_display_admin_order_meta( $order ) {
	echo '<p><strong>' . __( 'PO#' ) . ':</strong> ' . get_post_meta( $order->id, 'purchase_order_num', true ) . '</p>';
	echo '<p><strong>' . __( 'Contact' ) . ':</strong> ' . get_post_meta( $order->id, 'bella_contact_name', true ) . '</p>';
	$selected = get_post_meta( $order->id, 'bella_associate', true );
	$associates   = bella_custom_associate_get_associates();
	$output = '<select name="bella_associate">';
	$output .= '<option ' . selected( $selected, 0, false ) . ' value=""></option>';
	if ( ! empty( $associates ) ) {
		foreach ( $associates as $associate ):
			$value    = esc_attr( $associate );
			$output .= "<option value='{$value}' " . selected( $selected, $value, false ) . '>' . $value. '</option>';
		endforeach;
	}
	$output .= "</select>";
	echo '<p class="form-field form-field-wide"><label>' . __( 'Associate' ) . ':</label>' .  $output. '</p>';
}
add_action( 'woocommerce_before_save_order_items', 'bella_woocommerce_before_save_order_items', 10, 2 );
function bella_woocommerce_before_save_order_items( $order_id, $items ) {
	update_post_meta($order_id, 'bella_associate',sanitize_text_field($items['bella_associate']));
}
/* ----------------------------------------------
------------Filter based on order date------------
--------------------------------------------------
*/
add_filter( 'query_vars', 'bella_custom_month_register_query_vars' );
function bella_custom_month_register_query_vars( $qvars ) {
	//Add these query variables
	$qvars[] = 'bella_custom_month';

	return $qvars;
}

add_action( 'restrict_manage_posts', 'bella_custom_month_restrict_posts_by_metavalue' );
function bella_custom_month_restrict_posts_by_metavalue( $post_type ) {
	if ( $post_type && strcmp( $post_type, 'shop_order' ) === 0 ) {
		$months   = bella_custom_month_get_months();
		$selected = get_query_var( 'bella_custom_month' );
		$output   = "<select style='width:150px' name='bella_custom_month' class='postform'>\n";
		$output .= '<option ' . selected( $selected, 0, false ) . ' value="">' . __( 'Filter by Delivery Date' ) . '</option>';
		if ( ! empty( $months ) ) {
			foreach ( $months as $month ):
				$value    = esc_attr( $month->year . '' . $month->month );
				$month_dt = new DateTime( $month->year . '-' . $month->month . '-01' );
				$output .= "<option value='{$value}' " . selected( $selected, $value, false ) . '>' . $month_dt->format( 'F Y' ) . '</option>';
			endforeach;
		}
		$output .= "</select>\n";
		echo $output;
	}
}

add_action( 'pre_get_posts', 'bella_custom_month_pre_get_posts' );
function bella_custom_month_pre_get_posts( $query ) {

	//Only alter query if custom variable is set.
	$month_str = $query->get( 'bella_custom_month' );
	if ( ! empty( $month_str ) ) {

		//Be careful not override any existing meta queries.
		$meta_query = $query->get( 'meta_query' );
		if ( empty( $meta_query ) ) {
			$meta_query = array();
		}

		$month = new DateTime( $month_str . '01' );
		//Get posts with date between the first and last of given month
		$meta_query[] = array(
			'key'     => '_delivery_date',
			'value'   => array( esc_attr($month->format( 'Y-m-d' )), esc_attr($month->format( 'Y-m-t' ) )),
			'type'    => 'DATE',
			'compare' => 'BETWEEN',
		);
		$query->set( 'meta_query', $meta_query );
	}
}

function bella_custom_month_get_months() {
	global $wpdb;
	$months = wp_cache_get( 'bella_custom_month' );
	if ( false === $months ) {
		$query  = "SELECT YEAR(meta_value) AS `year`, DATE_FORMAT(meta_value,'%m') AS `month`,
                DATE_FORMAT(meta_value,'%d') AS `day`, count(post_id) as posts 
                FROM $wpdb->postmeta WHERE meta_key ='_delivery_date'           
                GROUP BY YEAR(meta_value), MONTH(meta_value) ORDER BY meta_value DESC";
		$months = $wpdb->get_results( $query );
		wp_cache_set( 'bella_custom_month', $months );
	}

	return $months;
}

/* ----------------------------------------------
------------Filter based on associate------------
--------------------------------------------------
*/
add_filter( 'query_vars', 'bella_custom_associate_register_query_vars' );
function bella_custom_associate_register_query_vars( $qvars ) {
	//Add these query variables
	$qvars[] = 'bella_associate';
	return $qvars;
}

add_action( 'restrict_manage_posts', 'bella_custom_associate_restrict_posts_by_metavalue' );
function bella_custom_associate_restrict_posts_by_metavalue( $post_type ) {
	if ( $post_type && strcmp( $post_type, 'shop_order' ) === 0 ) {
		$associates   = bella_custom_associate_get_associates();
		$selected = get_query_var( 'bella_associate' );
		$output   = "<select style='width:150px' name='bella_associate' class='postform'>\n";
		$output .= '<option ' . selected( $selected, 0, false ) . ' value="">' . __( 'Filter by Associate' ) . '</option>';
		if ( ! empty( $associates ) ) {
			foreach ( $associates as $associate ):
				$value    = esc_attr( $associate );
				$output .= "<option value='{$value}' " . selected( $selected, $value, false ) . '>' . $value. '</option>';
			endforeach;
		}
		$output .= "</select>\n";
		echo $output;
	}
}

add_action( 'pre_get_posts', 'bella_custom_associate_pre_get_posts' );
function bella_custom_associate_pre_get_posts( $query ) {

	//Only alter query if custom variable is set.
	$associate = $query->get( 'bella_associate' );
	if ( ! empty( $associate ) ) {

		//Be careful not override any existing meta queries.
		$meta_query = $query->get( 'meta_query' );
		if ( empty( $meta_query ) ) {
			$meta_query = array();
		}

		//Get posts with date between the first and last of given month
		$meta_query[] = array(
			'key'     => 'bella_associate',
			'value'   => $associate,
			'compare'    => 'LIKE',
		);
		$query->set( 'meta_query', $meta_query );
	}
}
function bella_get_acf_key($field_name){
	global $wpdb;

	return $wpdb->get_var("
        SELECT post_name
        FROM $wpdb->posts
        WHERE post_type='acf-field' AND post_excerpt='$field_name';
    ");
}
function bella_custom_associate_get_associates() {
    $field_key = bella_get_acf_key('associate');
    $field = get_field_object($field_key);
	global $wpdb;
	$associates = wp_cache_get( 'bella_associates' );
	if ( false === $associates ) {
		$query  = "SELECT meta_value AS `name` FROM $wpdb->postmeta WHERE meta_key ='bella_associate' 
                    UNION
                    SELECT meta_value AS 'name' FROM $wpdb->usermeta WHERE meta_key='associate'";
		$associates = $wpdb->get_results( $query );
		$associates_temp = array();
		foreach($associates as $associate){
		    $associates_temp[] = $associate->name;
        }
		$associates = array_unique(array_merge($associates_temp,array_keys($field['choices'])));
		wp_cache_set( 'bella_associates', $associates );
	}

	return $associates;
}

//custom postal value for csv export
add_filter('bella_woocommerce_order_shipping_method','bella_custom_shipping_method',10,1);
function bella_custom_shipping_method($title){
    return 'UPSG';
}
//add company name
add_action('manage_shop_order_posts_custom_column', 'bella_custom_shop_order_posts_custom_column',10,2);
function bella_custom_shop_order_posts_custom_column($column, $post_id){
	switch($column) {
		case 'company_name':
			echo get_post_meta($post_id,'_billing_company',true);
			break;
		case 'associate':
			echo get_post_meta($post_id,'bella_associate',true);
			break;
	}
}
add_filter('manage_edit-shop_order_columns', 'bella_custom_edit_shop_order_columns',10,1);
function bella_custom_edit_shop_order_columns($columns) {
	return array_merge($columns,array('company_name'=>'Company Name','associate'=>'Associate'));
}

add_action('woocommerce_email_after_order_table','bella_custom_woocommerce_email_after_order_table',10,1);
function bella_custom_woocommerce_email_after_order_table($order){
    echo '<p>Paid in full</p>';
    echo '<p>Requested Shipping Date '.(new DateTime(get_post_meta($order->id,'_delivery_date',true)))->format('m-d-Y').'</p>';
}
add_action('woocommerce_order_item_meta_start', 'bella_custom_woocommerce_order_item_meta_start',10,3);
function bella_custom_woocommerce_order_item_meta_start($item_id, $item, $order){
	$product_box_line_1 = get_post_meta($item['product_id'],"product_box_line_1",true );
	if($product_box_line_1){
	    echo "<br/>".$product_box_line_1;
	}
}
function bella_auto_disable_specific_plugins ( $update, $item ) {
	// Array of plugin slugs to always disable
	$plugins = array (
		'woocommerce-customer-order-csv-export',
	);
	if ( in_array( $item->slug, $plugins ) ) {
		return false; // Always disable plugins in this array
	} else {
		return $update; // Else, use the normal API response to decide whether to update or not
	}
}
add_filter( 'auto_update_plugin', 'bella_auto_disable_specific_plugins', 10, 2 );

add_filter( 'woocommerce_billing_fields', 'bella_filter_billing_company_name', 10, 1 );
function bella_filter_billing_company_name( $address_fields ) {
	$address_fields['billing_company']['required'] = true;
	$address_fields['billing_first_name']['required'] = false;
	$address_fields['billing_last_name']['required'] = false;
	return $address_fields;
}
add_filter( 'woocommerce_shipping_fields', 'bella_filter_shipping_company_name', 10, 1 );
function bella_filter_shipping_company_name( $address_fields ) {
	$address_fields['shipping_company']['required'] = true;
	$address_fields['shipping_first_name']['required'] = false;
	$address_fields['shipping_last_name']['required'] = false;
	return $address_fields;
}