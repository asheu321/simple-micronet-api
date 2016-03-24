<?php
/*
Plugin Name: MicroNet simple API
Description: This is a simple api just for testing
Plugin URI: http://#
Author: Author
Author URI: http://#
Version: 1.0
License: GPL2
Text Domain: micronet-api
*/

/**
 * Micronet shortcode
 *
 * To showing api response through shortcode [show-micronet-api]
 * 
 * @return string       list of business directory
 */
function micronet_API_view( $atts ) {
	ob_start();
		echo '<div id="micronet-container" class="micronet-container"></div>';
	$html = ob_get_clean();

	return $html;
}
add_shortcode( 'show-micronet-api','micronet_API_view' );

/**
 * Enqueue scripts
 *
 * @param string $handle Script name
 * @param string $src Script url
 * @param array $deps (optional) Array of script names on which this script depends
 * @param string|bool $ver (optional) Script version (used for cache busting), set to null to disable
 * @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
 */
function micronet_scripts() {
	global $post;

	if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'show-micronet-api') ) {
		wp_enqueue_style( 'micronet-api', plugins_url( '/micronet-api.css', __FILE__ ) );
		wp_enqueue_script( 'micronet-api', plugins_url( '/micronet-api.js', __FILE__ ), array('jquery'), '1.0', false );
		wp_localize_script( 'micronet-api', 'micronet_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'loading_img' => '<img src="' . plugins_url( '/gears.gif', __FILE__ ) . '">'
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'micronet_scripts' );

function _micronet_api_callback() {
	
	$endpoint = 'http://api.micronetonline.com/v1/associations(1896)/members';
	$apikey = '8a783d25-cd2f-4abd-9116-18912ae62263';

	// Start curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint );
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Fiddler');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-ApiKey:'. $apikey,
            'Content-Type: application/json'
        )
    );

    $curl_response = curl_exec($ch);

    curl_close($ch);

    // Convert result (json) to an array
    $res = json_decode($curl_response, true);

    // Show all data as html
    $html = '<div class="micronet-data">';
	foreach ( $res as $data ) {
		$html .= '<div class="micronet-list-item">';
		
		foreach ($data as $key => $value) {
			$html .= '<div class="micronet-sub-item ' . $key . '"><label>' . $key . '</label><span>' . $value . '</span></div>';
		}
		
		$html .= '</div>';
	}
	$html .= '</div>';

	echo $html;

	die();
}
add_action( 'wp_ajax__micronet_api', '_micronet_api_callback' );
add_action( 'wp_ajax_nopriv__micronet_api', '_micronet_api_callback' );



