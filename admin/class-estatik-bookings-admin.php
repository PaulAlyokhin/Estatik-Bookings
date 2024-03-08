<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Estatik_Bookings
 * @subpackage Estatik_Bookings/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Estatik_Bookings
 * @subpackage Estatik_Bookings/admin
 * @author     Your Name <email@example.com>
 */
class Estatik_Bookings_Admin {

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
		 * defined in Estatik_Bookings_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Estatik_Bookings_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style('jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
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
		 * defined in Estatik_Bookings_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Estatik_Bookings_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-ui-datepicker');
	}

	/**
	 * Register custom post types
	 * @return void
	 */
	public function register_custom_post_types(): void {
		register_post_type(
			'booking',
			[
				'public' => true,
				'labels' => [
					'name' => __('Bookings', 'estatik-bookings'),
					'singular_name' => __('Booking', 'estatik-bookings'),
					'add_new' => __('Create Booking', 'estatik-bookings'),
					'add_new_item' => __('Create New Booking', 'estatik-bookings'),
					'edit_item' => __('Edit Booking', 'estatik-bookings'),
					'view_item' => __('View Booking', 'estatik-bookings'),
					'search_items' => __('Search Booking', 'estatik-bookings'),
				],
			]
		);
	}

	/**
	 * Add meta box for booking post type
	 * @return void
	 */
	public function add_booking_meta_box(): void {
		add_meta_box(
			'booking-meta-box',
			__('Booking Details', 'estatik-bookings'),
			[$this, 'display_booking_meta_box'],
			['booking']
		);
	}

	/**
	 * Display booking meta box
	 * @param $post
	 *
	 * @return void
	 */
	public function display_booking_meta_box($post): void {
		$start_date = get_post_meta($post->ID, 'start_date', true);
		$end_date = get_post_meta($post->ID, 'end_date', true);
		$address = get_post_meta($post->ID, 'address', true);

		wp_nonce_field( 'booking_nonce', 'booking_nonce' );

		include_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/estatik-bookings-meta-box.php';
	}

	/**
	 * Save booking meta data
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_booking_meta_box($post_id): void {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		if (!wp_verify_nonce($_POST['booking_nonce'], 'booking_nonce')) {
			return;
		}

		update_post_meta($post_id, 'start_date', sanitize_text_field( strtotime($_POST['start_date']) ));
		update_post_meta($post_id, 'end_date', sanitize_text_field( strtotime($_POST['end_date']) ));
		update_post_meta($post_id, 'address', sanitize_text_field($_POST['address']));
	}

	/**
	 * Output booking meta data in the booking content
	 * @param $content
	 *
	 * @return string
	 */
	public function modify_booking_content($content): string {
		if (is_single() && get_post_type() === 'booking') { // Single booking page
			if ($start_date = get_post_meta(get_the_ID(), 'start_date', true)) { // Start date is not empty
				$content .= sprintf('<p>%s %s</p>',
					__('Start date:', 'estatik-bookings'),
					date('d M Y H:i', $start_date)
				);
			}

			if ($end_date = get_post_meta(get_the_ID(), 'end_date', true)) { // End date is not empty
				$content .= sprintf('<p>%s %s</p>',
					__('End date:', 'estatik-bookings'),
					date('d M Y H:i', $end_date)
				);
			}

			if ($address = get_post_meta(get_the_ID(), 'address', true)) { // Address is not empty
				$content .= sprintf('<p>%s %s</p>
					<div id="map"></div>
					<script>
						(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
					    	key: "YOUR_API_KEY_HERE",
					    	v: "weekly",
					    });
  						
						async function initMap() {
						    const { Map } = await google.maps.importLibrary("maps");
						    var geocoder = new google.maps.Geocoder();

						    geocoder.geocode({ "address": "%s" }, function (results, status) { // Search for location by address
                                if (status === google.maps.GeocoderStatus.OK) { // Address found
                                    let map_element = document.getElementById("map");
									map_element.style.height = "500px";
                                    
								    var map = new google.maps.Map(map_element, { // Initialize map
								        zoom: 15,
								        mapTypeId: google.maps.MapTypeId.ROADMAP,
								    });
                                    
									map.setCenter(results[0].geometry.location);
									
									new google.maps.Marker({ // Initialize marker
										map: map,
										position: results[0].geometry.location
									});
								} else { // Address not found
									console.error("Geocode was not successful for the following reason: " + status);
								}
							});
						}

						initMap();
					</script>',
					__('Address:', 'estatik-bookings'),
					esc_html($address),
					esc_js($address)
				);
			}
		}

		return $content;
	}
}