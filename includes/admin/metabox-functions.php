<?php
// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * remove metaboxes
 *
 * @since 3.1.3
 */
function wc_slider_remove_meta_boxes() {
	$post_type = 'wc_category_slider';

	remove_meta_box( 'submitdiv', $post_type, 'side' );
}

add_action( 'add_meta_boxes', 'wc_slider_remove_meta_boxes', 10 );


/**
 * register metaboxes
 *
 * @since 3.1.3
 */
function wc_slider_register_meta_boxes() {
	$post_type = 'wc_category_slider';

	add_meta_box( 'wc-slider-settings', __( 'Settings', 'woo-category-slider-by-pluginever' ), 'wc_slider_settings_metabox', $post_type, 'normal', 'high' );
	add_meta_box( 'wc_slider_category_settings', __( 'Category Settings', 'woo-category-slider-by-pluginever' ), 'wc_slider_render_category_settings_metabox', $post_type, 'side', 'high' );
}

add_action( 'add_meta_boxes', 'wc_slider_register_meta_boxes', 10 );

/**
 * Settings metabox
 */

function wc_slider_settings_metabox( $post ) {
	ob_start();
	include WC_SLIDER_INCLUDES . '/admin/views/metabox.php';
	$html = ob_get_clean();
	echo $html;
}


/**
 * Category settings metabox
 *
 * @since 3.1.3
 */
function wc_slider_render_category_settings_metabox( $post ) {

	echo wc_category_slider()->elements->select( array(
		'label'            => __( 'Selection Type', 'woo-category-slider-by-pluginever' ),
		'name'             => 'selection_type',
		'placeholder'      => '',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'options'          => array(
			'all'    => 'All',
			'custom' => 'Custom'
		),
		'required'         => true,
		'selected'         => get_post_meta( $post->ID, 'selection_type', true ),
		'desc'             => __( 'Select all categories or any custom categories', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->select( array(
		'label'            => __( 'Select Categories', 'woo-category-slider-by-pluginever' ),
		'name'             => 'selected_categories',
		'class'            => 'select-2 select-categories',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'multiple'         => true,
		'options'          => wc_slider_get_category_list(),
		'required'         => false,
		'selected'         => get_post_meta( $post->ID, 'selected_categories', true ),
		'desc'             => __( '', 'woo-category-slider-by-pluginever' ),
		'attrs'            => array(
			'multiple' => 'multiple'
		),
	) );

	echo wc_category_slider()->elements->input( array(
		'name'           => 'limit_number',
		'label'          => __( 'Limit Items', 'woo-category-slider-by-pluginever' ),
		'double_columns' => false,
		'type'           => 'number',
		'value'          => get_post_meta( $post->ID, 'limit_number', true ),
		'desc'           => __( 'Limit the number of category appear on the slider', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->switcher( array(
		'label'          => __( 'Include Children', 'woo-category-slider-by-pluginever' ),
		'name'           => 'include_child',
		'double_columns' => false,
		'value'          => get_post_meta( $post->ID, 'include_child', true ),
		'desc'           => __( 'Will include subcategories of the selected categories', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->switcher( array(
		'name'  => 'show_empty',
		'value' => get_post_meta( $post->ID, 'show_empty', true ),
		'label' => __( 'Empty Categories', 'woo-category-slider-by-pluginever' ),
		'desc'  => __( 'Show/hide Category without products', 'woo-category-slider-by-pluginever' ),
	) );

	echo wc_category_slider()->elements->select( apply_filters( 'wc_category_slider_orderby_args', array(
		'label'            => __( 'Order By', 'woo-category-slider-by-pluginever' ),
		'name'             => 'orderby',
		'class'            => 'orderby',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'options'          => array(
			'id'          => 'Term ID',
			'name'        => 'Term Name',
			'description' => 'Term Description',
			'term_group'  => 'Term Group',
			'count'       => 'Count',
			'none'        => 'None',
		),
		'disabled'         => true,
		'required'         => false,
		'desc'             => __( 'Order category slider according to the selection type', 'woo-category-slider-by-pluginever' ),

	), $post->ID ) );

	echo wc_category_slider()->elements->select( apply_filters( 'wc_category_slider_order_args', array(
		'label'            => __( 'Order', 'woo-category-slider-by-pluginever' ),
		'name'             => 'order',
		'class'            => 'order',
		'show_option_all'  => '',
		'show_option_none' => '',
		'double_columns'   => false,
		'options'          => array(
			'asc'  => 'ASC',
			'desc' => 'DESC',
		),
		'required'         => false,
		'disabled'         => true,
		'desc'             => __( 'Order category slider according to the selection type', 'woo-category-slider-by-pluginever' ),

	), $post->ID ) );


	$action = empty( $_GET['action'] ) ? '' : esc_attr( $_GET['action'] );

	?>
	<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="publish"/>

	<?php if ( $action !== 'edit' ) { ?>
		<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Publish' ) ?>"/>
		<?php submit_button( __( 'Create Slider', 'woo-category-slider-by-pluginever' ), 'primary button-large', 'publish', false ); ?><?php
	} else { ?>
		<input name="original_publish" type="hidden" id="original_publish" value="publish"/>
		<?php submit_button( __( 'Update Slider', 'woo-category-slider-by-pluginever' ), 'primary button-large', 'publish', false );
	}

}

/**
 * Update slider settings
 *
 * @param $post_id
 *
 * @return bool|null
 */

function wc_category_slider_update_settings( $post_id ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return false;
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return false;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return false;
	}

	//save post meta
	$posted = empty( $_POST ) ? [] : $_POST;

	$categories = array();

	foreach ( $posted['categories'] as $key => $meta ) {
		if ( ! empty( $meta['icon'] ) ) {
			$categories[ $key ]['icon'] = sanitize_key( $meta['icon'] );
		}
	}

	update_post_meta( $post_id, 'categories', empty( $posted['categories'] ) ? '' : $categories );

	update_post_meta( $post_id, 'selection_type', empty( $posted['selection_type'] ) ? '' : sanitize_key( $posted['selection_type'] ) );
	update_post_meta( $post_id, 'selected_categories', empty( $posted['selected_categories'] ) ? '' : $posted['selected_categories'] );
	update_post_meta( $post_id, 'limit_number', empty( $posted['limit_number'] ) ? '' : intval( $posted['limit_number'] ) );
	update_post_meta( $post_id, 'include_child', empty( $posted['include_child'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'show_empty', empty( $posted['show_empty'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_image', empty( $posted['empty_image'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_content', empty( $posted['empty_content'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_button', empty( $posted['empty_button'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_name', empty( $posted['empty_name'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_product_count', empty( $posted['empty_product_count'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_nav', empty( $posted['empty_nav'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'empty_border', empty( $posted['empty_border'] ) ? 'off' : 'on' );
	update_post_meta( $post_id, 'hover_style', empty( $posted['hover_style'] ) ? '' : sanitize_key( $posted['hover_style'] ) );
	update_post_meta( $post_id, 'theme', empty( $posted['theme'] ) ? '' : sanitize_key( $posted['theme'] ) );
	update_post_meta( $post_id, 'autoplay', empty( $posted['autoplay'] ) ? 'off' : 'on' );

	do_action( 'wc_category_slider_settings_update', $post_id, $posted );

}

add_action( 'save_post_wc_category_slider', 'wc_category_slider_update_settings' );
