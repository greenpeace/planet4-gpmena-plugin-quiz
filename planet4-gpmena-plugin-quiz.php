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
function load_quiz_js_css(){
    if ( is_page_template('quiz-page.php') ) {
        define('PLUGINDIRQUIZ',plugin_dir_url(__FILE__ ));
        wp_enqueue_script('quiz-script', untrailingslashit(PLUGINDIRQUIZ).'js/quiz.js?v='.time() ,['jquery']);
        wp_enqueue_style( 'slick-css', untrailingslashit( PLUGINDIRQUIZ ) . 'assets/src/library/css/slick.css', [], false, 'all' );
        wp_enqueue_style( 'slick-theme-css', untrailingslashit( PLUGINDIRQUIZ ) . 'assets/src/library/css/slick-theme.css', ['slick-css'], false, 'all' );
        wp_enqueue_script( 'carousel-js', untrailingslashit( PLUGINDIRQUIZ ) . 'assets/src/carousel/index.js', ['jquery', 'slick-js'], filemtime( untrailingslashit( PLUGINDIRQUIZ ) . '/assets/src/carousel/index.js' ), true );
    } 
}
//add_action('wp_enqueue_scripts','load_quiz_js_css');



function place_code_inside_head() {
    $styless = file_get_contents( plugin_dir_url(__FILE__)."css/style.css" );
        //echo'<style>'.$styless.'</style>';
    }
add_action('wp_head', 'place_code_inside_head');