<?php
function register_events_block()
{
    wp_register_script(
        'events-block-script',
        plugins_url('../blocks/events-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor')
    );

    register_block_type('plugin/events-block', array(
        'editor_script' => 'events-block-script',
        'render_callback' => 'render_events_block',
    ));
}
add_action('init', 'register_events_block');

function enqueue_block_assets()
{
    wp_enqueue_script(
        'events-block-script',
        plugins_url('../blocks/events-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-api-fetch')
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_block_assets');

function render_events_block($attributes)
{
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => intval($attributes['numberOfPosts']),
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );

    $events_query = new WP_Query($args);

    $value = get_option('hipsy_events_dark_mode');
    $dark_mode = $value === "1" ? 'dark' : '';
    $output = loop_wrapper_start($dark_mode);

		$dateformat = get_option('date_format');
	$timeformat = get_option('time_format');
	
    if ($events_query->have_posts()) {
		
//     print_r($events_query);
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $link = get_post_meta(get_the_ID(), 'hipsy_events_link', true);
            $title = get_the_title();
            $url = get_permalink();
            $location = get_post_meta(get_the_ID(), 'hipsy_events_location', true);
			$termlist = '';
		$terms = get_the_terms( get_the_ID(), 'hipsy-categorie' );
		if ( $terms && ! is_wp_error( $terms ) ) :     
			$term_links = array();    
			foreach ( $terms as $term ) {
				$term_links[] = '<div class="wp-block-button"><a class="wp-block-button__link" href="' . esc_attr( get_term_link( $term->slug, 'hipsy-categorie' ) ) . '">' . __( $term->name ) . '</a></div>';
			}
			if(is_array($term_links)) $termlist = '<div class="wp-block-buttons small">'.join( ' ', $term_links ).'</div>';
					endif;
            // Date
			$formatted_date     = wp_date($dateformat, strtotime( get_post_meta(get_the_ID(), 'hipsy_events_date', true)));
         	$formatted_time     = wp_date($timeformat, strtotime( get_post_meta(get_the_ID(), 'hipsy_events_date', true)));
			$formatted_time_end = wp_date($timeformat, strtotime( get_post_meta(get_the_ID(), 'hipsy_events_date_end', true)));

            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'event-image'));

            $output .= loop_item($url, $thumbnail, $formatted_date, $formatted_time, $formatted_time_end, $title, $location,$termlist);
        }
    }
    wp_reset_postdata();
    $output .= loop_wrapper_end();

    $output .= '<p class="has-text-align-center">Events synced with Hipsy</p>';

    return $output;
}
