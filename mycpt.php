<?php
/**
Plugin Name: My CPT plugin
**/
//// Create recipes CPT
function quiz_post_type() {
    register_post_type( 'quiz',
        array(
            'labels' => array(
                'name' => __( 'Quiz' ),
                'singular_name' => __( 'Quiz' )
            ),
            'public' => true,
            'hierarchical'=>false,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'rewrite'   => array( 'slug' => 'my-quiz' ),
            'menu_position' => 5,
            'menu_icon' => 'dashicons-editor-ul',
        // 'taxonomies' => array('cuisines', 'post_tag') // this is IMPORTANT
        )
    );
    register_post_type( 'options',
        array(
            'labels' => array(
                'name' => __( 'Options' ),
                'singular_name' => __( 'Option' )
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'rewrite'   => array( 'slug' => 'my-options' ),
            'menu_position' => 5,
            'menu_icon' => 'dashicons-editor-ol',
        // 'taxonomies' => array('cuisines', 'post_tag') // this is IMPORTANT
        )
    );
}
add_action( 'init', 'quiz_post_type' );
//// Add  taxonomy
function create_recipes_taxonomy() {
    register_taxonomy('cuisines','recipes',array(
        'hierarchical' => false,
        'labels' => array(
            'name' => _x( 'Cuisines', 'taxonomy general name' ),
            'singular_name' => _x( 'Cuisine', 'taxonomy singular name' ),
            'menu_name' => __( 'Cuisines' ),
            'all_items' => __( 'All Cuisines' ),
            'edit_item' => __( 'Edit Cuisine' ), 
            'update_item' => __( 'Update Cuisine' ),
            'add_new_item' => __( 'Add Cuisine' ),
            'new_item_name' => __( 'New Cuisine' ),
        ),
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    ));
    register_taxonomy('ingredients','recipes',array(
        'hierarchical' => false,
        'labels' => array(
            'name' => _x( 'Ingredients', 'taxonomy general name' ),
            'singular_name' => _x( 'Ingredient', 'taxonomy singular name' ),
            'menu_name' => __( 'Ingredients' ),
            'all_items' => __( 'All Ingredients' ),
            'edit_item' => __( 'Edit Ingredient' ), 
            'update_item' => __( 'Update Ingredient' ),
            'add_new_item' => __( 'Add Ingredient' ),
            'new_item_name' => __( 'New Ingredient' ),
        ),
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    ));
}
//add_action( 'init', 'create_recipes_taxonomy', 0 );
function my_template_array(){
    $temps=[];
    $temps['quiz-page.php']= '_Quiz Page';
    return $temps;
}
function my_templpate_register($page_templates,$theme,$post){
    $templates = my_template_array();
    foreach($templates as $tk=>$tv){
        $page_templates[$tk]=$tv;
    }
    return $page_templates;
}
add_filter('theme_page_templates','my_templpate_register',10,3);
function my_template_select($template){
    global $post , $wp_query , $wpdb;
    $page_temp_slug = get_page_template_slug($post->ID);
    $templates = my_template_array();
    if(isset($templates[$page_temp_slug])){
        $template = plugin_dir_path(__FILE__).'/templates/'.$page_temp_slug;
    }
    return $template;
}
add_filter('template_include' , 'my_template_select',99);
/* PART 2 */
add_action('wp_enqueue_scripts','Load_Template_Scripts_wpa83855');
function Load_Template_Scripts_wpa83855(){
    if ( is_page_template('quiz-page.php') ) {
		wp_enqueue_style( 'style-name-plugin', plugin_dir_url(__FILE__ ).'css/style.css?v='.time() );
        wp_enqueue_script('my-script', plugin_dir_url(__FILE__ ).'js/quiz.js?v='.time() , array('jquery'));
    } 
}
add_action('rest_api_init', function () {
	register_rest_route( 'v1', '/quiz-posts/(?P<lang>[^/]+)',array(
				  'methods' => 'GET',
				  'callback' => 'get_all_quiz',
				  'args' => [
					'lang'
				],
				));
  });
  function get_all_quiz($request) {
	wp_get_nocache_headers();
	$lang = $request->get_param( 'lang' );
	$args = array(
			'post_type' => 'quiz',
			'lang' => $lang,
			'order_by' => 'ID',
			'order' => 'ASC',
			'posts_per_page' => -1,
            'post_status' => 'publish'
    );
    $posts = get_posts($args);
    if (empty($posts)) {
    	return new WP_Error( 'empty_category', 'There are no posts to display', array('status' => 404) );
    }
	foreach($posts as $k=>$post){
		//$my_posts[]['post_title']=$post->post_title;
		$my_posts[]=array(
			'post_title' => $post->post_title,
			'slug' => $post->post_name,
			'has_long_title' => get_post_meta($post->ID , 'has_long_title' , true),
		);
		//$my_posts[]['slug']=$post->slug;
		$answersIDS = get_post_meta($post->ID , 'answers' , true);
		if( is_array($answersIDS) && sizeof($answersIDS) >= 1 ){
			foreach($answersIDS as $id){
				$answer = get_post($id);
				$points = get_post_meta($id , 'points' , true);
				$behavior = get_post_meta($id , 'behavior' , true);
				$my_posts[$k]['answers'][] = array(
					"answer" => $answer->post_title,
					"point" => $points,
					"behavior" => $behavior,
					"POSTID" => $post->ID,
				);	
			}
		}
	}
    $response = new WP_REST_Response($my_posts , 200);
	$response->set_headers(array('Cache-Control' => 'no-cache'));
    return $response;
}
function add_google_fonts() {
    wp_enqueue_style( ' add_google_fonts ', 'https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;500;700;800;900&display=swap', false );
    

}

add_action( 'wp_enqueue_scripts', 'add_google_fonts' );

if(function_exists('pll_register_string')){

    add_action('init', function() {
        pll_register_string('p4custom-start-quiz', 'Start Quiz');
        pll_register_string('p4custom-select_at_least_one_that_applies_to_you_to_continue', 'Select at least one that applies to you to continue');
        pll_register_string('p4custom-next', 'Next');
        pll_register_string('p4custom-back', 'Back');
        pll_register_string('p4custom-share', 'Share');
        pll_register_string('p4custom-donate', 'Donate Now');
    });
    
}


function mts($key){
    global $wpdb;
    $arr = [];
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT meta_value FROM wp_postmeta WHERE meta_key=%d and meta_id=13", '_pll_strings_translations' ) );
    $ser = $results[0]->meta_value;
    $unser =unserialize($ser);
    foreach ($unser as $k=>$v){
        $arr[$v[0]]=$v[1];
    }
    //echo "<pre>";    print_r(json_encode($arr));    echo "</pre>";    
}

//mts("");