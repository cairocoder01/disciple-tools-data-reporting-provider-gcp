<?php
/**
 * Plugin Name: Disciple Tools - Data Reporting Custom Provider
 * Plugin URI: https://github.com/cairocoder01/disciple-tools-data-reporting-provider-sample
 * Description: Disciple Tools - Data Reporting Custom Provider facilitates the addtion of custom providers to the Disciple Tools Data Reporting plugin
 * Version:  0.1.0
 * Author URI: https://github.com/cairocoder01
 * GitHub Plugin URI: https://github.com/cairocoder01/disciple-tools-data-reporting-provider-sample
 * Requires at least: 4.7.0
 * (Requires 4.7+ because of the integration of the REST API at 4.7 and the security requirements of this milestone version.)
 * Tested up to: 5.5
 *
 * @package Disciple_Tools
 * @link    https://github.com/DiscipleTools
 * @license GPL-2.0 or later
 *          https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Refactoring (renaming) this plugin as your own:
 * 1. @todo Refactor all occurrences of the name DT_Data_Reporting_Provider_Sample, dt_data_reporting_provider_sample, dt-data-reporting-provider-sample, data-reporting-provider-sample, and Data Reporting Provider Sample
 * 2. @todo Rename the `disciple-tools-data-reporting-provider-sample.php file.
 * 3. @todo Update the README.md and LICENSE
 * 4. @todo Update the default.pot file if you intend to make your plugin multilingual. Use a tool like POEdit
 * 5. @todo Change the translation domain to in the phpcs.xml your plugin's domain: @todo
 */

/**
 * The starter plugin is equipped with:
 * 1. Wordpress style requirements
 * 2. Travis Continuous Integration
 * 3. Disciple Tools Theme presence check
 * 4. Remote upgrade system for ongoing updates outside the Wordpress Directory
 * 5. Multilingual ready
 * 6. PHP Code Sniffer support (composer) @use /vendor/bin/phpcs and /vendor/bin/phpcbf
 * 7. Starter Admin menu and options page with tabs.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$dt_data_reporting_provider_sample_required_dt_theme_version = '0.28.0';

/**
 * Gets the instance of the `DT_Data_Reporting_Provider_Sample_Plugin` class.
 *
 * @since  0.1
 * @access public
 * @return object|bool
 */
function dt_data_reporting_provider_sample_plugin() {
    global $dt_data_reporting_provider_sample_required_dt_theme_version;
    $wp_theme = wp_get_theme();
    $version = $wp_theme->version;

    /*
     * Check if the Disciple.Tools theme is loaded and is the latest required version
     */
    $is_theme_dt = strpos( $wp_theme->get_template(), "disciple-tools-theme" ) !== false || $wp_theme->name === "Disciple Tools";
    if ( $is_theme_dt && version_compare( $version, $dt_data_reporting_provider_sample_required_dt_theme_version, "<" ) ) {
        add_action( 'admin_notices', 'dt_data_reporting_provider_sample_plugin_hook_admin_notice' );
        add_action( 'wp_ajax_dismissed_notice_handler', 'dt_hook_ajax_notice_handler' );
        return false;
    }
    if ( !$is_theme_dt ){
        return false;
    }
    /**
     * Load useful function from the theme
     */
    if ( !defined( 'DT_FUNCTIONS_READY' ) ){
        require_once get_template_directory() . '/dt-core/global-functions.php';
    }
    /*
     * Don't load the plugin on every rest request. Only those with the 'sample' namespace
     */
    $is_rest = dt_is_rest();
    if ( ! $is_rest ){
        return DT_Data_Reporting_Provider_Sample_Plugin::get_instance();
    }
}
add_action( 'after_setup_theme', 'dt_data_reporting_provider_sample_plugin' );

/**
 * Singleton class for setting up the plugin.
 *
 * @since  0.1
 * @access public
 */
class DT_Data_Reporting_Provider_Sample_Plugin {

    /**
     * Declares public variables
     *
     * @since  0.1
     * @access public
     * @return object
     */
    public $token;
    public $version;
    public $dir_path = '';
    public $dir_uri = '';
    public $img_uri = '';
    public $includes_path;

    /**
     * Returns the instance.
     *
     * @since  0.1
     * @access public
     * @return object
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new dt_data_reporting_provider_sample_plugin();
            $instance->setup();
            $instance->includes();
            $instance->setup_actions();
        }
        return $instance;
    }

    /**
     * Constructor method.
     *
     * @since  0.1
     * @access private
     * @return void
     */
    private function __construct() {
    }

