<?php

/**
 * Plugin Name: Cozmeena Registry 
 * Description: A plugin that creates a custom post type and adds the custom fields and meta boxes necessary for the Cozmeena Registry entries
 * Version: 2.1
 * Author: Sarah Maris 
 * Revised: 08-11-15 
 */

/* * Based on 	http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/  snd
				http://themefoundation.com/wordpress-meta-boxes-guide/

*/


 /**
 * Table of Contents:
 *
 *  1.0 - Register post type 'coz_registry' and taxonomies
 *   .1 - Register post type 
 *   .2 - Customize user messages
 *   .3 - Create custom taxonomy to categorize wool types and colors and display page
 *   .4 - Navigation for long registry pages
 *
 *  2.0 - Create custom meta boxes
 *   .1 - Fire our meta box setup function 
 *   .2 - Meta box setup function
 *   .3 - Create meta boxes to be displayed on the editor screen
 *   .4 - Display the Registry Info post meta box
 *   .5 - Display the Registry Number post meta box
 *
 *  3.0 - Save custom meta box data
 *   .1 - Save Registry info data
 *   .2 - Save Registry number data
 *
 *  4.0 - Customize Cozmeena Registry input page
 *   .1 - Add instruction box above data meta boxes
 *   .2 - Change "featured image" box titles
 *   .3 - Change "Title" to "Recipient"
 *   .4 - Customize meta box placement and titles
 *
 *  5.0 - Customize admin column options
 *   .1 - Set columns
 *   .2 - Populate the columns with data
 *   .3 - Make the Registry number column sortable
 *
 *  6.0 - Move text editor to the bottom
 *
 *  7.0 - Post navigation
 * 
 *  8.0 - Set display pages to order by number, ascending
 *
 *  9.0 - Create navigation for Registry List pages
 *
 **/

 
 
/* 1.0  REGISTER POST TYPE
* --------------------------------------------------*/

/* 1.1  Add Cozmeena Registry custom post type  - 'coz_registry'*/
function my_custom_post_registry() {
	$registry_labels = array(
		'name' => 'Registrations',
		'singular_name' => 'Cozmeena Shawl Registration',
		'add_new' => 'Add New',
		'all_items' => 'All Registrations',
		'add_new_item' => 'Add New Registration',
		'edit_item' => 'Edit Registration',
		'new_item' => 'New Registration',
		'view_item' => 'View Registration',
		'search_items' => 'Search Registrations',
		'not_found' =>  'No Registrations found',
		'not_found_in_trash' => 'No Registrations found in trash',
		'parent_item_colon' => '',
		'menu_name' => 'Cozmeena Shawl Registrations'
	);
	$registry_args = array(
		'labels' => $registry_labels,
		'description' => "The International Cozmeena Registry is the official record of Cozmeena Shawls",
		'public' => true,
		'menu_position' => 5,
		'menu_icon' => '',
		'supports' => array('title','author', 'editor','thumbnail'),
		'capability_type' => 'coz_registry', // need to assign capabilities via plugin
		'map_meta_cap' => true,
		'has_archive' => true,
	); 
	register_post_type('coz_registry',$registry_args);
}

add_action( 'init', 'my_custom_post_registry' );				
				
