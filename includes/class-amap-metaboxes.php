<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Agrega el Meta Box principal.
 */
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

/**
 * Renderiza el HTML del Meta Box.
 */
function amap_render_meta_box( $post ) {
	wp_nonce_field( 'amap_save_action', 'amap_nonce' );

	$pin_top  = get_post_meta( $post->ID, '_amap_pin_top', true ) ?: '50';
	$pin_left = get_post_meta( $post->ID, '_amap_pin_left', true ) ?: '50';
	$image_id = get_post_meta( $post->ID, '_amap_image_id', true );
	
	$label1 = get_post_meta( $post->ID, '_amap_label_1', true );
	$label2 = get_post_meta( $post->ID, '_amap_label_2', true );
	$label3 = get_post_meta( $post->ID, '_amap_label_3', true );

	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
	$map_image_url = AMAP_PLUGIN_URL . 'assets/images/map-placeholder.jpg';
	?>
	
	<div class="amap-admin-wrapper">
		<div class="amap-admin-controls">
			
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
			
			<h4>Ubicación Geográfica</h4>
			<p class="description">Selecciona un país de la lista para ubicarlo automáticamente o haz clic en el mapa.</p>
			
			<div style="margin-bottom: 15px;">
				<label for="amap_country_selector"><strong>Ubicación Rápida:</strong></label>
				<select id="amap_country_selector" style="width: 100%;">
					<option value="">-- Seleccionar País --</option>
					
					<optgroup label="América del Sur">
						<option value="-34,-64" data-country="ar">Argentina</option>
						<option value="-16,-68" data-country="bo">Bolivia</option>
						<option value="-14,-51" data-country="br">Brasil</option>
						<option value="-33,-70" data-country="cl">Chile</option>
						<option value="4,-74" data-country="co">Colombia</option>
						<option value="-1,-78" data-country="ec">Ecuador</option>
						<option value="5,-58" data-country="gy">Guyana</option>
						<option value="-23,-58" data-country="py">Paraguay</option>
						<option value="-9,-75" data-country="pe">Perú</option>
						<option value="3,-56" data-country="sr">Surinam</option>
						<option value="-32,-55" data-country="uy">Uruguay</option>
						<option value="6,-66" data-country="ve">Venezuela</option>
					</optgroup>

					<optgroup label="América del Norte y Central">
						<option value="17,-61" data-country="ag">Antigua y Barbuda</option>
						<option value="25,-77" data-country="bs">Bahamas</option>
						<option value="13,-59" data-country="bb">Barbados</option>
						<option value="17,-88" data-country="bz">Belice</option>
						<option value="56,-106" data-country="ca">Canadá</option>
						<option value="9,-83" data-country="cr">Costa Rica</option>
						<option value="21,-77" data-country="cu">Cuba</option>
						<option value="15,-61" data-country="dm">Dominica</option>
						<option value="13,-88" data-country="sv">El Salvador</option>
						<option value="37,-95" data-country="us">Estados Unidos</option>
						<option value="12,-61" data-country="gd">Granada</option>
						<option value="15,-90" data-country="gt">Guatemala</option>
						<option value="18,-72" data-country="ht">Haití</option>
						<option value="15,-86" data-country="hn">Honduras</option>
						<option value="18,-77" data-country="jm">Jamaica</option>
						<option value="23,-102" data-country="mx">México</option>
						<option value="12,-86" data-country="ni">Nicaragua</option>
						<option value="8,-80" data-country="pa">Panamá</option>
						<option value="18,-70" data-country="do">República Dominicana</option>
						<option value="17,-62" data-country="kn">San Cristóbal y Nieves</option>
						<option value="13,-60" data-country="lc">Santa Lucía</option>
						<option value="10,-61" data-country="tt">Trinidad y Tobago</option>
					</optgroup>

					<optgroup label="Europa">
						<option value="41,20" data-country="al">Albania</option>
						<option value="51,10" data-country="de">Alemania</option>
						<option value="42,1" data-country="ad">Andorra</option>
						<option value="47,14" data-country="at">Austria</option>
						<option value="50,4" data-country="be">Bélgica</option>
						<option value="53,27" data-country="by">Bielorrusia</option>
						<option value="43,17" data-country="ba">Bosnia y Herzegovina</option>
						<option value="42,25" data-country="bg">Bulgaria</option>
						<option value="45,15" data-country="hr">Croacia</option>
						<option value="56,10" data-country="dk">Dinamarca</option>
						<option value="48,17" data-country="sk">Eslovaquia</option>
						<option value="46,14" data-country="si">Eslovenia</option>
						<option value="40,-3" data-country="es">España</option>
						<option value="58,26" data-country="ee">Estonia</option>
						<option value="61,24" data-country="fi">Finlandia</option>
						<option value="46,2" data-country="fr">Francia</option>
						<option value="39,22" data-country="gr">Grecia</option>
						<option value="47,19" data-country="hu">Hungría</option>
						<option value="53,-8" data-country="ie">Irlanda</option>
						<option value="64,-19" data-country="is">Islandia</option>
						<option value="41,12" data-country="it">Italia</option>
						<option value="56,24" data-country="lv">Letonia</option>
						<option value="47,9" data-country="li">Liechtenstein</option>
						<option value="55,23" data-country="lt">Lituania</option>
						<option value="49,6" data-country="lu">Luxemburgo</option>
						<option value="41,21" data-country="mk">Macedonia del Norte</option>
						<option value="35,14" data-country="mt">Malta</option>
						<option value="47,28" data-country="md">Moldavia</option>
						<option value="42,19" data-country="me">Montenegro</option>
						<option value="43,12" data-country="mc">Mónaco</option>
						<option value="60,8" data-country="no">Noruega</option>
						<option value="52,5" data-country="nl">Países Bajos</option>
						<option value="51,19" data-country="pl">Polonia</option>
						<option value="39,-8" data-country="pt">Portugal</option>
						<option value="55,-3" data-country="gb">Reino Unido</option>
						<option value="49,15" data-country="cz">República Checa</option>
						<option value="45,24" data-country="ro">Rumania</option>
						<option value="61,105" data-country="ru">Rusia</option>
						<option value="43,12" data-country="sm">San Marino</option>
						<option value="44,20" data-country="rs">Serbia</option>
						<option value="60,18" data-country="se">Suecia</option>
						<option value="46,8" data-country="ch">Suiza</option>
						<option value="48,31" data-country="ua">Ucrania</option>
						<option value="41,12" data-country="va">Vaticano</option>
					</optgroup>

					<optgroup label="Asia">
						<option value="33,65" data-country="af">Afganistán</option>
						<option value="23,46" data-country="sa">Arabia Saudita</option>
						<option value="40,47" data-country="am">Armenia</option>
						<option value="40,47" data-country="az">Azerbaiyán</option>
						<option value="23,90" data-country="bd">Bangladesh</option>
						<option value="26,50" data-country="bh">Baréin</option>
						<option value="27,90" data-country="bt">Bután</option>
						<option value="4,114" data-country="bn">Brunéi</option>
						<option value="12,104" data-country="kh">Camboya</option>
						<option value="25,51" data-country="qa">Catar</option>
						<option value="35,104" data-country="cn">China</option>
						<option value="38,127" data-country="kp">Corea del Norte</option>
						<option value="35,127" data-country="kr">Corea del Sur</option>
						<option value="23,53" data-country="ae">Emiratos Árabes Unidos</option>
						<option value="12,121" data-country="ph">Filipinas</option>
						<option value="42,43" data-country="ge">Georgia</option>
						<option value="20,78" data-country="in">India</option>
						<option value="-0,113" data-country="id">Indonesia</option>
						<option value="33,43" data-country="iq">Irak</option>
						<option value="32,53" data-country="ir">Irán</option>
						<option value="31,34" data-country="il">Israel</option>
						<option value="36,138" data-country="jp">Japón</option>
						<option value="30,35" data-country="jo">Jordania</option>
						<option value="48,66" data-country="kz">Kazajistán</option>
						<option value="41,74" data-country="kg">Kirguistán</option>
						<option value="29,47" data-country="kw">Kuwait</option>
						<option value="19,102" data-country="la">Laos</option>
						<option value="33,35" data-country="lb">Líbano</option>
						<option value="4,101" data-country="my">Malasia</option>
						<option value="3,73" data-country="mv">Maldivas</option>
						<option value="46,103" data-country="mn">Mongolia</option>
						<option value="21,95" data-country="mm">Myanmar (Birmania)</option>
						<option value="28,84" data-country="np">Nepal</option>
						<option value="21,55" data-country="om">Omán</option>
						<option value="30,69" data-country="pk">Pakistán</option>
						<option value="31,35" data-country="ps">Palestina</option>
						<option value="1,103" data-country="sg">Singapur</option>
						<option value="34,38" data-country="sy">Siria</option>
						<option value="7,80" data-country="lk">Sri Lanka</option>
						<option value="15,100" data-country="th">Tailandia</option>
						<option value="38,71" data-country="tj">Tayikistán</option>
						<option value="-8,125" data-country="tl">Timor Oriental</option>
						<option value="38,35" data-country="tr">Turquía</option>
						<option value="41,64" data-country="uz">Uzbekistán</option>
						<option value="14,108" data-country="vn">Vietnam</option>
						<option value="15,48" data-country="ye">Yemen</option>
					</optgroup>

					<optgroup label="Oceanía">
						<option value="-25,133" data-country="au">Australia</option>
						<option value="-17,178" data-country="fj">Fiyi</option>
						<option value="7,134" data-country="mh">Islas Marshall</option>
						<option value="-9,159" data-country="sb">Islas Salomón</option>
						<option value="1,173" data-country="ki">Kiribati</option>
						<option value="7,150" data-country="fm">Micronesia</option>
						<option value="-0,166" data-country="nr">Nauru</option>
						<option value="-40,174" data-country="nz">Nueva Zelanda</option>
						<option value="7,134" data-country="pw">Palaos</option>
						<option value="-6,143" data-country="pg">Papúa Nueva Guinea</option>
						<option value="-13,-172" data-country="ws">Samoa</option>
						<option value="-21,-175" data-country="to">Tonga</option>
						<option value="-8,178" data-country="tv">Tuvalu</option>
						<option value="-15,166" data-country="vu">Vanuatu</option>
					</optgroup>

					<optgroup label="África">
						<option value="-11,17" data-country="ao">Angola</option>
						<option value="28,1" data-country="dz">Argelia</option>
						<option value="9,2" data-country="bj">Benín</option>
						<option value="-22,24" data-country="bw">Botsuana</option>
						<option value="12,-1" data-country="bf">Burkina Faso</option>
						<option value="-3,29" data-country="bi">Burundi</option>
						<option value="16,-24" data-country="cv">Cabo Verde</option>
						<option value="3,11" data-country="cm">Camerún</option>
						<option value="15,19" data-country="td">Chad</option>
						<option value="-0,15" data-country="cg">Congo</option>
						<option value="7,-5" data-country="ci">Costa de Marfil</option>
						<option value="26,30" data-country="eg">Egipto</option>
						<option value="15,39" data-country="er">Eritrea</option>
						<option value="9,40" data-country="et">Etiopía</option>
						<option value="-0,9" data-country="ga">Gabón</option>
						<option value="13,-15" data-country="gm">Gambia</option>
						<option value="7,-1" data-country="gh">Ghana</option>
						<option value="9,-9" data-country="gn">Guinea</option>
						<option value="11,-15" data-country="gw">Guinea-Bisáu</option>
						<option value="1,10" data-country="gq">Guinea Ecuatorial</option>
						<option value="0,37" data-country="ke">Kenia</option>
						<option value="-29,27" data-country="ls">Lesoto</option>
						<option value="6,-9" data-country="lr">Liberia</option>
						<option value="26,17" data-country="ly">Libia</option>
						<option value="-18,47" data-country="mg">Madagascar</option>
						<option value="-13,34" data-country="mw">Malaui</option>
						<option value="17,-4" data-country="ml">Malí</option>
						<option value="31,-7" data-country="ma">Marruecos</option>
						<option value="-20,57" data-country="mu">Mauricio</option>
						<option value="21,-11" data-country="mr">Mauritania</option>
						<option value="-22,18" data-country="na">Namibia</option>
						<option value="17,8" data-country="ne">Níger</option>
						<option value="9,8" data-country="ng">Nigeria</option>
						<option value="4,18" data-country="cf">República Centroafricana</option>
						<option value="-4,21" data-country="cd">República Democrática del Congo</option>
						<option value="-1,29" data-country="rw">Ruanda</option>
						<option value="0,6" data-country="st">Santo Tomé y Príncipe</option>
						<option value="14,-14" data-country="sn">Senegal</option>
						<option value="-4,55" data-country="sc">Seychelles</option>
						<option value="8,-11" data-country="sl">Sierra Leona</option>
						<option value="5,46" data-country="so">Somalia</option>
						<option value="-26,31" data-country="sz">Suazilandia</option>
						<option value="-30,25" data-country="za">Sudáfrica</option>
						<option value="12,30" data-country="sd">Sudán</option>
						<option value="6,31" data-country="ss">Sudán del Sur</option>
						<option value="-6,34" data-country="tz">Tanzania</option>
						<option value="8,0" data-country="tg">Togo</option>
						<option value="33,9" data-country="tn">Túnez</option>
						<option value="1,32" data-country="ug">Uganda</option>
						<option value="11,42" data-country="dj">Yibuti</option>
						<option value="-13,27" data-country="zm">Zambia</option>
						<option value="-19,29" data-country="zw">Zimbabue</option>
					</optgroup>
				</select>
			</div>

			<label>Top (%): <input type="number" step="0.1" id="amap_pin_top" name="amap_pin_top" value="<?php echo esc_attr( $pin_top ); ?>"></label>
			<label>Left (%): <input type="number" step="0.1" id="amap_pin_left" name="amap_pin_left" value="<?php echo esc_attr( $pin_left ); ?>"></label>
		</div>

		<div class="amap-admin-preview">
			<img src="<?php echo esc_url( $map_image_url ); ?>" class="amap-map-img">
			<div class="amap-admin-pin" style="top: <?php echo $pin_top; ?>%; left: <?php echo $pin_left; ?>%;"></div>
		</div>
	</div>
	<?php
}

function amap_save_meta( $post_id ) {
	if ( ! isset( $_POST['amap_nonce'] ) || ! wp_verify_nonce( $_POST['amap_nonce'], 'amap_save_action' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$fields = array( 'amap_pin_top', 'amap_pin_left', 'amap_image_id', 'amap_label_1', 'amap_label_2', 'amap_label_3' );
	
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
	
	// Lógica de descarga automática de la bandera (sideload) si se proveyó URL de bandera pero no se subió una imagen
	if ( ! empty( $_POST['amap_flag_url'] ) && empty( $_POST['amap_image_id'] ) ) {
		$flag_url = esc_url_raw( $_POST['amap_flag_url'] );
		
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		
		$sideload_id = media_sideload_image( $flag_url, $post_id, null, 'id' );
		
		if ( ! is_wp_error( $sideload_id ) ) {
			update_post_meta( $post_id, '_amap_image_id', $sideload_id );
		}
	}
}
add_action( 'save_post', 'amap_save_meta' );