    /**
     * Loads files needed by the plugin.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    private function includes() {

    }

    /**
     * Sets up globals.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    private function setup() {

        // Main plugin directory path and URI.
        $this->dir_path     = trailingslashit( plugin_dir_path( __FILE__ ) );
        $this->dir_uri      = trailingslashit( plugin_dir_url( __FILE__ ) );

        // Plugin directory paths.
        $this->includes_path      = trailingslashit( $this->dir_path . 'includes' );

        // Plugin directory URIs.
        $this->img_uri      = trailingslashit( $this->dir_uri . 'img' );

        // Admin and settings variables
        $this->token             = 'dt_data_reporting_provider_sample_plugin';
        $this->version             = '0.1';

    }

    /**
     * Sets up main plugin actions and filters.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    private function setup_actions() {

        if ( is_admin() ){
            // Check for plugin updates
            if ( ! class_exists( 'Puc_v4_Factory' ) ) {
                require( get_template_directory() . '/dt-core/libraries/plugin-update-checker/plugin-update-checker.php' );
            }
            /**
             * Below is the publicly hosted .json file that carries the version information. This file can be hosted
             * anywhere as long as it is publicly accessible. You can download the version file listed below and use it as
             * a template.
             * Also, see the instructions for version updating to understand the steps involved.
             * @see https://github.com/DiscipleTools/disciple-tools-version-control/wiki/How-to-Update-the-Starter-Plugin
             * @todo enable this section with your own hosted file
             * @todo An example of this file can be found in /includes/admin/disciple-tools-data-reporting-provider-sample-version-control.json
             * @todo It is recommended to host this version control file outside the project itself. Github is a good option for delivering static json.
             */

            /***** @todo remove from here

            $hosted_json = "https://raw.githubusercontent.com/DiscipleTools/disciple-tools-version-control/master/disciple-tools-data-reporting-provider-sample-version-control.json"; // @todo change this url
            Puc_v4_Factory::buildUpdateChecker(
                $hosted_json,
                __FILE__,
                'disciple-tools-data-reporting-provider-sample'
            );

            ********* @todo to here */

        }

        // Internationalize the text strings used.
        add_action( 'init', array( $this, 'i18n' ), 2 );

        if ( is_admin() ) {
            // adds links to the plugin description area in the plugin admin list.
            add_filter( 'plugin_row_meta', [ $this, 'plugin_description_links' ], 10, 4 );

            add_filter( 'dt_data_reporting_providers', [ $this, 'data_reporting_providers' ], 10, 4 );
            add_filter( 'dt_data_reporting_export_provider_sample-provider', [ $this, 'data_reporting_export' ], 10, 4 );
            add_action( 'dt_data_reporting_tab_provider_sample-provider', [ $this, 'data_reporting_tab' ], 10, 1 );
        }
    }

    /**
     * Config a new provider to be available in the Data Reporting Plugin
     * @param $providers
     * @return mixed
     */
    public function data_reporting_providers( $providers) {
        $providers ['sample-provider'] = [
            'name' => 'My Sample Provider',
            'fields' => [
                'sample_key' => [
                    'label' => 'My Sample Key',
                    'type' => 'text',
                    'helpText' => 'This is a sample key you need to authenticate with this provider'
                ]
            ]
        ];
        return $providers;
    }

  /**
   * Process the data retrieving by the Data Reporting Plugin and send to custom provider
   * @param array $columns
   * @param array $rows
   * @param string $type
   * @param array $config
   */
    public function data_reporting_export( $columns, $rows, $type, $config ) {
        // Return this result object at the end of your export process.
        // `success` should be set to true when you are sure that errors haven't happen. It is
        //   used to track the last exported values for differential exports.
        // `messages` is an array of messages to be added to the log.
        //   An optional type of `error` or `success` can be added for formatting
        $result = [
            'success' => false,
            'messages' => array(),
        ];
        $result['messages'][] = [
            'message' => 'This is a normal log message'
        ];
        $result['messages'][] = [
            'type' => 'error',
            'message' => 'This is an error log message'
        ];
        $result['messages'][] = [
            'type' => 'success',
            'message' => 'This is a success log message'
        ];


        $result['messages'][] = [
            'message' => 'Debug config: ' . print_r( $config, true ),
        ];

        return $result;
    }

    public function data_reporting_tab() {
        ?>
      <h2>My Sample Provider</h2>
      <p>Add here any getting started or how-to information that is needed for your provider</p>
        <?php
    }

    /**
     * Filters the array of row meta for each/specific plugin in the Plugins list table.
     * Appends additional links below each/specific plugin on the plugins page.
     *
     * @access  public
     * @param   array       $links_array            An array of the plugin's metadata
     * @param   string      $plugin_file_name       Path to the plugin file
     * @param   array       $plugin_data            An array of plugin data
     * @param   string      $status                 Status of the plugin
     * @return  array       $links_array
     */
    public function plugin_description_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
        if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
            // You can still use `array_unshift()` to add links at the beginning.

            $links_array[] = '<a href="https://disciple.tools">Disciple.Tools Community</a>'; // @todo replace with your links.

            // add other links here
        }

        return $links_array;
    }

    /**
     * Method that runs only when the plugin is activated.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public static function activation() {

        // Confirm 'Administrator' has 'manage_dt' privilege. This is key in 'remote' configuration when
        // Disciple Tools theme is not installed, otherwise this will already have been installed by the Disciple Tools Theme
        $role = get_role( 'administrator' );
        if ( !empty( $role ) ) {
            $role->add_cap( 'manage_dt' ); // gives access to dt plugin options
        }

    }

    /**
     * Method that runs only when the plugin is deactivated.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public static function deactivation() {
        delete_option( 'dismissed-dt-data-reporting-provider-sample' );
    }

    /**
     * Loads the translation files.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public function i18n() {
        load_plugin_textdomain( 'dt_data_reporting_provider_sample_plugin', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ). 'languages' );
    }

    /**
     * Magic method to output a string if trying to use the object as a string.
     *
     * @since  0.1
     * @access public
     * @return string
     */
    public function __toString() {
        return 'dt_data_reporting_provider_sample_plugin';
    }

    /**
     * Magic method to keep the object from being cloned.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, 'Whoah, partner!', '0.1' );
    }

    /**
     * Magic method to keep the object from being unserialized.
     *
     * @since  0.1
     * @access public
     * @return void
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, 'Whoah, partner!', '0.1' );
    }

    /**
     * Magic method to prevent a fatal error when calling a method that doesn't exist.
     *
     * @param string $method
     * @param array $args
     * @return null
     * @since  0.1
     * @access public
     */
    public function __call( $method = '', $args = array() ) {
        _doing_it_wrong( "dt_data_reporting_provider_sample_plugin::" . esc_html( $method ), 'Method does not exist.', '0.1' );
        unset( $method, $args );
        return null;
    }
}
// end main plugin class