/* 1.2: Customize user messages for 'coz_registry' post type */
function my_updated_registration_messages( $coz_registry_messages ) {
	global $post, $post_ID;
	$review_messages['coz_registry'] = array(
		0 => '', 
		1 => sprintf( 'Registration updated. <a href="%s">View Registration</a>', esc_url( get_permalink($post_ID) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'Registration updated.',
		5 => isset($_GET['revision']) ? sprintf( 'Registration restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'Registration published. <a href="%s">View Registration</a>', esc_url( get_permalink($post_ID) ) ),
		7 => 'Registration saved.',
		8 => sprintf( 'Registration submitted. <a target="_blank" href="%s">Preview Registration</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( 'Registration scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Registration</a>', date_i18n(  'M j, Y @ G:i' , strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( 'Registration draft updated. <a target="_blank" href="%s">Preview Registration</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $review_messages;  
}
add_filter( 'post_updated_messages', 'my_updated_registration_messages' );

/* 1.3 Create custom taxonomy to categorize wool types and colors and display page */
function my_taxonomies_registry() {
	$type_labels = array(
		'name'              => 'Wool Type',
		'singular_name'     => 'Wool Type',
		'search_items'      => 'Search Wool Types',
		'all_items'         => 'All Wool Types' ,
		'edit_item'         => 'Wool Type', 
		'update_item'       => 'Update Wool Type',
		'add_new_item'      => 'Add New Wool Type',
		'new_item_name'     => 'New Wool Type',
		'menu_name'         => 'Wool Types',
		'choose_from_most_used'    => 'Choose from most used wool types' 
	);
	$type_args = array(
		'labels' => $type_labels,
		'show_admin_column' => true,
		'hierarchical' => false,
		'capabilities' => array (
            'manage_terms' => 'manage_wool', //by default only admin
            'edit_terms' => 'edit_wool',
            'delete_terms' => 'delete_wool',
            'assign_terms' => 'assign_wool' 
             ),
		'public' => true,
		'query_var' => true,
		'show_ui'=> true,
		'show_tagcloud' => false,		
	);
	$color_labels = array(
		'name'              => 'Wool Colors',
		'singular_name'     => 'Wool Color',
		'search_items'      => 'Search Wool Colors',
		'all_items'         => 'All Wool Colors' ,
		'edit_item'         => 'Wool Color', 
		'update_item'       => 'Update Wool Color',
		'add_new_item'      => 'Add New Wool Color',
		'new_item_name'     => 'New Wool Color',
		'menu_name'         => 'Wool Colors',
		'choose_from_most_used'    => 'Choose from most used wool colors' 
	);
	$color_args = array(
		'labels' => $color_labels,
		'show_admin_column' => true,
		'hierarchical' => false,
		'capabilities' => array (
            'manage_terms' => 'manage_color', //by default only admin
            'edit_terms' => 'edit_color',
            'delete_terms' => 'delete_color',
            'assign_terms' => 'assign_color' 
             ),
		'public'  => true,
		'query_var'  => true,
		'show_ui'  => true,
		'show_tagcloud' => false,		
	);	
	$page_labels = array(
		'name'              => 'Display pages',
		'singular_name'     => 'Display pages',
		'search_items'      => 'Search Display pages',
		'all_items'         => 'All Display pages' ,
		'edit_item'         => 'Display pages', 
		'update_item'       => 'Update Display page',
		'add_new_item'      => 'Add New Display page',
		'new_item_name'     => 'New Display page',
		'menu_name'         => 'Display pages',
		'choose_from_most_used'    => 'Choose from most used' 
	);
	$page_args = array(
		'labels' => $page_labels,
		'show_admin_column' => true,
		'hierarchical' => false,
		'capabilities' => array (
            'manage_terms' => 'manage_color', //by default only admin
            'edit_terms' => 'edit_color',
            'delete_terms' => 'delete_color',
            'assign_terms' => 'assign_color' 
             ),
		'public'  => true,
		'query_var'  => true,
		'show_ui'  => true,
		'show_tagcloud' => false,
		'rewrite' => array('slug' => 'registrations'),		
	);
	register_taxonomy( 'wool_type', 'coz_registry', $type_args );
	register_taxonomy( 'wool_color', 'coz_registry', $color_args );
	register_taxonomy( 'reg_display_page', 'coz_registry', $page_args );
}
add_action( 'init', 'my_taxonomies_registry', 0 );

/* 1.4:  Create navigation for long registration pages -- adapted from twentythirteen_paging_nav() in functions.php*/
function registration_paging_nav() {
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
  
/* 2.0  CREATE CUSTOM META BOXES 
 * --------------------------------------------------*/

/* 2.1 Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'registry_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'registry_post_meta_boxes_setup' );

/* 2.2: Meta box setup function */
function registry_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'registry_add_post_meta_boxes', 1 );

  /* Save post info meta on the 'save_post' hook. */
  add_action( 'save_post', 'registry_save_coz_info_meta', 10, 2 );
  
  /* Save post info meta on the 'save_post' hook. */
  add_action( 'save_post', 'registry_save_coz_num_meta', 10, 2 );
  
}

/* 2.3:  Create meta boxes to be displayed on the editor screen. */
function registry_add_post_meta_boxes() {

  add_meta_box(
    'registry-info',      // Unique ID
    'When did you complete the Cozmeena Shawl?',    // Title
    'registry_coz_info_meta_box',   // Callback function
    'coz_registry',         // Admin page (or post type)
    'side',         // Context
    'core'         // Priority
  );

   global $current_user;
    if($current_user->roles[0] == 'administrator') {
        add_meta_box(
		'registry-num',      // Unique ID
		'International Cozmeena Registration Number',    // Title
		'registry_coz_num_meta_box',   // Callback function
		'coz_registry',         // Admin page (or post type)
		'normal',         // Context
		'low'       // Priority
		);
    }
}

/* 2.4: Display the info post meta box. */
function registry_coz_info_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'registry_coz_info_nonce' ); ?>

  <p>
    <label for="coz-registry-date">Enter a date - exact or approximate</label>
    <br />
    <input class="widefat" type="text" name="coz-registry-date" id="coz-registry-date" value="<?php echo esc_attr( get_post_meta( $object->ID, 'registry_coz_date', true ) ); ?>" />
  </p>  

<?php }

/* 2.5 Display the Registry Number post meta box*/
function registry_coz_num_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'registry_coz_num_nonce' ); ?>

  <p>
    <label for="coz-registry-num">Input International Cozmeena Registration Number</label>
    <br />
    <input class="widefat" type="number" name="coz-registry-num" id="coz-registry-num" value="<?php echo esc_attr( get_post_meta( $object->ID, 'registry_coz_num', true ) ); ?>" />
  </p>  
  
<?php }


