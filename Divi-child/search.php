<?php
/*
Template Name: Search 
*/
?>
<?php get_header(); 
global $wp_query;

echo '<pre/>';
print_r($wp_query);
wp_die();
?>

<div id="primary">
    <h1>Search Posts</h1>
    <?php get_search_form(); ?>
</div>

<?php

get_footer();
