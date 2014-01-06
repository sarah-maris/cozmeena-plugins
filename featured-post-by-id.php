<?php
/**
 * Plugin Name: Featured Post by ID
 * Description: A widget that displays a featured post title, thumbnail and content in the sidebar
 * Version: 1.0
 * Author: Sarah Maris 
 */


add_action( 'widgets_init', 'CozFeatByID' );


function CozFeatByID() {
	register_widget( 'CozFeatByID' );
}

class CozFeatByID extends WP_Widget {

	function CozFeatByID() {
		$widget_ops = array( 'classname' => 'CozFeatByID', 'description' => 'Displays the title, thumbnail and content of a post selected by ID' );
		
		
		
		$this->WP_Widget('CozFeatByID', 'Featured Post by ID', $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Define variables.
		$title = apply_filters('widget_title', $instance['title'] );
		$featID = $instance['featID'];
		
		// Add HTML to start widget area (defined in functions.php)
		echo $before_widget; //defined in functions.php

		// Pull desired content
		$featTitle = get_post_field( 'post_title', $featID); 
		$featContent = get_post_field( 'post_content', $featID); 
		$featImage = get_the_post_thumbnail($featID, 'thumbnail');

		// Display the Featured Post title 
		if ( $featTitle )
			echo $before_title .'<div id=feat-title>' . $featTitle .'</div>'. $after_title;

		//Display the featured image 
		if ( $featImage )
			echo( '<div id=feat-image>' . $featImage. '</div>' );

		//Display the post content
		if ( $featContent )
			echo( '<div id=feat-cont>' . $featContent. '</div>' );
			
		// Add HTML to end widget area (defined in functions.php)
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['featID'] = strip_tags( $new_instance['featID'] );

		return $instance;
	}
	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => __('Example', 'example'), 'featID'=> __('#', 'example') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title of widget', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'featID' ); ?>"><?php _e('Post ID number: click on "Get Shortlink" on post page and use number after "p="', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'featID' ); ?>" name="<?php echo $this->get_field_name( 'featID' ); ?>" value="<?php echo $instance['featID']; ?>" style="width:100%;" />
		</p>
		
	<?php
	}
}
// Helpful references in constructing this widget: 
// http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/
// http://codex.wordpress.org/Function_Reference/get_post_field
// http://codex.wordpress.org/Function_Reference/get_the_post_thumbnail

?>