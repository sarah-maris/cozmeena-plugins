<?php
/**
 * Plugin Name: Random Defintions of Cozmeena
 * Description: A widget that displays a random attribute of Cozmeena in a colorful sidebar
 * Version: 1.0  (01-07-14)
 * Author: Sarah Maris 
 */


add_action( 'widgets_init', 'coz_random' );


function coz_random() {
	register_widget( 'CozRand' );
}

class CozRand extends WP_Widget {

	function CozRand() {
		$widget_ops = array( 
			'classname' => 'coz-random', 
			'description' => 'Displays one of the attributes of Cozmeena in a colorful sidebar' );
		
		$control_ops = array(
			'width' => 300, 
			'height' => 350, 
			'id_base' => 'coz_random');
			
		$this->WP_Widget('coz_random', 'Random Definitions of Cozmeena', $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Define variables.
		$title = apply_filters('widget_title', $instance['title'] );
		
		// Add HTML to start widget area (defined in functions.php)
		echo $before_widget; //defined in functions.php		
		
		// Get ID for random definition
		$args=array(
			'post_type'=>'definition', 
			'orderby'=>'rand', 
			'posts_per_page'=> '1'
		);
		$my_posts = get_posts( $args );
		
		if( $my_posts ) {
				$featID = $my_posts[0]->ID;
		} 
		
		// Pull desired content
		$featTitle = get_post_field( 'post_title', $featID); 
		$featTag = simple_fields_value( 'tag_line', $featID);
		$featContent = get_post_field( 'post_content', $featID); 
		$dropNum = simple_fields_value( 'def_color', $featID, true);
		
	
		// SET DIV BASED ON COLOR STUFF GOES HERE!!!!
		
		if ($dropNum == 'dropdown_num_2')		
			echo '<div id="pink-def">';
		
		if ($dropNum == 'dropdown_num_5')			
			echo '<div id="green-def">';
		
		if ($dropNum == 'dropdown_num_3')			
			echo '<div id="orange-def">';
		
		if ($dropNum == 'dropdown_num_4')		
			echo '<div id="blue-def">';
		
		// SET UP INNNER DIV
		echo '<div id="inner-def">';
				
		
		
		// Display the definition title 
		if ( $featTitle )
			echo '<div id=def-title>' . $featTitle .'</div>';

		// Display the tag line 		
		if ( $featTag )
			echo '<div id=def-tag>' . $featTag .'</div>';	

		//Display the post content
		if ( $featContent )
			echo( '<div id=def-cont>' . $featContent. '</div>' );
		
		
		// Add HTML to end widget area (defined in functions.php)
		echo '</div>';
		echo '</div>';
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => 'Widget Title', 'featID'=> '104' , 'show_info' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
	<?php
	}
	

	
	
}
// Helpful references in constructing this widget: 
// http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/
// http://codex.wordpress.org/Function_Reference/get_post_field
// http://codex.wordpress.org/Function_Reference/get_the_post_thumbnail

//http://www.php-example.com/2011/05/php-html-form-select-box-example.html

?>