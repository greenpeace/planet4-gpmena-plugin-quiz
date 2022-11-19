<?php
/**
Plugin Name: Planet 4 Quiz
Description: Creates the Greenpeace quiz functionality. To get started, got to Pages (from the left side menu) then *Add New*. Paste the following shorcode: [quiz_html]
Version: 0.0.1
Author: Aimtech
Author URI: https://aimtech.am/
**/
function quiz_functionality($atts){
    ob_start();
    include( dirname(__FILE__)."/templates/quiz-page.php" );
    $ob_str=ob_get_contents();
    ob_end_clean();
    return $ob_str;
}
add_shortcode( 'quiz_html', 'quiz_functionality' );


function your_function_within_class()
    {
        define( 'PLUGINDIRQUIZFILE', plugin_dir_url(__FILE__) );

        wp_enqueue_style( 'slick-css', PLUGINDIRQUIZFILE.'assets/src/library/css/slick.css', [], false, 'all' );
        wp_enqueue_style( 'slick-theme-css', PLUGINDIRQUIZFILE.'assets/src/library/css/slick-theme.css', ['slick-css'], false, 'all' );
        wp_enqueue_script( 'slick-js', PLUGINDIRQUIZFILE.'assets/src/library/js/slick.min.js', ['jquery'] );
        wp_enqueue_script( 'carousel-js', ( PLUGINDIRQUIZFILE ) . 'assets/src/carousel/index.js?v='.time(), ['jquery', 'slick-js'] , null );

        wp_register_style( 'quiz-css-p4', untrailingslashit(plugin_dir_url(__FILE__))  . '/css/style.css?vvv='.time(),null, false  );
        wp_enqueue_style('quiz-css-p4');
    }
add_action('wp_enqueue_scripts','your_function_within_class');

function place_code_inside_head() {
    $styless = file_get_contents( plugin_dir_url(__FILE__)."css/style.css" );
        //echo'<style>'.$styless.'</style>';
    }
add_action('wp_head', 'place_code_inside_head');
function d($var){
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    echo '<pre  style="padding:40px;">';
    echo "<code>";
    echo '<span style="font-weight:bold;">Source: '.$caller['file'] .' Line:'. $caller['line']."\n\n</span>";
    print_r($var);
    echo "</code>";
    echo "</pre>";
}


