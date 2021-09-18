<?php
/**
 * Infinite Scoll Code
 *
 */
function infinity_load_more_hook() {
  
  if( ! is_singular( 'post' ) )
    return;

  $args = array(
    'url'   => admin_url( 'admin-ajax.php' ),
    'post__not_in' => array( get_queried_object_id() ),
  );

  wp_enqueue_script( 'infinity-load-more', get_stylesheet_directory_uri() . '/assets/js/loadmore.js', array( 'jquery' ), '1.0', true );
  wp_localize_script( 'infinity-load-more', 'infinityloadmore', $args );
    
}
add_action( 'wp_enqueue_scripts', 'infinity_load_more_hook' );

/**
 * AJAX Hook Load More 
 *
 */
function infinity_load_load_action() {
    $args = array(
        'post_type' => 'post',
        'paged' => $_POST['page'],
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'post__not_in' => $_POST['postnot']
    );
    ob_start();
    $loop = new WP_Query( $args );
    if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
        // Put content here which you want to load with every ajax action
        the_content(); 
    endwhile; endif; wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success( $data );
    wp_die();
}
add_action( 'wp_ajax_infinity_load_load_action', 'infinity_load_load_action' );
add_action( 'wp_ajax_nopriv_infinity_load_load_action', 'infinity_load_load_action' );
