<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://costinbotez.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/public
 * @author     Costin Botez <costibotez94@gmail.com>
 */
class Wp_Qpx_Api_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Qpx_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Qpx_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-qpx-api-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Qpx_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Qpx_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-qpx-api-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Track Contact Form 7 forms submissions
	 *
	 * @since    1.0.0
	 */
	public function track_cf7_post() {
		if ( $_POST ) {
			if ( isset( $_POST['_wpcf7'] ) && ( !empty( $_POST['_wpcf7'] ) ) ) {	// if it's a CF7 submission

			// echo '<pre>'; print_r($_POST); echo '</pre>'; exit;
				$search_form_id = get_option('qpx_cf7_search_flight_form_id');			// API Request URL
				$front_end_fields = array();	// empty array by default

				foreach ($_POST as $key => $value) {
					if ( strpos( $key, '_wpcf7' ) === false ) {	// filter ONLY front-end fields
						$front_end_fields[strtolower($key)] = $value;
					}
				}

				$this->search_for_flights( $front_end_fields );

			}
		}
	}

	/**
	 * Send CF7 submissions to FLG360
	 *
	 * @since    1.0.0
	 */
	protected function search_for_flights( $front_end_fields ) {

        $key = get_option('qpx_google_api_key');			// API Access key
        $url = get_option('qpx_google_api_url') . $key;		// API Request URL

        $search_fields = array(
        	'request' => array(
        		'passengers' => array(
        			'adultCount' 		=> $front_end_fields['menu-1'],
        			'childCount' 		=> $front_end_fields['menu-2'],
        			'infantInSeatCount' => $front_end_fields['menu-3'],
        			'seniorCount' 		=> $front_end_fields['menu-4'],
        		),
        		'slice'	=> array(
        			0 => array(
        				'origin' 		=> $front_end_fields['leaving-from'],
        				'destination' 	=> $front_end_fields['going-to'],
        				'date'			=> $front_end_fields['date-1'],
        				'preferredCabin'=> $front_end_fields['menu-5'],
        				'alliance'		=> $front_end_fields['menu-6'],
        			),
        			1 => array(
        				'origin' 		=> $front_end_fields['going-to'],
        				'destination' 	=> $front_end_fields['leaving-from'],
        				'date'			=> $front_end_fields['date-2'],
        				'preferredCabin'=> $front_end_fields['menu-5'],
        				'alliance'		=> $front_end_fields['menu-6'],
        			),
        		),
        		'solutions' => 20,
    			'refundable' => false
        	)
        );

        // $search_fields['request']['passengers']['adultCount'] = $front_end_fields['menu-1'];
        // $search_fields['request']['passengers']['childCount'] = $front_end_fields['menu-2'];
        // $search_fields['request']['passengers']['infantInSeatCount'] = $front_end_fields['menu-3'];
        // $search_fields['request']['passengers']['seniorCount'] = $front_end_fields['menu-4'];
        // $search_fields['request']['slice'][0]['origin'] = $front_end_fields['leaving-from'];
        // $search_fields['request']['slice'][0]['destination'] = $front_end_fields['going-to'];
        // $search_fields['request']['slice'][0]['date'] = $front_end_fields['date-1'];
        // $search_fields['request']['slice'][0]['preferredCabin'] = $front_end_fields['date-1'];
        // $search_fields['request']['slice'][0]['alliance'] = $front_end_fields['date-1'];

        // $search_fields['request']['slice'][1]['origin'] = $front_end_fields['going-to'];
        // $search_fields['request']['slice'][1]['destination'] = $front_end_fields['leaving-from'];
        // $search_fields['request']['slice'][1]['date'] = $front_end_fields['date-2'];
        // $search_fields['request']['slice'][1]['preferredCabin'] = $front_end_fields['menu-5'];
        // $search_fields['request']['slice'][1]['alliance'] = $front_end_fields['menu-6'];

        // echo '<pre>'; print_r(json_encode($search_fields)); echo '</pre>'; exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($search_fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        echo '<pre>'; print_r($result); echo '</pre>'; exit;
        $output = array();
        $output['success'] = true;
        if (curl_errno($ch)) {
            $output['success'] = false;
            $output['message'] = 'ERROR from curl_errno -> ' . curl_errno($ch) . ': ' . curl_error($ch);
        } else {
            $returnCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($returnCode) {
                case 200:
                    $dom->loadXML($result);
                    if ($dom->getElementsByTagName('status')->item(0)->textContent == "0") {
                        //good request
                        $output['message'] = "<p> Response Status: Passed - Message: " . $dom->getElementsByTagName('message')->item(0)->textContent;
                        $output['message'] .= "<p> FLG NUMBER: " . $dom->getElementsByTagName('id')->item(0)->textContent;
                        $output['flgNo'] = $dom->getElementsByTagName('id')->item(0)->textContent;
                        update_user_meta( $user_id, 'lead_key', $output['flgNo'] );
                        return $output;
                    } else {
                        $output['success'] = false;
                        $output['message'] = "<p> API Connection: Success - Lead Entry: Failed - Reason: " . $dom->getElementsByTagName('message')->item(0)->textContent;
                    }
                    break;
                default:
                    $output['success'] = false;
                    $output['message'] = '<p>HTTP ERROR -> ' . $returnCode;
                    break;
            }
        }
        curl_close($ch);

        return $output;

    }

}
