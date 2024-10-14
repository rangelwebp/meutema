<?php
get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        the_content(); // Conteúdo das páginas e posts
    endwhile;
endif;
get_footer();
?>
