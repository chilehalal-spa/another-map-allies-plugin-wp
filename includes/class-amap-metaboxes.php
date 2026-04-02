<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function amap_add_meta_boxes() {
	add_meta_box( 
		'amap_config_meta', 
		__( 'Configuración del Aliado', 'amap-domain' ), 
		'amap_render_meta_box', 
		'amap_ally', 
		'normal', 
		'high' 
	);
}
add_action( 'add_meta_boxes', 'amap_add_meta_boxes' );

function amap_get_world_countries_data() {
	return array(
		'América del Sur' => array(
			'ar' => array('Argentina', -38.4161, -63.6167),
			'bo' => array('Bolivia', -16.2902, -68.1193),
			'br' => array('Brasil', -14.2350, -51.9253),
			'cl' => array('Chile', -35.6751, -71.5430),
			'co' => array('Colombia', 4.5709, -74.2973),
			'ec' => array('Ecuador', -1.8312, -78.1834),
			'fk' => array('Islas Malvinas (Falkland)', -51.7963, -59.5236),
			'gf' => array('Guayana Francesa', 3.9339, -53.1258),
			'gy' => array('Guyana', 4.8604, -58.9302),
			'py' => array('Paraguay', -23.4425, -58.4438),
			'pe' => array('Perú', -9.1900, -75.0152),
			'sr' => array('Surinam', 3.9193, -56.0278),
			'uy' => array('Uruguay', -32.5228, -55.7658),
			've' => array('Venezuela', 6.4238, -66.5897)
		),
		'América del Norte y Central' => array(
			'ag' => array('Antigua y Barbuda', 17.0608, -61.7964),
			'bs' => array('Bahamas', 25.0343, -77.3963),
			'bb' => array('Barbados', 13.1939, -59.5432),
			'bz' => array('Belice', 17.1899, -88.4976),
			'bm' => array('Bermudas', 32.3214, -64.7505),
			'ca' => array('Canadá', 56.1304, -106.3468),
			'cr' => array('Costa Rica', 9.7489, -83.7534),
			'cu' => array('Cuba', 21.5218, -77.7812),
			'cw' => array('Curazao', 12.1696, -68.9900),
			'dm' => array('Dominica', 15.4150, -61.3710),
			'sv' => array('El Salvador', 13.7942, -88.8965),
			'us' => array('Estados Unidos', 37.0902, -95.7129),
			'gl' => array('Groenlandia', 71.7069, -42.6043),
			'gd' => array('Granada', 12.1165, -61.6790),
			'gt' => array('Guatemala', 15.7835, -90.2308),
			'ht' => array('Haití', 18.9712, -72.2852),
			'hn' => array('Honduras', 15.2000, -86.2419),
			'jm' => array('Jamaica', 18.1096, -77.2975),
			'mx' => array('México', 23.6345, -102.5528),
			'ni' => array('Nicaragua', 12.8654, -85.2072),
			'pa' => array('Panamá', 8.5380, -80.7821),
			'pr' => array('Puerto Rico', 18.2208, -66.5901),
			'do' => array('República Dominicana', 18.7357, -70.1627),
			'kn' => array('San Cristóbal y Nieves', 17.3578, -62.7830),
			'vc' => array('San Vicente y las Granadinas', 13.2528, -61.1971),
			'lc' => array('Santa Lucía', 13.9094, -60.9789),
			'tt' => array('Trinidad y Tobago', 10.6918, -61.2225)
		),
		'Europa' => array(
			'al' => array('Albania', 41.1533, 20.1683),
			'de' => array('Alemania', 51.1657, 10.4515),
			'ad' => array('Andorra', 42.5063, 1.5218),
			'at' => array('Austria', 47.5162, 14.5501),
			'be' => array('Bélgica', 50.5039, 4.4699),
			'by' => array('Bielorrusia', 53.7098, 27.9534),
			'ba' => array('Bosnia y Herzegovina', 43.9159, 17.6791),
			'bg' => array('Bulgaria', 42.7339, 25.4858),
			'hr' => array('Croacia', 45.1000, 15.2000),
			'dk' => array('Dinamarca', 56.2639, 9.5018),
			'sk' => array('Eslovaquia', 48.6690, 19.6990),
			'si' => array('Eslovenia', 46.1512, 14.9955),
			'es' => array('España', 40.4637, -3.7492),
			'ee' => array('Estonia', 58.5953, 25.0136),
			'fi' => array('Finlandia', 61.9241, 25.7482),
			'fr' => array('Francia', 46.2276, 2.2137),
			'gr' => array('Grecia', 39.0742, 21.8243),
			'hu' => array('Hungría', 47.1625, 19.5033),
			'ie' => array('Irlanda', 53.4129, -8.2439),
			'is' => array('Islandia', 64.9631, -19.0208),
			'it' => array('Italia', 41.8719, 12.5674),
			'xk' => array('Kosovo', 42.6026, 20.9029),
			'lv' => array('Letonia', 56.8796, 24.6032),
			'li' => array('Liechtenstein', 47.1660, 9.5554),
			'lt' => array('Lituania', 55.1694, 23.8813),
			'lu' => array('Luxemburgo', 49.8153, 6.1296),
			'mk' => array('Macedonia del Norte', 41.6086, 21.7453),
			'mt' => array('Malta', 35.9375, 14.3754),
			'md' => array('Moldavia', 47.4116, 28.3699),
			'mc' => array('Mónaco', 43.7384, 7.4246),
			'me' => array('Montenegro', 42.7087, 19.3744),
			'no' => array('Noruega', 60.4720, 8.4689),
			'nl' => array('Países Bajos', 52.1326, 5.2913),
			'pl' => array('Polonia', 51.9194, 19.1451),
			'pt' => array('Portugal', 39.3999, -8.2245),
			'gb' => array('Reino Unido', 55.3781, -3.4360),
			'cz' => array('República Checa', 49.8175, 15.4730),
			'ro' => array('Rumania', 45.9432, 24.9668),
			'ru' => array('Rusia', 61.5240, 105.3188),
			'sm' => array('San Marino', 43.9424, 12.4578),
			'rs' => array('Serbia', 44.0165, 21.0059),
			'se' => array('Suecia', 60.1282, 18.6435),
			'ch' => array('Suiza', 46.8182, 8.2275),
			'ua' => array('Ucrania', 48.3794, 31.1656),
			'va' => array('Vaticano', 41.9029, 12.4534)
		),
		'Asia' => array(
			'af' => array('Afganistán', 33.9391, 67.7100),
			'sa' => array('Arabia Saudita', 23.8859, 45.0792),
			'am' => array('Armenia', 40.0691, 45.0382),
			'az' => array('Azerbaiyán', 40.1431, 47.5769),
			'bd' => array('Bangladesh', 23.6850, 90.3563),
			'bh' => array('Baréin', 25.9304, 50.6378),
			'mm' => array('Birmania (Myanmar)', 21.9139, 95.9562),
			'bn' => array('Brunéi', 4.5353, 114.7277),
			'bt' => array('Bután', 27.5142, 90.4336),
			'kh' => array('Camboya', 12.5657, 104.9910),
			'qa' => array('Catar', 25.3548, 51.1839),
			'cn' => array('China', 35.8617, 104.1954),
			'cy' => array('Chipre', 35.1264, 33.4299),
			'kp' => array('Corea del Norte', 40.3399, 127.5101),
			'kr' => array('Corea del Sur', 35.9078, 127.7669),
			'ae' => array('Emiratos Árabes Unidos', 23.4241, 53.8478),
			'ph' => array('Filipinas', 12.8797, 121.7740),
			'ge' => array('Georgia', 42.3154, 43.3569),
			'hk' => array('Hong Kong', 22.3964, 114.1095),
			'in' => array('India', 20.5937, 78.9629),
			'id' => array('Indonesia', -0.7893, 113.9213),
			'iq' => array('Irak', 33.2232, 43.6793),
			'ir' => array('Irán', 32.4279, 53.6880),
			'il' => array('Israel', 31.0461, 34.8516),
			'jp' => array('Japón', 36.2048, 138.2529),
			'jo' => array('Jordania', 30.5852, 36.2384),
			'kz' => array('Kazajistán', 48.0196, 66.9237),
			'kg' => array('Kirguistán', 41.2044, 74.7661),
			'kw' => array('Kuwait', 29.3117, 47.4818),
			'la' => array('Laos', 19.8563, 102.4955),
			'lb' => array('Líbano', 33.8547, 35.8623),
			'mo' => array('Macao', 22.1987, 113.5439),
			'my' => array('Malasia', 4.2105, 101.9758),
			'mv' => array('Maldivas', 3.2028, 73.2207),
			'mn' => array('Mongolia', 46.8625, 103.8467),
			'np' => array('Nepal', 28.3949, 84.1240),
			'om' => array('Omán', 21.4735, 55.9754),
			'pk' => array('Pakistán', 30.3753, 69.3451),
			'ps' => array('Palestina', 31.9474, 35.2272),
			'sg' => array('Singapur', 1.3521, 103.8198),
			'sy' => array('Siria', 34.8021, 38.9968),
			'lk' => array('Sri Lanka', 7.8731, 80.7718),
			'th' => array('Tailandia', 15.8700, 100.9925),
			'tw' => array('Taiwán', 23.6978, 120.9605),
			'tj' => array('Tayikistán', 38.8610, 71.2761),
			'tl' => array('Timor Oriental', -8.8742, 125.7275),
			'tm' => array('Turkmenistán', 38.9697, 59.5563),
			'tr' => array('Turquía', 38.9637, 35.2433),
			'uz' => array('Uzbekistán', 41.3775, 64.5853),
			'vn' => array('Vietnam', 14.0583, 108.2772),
			'ye' => array('Yemen', 15.5527, 48.5164)
		),
		'África' => array(
			'ao' => array('Angola', -11.2027, 17.8739),
			'dz' => array('Argelia', 28.0339, 1.6596),
			'bj' => array('Benín', 9.3077, 2.3158),
			'bw' => array('Botsuana', -22.3285, 24.6849),
			'bf' => array('Burkina Faso', 12.2383, -1.5616),
			'bi' => array('Burundi', -3.3731, 29.9189),
			'cv' => array('Cabo Verde', 16.0021, -24.0132),
			'cm' => array('Camerún', 7.3697, 12.3547),
			'td' => array('Chad', 15.4542, 18.7322),
			'km' => array('Comoras', -11.6455, 43.3333),
			'cg' => array('Congo', -0.2280, 15.8277),
			'ci' => array('Costa de Marfil', 7.5400, -5.5471),
			'eg' => array('Egipto', 26.8206, 30.8025),
			'er' => array('Eritrea', 15.1794, 39.7823),
			'et' => array('Etiopía', 9.1450, 40.4897),
			'ga' => array('Gabón', -0.8037, 11.6094),
			'gm' => array('Gambia', 13.4432, -15.3101),
			'gh' => array('Ghana', 7.9465, -1.0232),
			'gn' => array('Guinea', 9.9456, -9.6966),
			'gw' => array('Guinea-Bisáu', 11.8037, -15.1804),
			'gq' => array('Guinea Ecuatorial', 1.6508, 10.2679),
			'ke' => array('Kenia', -0.0236, 37.9062),
			'ls' => array('Lesoto', -29.6100, 28.2336),
			'lr' => array('Liberia', 6.4281, -9.4295),
			'ly' => array('Libia', 26.3351, 17.2283),
			'mg' => array('Madagascar', -18.7669, 46.8691),
			'mw' => array('Malaui', -13.2543, 34.3015),
			'ml' => array('Malí', 17.5707, -3.9962),
			'ma' => array('Marruecos', 31.7917, -7.0926),
			'mu' => array('Mauricio', -20.3484, 57.5522),
			'mr' => array('Mauritania', 21.0079, -10.9408),
			'mz' => array('Mozambique', -18.6657, 35.5296),
			'na' => array('Namibia', -22.9576, 18.4904),
			'ne' => array('Níger', 17.6078, 8.0817),
			'ng' => array('Nigeria', 9.0820, 8.6753),
			'cf' => array('República Centroafricana', 6.6111, 20.9394),
			'cd' => array('R.D. del Congo', -4.0383, 21.7587),
			'rw' => array('Ruanda', -1.9403, 29.8739),
			'st' => array('Santo Tomé y Príncipe', 0.1864, 6.6131),
			'sn' => array('Senegal', 14.4974, -14.4524),
			'sc' => array('Seychelles', -4.6796, 55.4920),
			'sl' => array('Sierra Leona', 8.4606, -11.7799),
			'so' => array('Somalia', 5.1521, 46.1996),
			'sz' => array('Suazilandia (Esuatini)', -26.5225, 31.4659),
			'za' => array('Sudáfrica', -30.5595, 22.9375),
			'sd' => array('Sudán', 12.8628, 30.2176),
			'ss' => array('Sudán del Sur', 6.8770, 31.3070),
			'tz' => array('Tanzania', -6.3690, 34.8888),
			'tg' => array('Togo', 8.6195, 0.8248),
			'tn' => array('Túnez', 33.8869, 9.5375),
			'ug' => array('Uganda', 1.3733, 32.2903),
			'dj' => array('Yibuti', 11.8251, 42.5903),
			'zm' => array('Zambia', -13.1339, 27.8493),
			'zw' => array('Zimbabue', -19.0154, 29.1549)
		),
		'Oceanía' => array(
			'au' => array('Australia', -25.2744, 133.7751),
			'fj' => array('Fiyi', -17.7134, 178.0650),
			'gu' => array('Guam', 13.4443, 144.7937),
			'mh' => array('Islas Marshall', 7.1315, 171.1845),
			'sb' => array('Islas Salomón', -9.6457, 160.1562),
			'ki' => array('Kiribati', -3.3704, -168.7340),
			'fm' => array('Micronesia', 7.4256, 150.5508),
			'nr' => array('Nauru', -0.5228, 166.9315),
			'nc' => array('Nueva Caledonia', -20.9043, 165.6180),
			'nz' => array('Nueva Zelanda', -40.9006, 174.8860),
			'pw' => array('Palaos', 7.5150, 134.5825),
			'pg' => array('Papúa Nueva Guinea', -6.3150, 143.9555),
			'pf' => array('Polinesia Francesa', -17.6797, -149.4068),
			'ws' => array('Samoa', -13.7590, -172.1046),
			'as' => array('Samoa Americana', -14.2710, -170.1322),
			'to' => array('Tonga', -21.1790, -175.1982),
			'tv' => array('Tuvalu', -7.1095, 177.6493),
			'vu' => array('Vanuatu', -15.3767, 166.9592)
		)
	);
}

