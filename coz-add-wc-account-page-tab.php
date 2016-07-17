<?php
/**
 * Plugin Name: Custom Account Tabs Page
 * Description: A widget customizes the WooCommerce Account page for Cozmeena.com
 * Version: 1.0  (07-17-16)
 * Author: Sarah Maris
 *
 * Sources:  https://gist.github.com/claudiosmweb/a79f4e3992ae96cb821d3b357834a005
 *           https://wpbeaches.com/change-rename-woocommerce-endpoints-accounts-page/
 */


class My_Custom_My_Account_Endpoint1 {
  /**
   * Custom endpoint name.
   *
   * @var string
   */
  public static $endpoint1 = 'cozmeena-registrations';
  /**
   * Plugin actions.
   */
  public function __construct() {
    // Actions used to insert a new endpoint in the WordPress.
    add_action( 'init', array( $this, 'add_endpoints' ) );
    add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );
    // Change the My Accout page title.
    add_filter( 'the_title', array( $this, 'endpoint_title' ) );
    // Insering your new tab/page into the My Account page.
    add_filter( 'woocommerce_account_menu_items', array( $this, 'new_menu_items' ) );
    add_action( 'woocommerce_account_' . self::$endpoint1 .  '_endpoint', array( $this, 'endpoint_content' ) );
  }
  /**
   * Register new endpoint to use inside My Account page.
   *
   * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
   */
  public function add_endpoints() {
    add_rewrite_endpoint( self::$endpoint1, EP_ROOT | EP_PAGES );
  }
  /**
   * Add new query var.
   *
   * @param array $vars
   * @return array
   */
  public function add_query_vars( $vars ) {
    $vars[] = self::$endpoint1;
    return $vars;
  }
  /**
   * Set endpoint title.
   *
   * @param string $title
   * @return string
   */
  public function endpoint_title( $title ) {
    global $wp_query;
    $is_endpoint = isset( $wp_query->query_vars[ self::$endpoint1 ] );
    if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
      // New page title.
      $title = __( 'My Cozmeena Shawl Registrations', 'woocommerce' );
      remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
    }
    return $title;
  }
  /**
   * Insert the new endpoint into the My Account menu.
   *
   * @param array $items
   * @return array
   */
  public function new_menu_items( $items ) {
    // Remove the logout menu item.
    $logout = $items['customer-logout'];
    unset( $items['customer-logout'] );
    // Insert your custom endpoint.
    $items[ self::$endpoint1 ] = __( 'Cozmeena Shawl Registrations', 'woocommerce' );
    // Insert back the logout item.
    $items['customer-logout'] = $logout;
    return $items;
  }
  /**
   * Endpoint HTML content.
   */
  public function endpoint_content() {
    echo '<h2 class="mycozmeena">My International Cozmeena Shawl Registrations</h2>';

  $author = get_current_user_id();

    $args = array(  //Requests shawl registrations in alphabetical order
      'post_type' => 'coz_registry',
      'author' => $author,
      'meta_key' => 'registry_coz_num',
      'orderby' => 'meta_value_num',
      'order' => 'ASC',
      'showposts' => -1,
      );


      $wp_query = new WP_Query($args);
      $count = $wp_query->post_count;

      if ( $count > 0 ) : // have shawl registrations ?>

        <div class='coz-registry-content'>

        <?php while ($wp_query -> have_posts()) : $wp_query -> the_post();
                $id = get_the_ID(); ?>

            <p>#<?php echo get_post_meta($id,'registry_coz_num',true) ?>
            <a class="coz-recipient" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>

            <?php if ($date  = get_post_meta($id ,'registry_coz_date',true)) { //Completion date
            echo '/'.$date  ;
            };
            $color_terms = wp_get_post_terms($id ,'wool_color',array("fields" => "names"));
            $color = $color_terms[0];
            $wool_terms = wp_get_post_terms($id ,'wool_type',array("fields" => "names"));
            $wool = $wool_terms[0];
            if ( $color || $wool ) { //Completion date
              echo  '/'.$color . ' ' . $wool ;
            };  ?></p>

        <?php endwhile; ?>
        </br></div> <!-- .coz-registry-content -->

        <?php wp_reset_postdata(); //Resets after wp_query
         else: echo 'No registrations yet </br></br>'; //have shawl registrations

      endif; //have shawl registrations

      if (wc_customer_bought_product('', get_current_user_id(), '661') ||wc_customer_bought_product('', get_current_user_id(), '748')  || current_user_can( 'read_private_crafts') ) {
        echo '<p class="mycozmeena"> <strong>Have a new shawl to include in the International Cozmeena Registry? <a href="' .
              site_url() . '/wp-admin/post-new.php?post_type=coz_registry">Enter your information here</a>. </strong></p>';
      }

  }
  /**
   * Plugin install action.
   * Flush rewrite rules to make our custom endpoint available.
   */
  public static function install() {
    flush_rewrite_rules();
  }
}
new My_Custom_My_Account_Endpoint1();
// Flush rewrite rules on plugin activation.
register_activation_hook( __FILE__, array( 'My_Custom_My_Account_Endpoint1', 'install' ) );

