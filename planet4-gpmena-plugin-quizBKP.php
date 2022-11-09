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





/* Quiz management (CRUD) */
 function get_quiz_langs(){
     return ['en'=>'English','fr'=>'French','ar'=>'Arabic'];
 }
function p4menaq_settings_init() {
	register_setting( 'p4menaq', 'p4menaq_options' );
	add_settings_section(
        'p4menaq_section_developers',
		__( 'P4 mena quiz management', 'p4menaq' ), 'p4menaq_section_developers_callback',
		'p4menaq'
	);
$langs = get_quiz_langs();
$arr_stgss_multy=[];
foreach($langs as $ln=>$lang){
    $json = file_get_contents( plugin_dir_url(__FILE__ )."json/quiz_$ln.json" );
    $quiz_data_from_json = json_decode($json);
    if($json){
    
    foreach($quiz_data_from_json as $i=>$res){
        $arr_stgss_multy_answers=[];
            foreach($res->answers as $ak => $answer){
                //d($answer);
                $arr_stgss_multy_answers[]=
                 array(
                    'answer' =>array(
                        'label_for'         => $ln.'_q_'.$i.'_answer_'.$ak,
                        'value'         => $answer->answer,
                    ),
                    'points' =>array(
                        'label_for'         => $ln.'_q_'.$i.'_points_'.$ak,
                        'value'         => $answer->point,
                    ),
                    'behavior' =>array(
                        'label_for'         => $ln.'_q_'.$i.'_behavior_'.$ak,
                        'value'         => $answer->point,
                    )
            );
            }
            $arr_stgss_multy[$ln][]=
            array(
                'question' =>array(
                    'label_for'         => 'p4menaq_field_question-'.$i.'ln:'.$ln,
                    'value' => $res->post_title,
                ),
                'has_long_title' =>array(
                    'label_for'         => 'p4menaq_field_has_long_title-'.$i.'ln:'.$ln,
                    'value' => $res->has_long_title,
                ),
                'answers'=>$arr_stgss_multy_answers
            );
        }     
    }   
    }
    //d($arr_stgss_multy_answers);

        add_settings_field(
            'p4menaq_field_pill',
            __( 'Questions', 'p4menaq' ),
            'p4menaq_field_pill_cb',
            'p4menaq',
            'p4menaq_section_developers',
            $arr_stgss_multy
        );
}

add_action( 'admin_init', 'p4menaq_settings_init' );



function p4menaq_section_developers_callback( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php echo __( 'If you want the questions to be listed on top of each other, select <strong>Has long title</strong> from the dropdown .', 'p4menaq' ); ?></p>
	<?php
}

