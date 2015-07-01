<?php
   /*
   Plugin Name: Osteo Custom Posts Starter
   Description: A plugin containing the custom functions, custom posts types for this site, and site setup options.
   Version: 1.0
   Author: Jeremy Jones
   Author URI: http://jeremyjon.es
   License: GPL2
   */

//Automatically Load all the PHP files we need
$classesDir = array (
    plugin_dir_path( __FILE__ ) .'admin/cpt/',
    plugin_dir_path( __FILE__ ) .'admin/page-templates/',
    plugin_dir_path( __FILE__ ) .'admin/site-setup/',
    plugin_dir_path( __FILE__ ) .'front-end/functions/'
);

foreach ($classesDir as $directory) {
    foreach (glob($directory."*.php") as $filename){
        include $filename;
    }
}

?>
