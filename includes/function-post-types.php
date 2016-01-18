<?php

/**
 * Flush rewrite rules.
 *
 * @since 1.0
 * @author jogja-core
 */
add_action( 'after_switch_theme', 'jogja_flush_rewrite_rules' );
function jogja_flush_rewrite_rules() {
	flush_rewrite_rules();
}

/**
 * Register Core Post Types
 *
 * @return void
 * @author jogja-core
 **/
add_action( 'init', 'jogja_core_register_post_types' );
function jogja_core_register_post_types() {
	
	if ( current_theme_supports( 'jogja-portfolio' ) ) {

		register_extended_post_type( 'jogja-portfolio',
			array(
				'admin_cols' => array(
					'title' 			=> array(
							'title'			=> 'Project Name'
					),
					'featured_image' 	=> array(
						'title'          	=> 'Project Image',
						'featured_image' 	=> 'thumbnail',
						'height' 			=> 80,
						'width' 			=> 80

					),
					'project_categories' 	=> array(
						'title' 			=> 'Project Category',
						'taxonomy'			=> 'project_categories'
					),
					'date'
				),
				'filters' => array(
					'project_categories' => array(
						'title'    => 'Project Categories',
						'taxonomy' => 'project_categories'
					),
					'project_tags' => array(
						'title'    => 'Project Tags',
						'taxonomy' => 'project_tags'
					),
				),
				'supports'      => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon' 	=> 'dashicons-category',
				'menu_position' => 7.25,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Portfolio',
				'plural'   => 'Portfolios',
				'slug'     => 'project',
			)
		);

		// Register Taxonomy project categories
		register_extended_taxonomy( 'project_categories' , 'jogja-portfolio', array(),
			array(
				'singular' 	=> 'Category',
				'plural' 	=> 'Categories',
				'slug'		=> 'project_cat',
				)
		);

	}

	if ( current_theme_supports( 'jogja-testimonials' ) ) {

		register_extended_post_type( 'jogja-testimonials',
			array(
				'admin_cols' => array(
					'title' 			=> array(
							'title'			=> 'Name'
					),
					'featured_image' 	=> array(
						'title'          	=> 'Image',
						'featured_image' 	=> 'thumbnail',
						'height' 			=> 80,
						'width' 			=> 80

					),
					'date'
				),
				'supports'      => array( 'title', 'thumbnail' ),
				'menu_icon' 	=> 'dashicons-format-chat',
				'menu_position' => 8.25,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Testimonial',
				'plural'   => 'Testimonials',
				'slug'     => 'testimony',
			)
		);

	}

	if ( current_theme_supports( 'jogja-slides' ) ) {

		register_extended_post_type( 'jogja-slides',
			array(
				'admin_cols' => array(
					'title' 			=> array(
							'title'			=> 'Title'
					),
					'featured_image' 	=> array(
						'title'          	=> 'Image',
						'featured_image' 	=> 'thumbnail',
						'height' 			=> 80,
						'width' 			=> 80

					),
					'date'
				),
				'supports'      => array( 'title', 'thumbnail' ),
				'menu_icon' 	=> 'dashicons-camera',
				'menu_position' => 8.50,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Slide',
				'plural'   => 'Slides',
				'slug'     => 'slide',
			)
		);

	}
}