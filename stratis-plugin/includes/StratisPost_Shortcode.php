<?php

namespace Stratis\Plugin\Includes;
use Stratis\Plugin\Includes\StratisPost_Form_Handler;


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'StratisPost_Shortcode' ) ) :
class StratisPost_Shortcode
{
    public function __construct() {
        // Enregistrer le shortcode [stratis_post]
        add_shortcode('stratis_post', array($this, 'stratis_post_shortcode'));
    }

    // Shortcode [stratis_post]
    public function stratis_post_shortcode($atts, $content = null) {
        $atts = shortcode_atts(array(
            'submit_button_text' => 'Submit', // Texte du bouton par défaut
        ), $atts);

        // Générer le contenu du shortcode avec le texte du bouton personnalisé
        $output = $this->stratis_post_generate_output($atts, $content);

        return $output;
    }

    // Fonction d'assistance pour générer le contenu du shortcode [stratis_post]
    public function stratis_post_generate_output($atts, $content) {
        // Récupérer le texte du bouton à partir des attributs
        $submit_button_text = isset($atts['submit_button_text']) ? $atts['submit_button_text'] : 'Submit';

        ob_start();

        // Inclure le modèle de formulaire
        include(plugin_dir_path(__FILE__) . '../templates/post_form.php');

        // Inclure le traitement du formulaire
        $form_handler = new StratisPost_Form_Handler();
        // Traiter le formulaire
        $form_handler->handle_form_submission();

        // Logique de traitement du formulaire

        return ob_get_clean();
    }
}

    new StratisPost_Shortcode();
endif;