<?php

if ( class_exists( 'Jogja_Widget_Factory' ) ) {

	class Jogja_Instagram_Gallery extends Jogja_Widget_Factory {

		function __construct() {

			$args = array(
				'label' 		=> esc_html__( 'Jogja - Instagram Gallery', 'jogja-core' ),
				'description' 	=> esc_html__( 'A custom widget to display instagram photos in gallery display.', 'jogja-core' ),
			 );

			$args['fields'] = array(
				array(
					'name' 		=> esc_html__( 'Title', 'jogja-core' ),
					'desc' 		=> esc_html__( 'Enter the widget title.', 'jogja-core' ),
					'id' 		=> 'title',
					'type' 		=> 'text',
					'class' 	=> 'widefat',
					'std' 		=> esc_html__( 'Instagram Photo Gallery', 'jogja-core' ),
					'validate' 	=> 'alpha_dash',
					'filter' 	=> 'strip_tags|esc_attr'
				 ),
				array(
					'name'		=> esc_html__( 'Username', 'jogja-core' ),
					'id' 		=> 'username',
					'type'		=> 'text',
					'class' 	=> 'widefat',
					'std' 		=> '',
				 ),
				array(
					'name'		=> esc_html__( 'Number of images will be displayed', 'jogja-core' ),
					'id' 		=> 'number',
					'type'		=> 'number',
					'class' 	=> 'widefat',
					'std' 		=> 9,
				 ),
				array(
					'name' 		=> esc_html__( 'Link target', 'jogja-core' ),
					'id' 		=> 'target',
					'type'		=> 'select',
					'class' 	=> 'widefat',
					'std' 		=> '',
					'filter'	=> 'esc_attr',
					'fields' 	=> array(
							array(
								'name'  => esc_html__( 'Self', 'jogja-core' ),
								'value' => '_self'
							 ),
							array(
								'name'  => esc_html__( 'Blank', 'jogja-core' ),
								'value' => '_blank'
							 ),
					 ),
				 ),
				array(
					'name'		=> esc_html__( 'Link', 'jogja-core' ),
					'id' 		=> 'link',
					'type'		=> 'text',
					'class' 	=> 'widefat',
					'std' 		=> '',
				 ),
				array(
					'name'		=> esc_html__( 'Thumbnail Width', 'jogja-core' ),
					'id' 		=> 'thumbnail_width',
					'type'		=> 'text',
					'class' 	=> 'widefat',
					'std' 		=> 95,
				 ),
				array(
					'name'		=> esc_html__( 'Thumbnail Height', 'jogja-core' ),
					'id' 		=> 'thumbnail_height',
					'type'		=> 'text',
					'class' 	=> 'widefat',
					'std' 		=> 95,
				 ),

			 ); // fields array

			$args['options'] 	= array(
					'width'		=> 350,
					'height'	=> 350
				);

			// create widget
			$this->create_widget( $args );

			$this->defaults = array(
				'title'				=> esc_html__( 'Instagram Photo Gallery', 'jogja-core' ),
				'username'			=> '',
				'number'			=> 9,
				'target'			=> '_self',
				'link'				=> '',
				'thumbnail_width'	=> 95,
				'thumbnail_height'	=> 95,
			);

		}


		// Output function
		function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->defaults );

			extract( $args );
			extract( $instance );

			$title = apply_filters( 'widget_title', $title );

			printf( '%s', $before_widget );

			if ( ! empty( $title ) )
				printf( '%s %s %s', $before_title, $title, $after_title );

			if ( $username != '' ) {

				$media_array = $this->grab_instagram_gallery( $username, $number );

				if ( is_wp_error( $media_array ) ) {

					printf( $media_array->get_error_message() );

				} else {

					// filter for images only?
					if ( $images_only 	= apply_filters( 'jogja_images_only', FALSE ) )
						$media_array 	= array_filter( $media_array, array( $this, 'images_only' ) );

					$count 		= 1;
					$liclass 	= esc_attr( apply_filters( 'jogja_item_class', 'picture-item item-'.$count ) );
					$link_class = esc_attr( apply_filters( 'jogja_link_class', '' ) );
					$imgclass 	= esc_attr( apply_filters( 'jogja_img_class', '' ) );

					echo '<div class="gallery-list">';
					foreach ( $media_array as $item ) {
						$style = 'width='.$thumbnail_width.' height='.$thumbnail_height;
						echo '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. $link_class .'"><img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"  class="'. $imgclass .'" '.$style.' ></a>';
					}

					echo '</div>';
				}
			}

			if ( $link != '' ) { ?>
				<p class="clear">
					<a class="instagram-link" href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo esc_attr( $link ); ?></a>
				</p>
				<?php
			}

			printf( '%s', $after_widget );

		}

		function grab_instagram_gallery( $username, $slice = 9 ) {

			$username = strtolower( $username );

			if ( false === ( $instagram = get_transient( 'jogja-instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {

				$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

				if ( is_wp_error( $remote ) )
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'jogja-core' ) );

				if ( 200 != wp_remote_retrieve_response_code( $remote ) )
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'jogja-core' ) );

				$shards 		= explode( 'window._sharedData = ', $remote['body'] );
				$insta_json 	= explode( ';</script>', $shards[1] );
				$insta_array 	= json_decode( $insta_json[0], TRUE );

				if ( ! $insta_array )
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'jogja-core' ) );

				// old style
				if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
					$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
					$type 	= 'old';
				// new style
				} else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
					$type 	= 'new';
				} else {
					return new WP_Error( 'bad_josn_2', esc_html__( 'Instagram has returned invalid data.', 'jogja-core' ) );
				}

				if ( !is_array( $images ) )
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'jogja-core' ) );

				$instagram = array();

				switch ( $type ) {
					case 'old':
						foreach ( $images as $image ) {

							if ( $image['user']['username'] == $username ) {

								$image['link']						  	= preg_replace( "/^http:/i", "", $image['link'] );
								$image['images']['thumbnail']		   	= preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
								$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
								$image['images']['low_resolution']	  	= preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );

								$instagram[] = array(
									'description'   => $image['caption']['text'],
									'link'		  	=> $image['link'],
									'time'		  	=> $image['created_time'],
									'comments'	  	=> $image['comments']['count'],
									'likes'		 	=> $image['likes']['count'],
									'thumbnail'	 	=> $image['images']['thumbnail'],
									'large'		 	=> $image['images']['standard_resolution'],
									'small'		 	=> $image['images']['low_resolution'],
									'type'		  	=> $image['type']
								);
							}
						}
					break;
					default:
						foreach ( $images as $image ) {

							$image['display_src'] = preg_replace( "/^http:/i", "", $image['display_src'] );

							if ( $image['is_video']  == true ) {
								$type = 'video';
							} else {
								$type = 'image';
							}

							$instagram[] = array(
								'description'   => esc_html__( 'Instagram Image', 'jogja-core' ),
								'link'		  	=> '//instagram.com/p/' . $image['code'],
								'time'		  	=> $image['date'],
								'comments'	  	=> $image['comments']['count'],
								'likes'		 	=> $image['likes']['count'],
								'thumbnail'	 	=> $image['display_src'],
								'type'		  	=> $type
							);
						}
					break;
				}

				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient( 'jogja-instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
				}
			}

			if ( ! empty( $instagram ) ) {

				$instagram = unserialize( base64_decode( $instagram ) );
				return array_slice( $instagram, 0, $slice );

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'jogja-core' ) );

			}
		}

		function images_only( $media_item ) {

			if ( $media_item['type'] == 'image' )
				return true;

			return false;
		}

	}


}