/* 3.0  SAVE CUSTOM META BOX DATA 
 * --------------------------------------------------*/

/* 3.1: Save data from info box */ 

function registry_save_coz_info_meta( $post_id, $post ) {

  //Verify the nonce before proceeding
  if ( !isset( $_POST['registry_coz_info_nonce'] ) || !wp_verify_nonce( $_POST['registry_coz_info_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  // Get the post type object.
  $post_type = get_post_type_object( $post->post_type );

  // Check if the current user has permission to edit the post. 
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  // Get the posted data and sanitize it  
  $new_reg_date = ( isset( $_POST['coz-registry-date'] ) ? sanitize_text_field( $_POST['coz-registry-date'] ) : '' );
  
  // Get the meta key 
  $reg_date_key = 'registry_coz_date';

  // Get the meta values of the custom field keys 
  $reg_date = get_post_meta( $post_id, $reg_date_key, true );

	
  // If a new date was added and there was no previous date, add it. 
  if ( $new_reg_date && '' == $reg_date )
    add_post_meta( $post_id, $reg_date_key, $new_reg_date, true );

  // If the new date does not match the old date, update it. 
  elseif ( $new_reg_date && $new_reg_date != $reg_date )
	update_post_meta( $post_id, $reg_date_key, $new_reg_date );

  // If there is no new date but an old date exists, delete it. 
  elseif ( '' == $new_reg_date && $reg_date )
	delete_post_meta( $post_id, $reg_date_key, $reg_date );	
	
	
}

/* 3.2: Save Registration number */

function registry_save_coz_num_meta( $post_id, $post ) {

  //Verify the nonce before proceeding
  if ( !isset( $_POST['registry_coz_num_nonce'] ) || !wp_verify_nonce( $_POST['registry_coz_num_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  // Get the post type object.
  $post_type = get_post_type_object( $post->post_type );

  // Check if the current user has permission to edit the post. 
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  // Get the posted data and sanitize it  
  $new_reg_num = ( isset( $_POST['coz-registry-num'] ) ? intval( $_POST['coz-registry-num'] ) : '' );
  
  //Calculate the Registry Page and set slug
  if ($new_reg_num > 0)	{
	$place = floor (($new_reg_num-1)/20);	
	$reg_page_start = $place*20 +1 ;
	$reg_page_end = $place*20 + 20 ;
	$display_page = "Registrations $reg_page_start - $reg_page_end";		
	
	if ( $new_reg_num  < 20 ) {		
				$cat_slug = "000$reg_page_start" ;

	} elseif ($new_reg_num >=21 && $new_reg_num < 100) {
				$cat_slug = "00$reg_page_start" ;

	} elseif ($new_reg_num >=100 && $new_reg_num < 1000) {
				$cat_slug = "0$reg_page_start" ;
				
	} elseif  ($new_reg_num >= 1000 ) {
				$cat_slug = "$reg_page_start" ;					
	}		
  }
    
  // Get the meta keys 
  $reg_num_key = 'registry_coz_num';

  // Get the meta values of the custom field keys 
  $reg_num = get_post_meta( $post_id, $reg_num_key, true );
	
  // If a new number was added and there was no previous number, add it. 
  if ( $new_reg_num && '' == $reg_num ) {
		add_post_meta( $post_id, $reg_num_key, $new_reg_num, true );
		wp_set_object_terms( $post_id, $display_page, 'reg_display_page', false ); 		

  // If the new num does not match the old num, update it. 
	} elseif ( $new_reg_num && $new_reg_num != $reg_num ) {
		update_post_meta( $post_id, $reg_num_key, $new_reg_num );
		wp_set_object_terms( $post_id, $display_page, 'reg_display_page', false ); 	

  // If there is no new num but an old num exists, delete it. 
	} elseif ( '' == $new_reg_num && $reg_num ) {
		delete_post_meta( $post_id, $reg_num_key, $reg_num );	
		wp_set_object_terms( $post_id, 'Registry number not set', 'reg_display_page', false ); 
	}
	
 // Change category slug
	$post_cats = get_the_terms( $post_id, 'reg_display_page' );
		foreach( $post_cats as $term ) {
			$cat_id = $term->term_id;
			$args = array( 'slug' => $cat_slug );
			wp_update_term( $cat_id, 'reg_display_page', $args  ); 
		}  
}


/* 4.0  CUSTOMIZE REGISTRY INPUT PAGE
 * ---------------------------------*/

/* 4.1 Add instruction box above data meta boxes */
function coz_registry_instructions( $post_type ) {
    $screen = get_current_screen();
    $edit_post_type = $screen->post_type;
    if ( $edit_post_type != 'coz_registry' )
        return;
    ?>
    <div class="after-title-help postbox">
        <h3>Adding a Cozmeena Shawl to the International Cozmeena Registry</h3>
        <div class="inside">
            <p>To add a Cozmeena Shawl to the International Cozmeena Registry you need to do the following</p>
			<ol>
				<li>Enter the name of the person you made the Cozmeena Shawl for in the box above</li>
				<li>Share the story of why you knit this shawl and/or why you chose to give it to the recipient (OPTIONAL)</li>
				<li>Share a photo of your Cozmeena Shawl and/or the shawl recipient (OPTIONAL)</li>
				<li>Enter the date you finished the shawl, the wool color and wool type in the boxes to the right</li>
				<li>Submit for review and publication</li>
			</ol>
			<p>Once your registration has been submitted we will verify your registration, add the official International Cozmeena Registry number, publish it to the Registry* and send your certificate in the mail.</p>
			<p><em>*If you prefer that your registration not be published on our website please send an email with all of your information to <a href="mailto:Lisa@Cozmeena.com?Subject=Private%20Cozmeena%20Shawl%20registration" target="_top"> Lisa@cozmeena.com </a> and request a private registration"</em></p>
        </div><!-- .inside -->
    </div><!-- .postbox -->
<?php }
add_action( 'edit_form_after_title', 'coz_registry_instructions' );

/* 4.2: Change "featured image" box titles */

function coz_registry_photo_titles( $content ) {
    global $current_screen;
 
    if( 'coz_registry' == $current_screen->post_type ) {
		$content = str_replace( __( 'Set featured image' ), __( 'Add photo here' ), $content);
		$content = str_replace( __( 'Remove featured image' ), __( 'Remove photo' ), $content);
	}	
        return $content;
}
add_filter( 'admin_post_thumbnail_html', 'coz_registry_photo_titles' );

/* 4.2: Change "title" to "recipient" */
function coz_registry_recipient( $title ){
     $screen = get_current_screen();
 
     if  ( 'coz_registry' == $screen->post_type ) {
          $title = "Enter recipient's name";
		}
      return $title;
}
add_filter( 'enter_title_here', 'coz_registry_recipient' );

/* 4.3: Customize meta box placement and titles for Cozmeena Registry */
function move_registration_meta_boxes(){
	// change featured image box title for 'coz_registry' post type move 'Registration' meta boxes to side in coz_registry post type
   	remove_meta_box( 'postimagediv', 'coz_registry', 'side' );
    add_meta_box('postimagediv', 'Upload a picture of the Cozmeena Shawl and/or recipient (OPTIONAL)', 'post_thumbnail_meta_box', 'coz_registry', 'side','high');
	// Remove "Revisions" meta box
	remove_meta_box( 'revisionsdiv', 'coz_registry', 'side' );
}
add_action('do_meta_boxes', 'move_registration_meta_boxes');

/* 5.0: CHANGE ADMIN COLUMNS FOR COZMEENA REGISTRY */
/* --------------------------------------------------*/

/* 5.1 Add and rename the Recipient, Knitter, Wool Color and Registry Number columns */  
add_filter( 'manage_edit-coz_registry_columns', 'edit_coz_registry_columns' ) ;

function edit_coz_registry_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Recipient',
		'author' => 'Knitter',
		'wool_color' => 'Wool Color',
		'wool_type' => 'Wool Color',
		'registry_coz_num' => 'Cozmeena Registry Number',
		'reg_display_page' => 'Display Page',
		
	);
	return $columns;
}

/* 5.2 Populate the columns with data */  
add_action( 'manage_coz_registry_posts_custom_column', 'manage_coz_registry_columns', 10, 2 );

function manage_coz_registry_columns( $column, $post_id ) {
	global $post;
	switch( $column ) {
		
		case 'registry_coz_num' :
			$registry_coz_num = get_post_meta( $post_id, 'registry_coz_num', true );
			if ( empty( $registry_coz_num ) )
				echo 'Not yet assigned' ;
			else
				echo $registry_coz_num ;
			break;

		case 'wool_color' :
			$terms = get_the_terms( $post_id, 'wool_color' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'wool_color' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'wool_color', 'display' ) )
					);
				}
				echo join( ', ', $out );
			}
			else {
				_e( 'No color chosen' );
			}
			break;

		case 'wool_type' :
			$terms = get_the_terms( $post_id, 'wool_type' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'wool_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'wool_type', 'display' ) )
					);
				}
				echo join( ', ', $out );
			}
			else {
				_e( 'No wool type chosen' );
			}
			break;
		
		case 'reg_display_page' :
			$terms = wp_get_post_terms($post_id,'reg_display_page');  
			foreach ($terms as $term) {  
				echo $term->name ."<br> ";  
			}
			break;		
			
		default :
			break;
	}
} 
 
