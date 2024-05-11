<?php
/*
Plugin Name: Stratis Plugin
Plugin URI: http://example.com
Description: This plugin handles Stratis Post functionality. Use the shortcode "[stratis_post submit_button_text='Envoyer']" inside an article.
The attribute "submit_button_text='Envoyer'" defines the submit text. In case of the default "[stratis_post]",
the submit text will be "submit".
Version: 1.0.0
Author: OUMAIMA MESSADI
Author URI: http://example.com
Text Domain: stratis-plugin
*/
namespace Stratis\Plugin;

use Stratis\Plugin\Includes\StratisPost_Core;

define( 'STRATIS_POST_FILE', __FILE__ );
define( 'STRATIS_POST_PLUGIN_DIR', dirname(__FILE__) );
define( 'STRATIS_POST_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Blocking direct access
if( ! function_exists( 'stratis_post_block_direct_access' ) ) {
    function stratis_post_block_direct_access() {
        if( ! defined( 'ABSPATH' ) ) {
            exit( 'Direct access denied.' );
        }
    }
}

if( ! class_exists( 'StratisPost_Plugin' ) ) {
    class StratisPost_Plugin {

        const VERSION = '1.0.0';
        protected static $instance = null;

        private function __construct() {
            // Initialize your plugin here
            $this->load_textdomain();
        }

        public function load_textdomain() {
            // Load text domain for translations
            load_plugin_textdomain( 'stratis-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        public static function get_instance() {
            if ( null == self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    }
}

// Initialize the plugin
add_action( 'plugins_loaded', array( 'Stratis\Plugin\StratisPost_Plugin', 'get_instance' ) );

// Include additional files if needed
require_once STRATIS_POST_PLUGIN_DIR . '/includes/StratisPost_Core.php';

// Plugin Core function
$plugin_Core = new StratisPost_Core();
