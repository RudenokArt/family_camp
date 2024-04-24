<?php 
get_header(); 
$seasons = ACF_class::getSeasonsList();
$arrivals = ACF_class::getArrivalsList();
$directions = ACF_class::getDirectionsList();
?>
<pre><?php print_r($seasons) ?></pre>
<pre><?php print_r($directions) ?></pre>
<pre><?php print_r($arrivals) ?></pre>

<?php get_footer(); ?>