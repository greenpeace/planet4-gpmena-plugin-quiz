<?php
/**
Plugin Name: Planet 4 Quiz
Description: Creates the Greenpeace quiz functionality. To get started, got to Pages (from the left side menu) then *Add New*. Paste the following shorcode: [quiz_html]
Version: 0.0.1
Author: Aimtech
Author URI: https://aimtech.am/
**/
function quiz_functionality($atts){
    $content = include( dirname(__FILE__)."/templates/quiz-page.php" );
    return $content;
}
add_shortcode( 'quiz_html', 'quiz_functionality' );
add_action('wp_enqueue_scripts','load_quiz_javascript');
function load_quiz_javascript(){
    if ( is_page_template('quiz-page.php') ) {
        wp_enqueue_script('quiz-script', plugin_dir_url(__FILE__ ).'js/quiz.js?v='.time() , array('jquery'));
    } 
}
function place_code_inside_head() {
    $styless = file_get_contents( plugin_dir_url(__FILE__)."css/style.css" );
        echo'<style>'.$styless.'</style>';
    }
add_action('wp_head', 'place_code_inside_head');