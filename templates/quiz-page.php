<?php
$ln = get_locale();
define( 'PLUGIN_DIR', dirname(__DIR__).'/' );
$string = file_get_contents( PLUGIN_DIR."/json/quiz".($ln=='ar' ? '_ar' :'').".json" );
$tran = file_get_contents( PLUGIN_DIR."/json/strings.json" );
$trand = json_decode($tran, true);
$json = json_decode($string, true);
$redirect = isset($_GET['r']) ? $_GET['r'] : 0;
$pts = isset($_GET['pts']) ? $_GET['pts'] : 0;
wp_enqueue_script('my-script', plugin_dir_url(__DIR__ ).'js/quiz.js?v='.time() , array('jquery') ,false );
$pst = get_post();
$id_ar = apply_filters( 'wpml_object_id', $pst->ID, 'object', false, 'ar' );

$resultsArray=array(
    1=>array(10863,10771,10807,10815,10759),
    2=>array(10711,10721,10700),
    3=>array(10652,10644,10621,10619,10611)
);


$html='<style>
.page-id-'.$pst->ID.' .page-header .container,
.page-id-'.$id_ar.' .page-header .container{display:none}
.page-id-'.$pst->ID.'{background: url("'.plugin_dir_url(__DIR__ ).'/img/bg.png") 1px 1px no-repeat ;}</style>
<script type="text/javascript">var templateUrl = "'.get_option('siteurl').'";var my_slug = "'.$pst->slug.'";</script>
<div class="QUIZ-proj-wrapper'.($ln=='ar' ? ' lang_ar' :'').'" PID="'.$pst->ID.'">
<div class="quiz_main '.($redirect != 0 ? ' hidden' :'').'">
<div class="panel-start-quiz flex-center-column">
    <div class="quiz_image">
        <img src="'. plugin_dir_url(__DIR__).'/img/find-action-for-you.png" />
    </div>
    <div class="quiz_title">'.$pst->post_title.'</div>
    <div class="quiz_content">'.($ln =="ar" ? $trand['Lorum_ar'] : $trand['Lorum']) .'</div>
    <div class="btn-quiz btn-quiz-green pointer btn-startquiz"><span>'.($ln =="ar" ? $trand['Start Quiz'] : 'Start Quiz') .'</span>
    <img src="'. plugin_dir_url(__DIR__).'/img/arrow-right.png" /></div>
</div>
<div class="panelsWrapperOuter hidden">
    <div class="progressBar">
        <div class="progressBarInner"></div>
    </div>
    <div class="counterPer"><span class="stepNumber">1</span>/<span class="totalSteps">10</span></div>
    <div class="panelsWrapper">';
        $i=0; foreach($json as $item){ $i++;
            $html.='
        <div class="panel hidden" step="'.$i.'">
            <div class="question">'.$item['post_title'].'</div>
            <div class="instructions">'. ($ln=="ar" ? $trand['Select at least one that applies to you to continue'] : "Select at least one that applies to you to continue" ).'</div>
            <div class="options '. trim($item['has_long_title']).'">';
                foreach($item['answers'] as $answer){
                    $html.='
               <label class="thebtn '. ($answer['behavior'] ? "behavior-".$answer['behavior'] : "").'" points="'. $answer['point'].'">
               <div class="thebtnInner">';
                   if( strlen($item['has_long_title']) > 7 ){
                    $html.='
                    <img class="not-selected" src="'. plugin_dir_url(__DIR__).'/img/checkbox-not-selected.png" />
                    <img class="selected hidden" src="'. plugin_dir_url(__DIR__).'/img/checkbox-selected.png" />';
                    }
                    $html.='<input name="'. str_replace("-" , "_" , $item['slug']).'" type="checkbox" class="hidecheck" value="'. $answer['answer'].'">
                    <span>'. $answer['answer'].'</span>
                </div>   
                </label>';
                }
            $html.='</div>
        </div>';
        }
        $html.='</div>
</div>
<div class="navig flex-raw-center hidden">
    <div class="btn-quiz prev-btn-quiz btn-quiz-white pointer"><span>'. ($ln =="ar" ? $trand['Back'] : 'Back') .'</span><img
            src="'. plugin_dir_url(__DIR__).'img/arrow-left.png" /></div>
    <div class="btn-quiz next-btn-quiz btn-quiz-green pointer disabled"><span>'. ($ln=="ar" ? $trand['Next'] : 'Next') .'</span><img
            src="'. plugin_dir_url(__DIR__).'img/arrow-right.png" /></div>
</div>
</div>
<div class="result_main '. ($redirect != 0 ? '' :' hidden').'">
<div class="result_inner flex">
    <div class="txtc">
        <div class="big-tit">'. ($ln=='ar' ? $trand['Your Result'] : 'Your Result') .'</div>
        <div class="quote">'. ($ln=='ar' ? $trand['You don’t just live by principlesYour Result'] : 'You don’t just live by principlesYour Result') .'</div>
        <div class="percentage-phrase">&nbsp;<span class="perc">'. $pts.'%</span>&nbsp;<span>'. ($ln=='ar' ? $trand['of people get this result'] : 'of people get this result').'</span>&nbsp;</div>
        <div class="share-btn flex">
            <div class="inner flex">
                <img src="'. plugin_dir_url(__DIR__).'img/share.png" width="13" height="13" />
                <span>'. ($ln=='ar' ? $trand['Share'] : 'Share' ).'</span>
            </div>
        </div>    
    </div>
    <div class="qrel">
        <img src="'. plugin_dir_url(__DIR__).'img/below-60.png" class="res_image_glob per_below_60 '. ($redirect != 1 ? ' hidden' :'').'" />
        <img src="'. plugin_dir_url(__DIR__).'img/30-60-per.png" class="res_image_glob per_30-60 '. ($redirect != 2 ? ' hidden' :'').'" />
        <img src="'. plugin_dir_url(__DIR__).'img/Above-60-per.png" class="res_image_glob per_above-60 '. ($redirect != 3 ? ' hidden' :'').'" />
        <div class="donateBtn">'. ($ln=='ar' ? $trand['Donate Now'] : 'Donate Now') .'</div>
    </div>
</div>
<div class="actionsWrapper">
        <div class="impactfull_title">'.($ln=="ar" ? $trand['Take more impactful action'] : 'Take more impactful action').'</div>
        <div class="impactfull_desc">'.($ln=="ar" ? $trand['ACTIONTXT_AR'] : $trand['ACTIONTXT']).'</div>
        <div class="impactfull_sub_green">'.($ln=="ar" ? $trand['Here are the easiest ways you can create momentum'] : 'Here are the easiest ways you can create momentum').'</div>

        <div class="cardsWrapper">';
        if($redirect!=0){
            foreach ($resultsArray[$redirect] as $res) {
            $card = get_post( $res );
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $res ), 'large' );
            $cats = get_the_category($res);
            
            $html.='<div class="card card-'.$res.'">
                    <div><img src="'.$image[0].'" alt="" /></div>
                    <div class="cardTitle">'.$card->post_title.'</div>
                    <div class="cardCat"><a href="'.$cats[0]->cat_link.'">'.$cats[0]->cat_name.'</a></div>
                    <div><a class="btn-quiz btn-quiz-green" href="'.get_permalink( $res ).'">Join Us</a></div>
                </div>';

        }}


        $html.='</div>
</div>

</div>
</div>';
echo $html;