/* 5.3 Make the Registry number column sortable */   
add_filter( 'manage_edit-coz_registry_sortable_columns', 'coz_registry_sortable_columns' );

function coz_registry_sortable_columns( $columns ) {
	$columns['registry_coz_num'] = 'registry_coz_num';
	return $columns;
} 
 
/* 5.4 Run the customized columns on the correct page */
add_action( 'load-edit.php', 'coz_registry_load' );

function coz_registry_load() {
	add_filter( 'request', 'coz_sort_registry_nums' );
}

/* Sorts the registry numbers. */
function coz_sort_registry_nums( $vars ) {
	if ( isset( $vars['post_type'] ) && 'coz_registry' == $vars['post_type'] ) {
		if ( isset( $vars['orderby'] ) && 'registry_coz_num' == $vars['orderby'] ) {
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'registry_coz_num',
					'orderby' => 'meta_value_num'
				)
			);
		}
	}
	return $vars;
}
 
/* 6.0  Move Text Editor to the bottom of page 
* --------------------------------------------------*/
add_action( 'add_meta_boxes', 'action_add_meta_boxes', 0 );

function action_add_meta_boxes() {
	global $_wp_post_type_features;
		if (isset($_wp_post_type_features['coz_registry']['editor']) && $_wp_post_type_features['coz_registry']['editor']) {
			unset($_wp_post_type_features['coz_registry']['editor']);
			add_meta_box(
				'description_section',
				__('Tell us the story behind your Cozmeena. (OPTIONAL)  </br><span class= "inside"><em>Why did you knit this Cozmeena shawl and/or why did you give it to this recipient? </br> &nbsp;&nbsp; You can also add more pictures by clicking on the "Add Media" button</em></span>'),
					'inner_custom_box',
					'coz_registry', 'normal', 'low'
				);
			}
add_action( 'admin_head', 'action_admin_head'); //white background
}

