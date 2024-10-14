<?php if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) : ?>
    <!-- Elementor irá carregar o rodapé -->
<?php else : ?>
    <!-- Rodapé padrão do tema aqui -->
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