// Register activation hook.
register_activation_hook( __FILE__, [ 'DT_Data_Reporting_Provider_Sample_Plugin', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'DT_Data_Reporting_Provider_Sample_Plugin', 'deactivation' ] );

function dt_data_reporting_provider_sample_plugin_hook_admin_notice() {
    global $dt_data_reporting_provider_sample_required_dt_theme_version;
    $wp_theme = wp_get_theme();
    $current_version = $wp_theme->version;
    $message = __( "'Disciple Tools - Data Reporting Provider Sample' plugin requires 'Disciple Tools' theme to work. Please activate 'Disciple Tools' theme or make sure it is latest version.", "dt_data_reporting_provider_sample_plugin" );
    if ( $wp_theme->get_template() === "disciple-tools-theme" ){
        $message .= sprintf( esc_html__( 'Current Disciple Tools version: %1$s, required version: %2$s', 'dt_data_reporting_provider_sample_plugin' ), esc_html( $current_version ), esc_html( $dt_data_reporting_provider_sample_required_dt_theme_version ) );
    }
    // Check if it's been dismissed...
    if ( ! get_option( 'dismissed-dt-data-reporting-provider-sample', false ) ) { ?>
        <div class="notice notice-error notice-dt-data-reporting-provider-sample is-dismissible" data-notice="dt-data-reporting-provider-sample">
            <p><?php echo esc_html( $message );?></p>
        </div>
        <script>
            jQuery(function($) {
                $( document ).on( 'click', '.notice-dt-data-reporting-provider-sample .notice-dismiss', function () {
                    $.ajax( ajaxurl, {
                        type: 'POST',
                        data: {
                            action: 'dismissed_notice_handler',
                            type: 'dt-data-reporting-provider-sample',
                            security: '<?php echo esc_html( wp_create_nonce( 'wp_rest_dismiss' ) ) ?>'
                        }
                    })
                });
            });
        </script>
    <?php }
}


/**
 * AJAX handler to store the state of dismissible notices.
 */
if ( !function_exists( "dt_hook_ajax_notice_handler" )){
    function dt_hook_ajax_notice_handler(){
        check_ajax_referer( 'wp_rest_dismiss', 'security' );
        if ( isset( $_POST["type"] ) ){
            $type = sanitize_text_field( wp_unslash( $_POST["type"] ) );
            update_option( 'dismissed-' . $type, true );
        }
    }
}
