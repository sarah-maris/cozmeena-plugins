<?php
/**
 * Plugin Name: Cozmeena Roles
 * Description: A plugin that adds the "Offline Customer" role, "read-private-posts" capability and Cozmeena International Registry editing capability.  This is a "run-once" plugin -- new roles are stored in database so plug-in should be deactivated after running.
 * Version: 2.2
 * Author: Sarah Maris 
 * Updated: 8-3-14
 */

// NOTE: run once and the new roles are stored in database -- should deactivate plugin after running


add_role('offline-customer', 'Offline Customer', array(
    'read' => true, // True allows that capability
    'read_private_crafts' => true,
));

function add_craft_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );
		$admins ->  add_cap ('edit_craft');
		$admins ->  add_cap ('read_craft');
		$admins ->  add_cap ('delete_craft');
		$admins ->  add_cap ('edit_crafts');
		$admins ->  add_cap ('edit_others_crafts');
		$admins ->  add_cap ('publish_crafts');
		$admins ->  add_cap ('read_private_crafts');
		$admins ->  add_cap ('delete_crafts');
		$admins ->  add_cap ('delete_private_crafts');
		$admins ->  add_cap ('delete_published_crafts');
		$admins ->  add_cap ('delete_others_crafts');
		$admins ->  add_cap ('edit_private_crafts');
		$admins ->  add_cap ('edit_published_crafts');
	
	$edits = get_role( 'editor' );
		$edits ->  add_cap ('edit_craft');
		$edits ->  add_cap ('read_craft');
		$edits ->  add_cap ('delete_craft');
		$edits ->  add_cap ('edit_crafts');
		$edits ->  add_cap ('edit_others_crafts');
		$edits ->  add_cap ('publish_crafts');
		$edits ->  add_cap ('read_private_crafts');
		$edits ->  add_cap ('delete_crafts');
		$edits ->  add_cap ('delete_private_crafts');
		$edits ->  add_cap ('delete_published_crafts');
		$edits ->  add_cap ('delete_others_crafts');
		$edits ->  add_cap ('edit_private_crafts');
		$edits ->  add_cap ('edit_published_crafts');
	
	$auths = get_role( 'author' );
		$auths ->  add_cap ('edit_craft');
		$auths ->  add_cap ('read_craft');
		$auths ->  add_cap ('delete_craft');
		$auths ->  add_cap ('edit_crafts');
		$auths ->  add_cap ('publish_crafts');
		$auths ->  add_cap ('read_private_crafts');
		$auths ->  add_cap ('delete_crafts');
		$auths ->  add_cap ('delete_published_crafts');	
}
add_action( 'admin_init', 'add_craft_caps');

function add_registry_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );
		$admins ->  add_cap ('edit_coz_registry');
		$admins ->  add_cap ('read_coz_registry');
		$admins ->  add_cap ('delete_coz_registry');
		$admins ->  add_cap ('edit_coz_registrys');
		$admins ->  add_cap ('edit_others_coz_registrys');
		$admins ->  add_cap ('publish_coz_registrys');
		$admins ->  add_cap ('read_private_coz_registrys');
		$admins ->  add_cap ('delete_coz_registrys');
		$admins ->  add_cap ('delete_private_coz_registrys');
		$admins ->  add_cap ('delete_published_coz_registrys');
		$admins ->  add_cap ('delete_others_coz_registrys');
		$admins ->  add_cap ('edit_private_coz_registrys');
		$admins ->  add_cap ('edit_published_coz_registrys');
		$admins ->  add_cap ('manage_wool');
		$admins ->  add_cap ('edit_wool');		
		$admins ->  add_cap ('delete_wool');
		$admins ->  add_cap ('assign_wool');
		$admins ->  add_cap ('edit_color');
		$admins ->  add_cap ('assign_color');
		$admins ->  add_cap ('delete_color');
		$admins ->  add_cap ('manage_color');
	
	$edits = get_role( 'editor' );
		$edits ->  add_cap ('edit_coz_registry');
		$edits ->  add_cap ('read_coz_registry');
		$edits ->  add_cap ('delete_coz_registry');
		$edits ->  add_cap ('edit_coz_registrys');
		$edits ->  add_cap ('edit_others_coz_registrys');
		$edits ->  add_cap ('publish_coz_registrys');
		$edits ->  add_cap ('read_private_coz_registrys');
		$edits ->  add_cap ('delete_coz_registrys');
		$edits ->  add_cap ('delete_private_coz_registrys');
		$edits ->  add_cap ('delete_published_coz_registrys');
		$edits ->  add_cap ('delete_others_coz_registrys');
		$edits ->  add_cap ('edit_private_coz_registrys');
		$edits ->  add_cap ('edit_published_coz_registrys');
		$edits ->  add_cap ('edit_wool');
		$edits ->  add_cap ('assign_wool');
		$edits ->  add_cap ('edit_color');
		$edits ->  add_cap ('assign_color');
	
	$auths = get_role( 'author' );
		$auths ->  add_cap ('edit_coz_registrys');
		$auths ->  add_cap ('read_coz_registrys');
		$auths ->  add_cap ('delete_coz_registrys');
		$auths ->  add_cap ('edit_published_coz_registrys');
		$auths ->  add_cap ('delete_published_coz_registrys');
		$auths ->  add_cap ('edit_wool');
		$auths ->  add_cap ('assign_wool');
		$auths ->  add_cap ('edit_color');
		$auths ->  add_cap ('assign_color');
		
	$custs =  get_role( 'customer' );
		$custs ->  add_cap ('edit_coz_registrys');
		$custs ->  add_cap ('read_coz_registrys');
		$custs ->  add_cap ('delete_coz_registrys');
		$custs ->  add_cap ('edit_published_coz_registrys');
		$custs ->  add_cap ('delete_published_coz_registrys');
		$custs ->  add_cap ('edit_wool');
		$custs ->  add_cap ('assign_wool');
		$custs ->  add_cap ('edit_color');
		$custs ->  add_cap ('assign_color');
		$custs ->  add_cap ('upload_files');
		
	$offline_custs =  get_role( 'offline-customer' );
		$offline_custs ->  add_cap ('edit_coz_registrys');
		$offline_custs ->  add_cap ('read_coz_registrys');
		$offline_custs ->  add_cap ('delete_coz_registrys');
		$offline_custs ->  add_cap ('edit_published_coz_registrys');
		$offline_custs ->  add_cap ('delete_published_coz_registrys');		
		$offline_custs ->  add_cap ('edit_wool');
		$offline_custs ->  add_cap ('assign_wool');
		$offline_custs ->  add_cap ('edit_color');
		$offline_custs ->  add_cap ('assign_color');
		$offline_custs ->  add_cap ('upload_files');	
}
add_action( 'admin_init', 'add_registry_caps');
?>