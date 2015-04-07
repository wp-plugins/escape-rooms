<?php

global $wp_query;
global $wpdb;


if(is_numeric($_GET['roomId'])) {


$post_id = intval($_GET['roomId']);
$my_post = get_post($post_id);
$title = $my_post->post_title;
$difficulty = get_post_meta( $post_id, 'difficulty', 'true');
$terms = get_post_meta( $post_id, 'terms', 'true');
$price1 = get_post_meta( $post_id, 'price1', 'true');
$price2 = get_post_meta( $post_id, 'price2', 'true');
$price3 = get_post_meta( $post_id, 'price3', 'true');
$price4 = get_post_meta( $post_id, 'price4', 'true');
$price5 = get_post_meta( $post_id, 'price5', 'true');
$price6 = get_post_meta( $post_id, 'price6', 'true');
$price7 = get_post_meta( $post_id, 'price7', 'true');
$price8 = get_post_meta( $post_id, 'price8', 'true');


// if booking was made
if(!empty($_POST['hours'])) {

	// ----------------------- SANITIZE THE POSTED DATA -------------------------
	$sanFullname = sanitize_text_field( $_POST['fullname'] );
	$sanHours = sanitize_text_field( $_POST['hours'] );
	$sanTel = sanitize_text_field( $_POST['tel'] );
	$sanEmail = sanitize_email( $_POST['email'] );
	// ------------------------ END OF SANITIZING DATA --------------------------

	// ----------------------- BOOKING STARTS HERE ------------------------------
				$adminEmail = get_option( 'admin_email', '' );
				$blogName = get_option( 'blogname', '' );
				$domainName = $_SERVER['HTTP_HOST'];

				$headers = 'From: '.$blogName.' Booking Form <no-reply@'.$domainName.'>' . "\r\n";
				wp_mail( $adminEmail, "ESCAPE ROOM :: NEW BOOKING, " . $sanFullname.' - '.$title.' - '.$sanHours, "Please visit Wordpress Admin to see the booking details.", $headers, $attachments );

				$my_post = array(
				  'post_title'    => $sanFullname.' - '.$title.' - '.$sanHours,
				  'post_status'   => 'publish',
				  'post_author'   => 1,
				  'post_type'	  => 'erbooking'
				);

				// Insert the post into the database
				$newpost_id = wp_insert_post( $my_post, $wp_error );
				add_post_meta($newpost_id, 'fullname', $sanFullname);
				add_post_meta($newpost_id, 'telephone', $sanTel);
				add_post_meta($newpost_id, 'email', $sanEmail);
				add_post_meta($newpost_id, 'datestamp', $sanHours);
				add_post_meta($newpost_id, 'escaperoom', intval($_GET['roomId']));

	// ---------------------------- END OF BOOKING ------------------------------


?>
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-success" role="alert">Your booking has be completed! Soon our department will come in contact with you for confirming the order.</div>
					</div>
				</div>
<?php
} else {
// END OF BOOKING


echo "<form name=\"bookingForm\" method=\"post\" action\"\">";
echo "<div class=\"row\">";
		echo  "<div class=\"col-md-8\"><h3>Room: ".$title."</h3></div>";
		echo  "<div class=\"col-md-4 visible-md visible-lg\"><h3>Terms & Conditions</h3></div>";
echo "</div>";
echo "<div class=\"row\">";
echo "<div class=\"col-md-4\">";

				echo "<div >";
	
		echo  "<div>Date & Time<br> ";

		$avHours = explode("|",get_the_term_list($post_id, 'Hours', '', '|', '' ));

		$date1 = date("m/d/Y");



	echo '<select name="hours">';

		for($d=0;$d<7;$d++) {
			$dayc = $d+1;
			$nextDay = date('m-d-Y',strtotime($date1 . "+".$dayc." days"));
			unset($temp);
			$temp = explode("-",$nextDay);
			$daystr = date("l jS \of F", mktime(0, 0, 0, $temp[0], $temp[1], $temp[2]));
				echo "<optgroup label=\"$daystr\">";
			for($i=0;$i<count($avHours);$i++) {
				$strippedHours = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $avHours[$i]);
				echo "<option value=\"".$daystr.",".$strippedHours." \">".$strippedHours."</option>";	
			}
				echo "</optgroup>";
		}
			echo '</select>';

		echo "</div>";
		echo  "<div>Fullname<br> <input type=\"text\" name=\"fullname\"></div>";
	
		echo "</div>";
		
echo "</div><div class=\"col-md-4\">";

	echo  "<div>Contact Tel.<br> <input type=\"text\" name=\"tel\"></div>";
		echo  "<div>Email<br> <input type=\"text\" name=\"email\"></div>";

		
echo "</div><div class=\"col-md-4\">";
echo "<div class=\"visible-xs visible-sm\"><h3>Terms & Conditions</h3></div>";
echo "<blockquote>
	  <p style=\"font-size:12px;\">".$terms."</p>
</blockquote>";
echo "</div>";
echo "</div>";

	echo "<div class=\"row\">";
		echo "<div class=\"col-xs-12 text-right\">";
			echo "<input type=\"submit\" value=\"Complete Booking\" />";
		echo "</div>";		
	echo "</div>";
echo "</form>";
} // end of else
}
?>