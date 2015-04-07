<?php


global $wp_query;

if(is_numeric($_GET['roomId'])) {


$post_id = intval($_GET['roomId']);
$my_post = get_post($post_id);
$title = $my_post->post_title;
$difficulty = get_post_meta( $post_id, 'difficulty', 'true');
$tagline = get_post_meta( $post_id, 'tagline', 'true');
$price1 = get_post_meta( $post_id, 'price1', 'true');
$price2 = get_post_meta( $post_id, 'price2', 'true');
$price3 = get_post_meta( $post_id, 'price3', 'true');
$price4 = get_post_meta( $post_id, 'price4', 'true');
$price5 = get_post_meta( $post_id, 'price5', 'true');
$price6 = get_post_meta( $post_id, 'price6', 'true');
$price7 = get_post_meta( $post_id, 'price7', 'true');
$price8 = get_post_meta( $post_id, 'price8', 'true');



		echo "<div >";
echo  "<div style=\"text-align:center;\">".get_the_post_thumbnail( $post_id, 'big' )."</div>";

$showPrices = false; // default it
if((!empty($price1)) && ($price1<>'0')) { $showPrices = true; $prices .= " 1 person ".$price1."&euro;,"; }
if((!empty($price2)) && ($price2<>'0')) { $showPrices = true; $prices .= " 2 persons ".$price2."&euro;,"; }
if((!empty($price3)) && ($price3<>'0')) { $showPrices = true; $prices .= " 3 persons ".$price3."&euro;,"; }
if((!empty($price4)) && ($price4<>'0')) { $showPrices = true; $prices .= " 4 persons ".$price4."&euro;,"; }
if((!empty($price5)) && ($price5<>'0')) { $showPrices = true; $prices .= " 5 persons ".$price5."&euro;,"; }
if((!empty($price6)) && ($price6<>'0')) { $showPrices = true; $prices .= " 6 persons ".$price6."&euro;,"; }
if((!empty($price7)) && ($price7<>'0')) { $showPrices = true; $prices .= " 7 persons ".$price7."&euro;,"; }
if((!empty($price8)) && ($price8<>'0')) { $showPrices = true; $prices .= " 8 persons ".$price8."&euro;,"; }

if($showPrices == true) { 
	echo "<div style=\"float:left;\" class=\"text-danger\"><span class=\"glyphicon glyphicon-certificate\"></span> Prices: ".substr($prices,0,-1)."</div>"; 
}

if(strlen($difficulty)>0) {
	echo "<div style=\"float:right;\" class=\"text-danger\"><span class=\"glyphicon glyphicon-signal\"></span> Difficulty level : ".$difficulty."</div>";
}
echo "<div style=\"clear:both;\"><br></div>";

if(strlen($tagline)>0) {
	echo "<div ><h4> ".$tagline." </h4> </div>";
}

echo "<div><p>".$my_post->post_content."</p></div>";

?>
<div style="float:right;">
<?php $erBookingPage = get_option( 'erBookingId' ,'0'); ?>
<a href="<?php echo add_query_arg( 'roomId',$post_id, get_permalink($erBookingPage) ); ?>"  title="<?php the_title_attribute(); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-tag"></span> BOOK NOW </a>		
</div>

        <?php 

//        echo '</ul>';
echo "</div>";


}
?>