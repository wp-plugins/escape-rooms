<?php
    /*
    Plugin Name: Escape Rooms
    Plugin URI: http://www.waza.gr/escape-rooms
    Description: Do you have a Escape Room Company and want a plugin to cover your needs? Search no more! Escape Rooms Wordpress plugin will cover all your needs, by showcasing the rooms, checking prices and available hours and finally proceed with the booking!
    Author: Simos Fasouliotis
    Version: 1.0.1
    Author URI: http://www.waza.gr
    */


add_filter( 'the_title', 'detailPageTitle');
function detailPageTitle($title){
	$post_id = intval($_GET['roomId']);
	$my_post = get_post($post_id);
	$titlex = $my_post->post_title;
    return str_replace('Escape Room Details Page', $titlex, $title);
}

	function create_post_type() {
  $labels = array(
    'name'               => _x( 'Escape Rooms', 'post type general name' ),
    'singular_name'      => _x( 'Escape Room', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Escape Room' ),
    'edit_item'          => __( 'Edit Escape Room' ),
    'new_item'           => __( 'New Escape Room' ),
    'all_items'          => __( 'All Escape Rooms' ),
    'view_item'          => __( 'View Escape Rooms' ),
    'search_items'       => __( 'Search Escape Rooms' ),
    'not_found'          => __( 'No Escape Rooms found' ),
    'not_found_in_trash' => __( 'No Escape Rooms found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Escape Rooms Setup'
  );

	$args = array(
    'labels'        => $labels,
    'description'   => 'Holds our Escape Rooms specific data',
    'public'        => true,
	'capability_type' => 'post',
	//'rewrite' => true,
	'rewrite' => array('slug' => 'rooms'),
	'show_ui' => true,
	'publicly_queryable' => true,
//    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail' ),
    'has_archive'   => true
  );


	$labels2 = array(
    'name'               => _x( 'Escape Rooms Bookings', 'post type general name' ),
    'singular_name'      => _x( 'Escape Rooms Booking', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Booking' ),
    'edit_item'          => __( 'Edit Booking' ),
    'new_item'           => __( 'New Booking' ),
    'all_items'          => __( 'All Bookings' ),
    'view_item'          => __( 'View Bookings' ),
    'search_items'       => __( 'Search Bookings' ),
    'not_found'          => __( 'No Bookings found' ),
    'not_found_in_trash' => __( 'No Bookings found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Escape Rooms Bookings'
  );

	$args2 = array(
    'labels'        => $labels2,
    'description'   => 'Holds our Escape Rooms Bookingsspecific data',
    'public'        => true,
	'capability_type' => 'post',
	//'rewrite' => true,
	//'rewrite' => array('slug' => 'rooms'),
	'show_ui' => true,
	'publicly_queryable' => false,
	'taxonomies' => array( 'escaperoom' ),
//    'menu_position' => 5,
    'supports'      => array( 'title' ),
    'has_archive'   => false
  );



register_post_type( 'escaperoom', $args );
register_post_type( 'erbooking', $args2 );
register_taxonomy("Hours", array("escaperoom"), array("hierarchical" => true, "add_new_item" => 'Add new Hour', "label" => "Hours", "singular_label" => "Hour", "rewrite" => true));



	

}

add_action( 'init', 'create_post_type' );
add_action("admin_init", "admin_init");
 
function admin_init(){
  add_meta_box("prices-meta", "Prices (0 for not available)", "price_completed", "escaperoom", "side", "high");
  add_meta_box("extras-meta", "Extra Fields", "extras_completed", "escaperoom", "normal", "high");
  add_meta_box("bookings-meta", "Booking Details", "booking_completed", "erbooking", "normal", "high");

  remove_meta_box( 'postimagediv', 'erbooking','side' );
}

function price_completed(){
  global $post;
  $custom = get_post_custom($post->ID);
	$price1 = $custom["price1"][0];
	$price2 = $custom["price2"][0];
	$price3 = $custom["price3"][0];
	$price4 = $custom["price4"][0];
	$price5 = $custom["price5"][0];
	$price6 = $custom["price6"][0];
	$price7 = $custom["price7"][0];
	$price8 = $custom["price8"][0];
  ?>
  <label>Price for 1 person:</label>
  <input name="price1" value="<?php echo $price1; ?>" placeholder="0"/><br>
  <label>Price for 2 persons:</label>
  <input name="price2" value="<?php echo $price2; ?>" placeholder="0"/><br>
  <label>Price for 3 persons:</label>
  <input name="price3" value="<?php echo $price3; ?>" placeholder="0"/><br>
  <label>Price for 4 persons:</label>
  <input name="price4" value="<?php echo $price4; ?>" placeholder="0"/><br>
  <label>Price for 5 persons:</label>
  <input name="price5" value="<?php echo $price5; ?>" placeholder="0"/><br>
  <label>Price for 6 persons:</label>
  <input name="price6" value="<?php echo $price6; ?>" placeholder="0"/><br>
  <label>Price for 7 persons:</label>
  <input name="price7" value="<?php echo $price7; ?>" placeholder="0"/><br>
  <label>Price for 8 persons:</label>
  <input name="price8" value="<?php echo $price8; ?>" placeholder="0"/><br>
  <?php
}


function extras_completed(){
  global $post;
  $custom = get_post_custom($post->ID);
	$difficulty = $custom["difficulty"][0];
	$terms = $custom["terms"][0];
	$tagline = $custom["tagline"][0];
  ?>
  <label>Tagline:</label><br>
  <input name="tagline" value="<?php echo $tagline; ?>" placeholder="Room Tagline"/><br>

  <label>Difficulty:</label><br>
  <input name="difficulty" value="<?php echo $difficulty; ?>" placeholder="Difficulty Level"/><br>

<br>  <h3>Terms & Conditions</h3>
<?php 
	  $settings = array( 'media_buttons' => false );
      wp_editor( $terms, 'terms', $settings ); ?>
  <?php
}

  function booking_completed(){
  global $post;
  $custom = get_post_custom($post->ID);
	$fullname = $custom["fullname"][0];
	$telephone = $custom["telephone"][0];
	$email = $custom["email"][0];
	$datestamp = $custom["datestamp"][0];
	$escaperoom = $custom["escaperoom"][0];
  ?>
   <label>Client Full Name</label>
  <input name="fullname" value="<?php echo $fullname; ?>" placeholder="Client Full Name"/><br>
   <label>Contact Telephone</label>
  <input name="telephone" value="<?php echo $telephone; ?>" placeholder="Client Telephone"/><br>
  <label>Contact Email</label>
  <input name="email" value="<?php echo $email; ?>" placeholder="Client E-mail"/><br>
  <label>Booking Datestamp</label>
  <input name="datestamp" value="<?php echo $datestamp; ?>" placeholder="Date and time of booking"/><br>
  
  <label for="my_meta_box_post_type">Booked Room: </label>
        <select name='escaperoom' id='escaperoom'>
<?php $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => '',
	'order'            => '',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'escaperoom',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <option value="<?php the_id() ?>" <?php if($escaperoom ==  get_the_ID()) { echo "selected"; } ?>><?php the_title() ?></options>
    <?php
  endwhile;
}
wp_reset_query();
?>
	</select>
<?php
}


  add_action('save_post', 'save_details');
  add_action('save_post', 'save_extras');
  add_action('save_post', 'save_booking');


  function save_details(){
  global $post;
 
 	// ----------------------- SANITIZE THE POSTED DATA -------------------------
	$safePrice1 = floatval( $_POST['price1'] );	if ( ! $safePrice1 ) {  $safePrice1 = 0; }
	$safePrice2 = floatval( $_POST['price2'] );	if ( ! $safePrice2 ) {  $safePrice2 = 0; }
	$safePrice3 = floatval( $_POST['price3'] );	if ( ! $safePrice3 ) {  $safePrice3 = 0; }
	$safePrice4 = floatval( $_POST['price4'] );	if ( ! $safePrice4 ) {  $safePrice4 = 0; }
	$safePrice5 = floatval( $_POST['price5'] );	if ( ! $safePrice5 ) {  $safePrice5 = 0; }
	$safePrice6 = floatval( $_POST['price6'] );	if ( ! $safePrice6 ) {  $safePrice6 = 0; }
	$safePrice7 = floatval( $_POST['price7'] );	if ( ! $safePrice7 ) {  $safePrice7 = 0; }
	$safePrice8 = floatval( $_POST['price8'] );	if ( ! $safePrice8 ) {  $safePrice8 = 0; }

	$safePrice1 = sanitize_text_field( $safePrice1 );
	$safePrice2 = sanitize_text_field( $safePrice2 );
	$safePrice3 = sanitize_text_field( $safePrice3 );
	$safePrice4 = sanitize_text_field( $safePrice4 );
	$safePrice5 = sanitize_text_field( $safePrice5 );
	$safePrice5 = sanitize_text_field( $safePrice6 );
	$safePrice7 = sanitize_text_field( $safePrice7 );
	$safePrice7 = sanitize_text_field( $safePrice8 );
	// ------------------------ END OF SANITIZING DATA --------------------------


  update_post_meta($post->ID, "price1", $safePrice1);
  update_post_meta($post->ID, "price2", $safePrice2);
  update_post_meta($post->ID, "price3", $safePrice3);
  update_post_meta($post->ID, "price4", $safePrice4);
  update_post_meta($post->ID, "price5", $safePrice5);
  update_post_meta($post->ID, "price6", $safePrice6);
  update_post_meta($post->ID, "price7", $safePrice7);
  update_post_meta($post->ID, "price8", $safePrice8);
}

 function save_extras(){
  global $post;

  	// ----------------------- SANITIZE THE POSTED DATA -------------------------
	$sanDifficulty = sanitize_text_field( $_POST['difficulty'] );
	$sanTerms = wp_kses_post( $_POST['terms'] );
	$sanTagline = sanitize_text_field( $_POST['tagline'] );
	// ------------------------ END OF SANITIZING DATA --------------------------
 
  update_post_meta($post->ID, "difficulty", $sanDifficulty);
  update_post_meta($post->ID, "terms", $sanTerms);
  update_post_meta($post->ID, "tagline", $sanTagline);
}

function save_booking(){
  global $post;

 	// ----------------------- SANITIZE THE POSTED DATA -------------------------
	$sanFullname = sanitize_text_field( $_POST['fullname'] );
	$sanHours = sanitize_text_field( $_POST['hours'] );
	$sanTel = sanitize_text_field( $_POST['telephone'] );
	$sanEmail = sanitize_email( $_POST['email'] );
	$sanDatestamp = sanitize_email( $_POST['datestamp'] );
	$sanEscaperoom = sanitize_email( $_POST['escaperoom'] );
	// ------------------------ END OF SANITIZING DATA --------------------------

  update_post_meta($post->ID, "fullname", $sanFullname);
  update_post_meta($post->ID, "telephone", $sanTel);
  update_post_meta($post->ID, "email", $sanEmail);
  update_post_meta($post->ID, "datestamp", $sanDatestamp);
  update_post_meta($post->ID, "escaperoom", $sanEscaperoom);
}



add_shortcode( 'escape-rooms', 'html_list_rooms' );
add_shortcode( 'escaperoomdetails', 'html_detail_rooms' );
add_shortcode( 'escaperoombooking', 'html_booking' );



// --------------------------------------------------------------------------------------------------
// |                                   RUNNER WHEN THE PLUGIN IS ENABLED                            |
// --------------------------------------------------------------------------------------------------
	register_activation_hook( __FILE__, 'escaperooms_activate' );
	register_deactivation_hook( __FILE__, 'escaperooms_deactivate');
	
	function escaperooms_activate() {
	// Create post object
	$er_post = array(
	  'post_title'    => 'Escape Room Details Page',
	  'post_content'  => '[escaperoomdetails]',
	  'post_name'  => 'room-details',
	  'post_type'   => 'page',
	  'post_status'   => 'publish',
	  'post_author'   => 1
	);

	// Insert the post into the database
	$post_id = wp_insert_post( $er_post, $wp_error );

	add_option( 'erDetailId', $post_id, '', 'yes' );



	$er_post = array(
	  'post_title'    => 'Escape Room Booking Page',
	  'post_content'  => '[escaperoombooking]',
	  'post_name'  => 'room-booking',
	  'post_type'   => 'page',
	  'post_status'   => 'publish',
	  'post_author'   => 1
	);

	// Insert the post into the database
	$post_id = wp_insert_post( $er_post, $wp_error );

	add_option( 'erBookingId', $post_id, '', 'yes' );
		
	}

	function escaperooms_deactivate() {
		$erDetailPage = get_option( 'erDetailId' ,'0');
		if($erDetailPage != 0) {
			wp_delete_post( $erDetailPage, 'true' );
		}
		$erBookingPage = get_option( 'erBookingId' ,'0');
		if($erBookingPage != 0) {
			wp_delete_post( $erBookingPage, 'true' );
		}

		delete_option( 'erDetailId' );
		delete_option( 'erBookingId' );

		
	}
// \------------------------------------------------------------------------------------------------/


function html_list_rooms( $atts ){
	include ( plugin_dir_path( __FILE__ ) . 'html_listRooms.php');
}

function html_detail_rooms( $atts ){
	include ( plugin_dir_path( __FILE__ ) . 'html_detailRooms.php');
}

function html_booking( $atts ){
	include ( plugin_dir_path( __FILE__ ) . 'html_booking.php');
}






?>