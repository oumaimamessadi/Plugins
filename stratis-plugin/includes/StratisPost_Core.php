<?php


namespace Stratis\Plugin\Includes;

use Stratis\Plugin\Includes\StratisPost_Shortcode;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (!class_exists('StratisPost_Core')) :
    class StratisPost_Core
    {
        public function __construct() {
            // Require necessary files
            require_once STRATIS_POST_PLUGIN_DIR . '/includes/StratisPost_Shortcode.php';
            require_once STRATIS_POST_PLUGIN_DIR . '/includes/StratisPost_Form_Handler.php';

            // Enqueue styles and scripts
            add_action('wp_enqueue_scripts', array($this, 'stratis_enqueue_styles'));
            add_action('wp_enqueue_scripts', array($this, 'add_conditional_bootstrap_styles'));
            add_action('wp_enqueue_scripts', array($this, 'add_conditional_bootstrap_scripts'));

            // Add instance of StratisPost_Shortcode
            new StratisPost_Shortcode();
        }

        // Enqueue custom styles
        public function stratis_enqueue_styles() {
            wp_enqueue_style('stratis-plugin-style', plugins_url('assets/css/custom-style.css', __FILE__));
        }

        // Function to add Bootstrap styles conditionally
        public function add_conditional_bootstrap_styles() {
            // Check if Bootstrap is not already registered
            if (!wp_style_is('bootstrap')) {
                // Load Bootstrap style only if no other version is registered
                wp_enqueue_style('stratis-bootstrap-css', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
            }
        }

        // Function to add Bootstrap scripts conditionally
        public function add_conditional_bootstrap_scripts() {
            // Check if Bootstrap is not already registered
            if (!wp_script_is('bootstrap')) {
                // Load Bootstrap script only if no other version is registered
                wp_enqueue_script('stratis-bootstrap-js', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js', array('jquery'), '', true);
            }
        }
    }
    new StratisPost_Core();
endif;