function action_admin_head() {
	?>
	<style type="text/css">
		.wp-editor-container{background-color:#fff;}
	</style>
	<?php
}

function inner_custom_box( $post ) {
	echo '<div class="wp-editor-wrap">';
		wp_editor($post->post_content, 'content', array('dfw' => true, 'tabindex' => 1, 'teeny' => true) );
	echo '</div>';
}

/* 7.0  POST NAVIGATION
* --------------------------------------------------*/

if ( ! function_exists( 'coz_registry_post_nav' ) ) :

function coz_registry_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Cozmeena Registry navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

		<?php 
		
			$postlist_args = array(
				'posts_per_page'  => -1,
				'post_type' => 'coz_registry',
				'meta_key' => 'registry_coz_num',
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
				
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
 
 
 /*  8.0   DISPLAY PAGE ORDER BY SLUG, ASCENDING
 * --------------------------------------------------*/
 
 function coz_reg_post_order( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_tax( 'reg_display_page' )  ) {
        // Display 50 posts for a custom post type called 'movie'
        $query->set( 'posts_per_page', 20 );
		$query-> set ('orderby', 'slug');
		$query-> set ('order', 'asc');
        return;
    }
}
add_action( 'pre_get_posts', 'coz_reg_post_order', 1 );
 
 
/* 9.0   NAVIGATION FOR REGISTRY LIST PAGES
 * --------------------------------------------------*/
function registry_list_paging_nav() {
		$current_cats =  get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$current_cat = $current_cats -> slug;

		$previous = -1;
		$next = 0;
		$count = 0;
		$args = array(
			'taxonomy' => 'reg_display_page',
			'orderby' => 'slug',
			'order' => 'ASC',
			'hierarchical' => 0,
			'hide_empty' => 1
			);
		  $categories = get_categories($args);

		  foreach ($categories as $cat) {
			$count++;
			if ($cat->slug == $current_cat) {
			  $previous = $count - 2;
			  $next = $count;
			}
		  }
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">
		
			
			<?php if  ($previous >= 0)  : 
				$prev_link = get_term_link( $categories[$previous]->slug, 'reg_display_page' );
				$prev_title = $categories[$previous]->name;		
			?>
				<div class="nav-next">
				 <?php echo "<a href='$prev_link' title='View Registrations $prev_title'?> <span class='meta-nav'>&larr;</span> Registrations $prev_title </a> "; ?>
				</div> <!-- .nav-next -->
			<?php endif;  //$previous >=0 ?>
 
			<?php if ($next > 0 && $next < count($categories)) :
				$next_link = get_term_link( $categories[$next]->slug, 'reg_display_page' );
				$next_title = $categories[$next]->name;	
			?>
				<div class="nav-previous">
				 <?php echo "<a href='$next_link' title='View Registrations $next_title'?>  Registrations $next_title <span class='meta-nav'>&rarr;</span></a> "; ?>
				</div> <!-- .nav-previous -->
 
			<?php endif; //$next >=0?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php }

?>