<?php

defined( 'ABSPATH' ) or die();

class FG_Services_Post_Type {

	const POST_TYPE_NAME = 'fg_services';
	const TAXONOMY_NAME = 'fg_services_cat';
	const POST_TYPE_SLUG = 'services';
	const TAXONOMY_SLUG = 'service_cat';

	private $archive_page_slug;
	private $archive_page_title;

	private static $_instance;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function __construct() {
		$service_page_slug       = FG_Services_Settings::get_services_page_slug();
		$this->archive_page_slug = ! empty( $service_page_slug ) ? $service_page_slug : self::POST_TYPE_SLUG;

		$service_page_title      = FG_Services_Settings::get_services_page_title();
		$this->archive_page_title = ! empty( $service_page_title ) ? $service_page_title : self::POST_TYPE_SLUG;

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
//		add_action( 'pre_get_posts', array( $this, 'custom_query' ) );
	}

	/**
	 * Registers post type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'FG Services', 'FG Services General Name', 'fg-services' ),
			'singular_name'         => _x( 'FG Service', 'FG Service Singular Name', 'fg-services' ),
			'menu_name'             => __( 'FG Services', 'fg-services' ),
			'name_admin_bar'        => __( 'FG Services', 'fg-services' ),
			'archives'              => __( 'FG Service Archives', 'fg-services' ),
			'attributes'            => __( 'FG Service Attributes', 'fg-services' ),
			'parent_item_colon'     => __( 'Parent FG Service:', 'fg-services' ),
			'all_items'             => __( 'All FG Services', 'fg-services' ),
			'add_new_item'          => __( 'Add New FG Service', 'fg-services' ),
			'add_new'               => __( 'Add New', 'fg-services' ),
			'new_item'              => __( 'New FG Service', 'fg-services' ),
			'edit_item'             => __( 'Edit FG Service', 'fg-services' ),
			'update_item'           => __( 'Update FG Service', 'fg-services' ),
			'view_item'             => __( 'View FG Service', 'fg-services' ),
			'view_items'            => __( 'View FG Services', 'fg-services' ),
			'search_items'          => __( 'Search FG Service', 'fg-services' ),
			'not_found'             => __( 'Not found', 'fg-services' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'fg-services' ),
			'featured_image'        => __( 'Featured Image', 'fg-services' ),
			'set_featured_image'    => __( 'Set Featured Image', 'fg-services' ),
			'remove_featured_image' => __( 'Remove Featured Image', 'fg-services' ),
			'use_featured_image'    => __( 'Use as Featured Image', 'fg-services' ),
			'insert_into_item'      => __( 'Insert into FG Service', 'fg-services' ),
			'uploaded_to_this_item' => __( 'Uploaded to this FG Service', 'fg-services' ),
			'items_list'            => __( 'FG Services list', 'fg-services' ),
			'items_list_navigation' => __( 'FG Services list navigation', 'fg-services' ),
			'filter_items_list'     => __( 'Filter FG Services list', 'fg-services' ),
		);

		$rewrite = array(
			'slug'       => self::POST_TYPE_SLUG,
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'         => __( 'FG Service', 'fg-services' ),
			'description'   => __( 'FG Service Description', 'fg-services' ),
			'labels'        => $labels,
			'supports'      => array( 'title', 'editor', 'excerpt' ), //'thumbnail',
			'taxonomies'    => array( self::TAXONOMY_NAME ),
			'hierarchical'  => false,
			'public'        => true,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-admin-post',
			'menu_position' => 30,
			'can_export'    => true,
			'rewrite'       => $rewrite,
			'map_meta_cap'  => true,
			'show_in_rest'  => true,
			'has_archive'   => $this->archive_page_slug,
		);

		register_post_type( self::POST_TYPE_NAME, $args );
	}

	/**
	 * Registers taxonomy
	 */
	public function register_taxonomy() {

		$labels = array(
			'name'              => __( 'FG Service Categories', 'fg-services' ),
			'singular_name'     => __( 'FG Service Category', 'fg-services' ),
			'search_items'      => __( 'Search FG Service Categories', 'fg-services' ),
			'all_items'         => __( 'All FG Service Categories', 'fg-services' ),
			'parent_item'       => __( 'Parent FG Service Category', 'fg-services' ),
			'parent_item_colon' => __( 'Parent FG Service Category:', 'fg-services' ),
			'edit_item'         => __( 'Edit FG Service Category', 'fg-services' ),
			'update_item'       => __( 'Update FG Service Category', 'fg-services' ),
			'add_new_item'      => __( 'Add New FG Service Category', 'fg-services' ),
			'new_item_name'     => __( 'New FG Service Category Name', 'fg-services' ),
			'menu_name'         => __( 'FG Service Categories', 'fg-services' ),
		);

		$rewrite = array(
			'slug'       => self::TAXONOMY_SLUG,
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'hierarchical'       => true, // make it hierarchical (like categories)
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'meta_box_cb'        => 'post_categories_meta_box',
			'rewrite'            => $rewrite,
		);

		register_taxonomy( self::TAXONOMY_NAME, array( self::POST_TYPE_NAME ), $args );
	}

	/**
	 * @param $query WP_Query
	 */
	public function custom_query( $query ) {
		$is_shortcode = $query->get( 'is_shortcode' );
		$is_post_in   = $query->get( 'post__in' );

		if ( ! is_admin() && ( $query->is_main_query() || $is_shortcode ) ) {
			if ( self::POST_TYPE_NAME == $query->get( 'post_type' ) ) {
				$query->set( 'orderby', 'menu_order title' );
				$query->set( 'order', 'ASC' );
//				$query->set( 'suppress_filters', 'true' );

				if ( ! empty( $is_post_in ) ) {
					$query->set( 'orderby', 'post__in' );
				}
			}
		}
	}

	/**
	 * @param $atts array
	 *
	 * @return WP_Query
	 */
	public function get_query( $atts = array() ) {
		return $this->_get_query( $atts );
	}

	/**
	 * @return int[]|WP_Post[]
	 */
	public function get_items() {
		return $this->_get_items();
	}


	/**
	 * @param $atts array
	 *
	 * @return WP_Query
	 */
	private function _get_query( $atts = array() ) {
		$default = array(
			'post_type'      => self::POST_TYPE_NAME,
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
		);

		$args = wp_parse_args( $atts, $default );

		return new WP_Query( $args );
	}

	/**
	 * @return int[]|WP_Post[]
	 */
	private function _get_items() {
		$query = $this->_get_query();

		return $query->get_posts();
	}
}