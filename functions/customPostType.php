<?php

// Create a content type called Hipsy Events
function create_posttype()
{
    register_post_type(
        'events',
        array(
            'labels' => array(
                'name' => __('Hipsy Events'),
                'all_items' => __('All Events'),
                'singular_name' => __('Event'),
                'add_new' => __('Add Event'),
                'add_new_item' => __('Add Event'),
                'edit_item' => __('Edit Event'),
                'view_item' => __('View Event')
            ),
            'supports' => array(
                'title', 'editor', 'thumbnail', 'custom-fields'
            ),
 			'rewrite' => ['slug' => 'agenda', 'with_front' => false],
            'menu_position' => 20,
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'has_archive' => false,
        )
    );
	
	    // Vacature Taxonomies
    register_taxonomy('hipsy-categorie', ['events'], [
		'label' => __('Hipsy Categorie', 'txtdomain'),
        'show_ui' => true,
		'hierarchical' => false,
		'rewrite' => ['slug' => 'aanbod', 'with_front' => false],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Categorie', 'txtdomain'),
			'all_items' => __('Alle Categorieën', 'txtdomain'),
			'edit_item' => __('Bewerk Categorie', 'txtdomain'),
			'view_item' => __('Bekijk Categorieën', 'txtdomain'),
			'update_item' => __('Update Categorieën', 'txtdomain'),
			'add_new_item' => __('Voeg nieuwe Categorie toe', 'txtdomain'),
			'new_item_name' => __('Nieuwe Categorie naam', 'txtdomain'),
			'search_items' => __('Zoek Categorie', 'txtdomain'),
			'popular_items' => __('Populaire Categorie', 'txtdomain'),
			'separate_items_with_commas' => __('Onderscheid Categorieën met een komma', 'txtdomain'),
			'choose_from_most_used' => __('Kies uit meest gebruikte Categorieën', 'txtdomain'),
			'not_found' => __('Geen Categorie gevonden', 'txtdomain'),
		]
	]);
}
add_action('init', 'create_posttype');
