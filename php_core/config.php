<?php

add_action('after_setup_theme', static function () {
	add_theme_support('custom-logo', []);
});

add_theme_support( 'post-thumbnails' ); 

