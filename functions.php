<?php
// Enfileirar scripts e estilos
function meutema_enqueue_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'meutema_enqueue_scripts' );

function meutema_elementor_support() {
    add_theme_support( 'elementor-header-footer' );
}
// add_action( 'after_setup_theme', 'meutema_elementor_support' );


// Suporte a thumbnails e Elementor
function meutema_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_theme_support( 'title-tag' ); 
    // add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'meutema_setup' );

// Remover estilos e scripts de Emojis
function meutema_disable_wp_emojicons() {
    // Desativa o suporte a emojis
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'meutema_disable_emojicons_tinymce' );
}
add_action( 'init', 'meutema_disable_wp_emojicons' );

// Desativar o emoji no TinyMCE
function meutema_disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    }
    return array();
}

// Remover meta tag de versão do Elementor
function meutema_remove_elementor_generator() {
    remove_action( 'wp_head', [ \Elementor\Plugin::instance(), 'add_meta_generator_tag' ] );
}
add_action( 'init', 'meutema_remove_elementor_generator' );

// Remover o menu "Novo Conteúdo" da barra de administração superior
function meutema_remove_admin_bar_new_content( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-content' ); // Remove o menu "Adicionar Novo"
}
add_action( 'admin_bar_menu', 'meutema_remove_admin_bar_new_content', 999 );

// Remover o post state do Elementor da lista de páginas
function meutema_remove_elementor_post_state( $post_states, $post ) {
    // Verifica se o tipo de post é 'page' ou qualquer outro e remove o estado 'Elementor'
    if ( 'page' === $post->post_type && isset( $post_states['elementor'] ) ) {
        unset( $post_states['elementor'] );
    }
    return $post_states;
}
add_filter( 'display_post_states', 'meutema_remove_elementor_post_state', 10, 2 );


// Remover o link "Editar com Elementor" na lista de páginas
function meutema_remove_edit_with_elementor_link( $actions, $post ) {
    // Verifica se o tipo de post é 'page' e remove o link 'edit_with_elementor'
    if ( 'page' === $post->post_type && isset( $actions['edit_with_elementor'] ) ) {
        unset( $actions['edit_with_elementor'] );
    }
    return $actions;
}
add_filter( 'page_row_actions', 'meutema_remove_edit_with_elementor_link', 10, 2 );




// Carregar CSS personalizado no admin, exceto para o usuário com email específico
function meutema_admin_styles() {
    // Obter o e-mail do usuário logado
    $user = wp_get_current_user();

    // Verificar se o e-mail é diferente de 'rangel.webp@gmail.com'
    if ( $user->user_email !== 'rangel.webp@gmail.com' ) {
        // Enfileirar o estilo admin_style.css
        wp_enqueue_style( 'meutema-admin-css', get_template_directory_uri() . '/admin_style.css' );
    }
}
add_action( 'admin_enqueue_scripts', 'meutema_admin_styles' );


?>
