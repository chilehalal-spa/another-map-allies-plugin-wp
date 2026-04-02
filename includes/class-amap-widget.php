<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class AMAP_Grid_Map_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct( 
			'amap_grid_map', 
			__( 'Mapa con Aliados (Completo)', 'amap-domain' ), 
			array( 'description' => __( 'Distribuye los aliados usando jsVectorMap.', 'amap-domain' ) ) 
		);
	}

	public function widget( $args, $instance ) {
		$allies_query = new WP_Query( array(
			'post_type'      => 'amap_ally',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		) );
		
		$map_color = ! empty( $instance['map_color'] ) ? $instance['map_color'] : '#e9ecef';

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];

		if ( $allies_query->have_posts() ) : 
			
			$valid_posts = array();
			$map_markers = array();

			foreach ( $allies_query->get_posts() as $post ) {
				$lat = get_post_meta( $post->ID, '_amap_lat', true );
				$lng = get_post_meta( $post->ID, '_amap_lng', true );
				
				if ( $lat !== '' && $lng !== '' ) {
					$norm_top  = ( 90 - (float) $lat ) / 180 * 100;
					$norm_left = ( (float) $lng + 180 ) / 360 * 100;

					$valid_posts[] = array(
						'post'      => $post,
						'lat'       => (float) $lat,
						'lng'       => (float) $lng,
						'norm_top'  => $norm_top,
						'norm_left' => $norm_left
					);

					$map_markers[] = array(
						'name'   => $post->post_title,
						'coords' => array( (float) $lat, (float) $lng ),
						'id'     => $post->ID
					);
				}
			}

			$total = count( $valid_posts );
			$share_unit = $total / 6;
			$limit_horizontal = max( 1, ceil( $share_unit * 2 ) ); 
			$limit_vertical   = max( 1, ceil( $share_unit * 1 ) );

			$zones = array( 'top' => array(), 'right' => array(), 'bottom' => array(), 'left' => array() );

			foreach ( $valid_posts as $item ) {
				$distances = array(
					'top'    => $item['norm_top'],
					'bottom' => 100 - $item['norm_top'],
					'left'   => $item['norm_left'],
					'right'  => 100 - $item['norm_left']
				);
				asort( $distances );

				$assigned = false;
				foreach ( $distances as $zone_name => $dist ) {
					$current_limit = ( $zone_name === 'top' || $zone_name === 'bottom' ) ? $limit_horizontal : $limit_vertical;
					if ( count( $zones[ $zone_name ] ) < $current_limit ) {
						$zones[ $zone_name ][] = $item; 
						$assigned = true;
						break;
					}
				}
				if ( ! $assigned ) $zones[ array_key_first( $distances ) ][] = $item;
			}

			usort( $zones['top'], function($a, $b) { return $a['norm_left'] <=> $b['norm_left']; } );
			usort( $zones['bottom'], function($a, $b) { return $a['norm_left'] <=> $b['norm_left']; } );
			usort( $zones['left'], function($a, $b) { return $a['norm_top'] <=> $b['norm_top']; } );
			usort( $zones['right'], function($a, $b) { return $a['norm_top'] <=> $b['norm_top']; } );

			foreach ( $zones as $key => $items ) {
				$zones[ $key ] = array_column( $items, 'post' );
			}

			?>
			<div class="amap-wrapper">
				<svg class="amap-global-svg"></svg>
				
				<?php $this->render_zone( 'top', $zones['top'] ); $this->render_zone( 'left', $zones['left'] ); ?>
				
				<div class="amap-map-section" style="width: 100%; height: 400px; min-height: 300px; position: relative;">
					<div id="amap-vmap-container" 
						 data-markers="<?php echo esc_attr( wp_json_encode( $map_markers ) ); ?>" 
						 data-map-color="<?php echo esc_attr( $map_color ); ?>"
						 style="width: 100%; height: 100%;"></div>
				</div>

				<?php $this->render_zone( 'right', $zones['right'] ); $this->render_zone( 'bottom', $zones['bottom'] ); ?>
			</div>

		<?php endif; 
		wp_reset_postdata();
		echo $args['after_widget'];
	}

	private function render_zone( $zone_name, $posts ) {
		echo '<div class="amap-zone amap-zone-' . esc_attr( $zone_name ) . '">';
		foreach ( $posts as $post ) {
			$img_id  = get_post_meta( $post->ID, '_amap_image_id', true );
			$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
			?>
			<div class="amap-grid-item" data-id="<?php echo esc_attr( $post->ID ); ?>">
				<div class="amap-logo-box">
					<?php if ( $img_url ) : ?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $post->post_title ); ?>" class="amap-flag-img">
					<?php else : ?>
						<span class="amap-no-img">?</span>
					<?php endif; ?>
				</div>
				<div class="amap-ally-name"><?php echo esc_html( $post->post_title ); ?></div>
			</div>
			<?php
		}
		echo '</div>';
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Nuestros Aliados', 'amap-domain' );
		$map_color = ! empty( $instance['map_color'] ) ? $instance['map_color'] : '#e9ecef';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'map_color' ) ); ?>"><?php _e( 'Color de los Continentes:', 'amap-domain' ); ?></label><br>
			<input id="<?php echo esc_attr( $this->get_field_id( 'map_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'map_color' ) ); ?>" type="color" value="<?php echo esc_attr( $map_color ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) { 
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['map_color'] = ( ! empty( $new_instance['map_color'] ) ) ? sanitize_hex_color( $new_instance['map_color'] ) : '#e9ecef';
		return $instance; 
	}
}

add_action( 'widgets_init', function() { register_widget( 'AMAP_Grid_Map_Widget' ); } );