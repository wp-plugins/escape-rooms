<?php

// Define the WP query
$args = array(
    'post_type' => 'escaperoom',
    'posts_per_page' => -1,
);
?>

<?php
$query = new WP_Query( $args );

if ($query->have_posts()) {

    // Output the post titles in a list
  //  echo '<ul id="cpt-menu">';
  ?>
  <!--<a href="#" class="btn btn-primary"><span class="glyphicon glyphicon-info-sign"></span> View more details</a> -->
  <?php
 echo "<div class=\"row\">"; 

        // Start the Loop
		$i = 1;
        while ( $query->have_posts() ) : $query->the_post(); ?>
<?php // if($i==4) { echo "</div><div class=\"row\">"; } ?>
		<div class="col-xs-12 col-sm-4">
			<h2 class="col-xs-12"><?php the_title(); ?></h2>
			

			<?php the_post_thumbnail('medium', array( 'class' => 'col-xs-12 img-responsive' )  ); ?>
			<div><?php $erDetailPage = get_option( 'erDetailId' ,'0'); ?></div>
			<?php $tagline = get_post_meta( get_the_ID(), 'tagline', 'true'); ?>
			<div style="text-align:center;"><h4 style="position:relative; top:5px"><?php echo $tagline; ?></h4></div>
			<div style="float:right;padding:15px;">
				<a href="<?php echo add_query_arg( 'roomId',get_the_ID(), get_permalink($erDetailPage) ); ?>"  title="<?php the_title_attribute(); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-info-sign"></span> View more details</a>			
			</div>
		</div>

		<div class="clearfix visible-xs"></div>
		<?php if($i%3==0) { echo "<div class=\"clearfix visible-sm\"></div>"; } ?>		
		<?php if($i%3==0) { echo "<div class=\"clearfix visible-md\"></div>"; } ?>		
		<?php if($i%3==0) { echo "<div class=\"clearfix visible-lg\"></div>"; } ?>		

		<?php $i++ ?>
        <?php endwhile;

 echo "</div>";

}

// Reset the WP Query
wp_reset_postdata();

?>