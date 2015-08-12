<?php

/**
 * Plugin Name: Cozmeena Custom Posts
 * Description: A plugin that creates the custom post types for the Cozmeena website
 * Version: 1.2
 * Author: Sarah Maris 
 * Revised: 04-11-15
 */

  /**
 * Table of Contents:
 *
 *  1.0 - Cancer Resources post type
 *   .1 - add 'resource' post type
 *   .2 - user messages
 *   .3 - user interface
 *   .4 - custom taxonomy
 *   .5 - resource page navigation
 *
 *  2.0 - Cozmeena Story post type
 *   .1 - add 'story' post type
 *   .2 - user messages
 *   .3 - user interface
 *   .4 - custom taxonomy
 *   .5 - story page navigation
 *
 *  3.0 - Cozmeena Definitions post type
 *   .1 - add 'definition' post type
 *   .2 - user messages
 *   .3 - user interface
 * 
 *  4.0 - Cozmeena Recipes post type 
 *   .1 - add 'recipe' post type
 *   .2 - user messages
 *   .3 - user interface
 *   .4 - custom taxonomy
 *   .5 - recipe page navigation
 *
 *  5.0 - Cozmeena Crafts post type 
 *   .1 - add 'craft' post type
 *   .2 - user messages
 *   .3 - user interface
 *   .4 - custom taxonomy
 *   .5 - crafts page navigation
 *
 *  6.0 - CozMedia Reviews post type 
 *   .1 - add 'review' post type
 *   .2 - user messages
 *   .3 - user interface
 *   .4 - custom taxonomy
 *   .5 - review page navigation
 *
 *  7.0 - Admin Columns for Custom post types
 *   .1 - Resource post type
 *   .2 - Story post type
 *   .3 - Recipe post type
 *   .4 - Definitions post type
 *   .5 - Crafts post type
 *   .6 - Reviews post type
 * 
 *  8.0 - Enable tags for custom post types
 *
 * 9.0 - Fix post navigation for custom post types
 *   .1 - Resource (alpha)
 *   .2 - Story (number order)
 *   .3 - Recipe (alpha)
 *   .4 - Craft (number order)
 *   .5 - Review (alpha order)
 * 
 */
 
 
 
 /* 1.0  CANCER RESOURCES 
 * --------------------------------------------------*/
 
/* 1.1:  Add Cancer Resource custom post type  - 'resource'*/
function my_custom_post_resource() {
	$labels = array(
		'name'               => 'Cancer Resources',
		'singular_name'      => 'Cancer Resource',
		'add_new'            => 'Add New', 
		'add_new_item'       => 'Add New Resource',
		'edit_item'          => 'Edit Resource',
		'new_item'           => 'New Resource' ,
		'all_items'          => 'All Resources' ,
		'view_item'          => 'View Resource',
		'search_items'       => 'Search Resources',
		'not_found'          => 'No resources found',
		'not_found_in_trash' => 'No resources found in the Trash', 
		'parent_item_colon'  => '',
		'menu_name'          => 'Cancer Resources'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our Cancer Resources referrals and resource specific data',
		'public'        => true,
		'menu_position' => 5,
		'menu_icon' => '',
		'supports'      => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt'  ),  // DID NOT INCLUDE AUTHOR, COMMENTS, POST FORMAT // 
		'taxonomies' => array( 'post_tag' ),
		'has_archive'   => true,
		);
	register_post_type( 'resource', $args );	
}
add_action( 'init', 'my_custom_post_resource' );

