<?php

namespace Stratis\Plugin\Includes;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'StratisPost_Form_Handler' ) ) :
    class StratisPost_Form_Handler
    {
        public function __construct() {
            if ( ! is_admin() ) {
                require_once( ABSPATH . 'wp-admin/includes/post.php' );
            }
        }

        public function handle_form_submission(){
            // Vérifier si le formulaire est soumis avec une vérification de nonce
            if (isset($_POST['submit_post']) && isset($_POST['post_nonce']) && wp_verify_nonce($_POST['post_nonce'], 'post_form_nonce')) {

                // Récupérer les données soumises et nettoyer les champs de texte
                $post_title = isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : '';
                $post_content = isset($_POST['post_content']) ? wp_kses_post($_POST['post_content']) : '';

                // Vérifier si les données sont valides
                if (!empty($post_title) && !empty($post_content)) {
                    // Vérifier les autorisations de l'utilisateur
                    if (current_user_can('publish_posts')) {
                        // Vérifier si un article avec le même titre existe déjà
                        $existing_post = post_exists($post_title);

                        if (!$existing_post) {
                            // Créer un nouvel article avec les données soumises
                            $post_id = wp_insert_post(array(
                                'post_title' => $post_title,
                                'post_type' => 'post',
                                'post_content' => $post_content,
                                'post_status' => 'publish'
                            ));

                            // Vérifier si l'article a été créé avec succès
                            if ($post_id) {

                                // Envoyer un e-mail à l'administrateur
                                $admin_email = get_option( 'admin_email' );
                                $user_email = wp_get_current_user()->user_email;
                                $subject = 'New post created';
                                $message = "A new post titled '$post_title' has been created on the site.";
                                $headers = array('Content-Type: text/html; charset=UTF-8');
                                $headers[] .= 'From:' . $user_email;

                                $sent = wp_mail( $admin_email, $subject, $message, $headers );

                                // Afficher un message de succès
                                echo '<div class="alert alert-success stratis__plugin" role="alert">' . esc_html__('Post created successfully!', 'stratis-plugin') . '</div>';
                                if ( $sent ) {
                                    // Afficher un message de succès
                                    echo '<div class="alert alert-success stratis__plugin" role="alert">' . esc_html__( 'Email sent to admin.', 'stratis-plugin' ) . '</div>';
                                } else {
                                    // Afficher un message d'erreur générique
                                    echo '<div class="alert alert-danger stratis__plugin" role="alert">' . esc_html__( 'Error sending email.', 'stratis-plugin' ) . '</div>';
                                }
                            } else {
                                // Afficher un message d'erreur générique
                                echo '<div class="alert alert-danger stratis__plugin" role="alert">' . esc_html__('Error creating post. Please try again!!', 'stratis-plugin') . '</div>';
                            }
                        } else {
                            // Afficher un message d'erreur générique
                            echo '<div class="alert alert-danger stratis__plugin" role="alert">' . esc_html__('Post already exist!!', 'stratis-plugin') . '</div>';
                        }

                    } else {
                        // Afficher un message d'erreur si l'utilisateur n'est pas autorisé à publier des articles
                        echo '<div class="alert alert-danger stratis__plugin" role="alert">' . esc_html__('You are not authorized to publish posts!!', 'stratis-plugin') . '</div>';

                    }
                } else {
                    // Afficher un message d'erreur si des champs sont vides
                    echo '<div class="alert alert-danger stratis__plugin" role="alert">' . esc_html__('Please fill in all fields!!!', 'stratis-plugin') . '</div>';

                }
            }
        }
    }

endif;