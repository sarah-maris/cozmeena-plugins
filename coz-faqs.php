<?php

/**
 * Plugin Name: Cozmeena FAQs
 * Description: A plugin that creates the custom post type for an FAQ page
 * Version: 1.0
 * Author: Sarah Maris
 * Revised 10-26-14
 *
 * Based on 	http://code.tutsplus.com/articles/how-to-create-a-faq-page-with-wordpress-and-custom-post-types--net-14767
*/

add_action('init', 'coz_faq');

function coz_faq()
{
  $labels = array(
    'name' => _x('FAQs', 'post type general name'),
    'singular_name' => _x('FAQ', 'post type singular name'),
    'add_new' => _x('Add New', 'FAQ'),
    'add_new_item' => __('Add New FAQ'),
    'edit_item' => __('Edit FAQ'),
    'new_item' => __('New FAQ'),
    'view_item' => __('View FAQ'),
    'search_items' => __('Search FAQs'),
    'not_found' =>  __('No FAQs found'),
    'not_found_in_trash' => __('No FAQs found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
	'menu_icon' => '',
	'has_archive'   => true,
    'supports' => array('title','editor','thumbnail','custom-fields')
  );
  register_post_type('faqs',$args);
}

?>