function amap_render_meta_box( $post ) {
	wp_nonce_field( 'amap_save_action', 'amap_nonce' );

	$lat      = get_post_meta( $post->ID, '_amap_lat', true ) ?: '0';
	$lng      = get_post_meta( $post->ID, '_amap_lng', true ) ?: '0';
	$image_id = get_post_meta( $post->ID, '_amap_image_id', true );
	
	$label1 = get_post_meta( $post->ID, '_amap_label_1', true );
	$label2 = get_post_meta( $post->ID, '_amap_label_2', true );
	$label3 = get_post_meta( $post->ID, '_amap_label_3', true );

	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
	$countries_data = amap_get_world_countries_data();
	?>
	<div class="amap-admin-wrapper">
		<div class="amap-admin-controls" style="width: 100%; max-width: 600px;">
			
			<h4>Logo del Aliado</h4>
			<div class="amap-image-uploader">
				<input type="hidden" name="amap_image_id" id="amap_image_id" value="<?php echo esc_attr( $image_id ); ?>">
				<input type="hidden" name="amap_flag_url" id="amap_flag_url" value="">
				
				<div id="amap_image_preview" style="margin-bottom: 10px; width: 100px; height: 100px; background: #f0f0f1; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; overflow: hidden;">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" style="max-width:100%; max-height:100%;">
					<?php else : ?>
						<span style="color:#aaa; font-size:12px;">Sin Imagen</span>
					<?php endif; ?>
				</div>
				<button type="button" class="button" id="amap_upload_btn"><?php _e( 'Elegir Imagen', 'amap-domain' ); ?></button>
				<button type="button" class="button" id="amap_remove_btn" style="<?php echo $image_url ? '' : 'display:none;'; ?> color: #b32d2e;"><?php _e( 'Quitar', 'amap-domain' ); ?></button>
			</div>
			
			<hr>
			<h4>Etiquetas Informativas</h4>
			<label>Etiqueta 1: <input type="text" name="amap_label_1" value="<?php echo esc_attr( $label1 ); ?>" placeholder="Ej: País"></label>
			<label>Etiqueta 2: <input type="text" name="amap_label_2" value="<?php echo esc_attr( $label2 ); ?>" placeholder="Ej: Sector"></label>
			<label>Etiqueta 3: <input type="text" name="amap_label_3" value="<?php echo esc_attr( $label3 ); ?>" placeholder="Ej: Año"></label>
			
			<hr>
			<h4>Ubicación Geográfica (Latitud / Longitud)</h4>
			<div style="margin-bottom: 15px;">
				<label for="amap_country_selector"><strong>Autocompletar por País:</strong></label>
				<select id="amap_country_selector" style="width: 100%; max-width: 300px;">
					<option value="">-- Seleccionar País --</option>
					<?php foreach ( $countries_data as $region => $countries ) : ?>
						<optgroup label="<?php echo esc_attr( $region ); ?>">
							<?php 
							// Ordenar alfabéticamente dentro del grupo para mejor UX
							uasort( $countries, function($a, $b) { return strcmp($a[0], $b[0]); } );
							foreach ( $countries as $iso => $data ) : 
							?>
								<option value="<?php echo esc_attr( $data[1] . ',' . $data[2] ); ?>" data-country="<?php echo esc_attr( $iso ); ?>">
									<?php echo esc_html( $data[0] ); ?>
								</option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select>
			</div>

			<label>Latitud: <input type="number" step="0.000001" id="amap_lat" name="amap_lat" value="<?php echo esc_attr( $lat ); ?>"></label>
			<label>Longitud: <input type="number" step="0.000001" id="amap_lng" name="amap_lng" value="<?php echo esc_attr( $lng ); ?>"></label>
		</div>
	</div>
	<?php
}

function amap_save_meta( $post_id ) {
	if ( ! isset( $_POST['amap_nonce'] ) || ! wp_verify_nonce( $_POST['amap_nonce'], 'amap_save_action' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$fields = array( 'amap_lat', 'amap_lng', 'amap_image_id', 'amap_label_1', 'amap_label_2', 'amap_label_3' );
	
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
	
	if ( ! empty( $_POST['amap_flag_url'] ) && empty( $_POST['amap_image_id'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		
		$sideload_id = media_sideload_image( esc_url_raw( $_POST['amap_flag_url'] ), $post_id, null, 'id' );
		if ( ! is_wp_error( $sideload_id ) ) update_post_meta( $post_id, '_amap_image_id', $sideload_id );
	}
}
add_action( 'save_post', 'amap_save_meta' );