/* 1.2: Customize user messages for 'resource' post type */
function my_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['resource'] = array(
		0 => '', 
		1 => sprintf( __('Cancer Resource updated. <a href="%s">View Cancer Resource</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Cancer Resource updated.',
		5 => isset($_GET['revision']) ? sprintf( 'Cancer Resource restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Cancer Resource published. <a href="%s">View resource</a>', esc_url( get_permalink($post_ID) ) ),
		7 => 'Cancer Resource saved.',
		8 => sprintf( 'Cancer Resource submitted. <a target="_blank" href="%s">Preview resource</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Cancer Resource scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview resource</a>', date_i18n(  'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Cancer Resource draft updated. <a target="_blank" href="%s">Preview Cancer Resource</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'my_updated_messages' );

add_action('do_meta_boxes', 'move_resource_meta_boxes');

/* 1.3: Customize featured image box title for 'resource' post type and move 'Resource Logo' and 'Revisions' meta boxes to side */
function move_resource_meta_boxes() {
    remove_meta_box( 'postimagediv', 'resource', 'side' );
    add_meta_box('postimagediv', 'Resource Logo', 'post_thumbnail_meta_box', 'resource', 'side');
	remove_meta_box( 'revisionsdiv', 'resource', 'side' );
    add_meta_box('revisionsdiv','Revisions','post_revisions_meta_box','resource', 'side');
}

/* 1.4:  Create custom taxonomy to categorize Cancer Resources */
function my_taxonomies_resource() {
	$labels = array(
		'name'              =>  'Cancer Resource Categories',
		'singular_name'     => 'Cancer Resource Category',
		'search_items'      =>  'Search Cancer Resource Categories',
		'all_items'         =>  'All Categories',

		'edit_item'         => 'Edit Cancer Resource Category' , 
		'update_item'       => 'Update Cancer Resource Category' ,
		'add_new_item'      => 'Add New Cancer Resource Category' ,
		'new_item_name'     => 'New Cancer Resource Category',
		'menu_name'         => 'Resource Categories' ,
	);
	$args = array(
		'labels' => $labels,
		'show_admin_column' => true,
		'hierarchical' => true,
	);
	register_taxonomy( 'resource_category', 'resource', $args );
}
add_action( 'init', 'my_taxonomies_resource', 0 );

/* 1.5:  Create navigation for long resource pages -- adapted from twentythirteen_paging_nav() in functions.php*/
function resource_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'More resources <span class="meta-nav">&rarr;</span> ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Back ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

 /* 2.0  COZMEENA STORIES
 * --------------------------------------------------*/
 
/* 2.1:  Add Story custom post type  - 'story' */
function my_custom_post_story() {
	$story_labels = array(
		'name'               => 'Stories', 'post type general name' ,
		'singular_name'      => 'Story', 'post type singular name' ,
		'add_new'            => 'Add New', 'book' ,
		'add_new_item'       =>  'Add New Story' ,
		'edit_item'          => 'Edit Story' ,
		'new_item'           => 'New Story' ,
		'all_items'          =>  'All Stories' ,
		'view_item'          =>  'View Story' ,
		'search_items'       => 'Search Stories' ,
		'not_found'          =>  'No Stories found' ,
		'not_found_in_trash' =>  'No Stories found in the Trash' , 
		'parent_item_colon'  => '',
		'menu_name'          => 'Stories'
	);
	$story_args = array(
		'labels'        => $story_labels,
		'description'   => 'Holds our 9-11 and Cozmeena Stories',
		'public'        => true,
		'menu_position' => 5,
		'menu_icon' => '',
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions'  ),  // DID NOT INCLUDE AUTHOR, TRACKBACKS etc.
		'taxonomies' => array( 'post_tag'),
		'has_archive'   => true,
		);
	register_post_type( 'story', $story_args );	
}
add_action( 'init', 'my_custom_post_story' );

/* 2.2: Customize user messages for 'story' post type */
function my_updated_story_messages( $story_messages ) {
	global $post, $post_ID;
	$story_messages['story'] = array(
		0 => '', 
		1 => sprintf( 'Story updated. <a href="%s">View Story</a>', esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Story updated.',
		5 => isset($_GET['revision']) ? sprintf( __('Story restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Story published. <a href="%s">View Story</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => 'Story saved.',
		8 => sprintf( 'Story submitted. <a target="_blank" href="%s">Preview story</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Story scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Story</a>', date_i18n( 'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Story draft updated. <a target="_blank" href="%s">Preview Story</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $story_messages;  
}
add_filter( 'post_updated_messages', 'my_updated_story_messages' );

add_action('do_meta_boxes', 'move_story_meta_boxes');

/* 2.3: Move 'Revisions' meta boxes to side in story post type*/
function move_story_meta_boxes(){
   	remove_meta_box( 'revisionsdiv', 'story', 'side' );
    add_meta_box('revisionsdiv',__('Revisions'),'post_revisions_meta_box','story', 'side');
}

/* 2.4:  Create custom taxonomy to categorize Cozmeena Stories */
function my_taxonomies_story() {
	$labels = array(
		'name'              => 'Story Categories', 'taxonomy general name' ,
		'singular_name'     => 'Story Category', 'taxonomy singular name' ,
		'search_items'      =>  'Search Story Categories' ,
		'all_items'         => 'All Categories' ,

		'edit_item'         => 'Edit Story Category', 
		'update_item'       =>  'Update Story Category' ,
		'add_new_item'      => 'Add New Story Category' ,
		'new_item_name'     =>  'New Story Category' ,
		'menu_name'         =>  'Story Categories',
	);
	$args = array(
		'labels' => $labels,
		'show_admin_column' => true,
		'hierarchical' => true,
	);
	register_taxonomy( 'story_category', 'story', $args );
}
add_action( 'init', 'my_taxonomies_story', 0 );

/* 2.5:  Create navigation for long story pages -- adapted from twentythirteen_paging_nav() in functions.php*/
function story_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'More stories <span class="meta-nav">&rarr;</span> ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Back ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

 /* 3.0  THE DEFINITION OF COZMEENA 
 * --------------------------------------------------*/
 
/* 3.1:  Add Definition custom post type  - 'definition' */
function my_custom_post_definition() {
	$definition_labels = array(
		'name'               => 'Definition',
		'singular_name'      =>  'Definition', 
		'add_new'            => 'Add New', 'book' ,
		'add_new_item'       => 'Add New Definition',
		'edit_item'          =>  'Edit Definition' ,
		'new_item'           => 'New Definition' ,
		'all_items'          => 'All Definitions' ,
		'view_item'          =>  'View Definitions' ,
		'search_items'       =>  'Search Definitions' ,
		'not_found'          => 'No Definitions found' ,
		'not_found_in_trash' =>  'No Definitions found in the Trash' , 
		'parent_item_colon'  => '',
		'menu_name'          => 'Definitions'
	);
	$definition_args = array(
		'labels'        => $definition_labels,
		'description'   => 'Holds our definitions of Cozmeena',
		'public'        => true,
		'menu_position' => 5,
		'menu_icon' => '',
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions'  ),  // DID NOT INCLUDE AUTHOR, TRACKBACKS etc.
		'taxonomies' => array( 'post_tag'),
		'has_archive'   => true,
		);
	register_post_type( 'definition', $definition_args );	
}
add_action( 'init', 'my_custom_post_definition' );

/* 3.2: Customize user messages for 'definition' post type */
function my_updated_definition_messages( $definition_messages ) {
	global $post, $post_ID;
	$story_messages['definition'] = array(
		0 => '', 
		1 => sprintf( 'definition updated. <a href="%s">View definition</a>', esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Definition updated.',
		5 => isset($_GET['revision']) ? sprintf( 'Definition restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Definition published. <a href="%s">View Definition</a>', esc_url( get_permalink($post_ID) ) ),
		7 => 'Definitionsaved.',
		8 => sprintf( 'Definition submitted. <a target="_blank" href="%s">Preview definition</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Definition scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Definition</a>', date_i18n( 'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Definition draft updated. <a target="_blank" href="%s">Preview Definition</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $story_messages;
}
add_filter( 'post_updated_messages', 'my_updated_definition_messages' );

add_action('do_meta_boxes', 'move_definition_meta_boxes');

/* 3.3: Move 'Revisions' meta boxes to side in definition post type*/
function move_definition_meta_boxes(){
   	remove_meta_box( 'revisionsdiv', 'definition', 'side' );
    add_meta_box('revisionsdiv',__('Revisions'),'post_revisions_meta_box','definition', 'side');
}


 




/* 4.0  COZMEENA RECIPES
 * --------------------------------------------------*/
/* 4.1:  Add Recipe custom post type  - 'recipe'*/
function my_custom_post_recipe() {
	$recipe_labels = array(
		'name'               => 'Recipes', 
		'singular_name'      => 'Recipe', 
		'add_new'            =>  'Add New', 
		'add_new_item'       =>  'Add New Recipe' ,
		'edit_item'          => 'Edit Recipe' ,
		'new_item'           =>  'New Recipe' ,
		'all_items'          => 'All Recipes' ,
		'view_item'          => 'View Recipe' ,
		'search_items'       => 'Search Recipes' ,
		'not_found'          => 'No Recipes found' ,
		'not_found_in_trash' => 'No Recipes found in the Trash' , 
		'parent_item_colon'  => '',
		'menu_name'          => 'Recipes'
	);
	$recipe_args = array(
		'labels'        => $recipe_labels,
		'description'   => 'Holds our Cozmeena Recipes',
		'public'        => true,
		'menu_position' => 5,
		'menu_icon' => '',		
		'supports'      => array( 'title', 'thumbnail', 'excerpt', 'comments', 'revisions' ),  // DID NOT INCLUDE AUTHOR, TRACKBACKS etc.
		'taxonomies' => array( 'post_tag'),
		'has_archive'   => true,
		);
	register_post_type( 'recipe', $recipe_args );	
}
add_action( 'init', 'my_custom_post_recipe' );

/* 4.2: Customize user messages for 'recipe' post type */
function my_updated_recipe_messages( $recipe_messages ) {
	global $post, $post_ID;
	$recipe_messages['recipe'] = array(
		0 => '', 
		1 => sprintf( 'Recipe updated. <a href="%s">View Recipe</a>', esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Recipe updated.',
		5 => isset($_GET['revision']) ? sprintf( 'Recipe restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Recipe published. <a href="%s">View Recipe</a>', esc_url( get_permalink($post_ID) ) ),
		7 => 'Recipe saved.',
		8 => sprintf( 'Recipe submitted. <a target="_blank" href="%s">Preview recipe</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Recipe scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Recipe</a>', date_i18n(  'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Recipe draft updated. <a target="_blank" href="%s">Preview Recipe</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $recipe_messages;  
}
add_filter( 'post_updated_messages', 'my_updated_recipe_messages' );

add_action('do_meta_boxes', 'move_recipe_meta_boxes');

/* 4.3: Move 'Revisions' meta boxes to side in recipe post type*/
function move_recipe_meta_boxes(){
   	remove_meta_box( 'revisionsdiv', 'recipe', 'side' );
    add_meta_box('revisionsdiv','Revisions','post_revisions_meta_box','recipe', 'side');
}

/* 4.4:  Create custom taxonomy to categorize Cozmeena Recipes */
function my_taxonomies_recipe() {
	$labels = array(
		'name'              => 'Recipe Categories', 
		'singular_name'     => 'Recipe Category', 
		'search_items'      => 'Search Recipe Categories' ,
		'all_items'         =>  'All Categories',

		'edit_item'         => 'Edit Recipe Category' , 
		'update_item'       => 'Update Recipe Category' ,
		'add_new_item'      => 'Add New Recipe Category' ,
		'new_item_name'     => 'New Recipe Category' ,
		'menu_name'         => 'Recipe Categories',
	);
	$args = array(
		'labels' => $labels,
		'show_admin_column' => true,
		'hierarchical' => true,
	);
	register_taxonomy( 'recipe_category', 'recipe', $args );
}
add_action( 'init', 'my_taxonomies_recipe', 0 );

/* 4.5:  Create navigation for long recipe pages -- adapted from twentythirteen_paging_nav() in functions.php*/
function recipe_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'More recipes <span class="meta-nav">&rarr;</span> ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Back ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/* 5.0  COZMEENA CRAFTS
 * --------------------------------------------------*/
/* 5.1:  Add Craft custom post type  - 'craft'*/
function my_custom_post_craft() {
	$craft_labels = array(
		'name'               => 'Crafts', 
		'singular_name'      => 'Craft', 
		'add_new'            => 'Add New', 
		'add_new_item'       =>  'Add New Craft' ,
		'edit_item'          =>  'Edit Craft' ,
		'new_item'           =>  'New Craft' ,
		'all_items'          =>  'All Crafts' ,
		'view_item'          =>  'View Craft' ,
		'search_items'       =>  'Search Crafts' ,
		'not_found'          =>  'No Crafts found' ,
		'not_found_in_trash' =>  'No Crafts found in the Trash' , 
		'parent_item_colon'  => '',
		'menu_name'          => 'Crafts'
	);
	$craft_args = array(
		'labels'        => $craft_labels,
		'description'   => 'Holds our Cozmeena Crafts',
		'public'        => true,
		'menu_position' => 5,
		'menu_icon' => '',		
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions' ),  // DID NOT INCLUDE AUTHOR, TRACKBACKS etc.
		'taxonomies' => array( 'post_tag'),
		'has_archive'   => true,
		'capability_type' 		=> 'craft', // need to assign capabilities via plugin
		'map_meta_cap'			=> true,
		'show_ui' 				=> true,
		'publicly_queryable' 	=> true,
		'exclude_from_search' 	=> false,
		'hierarchical' 			=> false,
		'query_var' 			=> true,
		);
	register_post_type( 'craft', $craft_args );	
}
add_action( 'init', 'my_custom_post_craft' );

/* 5.2: Customize user messages for 'craft' post type */
function my_updated_craft_messages( $craft_messages ) {
	global $post, $post_ID;
	$craft_messages['craft'] = array(
		0 => '', 
		1 => sprintf( 'Craft updated. <a href="%s">View Craft</a>', esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Craft updated.',
		5 => isset($_GET['revision']) ? sprintf( 'Craft restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Craft published. <a href="%s">View Craft</a>', esc_url( get_permalink($post_ID) ) ),
		7 => 'Craft saved.',
		8 => sprintf( 'Craft submitted. <a target="_blank" href="%s">Preview craft</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Craft scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Craft</a>', date_i18n(  'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Craft draft updated. <a target="_blank" href="%s">Preview Craft</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $craft_messages;  
}
add_filter( 'post_updated_messages', 'my_updated_craft_messages' );

add_action('do_meta_boxes', 'move_craft_meta_boxes');

/* 5.3: Move 'Revisions' meta boxes to side in craft post type*/
function move_craft_meta_boxes(){
   	remove_meta_box( 'revisionsdiv', 'craft', 'side' );
    add_meta_box('revisionsdiv','Revisions','post_revisions_meta_box','craft', 'side');
}

/* 5.4:  Create custom taxonomy to categorize Cozmeena Crafts */
function my_taxonomies_craft() {
	$labels = array(
		'name'              => 'Craft Categories', 
		'singular_name'     => 'Craft Category', 
		'search_items'      =>  'Search Craft Categories' ,
		'all_items'         =>  'All Categories' ,

		'edit_item'         =>  'Edit Craft Category' , 
		'update_item'       =>  'Update Craft Category' ,
		'add_new_item'      =>  'Add New Craft Category' ,
		'new_item_name'     =>  'New Craft Category' ,
		'menu_name'         =>  'Craft Categories' ,
	);
	$args = array(
		'labels' => $labels,
		'show_admin_column' => true,
		'hierarchical' => true,
	);
	register_taxonomy( 'craft_category', 'craft', $args );
}
add_action( 'init', 'my_taxonomies_craft', 0 );

/* 5.5:  Create navigation for long craft pages -- adapted from twentythirteen_paging_nav() in functions.php*/
function craft_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'More crafts <span class="meta-nav">&rarr;</span> ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Back ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/* 6.0  COZMEDIA REVIEWS
 * --------------------------------------------------*/
/* 6.1:  Add Review custom post type  - 'review'*/
function my_custom_post_review() {
	$review_labels = array(
		'name'               => 'Reviews', 
		'singular_name'      => 'Review', 
		'add_new'            => 'Add New', 'book' ,
		'add_new_item'       =>  'Add New Review' ,
		'edit_item'          =>  'Edit Review' ,
		'new_item'           =>  'New Review' ,
		'all_items'          =>  'All Reviews' ,
		'view_item'          =>  'View Review' ,
		'search_items'       =>  'Search Reviews' ,
		'not_found'          =>  'No Reviews found' ,
		'not_found_in_trash' =>  'No Reviews found in the Trash' , 
		'parent_item_colon'  => '',
		'menu_name'          => 'Reviews'
	);
	$review_args = array(
		'labels'        => $review_labels,
		'description'   => 'Holds our Cozmeena Reviews',
		'public'        => true,
		'menu_position' => 5,
		'menu_icon' => '',		
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions' ),  // DID NOT INCLUDE AUTHOR, TRACKBACKS etc.
		'taxonomies' => array( 'post_tag'),
		'has_archive'   => true,
		);
	register_post_type( 'review', $review_args );	
}
add_action( 'init', 'my_custom_post_review' );

/* 6.2: Customize user messages for 'review' post type */
function my_updated_review_messages( $review_messages ) {
	global $post, $post_ID;
	$review_messages['review'] = array(
		0 => '', 
		1 => sprintf( 'Review updated. <a href="%s">View Review</a>', esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Review updated.',
		5 => isset($_GET['revision']) ? sprintf( 'Review restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Review published. <a href="%s">View Review</a>', esc_url( get_permalink($post_ID) ) ),
		7 => 'Review saved.',
		8 => sprintf( 'Review submitted. <a target="_blank" href="%s">Preview review</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Review scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Review</a>', date_i18n(  'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Review draft updated. <a target="_blank" href="%s">Preview Review</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $review_messages;  
}
add_filter( 'post_updated_messages', 'my_updated_review_messages' );

add_action('do_meta_boxes', 'move_review_meta_boxes');

/* 6.3: Move 'Revisions' meta boxes to side in review post type*/
function move_review_meta_boxes(){
   	remove_meta_box( 'revisionsdiv', 'review', 'side' );
    add_meta_box('revisionsdiv','Revisions','post_revisions_meta_box','review', 'side');
}

/* 6.4:  Create custom taxonomy to categorize CozMedia Reviews */
function my_taxonomies_review() {
	$labels = array(
		'name'              => 'Review Categories', 
		'singular_name'     => 'Review Category', 
		'search_items'      =>  'Search Review Categories',
		'all_items'         =>  'All Categories' ,

		'edit_item'         =>  'Edit Review Category' ,
		'update_item'       =>  'Update Review Category' ,
		'add_new_item'      =>  'Add New Review Category' ,
		'new_item_name'     =>  'New Review Category' ,
		'menu_name'         =>  'Review Categories' ,
	);
	$args = array(
		'labels' => $labels,
		'show_admin_column' => true,
		'hierarchical' => true,
	);
	register_taxonomy( 'review_category', 'review', $args );
}
add_action( 'init', 'my_taxonomies_review', 0 );

/* 6.5:  Create navigation for long reviews pages -- adapted from twentythirteen_paging_nav() in functions.php*/
function review_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( 'More registrations <span class="meta-nav">&rarr;</span> ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Back ', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}




/* 7.0 COLUMNS FOR CUSTOM POST TYPES 
 * --------------------------------------------------*/
 
/* 7.1:  Change Resource post columns */

function change_resource_columns( $cols ) {
  $cols = array(
    'cb'  => '<input type="checkbox" />',
	'title' =>  'Title',
	'resource_category' =>  'Resource Category',
	'tags' => ' Tags', 
	'date'  =>  'Date',
	'aiotitle' =>  'SEO Title', 
	'aiodesc' =>  'SEO Description',
  );
  return $cols;
}
add_filter( "manage_resource_posts_columns", "change_resource_columns" );

function resource_columns( $column, $post_id ) { //Populate columns with data
  switch ( $column ) {

	case "resource_category": 
	  $terms = wp_get_post_terms($post_id,'resource_category');  
		foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
		break; 

	case "aiotitle":
		echo get_post_meta( $post_id, '_aioseop_title', true);
		break; 

	case "aiodesc":
		echo get_post_meta( $post_id, '_aioseop_description', true);
		break; 
  }
}

add_action( "manage_posts_custom_column", "resource_columns", 10, 2 );

function resource_sortable_columns() { // Make these columns sortable
  return array(
    'title' => 'title',
	'date' => 'date',
	'aiotitle' => 'aiotitle',
	);
}

add_filter( "manage_edit-resource_sortable_columns", "resource_sortable_columns" );

function my_resource_filter() { //Add filter function for resource category
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'resource' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Resource Categories',
            'taxonomy' => 'resource_category',
            'name' => 'resource_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['resource_category'] ) ? $wp_query->query['resource_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

function resource_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['resource_category'] ) && is_numeric( $qv['resource_category'] ) ) {
        $term = get_term_by( 'id', $qv['resource_category'], 'resource_category' );
        $qv['resource_category'] = $term->slug;
    }
}

add_filter( 'parse_query','resource_filtering' );

add_action( 'restrict_manage_posts', 'my_resource_filter' );



/* 7.2:  Change Story post columns */
function change_story_columns( $cols ) {
  $cols = array(
    'cb'  => '<input type="checkbox" />',
	'title' =>  'Title',
	'story_category' =>  'Story Category',
	'tags' => ' Tags', 
    'order'  =>  'Story Order', 
	'date'  =>  'Date',
	'aiotitle' =>  'SEO Title', 
	'aiodesc' =>  'SEO Description',
  );
  return $cols;
}
add_filter( "manage_story_posts_columns", "change_story_columns" );

function story_columns( $column, $post_id ) { //Populate columns with data
  switch ( $column ) {
    case "order":
      echo get_post_meta( $post_id, '_simple_fields_fieldGroupID_9_fieldID_1_numInSet_0', true);
      break;

	case "story_category": 
	  $terms = wp_get_post_terms($post_id,'story_category');  
		foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
		break; 
  }
}

add_action( "manage_posts_custom_column", "story_columns", 10, 2 );

function sortable_columns() { // Make these columns sortable
  return array(
    'title' => 'title',
    'order' => 'order',
	'aiotitle' => 'aiotitle',
	'date' => 'date'
	);
}

add_filter( "manage_edit-story_sortable_columns", "sortable_columns" );


function my_storynum_orderby( $query ) {  // Add sort function for story order
	if( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby');

	if( 'order' == $orderby ) {
		$query->set('meta_key','_simple_fields_fieldGroupID_9_fieldID_1_numInSet_0');
		$query->set('orderby','meta_value_num');
	}
}

add_action( 'pre_get_posts', 'my_storynum_orderby' );

function my_seotitle_orderby( $query ) { //Add sort function for SEO Title
	if( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby');

	if( 'order' == $orderby ) {
		$query->set('meta_key','_aioseop_title');
		$query->set('orderby','meta_value_num');
	}
}

add_action( 'pre_get_posts', 'my_seotitle_orderby' );

function my_story_filter() { //Add filter function for story category
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'story' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Story Categories',
            'taxonomy' => 'story_category',
            'name' => 'story_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['story_category'] ) ? $wp_query->query['story_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

function story_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['story_category'] ) && is_numeric( $qv['story_category'] ) ) {
        $term = get_term_by( 'id', $qv['story_category'], 'story_category' );
        $qv['story_category'] = $term->slug;
    }
}

add_filter( 'parse_query','story_filtering' );

add_action( 'restrict_manage_posts', 'my_story_filter' );


/* 7.3:  Change Recipe post columns */
function change_recipe_columns( $cols ) {
  $cols = array(
    'cb'  => '<input type="checkbox" />',
	'title' =>  'Title',
	'recipe_category' =>  'Recipe Category',
	'tags' => ' Tags', 
	'date'  =>  'Date',
	'aiotitle' =>  'SEO Title', 
	'aiodesc' =>  'SEO Description',
  );
  return $cols;
}
add_filter( "manage_recipe_posts_columns", "change_recipe_columns" );

function recipe_columns( $column, $post_id ) { //Populate columns with data
  switch ( $column ) {

	case "recipe_category": 
	  $terms = wp_get_post_terms($post_id,'recipe_category');  
		foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
		break; 
  }
}

add_action( "manage_posts_custom_column", "recipe_columns", 10, 2 );

function my_recipe_filter() { //Add filter function for recipe category
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'recipe' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Recipe Categories',
            'taxonomy' => 'recipe_category',
            'name' => 'recipe_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['recipe_category'] ) ? $wp_query->query['recipe_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

function recipe_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['recipe_category'] ) && is_numeric( $qv['recipe_category'] ) ) {
        $term = get_term_by( 'id', $qv['recipe_category'], 'recipe_category' );
        $qv['recipe_category'] = $term->slug;
    }
}

add_filter( 'parse_query','recipe_filtering' );

add_action( 'restrict_manage_posts', 'my_recipe_filter' );

/* 7.4:  Change Definition post columns */
function change_definition_columns( $cols ) {
  $cols = array(
    'cb'  => '<input type="checkbox" />',
	'title' =>  'Title',
	'definition_category' =>  'Definition Category',
	'tags' => ' Tags', 
	'date'  =>  'Date',
	'aiotitle' =>  'SEO Title', 
	'aiodesc' =>  'SEO Description',
  );
  return $cols;
}
add_filter( "manage_definition_posts_columns", "change_definition_columns" );

function definition_columns( $column, $post_id ) { //Populate columns with data
  switch ( $column ) {

	case "definition_category": 
	  $terms = wp_get_post_terms($post_id,'definition_category');  
		foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
		break; 
  }
}

add_action( "manage_posts_custom_column", "definition_columns", 10, 2 );

function my_definition_filter() { //Add filter function for definition category
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'definition' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Definition Categories',
            'taxonomy' => 'definition_category',
            'name' => 'definition_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['definition_category'] ) ? $wp_query->query['definition_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

function definition_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['definition_category'] ) && is_numeric( $qv['definition_category'] ) ) {
        $term = get_term_by( 'id', $qv['definition_category'], 'definition_category' );
        $qv['definition_category'] = $term->slug;
    }
}

add_filter( 'parse_query','definition_filtering' );

add_action( 'restrict_manage_posts', 'my_definition_filter' );


/* 7.5:  Change Craft post columns */
function change_craft_columns( $cols ) {
  $cols = array(
    'cb'  => '<input type="checkbox" />',
	'title' =>  'Title',
	'craft_category' =>  'Craft Category',
	'tags' => ' Tags', 
	'order'  =>  'Story Order', 
	'date'  =>  'Date',
	'aiotitle' =>  'SEO Title', 
	'aiodesc' =>  'SEO Description',
  );
  return $cols;
}
add_filter( "manage_craft_posts_columns", "change_craft_columns" );

function craft_columns( $column, $post_id ) { //Populate columns with data
  switch ( $column ) {
	
	case "craft_category": 
	  $terms = wp_get_post_terms($post_id,'craft_category');  
		foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
		break; 
  }
}

add_action( "manage_posts_custom_column", "craft_columns", 10, 2 );

function my_craft_filter() { //Add filter function for craft category
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'craft' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Craft Categories',
            'taxonomy' => 'craft_category',
            'name' => 'craft_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['craft_category'] ) ? $wp_query->query['craft_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

function sortable_craft_columns() { // Make these columns sortable
  return array(
    'title' => 'title',
    'order' => 'order',
	'aiotitle' => 'aiotitle',
	'date' => 'date'
	);
}

add_filter( "manage_edit-craft_sortable_columns", "sortable_craft_columns" );


function my_craftnum_orderby( $query ) {  // Add sort function for craft order
	if( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby');

	if( 'order' == $orderby ) {
		$query->set('meta_key','_simple_fields_fieldGroupID_9_fieldID_1_numInSet_0');
		$query->set('orderby','meta_value_num');
	}
}

add_action( 'pre_get_posts', 'my_craftnum_orderby' );


function craft_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['craft_category'] ) && is_numeric( $qv['craft_category'] ) ) {
        $term = get_term_by( 'id', $qv['craft_category'], 'craft_category' );
        $qv['craft_category'] = $term->slug;
    }
}

add_filter( 'parse_query','craft_filtering' );

add_action( 'restrict_manage_posts', 'my_craft_filter' );




/* 7.6:  Change Review post columns */
function change_review_columns( $cols ) {
  $cols = array(
    'cb'  => '<input type="checkbox" />',
	'title' =>  'Title',
	'review_category' =>  'Review Category',
	'tags' => ' Tags', 
	'date'  =>  'Date',
	'aiotitle' =>  'SEO Title', 
	'aiodesc' =>  'SEO Description',
  );
  return $cols;
}
add_filter( "manage_review_posts_columns", "change_review_columns" );

function review_columns( $column, $post_id ) { //Populate columns with data
  switch ( $column ) {

	case "review_category": 
	  $terms = wp_get_post_terms($post_id,'review_category');  
		foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
		break; 
  }
}

add_action( "manage_posts_custom_column", "review_columns", 10, 2 );

function my_review_filter() { //Add filter function for review category
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'review' ) {
        wp_dropdown_categories( array(
            'show_option_all' => 'Show All Review Categories',
            'taxonomy' => 'review_category',
            'name' => 'review_category',
            'orderby' => 'name',
            'selected' => ( isset( $wp_query->query['review_category'] ) ? $wp_query->query['review_category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ) );
    }
}

function review_filtering( $query ) {
    $qv = &$query->query_vars;
    if ( ( $qv['review_category'] ) && is_numeric( $qv['review_category'] ) ) {
        $term = get_term_by( 'id', $qv['review_category'], 'review_category' );
        $qv['review_category'] = $term->slug;
    }
}

add_filter( 'parse_query','review_filtering' );

add_action( 'restrict_manage_posts', 'my_review_filter' );


/*  8.0  TAGS FOR CUSTOM POST TYPES
 * --------------------------------------------------*/
add_action( 'pre_get_posts', 'add_custom_post_types' );

function add_custom_post_types( $query ) {
	if ( $query->is_tag )
	$query->set('post_type', array('post', 'resource', 'story', 'definition', 'recipe', 'craft', 'review'));
return $query;
}

 /* 9.0:  POST NAVIGATION  based on: http://bucketpress.com/next-and-previous-post-link-in-same-custom-taxonomy
 * --------------------------------------------------------------------------------------------------------------*/

/* 9.1 Resource post navigation */
if ( ! function_exists( 'resource_post_nav' ) ) :

function resource_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Resource navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

		<?php 
		
			$postlist_args = array(
				'posts_per_page'  => -1,
				'orderby'         => 'title',
				'order'           => 'ASC',
				'post_type'       => 'resource',
				
			); 
			$postlist = get_posts( $postlist_args );

// get ids of posts retrieved from get_posts
			$ids = array();
			foreach ($postlist as $thepost) {
				$ids[] = $thepost->ID;
}

// get and echo previous and next post in the same taxonomy        
			$thisindex = array_search($post->ID, $ids);
			$previd = $ids[$thisindex-1];
			$prevtitle = get_the_title($previd);
			$nextid = $ids[$thisindex+1];
			$nexttitle = get_the_title($nextid);
			
			
			if ( !empty($previd) ) {
			   echo '<a rel="prev" href="' . get_permalink($previd). '">&larr;' . $prevtitle. '</a>';
			}
			if ( !empty($nextid) ) {
				   echo '<a rel="next" href="' . get_permalink($nextid). '"> '.$nexttitle.'&rarr;</a>';
			}
			
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
 
 /* 9.2 Story post navigation */
if ( ! function_exists( 'story_post_nav' ) ) :

function story_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Story navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

		<?php 
		
			$postlist_args = array(
				'posts_per_page'  => -1,
				'meta_key'		=> '_simple_fields_fieldGroupID_9_fieldID_1_numInSet_0', 
				'orderby'         => 'meta_value_num',
				'order'           => 'ASC',
				'post_type'       => 'story',
				
			); 
			$postlist = get_posts( $postlist_args );

// get ids of posts retrieved from get_posts
			$ids = array();
			foreach ($postlist as $thepost) {
				$ids[] = $thepost->ID;
}

// get and echo previous and next post in the same taxonomy        
			$thisindex = array_search($post->ID, $ids);
			$previd = $ids[$thisindex-1];
			$prevtitle = get_the_title($previd);
			$nextid = $ids[$thisindex+1];
			$nexttitle = get_the_title($nextid);
			
			
			if ( !empty($previd) ) {
			   echo '<a rel="prev" href="' . get_permalink($previd). '">&larr;' . $prevtitle. '</a>';
			}
			if ( !empty($nextid) ) {
				   echo '<a rel="next" href="' . get_permalink($nextid). '"> '.$nexttitle.'&rarr;</a>';
			}
			
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
 
/* 9.3 Recipe post navigation */
if ( ! function_exists( 'recipe_post_nav' ) ) :

function recipe_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Recipe navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

		<?php 
		
			$postlist_args = array(
				'posts_per_page'  => -1,
				'orderby'         => 'title',
				'order'           => 'ASC',
				'post_type'       => 'recipe',
				
			); 
			$postlist = get_posts( $postlist_args );

// get ids of posts retrieved from get_posts
			$ids = array();
			foreach ($postlist as $thepost) {
				$ids[] = $thepost->ID;
}

// get and echo previous and next post in the same taxonomy        
			$thisindex = array_search($post->ID, $ids);
			$previd = $ids[$thisindex-1];
			$prevtitle = get_the_title($previd);
			$nextid = $ids[$thisindex+1];
			$nexttitle = get_the_title($nextid);
			
			
			if ( !empty($previd) ) {
			   echo '<a rel="prev" href="' . get_permalink($previd). '">&larr;' . $prevtitle. '</a>';
			}
			if ( !empty($nextid) ) {
				   echo '<a rel="next" href="' . get_permalink($nextid). '"> '.$nexttitle.'&rarr;</a>';
			}
			
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
   
/* 9.4 Craft post navigation */
if ( ! function_exists( 'crafts_post_nav' ) ) :

function crafts_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Craft navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

		<?php 
			$postlist_args = array(
				'posts_per_page'  => -1,
				'meta_key'		=> '_simple_fields_fieldGroupID_9_fieldID_1_numInSet_0', 
				'orderby'         => 'meta_value_num',
				'order'           => 'ASC',
				'post_type'       => 'craft',
				
			); 
			$postlist = get_posts( $postlist_args );

// get ids of posts retrieved from get_posts
			$ids = array();
			foreach ($postlist as $thepost) {
				$ids[] = $thepost->ID;
}

// get and echo previous and next post in the same taxonomy        
			$thisindex = array_search($post->ID, $ids);
			$previd = $ids[$thisindex-1];
			$prevtitle = get_the_title($previd);
			$nextid = $ids[$thisindex+1];
			$nexttitle = get_the_title($nextid);
			
			
			if ( !empty($previd) ) {
			   echo '<a rel="prev" href="' . get_permalink($previd). '">&larr;' . $prevtitle. '</a>';
			}
			if ( !empty($nextid) ) {
				   echo '<a rel="next" href="' . get_permalink($nextid). '"> '.$nexttitle.'&rarr;</a>';
			}
			
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/* 9.5 Review post navigation */
if ( ! function_exists( 'review_post_nav' ) ) :

function review_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'CozMedia Review navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

		<?php 
		
			$postlist_args = array(
				'posts_per_page'  => -1,
				'orderby'         => 'title',
				'order'           => 'ASC',
				'post_type'       => 'review',
				
			); 
			$postlist = get_posts( $postlist_args );

// get ids of posts retrieved from get_posts
			$ids = array();
			foreach ($postlist as $thepost) {
				$ids[] = $thepost->ID;
}

// get and echo previous and next post in the same taxonomy        
			$thisindex = array_search($post->ID, $ids);
			$previd = $ids[$thisindex-1];
			$prevtitle = get_the_title($previd);
			$nextid = $ids[$thisindex+1];
			$nexttitle = get_the_title($nextid);
			
			
			if ( !empty($previd) ) {
			   echo '<a rel="prev" href="' . get_permalink($previd). '">&larr;' . $prevtitle. '</a>';
			}
			if ( !empty($nextid) ) {
				   echo '<a rel="next" href="' . get_permalink($nextid). '"> '.$nexttitle.'&rarr;</a>';
			}
			
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
 
 ?>