<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://costinbotez.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/admin
 * @author     Costin Botez <costibotez94@gmail.com>
 */
class Wp_Qpx_Api_Admin {

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
	 * The screen seetings hook suffix of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_screen_hook_suffix
	 */
	private $plugin_screen_hook_suffix;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private static $option_name = 'qpx';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-qpx-api-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-qpx-api-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'WP QPX API', 'wp-qpx-api' ),
			__( 'WP QPX API', 'wp-qpx-api' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {

		include_once 'partials/wp-qpx-api-admin-display.php';

	}

	/**
	 * Register plugin's options
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {

		// Add a General section
		add_settings_section(
			Wp_Qpx_Api_Admin::$option_name . '_general',
			__( 'General', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			Wp_Qpx_Api_Admin::$option_name . '_google_api_key',
			__( 'Google API Key', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_google_api_key_cb' ),
			$this->plugin_name,
			Wp_Qpx_Api_Admin::$option_name . '_general',
			array( 'label_for' => Wp_Qpx_Api_Admin::$option_name . '_google_api_key' )
		);

		add_settings_field(
			Wp_Qpx_Api_Admin::$option_name . '_google_api_url',
			__( 'Google API URL', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_google_api_url_cb' ),
			$this->plugin_name,
			Wp_Qpx_Api_Admin::$option_name . '_general',
			array( 'label_for' => Wp_Qpx_Api_Admin::$option_name . '_google_api_url' )
		);

		add_settings_field(
			Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id',
			__( 'CF7 Search Flight Form ID', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id_cb' ),
			$this->plugin_name,
			Wp_Qpx_Api_Admin::$option_name . '_general',
			array( 'label_for' => Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id' )
		);

		add_settings_field(
			Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id',
			__( 'CF7 Reservation Form ID', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id_cb' ),
			$this->plugin_name,
			Wp_Qpx_Api_Admin::$option_name . '_general',
			array( 'label_for' => Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id' )
		);

		add_settings_field(
			Wp_Qpx_Api_Admin::$option_name . '_max_solutions',
			__( 'Max Solutions', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_max_solutions_cb' ),
			$this->plugin_name,
			Wp_Qpx_Api_Admin::$option_name . '_general',
			array( 'label_for' => Wp_Qpx_Api_Admin::$option_name . '_max_solutions' )
		);

		add_settings_field(
			Wp_Qpx_Api_Admin::$option_name . '_listing_page',
			__( 'Listing Page', 'wp-qpx-api' ),
			array( $this, Wp_Qpx_Api_Admin::$option_name . '_listing_page_cb' ),
			$this->plugin_name,
			Wp_Qpx_Api_Admin::$option_name . '_general',
			array( 'label_for' => Wp_Qpx_Api_Admin::$option_name . '_listing_page' )
		);

		register_setting( $this->plugin_name, Wp_Qpx_Api_Admin::$option_name . '_google_api_key');
		register_setting( $this->plugin_name, Wp_Qpx_Api_Admin::$option_name . '_google_api_url');
		register_setting( $this->plugin_name, Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id');
		register_setting( $this->plugin_name, Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id');
		register_setting( $this->plugin_name, Wp_Qpx_Api_Admin::$option_name . '_max_solutions');
		register_setting( $this->plugin_name, Wp_Qpx_Api_Admin::$option_name . '_listing_page');

	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function qpx_general_cb() {

		echo '<p>' . __( 'Please change the settings accordingly.', 'wp-qpx-api' ) . '</p>';

	}

	/**
	 * Render the API Key field
	 *
	 * @since  1.0.0
	 */
	public function qpx_google_api_key_cb() {

		$google_api_key = get_option( Wp_Qpx_Api_Admin::$option_name . '_google_api_key' );
		?>
			<input type="text" style="width:350px" name="<?php echo Wp_Qpx_Api_Admin::$option_name . '_google_api_key'; ?>" id="<?php echo Wp_Qpx_Api_Admin::$option_name . '_google_api_key'; ?>" value="<?php echo $google_api_key; ?>" />
			<p class="description">Your unique Google API key. You can generate one from <a href="https://console.developers.google.com/apis/credentials" target="_blank">here</a></p>
		<?php
	}

	/**
	 * Render the API URL field
	 *
	 * @since  1.0.0
	 */
	public function qpx_google_api_url_cb() {

		$google_api_url = get_option( Wp_Qpx_Api_Admin::$option_name . '_google_api_url' );
		?>
			<input type="text" style="width:350px" name="<?php echo Wp_Qpx_Api_Admin::$option_name . '_google_api_url'; ?>" id="<?php echo Wp_Qpx_Api_Admin::$option_name . '_google_api_url'; ?>" value="<?php echo $google_api_url; ?>" />
			<p class="description">The main Google API Request URL</p>
		<?php
	}

	/**
	 * Render the CF7 Search Flights Form ID field
	 *
	 * @since  1.0.0
	 */
	public function qpx_cf7_search_flight_form_id_cb() {

		$cf7_search_flight_form_id = get_option( Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id' );
		?>
			<input type="text" style="width:350px" name="<?php echo Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id'; ?>" id="<?php echo Wp_Qpx_Api_Admin::$option_name . '_cf7_search_flight_form_id'; ?>" value="<?php echo $cf7_search_flight_form_id; ?>" />
			<p class="description">The Imported CF7 Form ID (Recommended: 1)</p>
		<?php
	}

	/**
	 * Render the CF7 Reservation Form ID field
	 *
	 * @since  1.0.0
	 */
	public function qpx_cf7_reservation_form_id_cb() {

		$cf7_reservation_form_id = get_option( Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id' );
		?>
			<input type="text" style="width:350px" name="<?php echo Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id'; ?>" id="<?php echo Wp_Qpx_Api_Admin::$option_name . '_cf7_reservation_form_id'; ?>" value="<?php echo $cf7_reservation_form_id; ?>" />
			<p class="description">The Imported CF7 Form ID (Recommended: 2)</p>
		<?php
	}

	/**
	 * Render the Max Solutions field
	 *
	 * @since  1.0.0
	 */
	public function qpx_max_solutions_cb() {

		$max_solutions = get_option( Wp_Qpx_Api_Admin::$option_name . '_max_solutions' );
		?>
			<input type="text" style="width:350px" name="<?php echo Wp_Qpx_Api_Admin::$option_name . '_max_solutions'; ?>" id="<?php echo Wp_Qpx_Api_Admin::$option_name . '_max_solutions'; ?>" value="<?php echo $max_solutions; ?>" />
			<p class="description">The maximum number of solutions per request (Minimum recommended: 10)</p>
		<?php
	}

	/**
	 * Render the listing page field
	 *
	 * @since  1.0.0
	 */
	public function qpx_listing_page_cb() {

		$listing_page = get_option( Wp_Qpx_Api_Admin::$option_name . '_listing_page' );
		$pages = get_pages();
		?>
			<select style="width:350px" name="<?php echo Wp_Qpx_Api_Admin::$option_name . '_listing_page'; ?>" id="<?php echo Wp_Qpx_Api_Admin::$option_name . '_listing_page'; ?>">
				<option value="">Select page</option>
				<?php if( count( $pages ) > 0 ) : ?>
					<?php foreach ( $pages as $page ) : ?>
						<option value="<?php echo $page->ID; ?>" <?php echo selected($listing_page, $page->ID); ?>><?php echo esc_attr($page->post_title); ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<p class="description">The content will be overwritten by the plugin</p>
		<?php
	}

	/**
	 * Add 'Settings' link in plugins listing
	 *
	 * @since  1.0.0
	 */
	public function add_action_links ( $links ) {

 		$mylinks = array(
 			'<a href="' . admin_url( 'options-general.php?page=wp-qpx-api' ) . '">Settings</a>',
 		);

		return array_merge( $links, $mylinks );

	}


}
