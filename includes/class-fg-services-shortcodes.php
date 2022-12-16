<?php

defined( 'ABSPATH' ) or die();

class FG_Services_Shortcodes {

	const SERVICES_SHORTCODE_NAME = 'fg-services';

	private static $instance = null;

	/**
	 * FG_Features_Shortcodes constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	public static function instance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function register_shortcodes() {
		add_shortcode( self::SERVICES_SHORTCODE_NAME, array( $this, 'shortcode' ) );
	}

	public function shortcode( $atts ) {
		global $wp_query;

		$default = array(
			'is_shortcode' => true,
			'post__in'     => '',
		);

		$args = shortcode_atts( $default, $atts );

		$args['post__in'] = ! empty( $args['post__in'] ) ? explode( ',', $args['post__in'] ) : array();
		$args['paged']    = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;

		$wp_query = FG_Services_Post_Type::instance()->get_query( $args );

		ob_start();

		if ( have_posts() ) :
			?>
            <div class="uk-grid uk-child-width-1-2@m fg-services-grid" uk-grid>
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;
				?>
            </div>
			<?php

			the_posts_pagination( array(
				'type'      => 'list',
				'prev_text' => '<span uk-pagination-previous></span>',
				'next_text' => '<span uk-pagination-next></span>',
			) );
		endif;

		wp_reset_postdata();
		wp_reset_query();

		$html = ob_get_clean();

		return $html;

	}
}