function p4menaq_field_pill_cb( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'p4menaq_options' );
     d($options);
    $langs = get_quiz_langs();?>
    <div class="wrapper_admin_qqq">
    <div class="tabs_admin_quiz_lng">
        <?php foreach($langs as $ln=>$lang){?>
            <h1 ln="<?php echo $ln?>"><?php echo $lang?></h1>
            <?php }?>
        </div>

    <?php foreach($langs as $ln=>$lang){?>
        <div class="tab tab-<?php echo $ln;?>">


    <?php
    foreach($args[$ln] as $i=>$arg){?>
<div class="main_row_q_p">
        <div class="row_options_quiz row_options_quiz_<?php echo $i;?>">    
            <div class="myadmin_quiz_fld_wrp">Question # <?php echo ($i+1);?></div>
            <textarea type="text" 
                id="<?php echo esc_attr( $arg['question']['label_for'] ); ?>"
                name="p4menaq_options[<?php echo esc_attr( $arg['question']['label_for'] ); ?>]"
                ><?php 
                //echo $arg['question']['value']
                echo isset( $options[$arg['question']['label_for']] ) ? $options[ $arg['question']['label_for']]  :  '' ;
                 ?></textarea>
            <select 
                id="<?php echo esc_attr( $arg['has_long_title']['label_for'] ); ?>"
	            data-custom="<?php echo esc_attr( $arg['has_long_title']['p4menaq_custom_data'] ); ?>"
	            name="p4menaq_options[<?php echo esc_attr( $arg['has_long_title']['label_for'] ); ?>]"
            > 
            <option value="has_long_title" <?php echo isset( $options[ $arg['has_long_title']['label_for'] ] ) ? ( selected( $options[ $arg['has_long_title']['label_for'] ], 'has_long_title', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Has long title', 'p4menaq' ); ?>
            </option>
            <option value="normal" <?php echo isset( $options[ $arg['has_long_title']['label_for'] ] ) ? ( selected( $options[ $arg['has_long_title']['label_for'] ], 'normal', false ) ) : ( '' ); ?>>
                <?php esc_html_e( 'Normal', 'p4menaq' ); ?>
            </option>
    </select>
    <a href="#" class="show_nsr_trigger">show answers</a>
</div>
<div class="answers">
<?php
//d($arg['answers']);
foreach($arg['answers'] as $n=>$argc){
   //d($argc);
    ?>
    <div class="answer_row">
    <textarea
        id="<?php echo esc_attr( $argc['answer']['label_for'] ); ?>"
        name="p4menaq_options[answer_<?php echo $ln.$i;?>][<?php echo esc_attr( $argc['answer']['label_for'] ); ?>]" 
        class="nsr_inpt"
    ><?php 
        //echo esc_attr( $options[$argc['answer']['label_for']]); 
        echo esc_attr( $argc['answer']['value']); 
    ?></textarea>
    <input 
        name="p4menaq_options[answer_<?php echo $ln.$i;?>][<?php echo esc_attr( $argc['points']['label_for'] ); ?>]" 
        class="ptsnumber" 
        type="number" 
        value="<?php 
        //echo esc_attr( $options[$argc['points']['label_for']] ); 
        echo esc_attr( $argc['points']['value'] ); 
        ?>"
     />
    <select 
        id="<?php echo esc_attr( $argc['behavior']['label_for'] ); ?>"
	    name="p4menaq_options[answer_<?php echo $ln.$i;?>][<?php echo esc_attr( $argc['behavior']['label_for'] ); ?>]"
        >
		<option value="has_long_title" <?php echo isset( $options[ $argc['behavior']['label_for'] ] ) ? ( selected( $options[ $argc['behavior']['label_for'] ], 'All_Of_these', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'All Of these', 'p4menaq' ); ?>
		</option>
        <option value="None_of_the_above" <?php echo isset( $options[ $argc['behavior']['label_for'] ] ) ? ( selected( $options[ $argc['behavior']['label_for'] ], 'None_of_the_above', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'None of the above', 'p4menaq' ); ?>
		</option>
        <option value="Normal" <?php echo isset( $options[ $argc['behavior']['label_for'] ] ) ? ( selected( $options[ $argc['behavior']['label_for'] ], 'Normal', false ) ) : ( '' ); ?>>
			<?php esc_html_e( 'Normal', 'p4menaq' ); ?>
		</option>
	</select>
    </div>
<?php }?>
</div>
</div>
<?php }?>
</div>
<?php }?>
</div>
<?php
}
/**
 * Add the top level menu page.
 */
function p4menaq_options_page() {
	add_menu_page(
		'p4menaq',
		'Quiz Management',
		'manage_options',
		'p4menaq',
		'p4menaq_options_page_html',
        plugin_dir_url(__FILE__ )."/img/quiz.png"
        ,4
 //       'dashicons-admin-page'
	);
}
/**
 * Register our p4menaq_options_page to the admin_menu action hook.
 */
 add_action( 'admin_menu', 'p4menaq_options_page' );
/**
 * Top level menu callback function
 */
function p4menaq_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	// add error/update messages
	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'p4menaq_messages', 'p4menaq_message', __( 'Settings Saved', 'p4menaq' ), 'updated' );
	}
	// show error/update messages
	settings_errors( 'p4menaq_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		
        
        <form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "p4menaq"
			settings_fields( 'p4menaq' );
			// output setting sections and their fields
			// (sections are registered for "p4menaq", each field is registered to a specific section)
			do_settings_sections( 'p4menaq' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}
add_action('admin_head', 'my_custom_quiz_admin_css');
function my_custom_quiz_admin_css() {
  echo '<style>
  </style>';
}


function quiz_admin_script( $hook ) {    
    if ( $_GET['page'] != 'p4menaq' ) {
        return;
    }
    wp_enqueue_style( 'my_custom_css_admin_quiz', plugin_dir_url( __FILE__ ) . 'css/admin.css', [], false, 'all' );
    wp_enqueue_script( 'my_custom_script_admin_quiz', plugin_dir_url( __FILE__ ) . 'js/admin.js', ['jquery'], '1.0' );
}
add_action( 'admin_enqueue_scripts', 'quiz_admin_script' );