class My_Custom_My_Account_Endpoint2 {
  /**
   * Custom endpoint name.
   *
   * @var string
   */
  public static $endpoint2 = 'cozmeena-extras';
  /**
   * Plugin actions.
   */
  public function __construct() {
    // Actions used to insert a new endpoint in the WordPress.
    add_action( 'init', array( $this, 'add_endpoints' ) );
    add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );
    // Change the My Accout page title.
    add_filter( 'the_title', array( $this, 'endpoint_title' ) );
    // Insering your new tab/page into the My Account page.
    add_filter( 'woocommerce_account_menu_items', array( $this, 'new_menu_items' ) );
    add_action( 'woocommerce_account_' . self::$endpoint2 .  '_endpoint', array( $this, 'endpoint_content' ) );
  }
  /**
   * Register new endpoint to use inside My Account page.
   *
   * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
   */
  public function add_endpoints() {
    add_rewrite_endpoint( self::$endpoint2, EP_ROOT | EP_PAGES );
  }
  /**
   * Add new query var.
   *
   * @param array $vars
   * @return array
   */
  public function add_query_vars( $vars ) {
    $vars[] = self::$endpoint2;
    return $vars;
  }
  /**
   * Set endpoint title.
   *
   * @param string $title
   * @return string
   */
  public function endpoint_title( $title ) {
    global $wp_query;
    $is_endpoint = isset( $wp_query->query_vars[ self::$endpoint2 ] );
    if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
      // New page title.
      $title = __( 'My Cozmeena Extras', 'woocommerce' );
      remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
    }
    return $title;
  }
  /**
   * Insert the new endpoint into the My Account menu.
   *
   * @param array $items
   * @return array
   */
  public function new_menu_items( $items ) {
    // Remove the logout menu item.
    $logout = $items['customer-logout'];
    unset( $items['customer-logout'] );
    // Insert your custom endpoint.
    $items[ self::$endpoint2 ] = __( 'Cozmeena Extras', 'woocommerce' );
    // Insert back the logout item.
    $items['customer-logout'] = $logout;
    return $items;
  }
  /**
   * Endpoint HTML content.
   */
  public function endpoint_content() {

    if (wc_customer_bought_product('', get_current_user_id(), '661')  ||wc_customer_bought_product('', get_current_user_id(), '748') || current_user_can( 'read_private_crafts') ) { // Product #661 for live site, 475 for CozMirror
      echo '<p class="mycozmeena"> As purchaser of a Cozmeena Shawl Kit you now have access to the <a href="http://cozmeena.com/craft/cozmeena-shawl-kit-tutorial/">Cozmeena Knitting Tutorial</a> </p>';

      // display the cozmeena shawl videos
      $post_id = 924;
      $queried_post = get_post($post_id);
      $content = $queried_post->post_content;
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);
      echo $content;
      }
    else echo '<p class="mycozmeena"> Purchase a <a href="http://cozmeena.com/product/shawl-kit/">Cozmeena Shawl Kit</a> to gain access to the Cozmeena Knitting Tutorial </p>';

  }
  /**
   * Plugin install action.
   * Flush rewrite rules to make our custom endpoint available.
   */
  public static function install() {
    flush_rewrite_rules();
  }
}
new My_Custom_My_Account_Endpoint2();
// Flush rewrite rules on plugin activation.
register_activation_hook( __FILE__, array( 'My_Custom_My_Account_Endpoint2', 'install' ) );


/*
 * Change the order of the endpoints that appear in My Account Page - WooCommerce 2.6
 * https://wpbeaches.com/change-rename-woocommerce-endpoints-accounts-page/
 */
function wpb_woo_my_account_order() {
  $myorder = array(
    'dashboard'               => __( 'Dashboard', 'woocommerce' ),
    'cozmeena-registrations'  => __( 'Cozmeena Shawl Registrations', 'woocommerce' ),
    'cozmeena-extras'         => __( 'Cozmeena Extras', 'woocommerce' ),
    'edit-account'            => __( 'Change My Details', 'woocommerce' ),
    'orders'                  => __( 'My Orders', 'woocommerce' ),
//  'downloads'               => __( 'Download MP4s', 'woocommerce' ), NOT USED
    'edit-address'            => __( 'Addresses', 'woocommerce' ),
    'payment-methods'         => __( 'Payment Methods', 'woocommerce' ),
    'customer-logout'         => __( 'Logout', 'woocommerce' ),
  );
  return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );
?>
