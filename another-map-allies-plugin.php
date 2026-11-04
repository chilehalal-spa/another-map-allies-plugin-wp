<?php
/*
Plugin Name: Another Map Allies Plugin
Plugin URI: https://github.com/chilehalal-spa/another-map-allies-plugin-wp
Description: Grid de aliados con carga de imágenes personalizada y mapa de conexiones. (Estructura Modular)
Version: 1.7.0
Author: Zumito
Author URI: https://github.com/chomusuke-png
License: GPL2
Requires at least: 5.8
Update URI: https://github.com/chilehalal-spa/another-map-allies-plugin-wp
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Actualizaciones desde las releases de GitHub
require_once __DIR__ . '/includes/class-chilehalal-github-updater.php';
Chilehalal_GitHub_Updater_V1::register( __FILE__, 'chilehalal-spa/another-map-allies-plugin-wp' );

// 1. Definir Constantes
define( 'AMAP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AMAP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// 2. Cargar Módulos (Includes)
require_once AMAP_PLUGIN_DIR . 'includes/class-amap-cpt.php';
require_once AMAP_PLUGIN_DIR . 'includes/class-amap-metaboxes.php';
require_once AMAP_PLUGIN_DIR . 'includes/class-amap-assets.php';
require_once AMAP_PLUGIN_DIR . 'includes/class-amap-widget.php';
require_once AMAP_PLUGIN_DIR . 'includes/class-amap-import-export.php';