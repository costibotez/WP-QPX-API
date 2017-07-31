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

				$flights_list = $this->search_for_flights( $front_end_fields );
				$this->save_to_file( $flights_list );
				// echo '<pre>'; print_r($flights_list); echo '</pre>'; exit;
			}
		}
	}

	/**
	 * Send CF7 submissions to QPX
	 *
	 * @since    1.0.0
	 */
	protected function search_for_flights( $front_end_fields ) {

        $key 		= get_option( 'qpx_google_api_key' );			// API Access key
        $url 		= get_option( 'qpx_google_api_url' ) . $key;		// API Request URL
        $solutions 	= get_option( 'qpx_max_solutions' );

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
        		'solutions' => $solutions,
				'refundable'=> false
        	)
        );

        // echo '<pre>'; print_r(json_encode($search_fields)); echo '</pre>'; exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($search_fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        // echo '<pre>'; print_r($result); echo '</pre>'; exit;
        $output = array();
        $output['success'] = true;
        if (curl_errno($ch)) {
            $output['success'] = false;
            $output['message'] = 'ERROR from curl_errno -> ' . curl_errno($ch) . ': ' . curl_error($ch);
        } else {
            $returnCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch ($returnCode) {
                case 200:
                    $output['success'] = false;
                    $output['message'] = "<p> API Connection: Success <br> Request: Failed <br>";
                    break;
                default:
                    $output['success'] = false;
                    $output['message'] = '<p>HTTP ERROR -> ' . $returnCode;
                    break;
            }
        }
        curl_close($ch);

        return $result;

    }

    /**
	 * Save the most recent flight query into a file
	 *
	 * @since    1.0.0
	 */
    protected function save_to_file( $flights_list ) {
    	file_put_contents( plugin_dir_path( __FILE__ ) . 'request.txt', $flights_list);
    }

	/**
	 * Redirect to custom 'Listing page'
	 *
	 * @since    1.0.0
	 */
    public function add_this_script_footer() {

    	if ( !empty( get_option( 'qpx_listing_page' ) ) ) {
	    	$listing_page = get_permalink( get_option( 'qpx_listing_page' ) ); ?>

			<script>
			document.addEventListener( 'wpcf7mailsent', function( event ) {
			    location = '<?php echo esc_attr( $listing_page ); ?>';
			}, false );
			</script>

		<?php }

	}

	/**
	 * Redirect to
	 *
	 * @since    1.0.0
	 */
	public function parse_search_request() {

		$request = file_get_contents( plugin_dir_path( __FILE__ ) . 'request.txt' );
		$trip_options = json_decode($request);
		// echo '<pre>'; print_r($trip_options->trips->tripOption); echo '</pre>';
		include_once 'partials/wp-qpx-api-public-display.php';

	}

	public static function convert_minutes_to_hours( $time, $format = '%02dh %02dmin' ) {

	    if ($time < 1) {
	        return;
	    }

	    $hours = floor($time / 60);
	    $minutes = ($time % 60);

	    return sprintf($format, $hours, $minutes);

	}

}
