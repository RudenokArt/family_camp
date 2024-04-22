<?php 
get_header(); 
$arrivals = ACF_class::getArrivalsList();
?>

<pre><?php print_r($arrivals) ?></pre>

<?php get_footer(); ?>