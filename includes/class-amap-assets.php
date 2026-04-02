<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class AMAP_Assets {
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ) );
	}

	public static function enqueue_frontend() {
		// jsVectorMap Core & Map Data (CDN)
		wp_enqueue_style( 'jsvectormap-css', 'https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css', array(), '1.5.3' );
		wp_enqueue_script( 'jsvectormap-js', 'https://cdn.jsdelivr.net/npm/jsvectormap', array(), '1.5.3', true );
		wp_enqueue_script( 'jsvectormap-world', 'https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js', array( 'jsvectormap-js' ), '1.5.3', true );

		wp_enqueue_style( 'amap-style', AMAP_PLUGIN_URL . 'assets/css/amap-style.css', array(), '6.0' );
		wp_enqueue_script( 'amap-frontend-js', AMAP_PLUGIN_URL . 'assets/js/amap-frontend.js', array( 'jsvectormap-world' ), '6.0', true );
	}

	public static function enqueue_admin( $hook ) {
		global $post;
		$is_amap_screen = ( 'post.php' === $hook || 'post-new.php' === $hook ) && isset( $post ) && 'amap_ally' === $post->post_type;

		if ( $is_amap_screen ) {
			wp_enqueue_media(); 
			wp_enqueue_style( 'amap-admin-css', AMAP_PLUGIN_URL . 'assets/admin/css/amap-admin.css', array(), '6.0' );
			wp_enqueue_script( 'amap-admin-js', AMAP_PLUGIN_URL . 'assets/admin/js/amap-admin.js', array( 'jquery' ), '6.0', true );
		}
	}
}
AMAP_Assets::init();