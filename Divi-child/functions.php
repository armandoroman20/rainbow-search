<?php 

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/*
* Remove Ajax from The Events Calendar Pagination on Month, List, and Day Views
* JE added 6/11/19
*/
function events_calendar_remove_scripts() {
if (!is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {

        wp_dequeue_script( 'the-events-calendar');
        wp_dequeue_script( 'tribe-events-list');
        wp_dequeue_script( 'tribe-events-ajax-day');

}}
add_action('wp_print_scripts', 'events_calendar_remove_scripts' , 10);
add_action('wp_footer', 'events_calendar_remove_scripts' , 10);

/*
 * Add Events CPT to Pixel Cat
 */
function my_custom_cpt_pixel_support( $array ) {
	return array( 'event', 'events' );
}
add_filter( 'fca_pc_custom_post_support', 'my_custom_cpt_pixel_support' );

// Remove post comment website field
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields){
    if(isset($fields['url']))
       unset($fields['url']);
       return $fields;
}


/* creating PDF post type */
function create_posttype() {
 
    register_post_type( 'pdfs',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Pdfs' ),
                'singular_name' => __( 'Pdf' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'pdfs'),
            'show_in_rest' => true,
 			'supports' => array('title','thumbnail','editor','excerpt'), 
			'taxonomies' => array('topics', 'category','post_tag' ),

        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

/* Exclude pages from search results, but leave pdfs, and posts*/
if (!is_admin()) {
    function wpb_search_filter($query) {
        if ($query->is_search) {
            $query->set('post_type', array('post', 'pdfs'));
        }
        return $query;
    }
    add_filter('pre_get_posts','wpb_search_filter');
}

// if (isset ( $_REQUEST[ 'search' ])){
// query_posts( array(
// 's' => $_REQUEST[ 'search' ],
// 'post_type' => $_REQUEST ['post_type'],
//  'paged' => $paged
// )
// );

// if ( have_posts() ) : while ( have_posts() ) :
// endwhile; endif;

// wp_reset_query();
// }
?>