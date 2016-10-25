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
add_action( 'init', 'jogja_core_register_post_types', 0 );
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
				'has_archive'	=> false,
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
				'has_archive'	=> false,
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
				'has_archive'	=> false,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Slide',
				'plural'   => 'Slides',
				'slug'     => 'slide',
			)
		);

	}

	if ( current_theme_supports( 'jogja-galleries' ) ) {

		register_extended_post_type( 'jogja-galleries',
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
				'supports'      => array( 'title', 'thumbnail', 'editor' ),
				'menu_icon' 	=> 'dashicons-format-image',
				'menu_position' => 8.70,
				'has_archive'	=> false,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Gallery',
				'plural'   => 'Galleries',
				'slug'     => 'gallery',
			)
		);

		// Register Taxonomy Gallery categories
		register_extended_taxonomy( 'gallery_cat' , 'jogja-galleries', array(),
			array(
				'singular' 	=> 'Category',
				'plural' 	=> 'Categories',
				'slug'		=> 'gallery_cat',
				)
		);

	}

	if ( current_theme_supports( 'jogja-events' ) ) {

		register_extended_post_type( 'jogja-events',
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
				'supports'      => array( 'title', 'thumbnail', 'editor' ),
				'menu_icon' 	=> 'dashicons-calendar',
				'menu_position' => 8.80,
				'has_archive'	=> false,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Event',
				'plural'   => 'Events',
				'slug'     => 'event',
			)
		);

	}

	if ( current_theme_supports( 'jogja-stories' ) ) {

		register_extended_post_type( 'jogja-stories',
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
				'supports'      => array( 'title', 'thumbnail', 'editor' ),
				'menu_icon' 	=> 'dashicons-sticky',
				'menu_position' => 8.90,
				'has_archive'	=> false,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Story',
				'plural'   => 'Stories',
				'slug'     => 'story',
			)
		);

	}

	if ( current_theme_supports( 'jogja-peoples' ) ) {

		register_extended_post_type( 'jogja-peoples',
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
				'supports'      => array( 'title', 'thumbnail', 'editor' ),
				'menu_icon' 	=> 'dashicons-businessman',
				'menu_position' => 8.99,
				'has_archive'	=> false,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'People',
				'plural'   => 'Peoples',
				'slug'     => 'people',
			)
		);

		register_extended_taxonomy( 'people-group' , 'jogja-peoples', array(),
			array(
				'singular' 	=> 'Group',
				'plural' 	=> 'Groups',
				'slug'		=> 'group',
				)
		);

	}

	if ( current_theme_supports( 'jogja-guestbook' ) ) {

		register_extended_post_type( 'jogja-guestbook',
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
				'supports'      => array( 'title', 'thumbnail', 'editor' ),
				'menu_icon' 	=> 'dashicons-format-chat',
				'menu_position' => 8.993,
				'has_archive'	=> false,
			),
			array(
				# Override the base names used for labels:
				'singular' => 'Guest Book',
				'plural'   => 'Guest Books',
				'slug'     => 'guest-book',
			)
		);

	}
}