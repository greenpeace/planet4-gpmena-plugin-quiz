<?php
$ln = get_locale();
$whitelist = array(
    '127.0.0.1',
    '::1'
);
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){ 
    $getlocal = get_locale();
    switch($getlocal){
            case 'en_US': $ln= 'en';break;
            case 'fr_FR': $ln= 'fr';break;
            case 'ar': $ln= 'ar';break;
        }
    }
define( 'PLUGIN_DIR', dirname(__DIR__)  );
define( 'PLUGINDIRQUIZ', plugin_dir_url(__DIR__) );
$string = file_get_contents( PLUGIN_DIR."/json/quiz_all.json" );
//$string = file_get_contents( PLUGIN_DIR."/json/quiz_enDEBB.json" );

$tran = file_get_contents( PLUGIN_DIR."/json/translation.json" );
$trand = json_decode($tran, true);
$newArr = [];
foreach( $trand as $k=>$v){
    $translations[$k]=array(
        'en' =>$k,
        'ar' =>$v,
        'fr' =>'FR',
    );
}
//d(json_encode($newArr));
$json = json_decode($string, true);
$quiz_data_db = get_option( 'p4menaq_options' );
//echo '<div class="flex">';d($quiz_data_db[$ln]);d($json);echo '</div>';


$redirect = isset($_GET['r']) ? $_GET['r'] : '0';
$pts = isset($_GET['pts']) ? $_GET['pts'] : 0;
wp_enqueue_script('quiz-script', PLUGINDIRQUIZ.'js/quiz.js?v='.time() ,['jquery']);

$pst = get_post();
$id_ar = apply_filters( 'wpml_object_id', $pst->ID, 'object', false, 'ar' );

include( PLUGIN_DIR."/templates/inc-results-source.php" );

$classDebug="";
if(isset($_GET['DEBB'])){
    $classDebug="DEBB";
}

// if(isset($_GET['DEBB'])){
//     d($resultsArray[$redirect]);
//     d($morForYouArray[$redirect]);
// }

?>
<style>
.page-id-<?php echo $pst->ID;?>.page-content.container {
    max-width: 100%;
    padding: 0;
}

.page-id-<?php echo $pst->ID;?> .article-h1,
.page-id-<?php echo $pst->ID;?> .page-header {
    display: none
}
.page-id-<?php echo $pst->ID;?>
 {
    background: url("<?php echo plugin_dir_url(__DIR__ );?>/img/bg.png") 1px 1px no-repeat;
}
</style>
<script type="text/javascript">
var templateUrl = "<?php echo get_option('siteurl') . "/$ln/" ;?>";
var my_slug = "<?php echo $pst->post_name;?>";
var DEBUGG = <?php echo (isset($_GET['DEBB'])) ? 'true' :'false'; ?>
</script>
<div class="QUIZ-proj-wrapper<?php echo " lang_$ln" .($classDebug ? ' DEBB':'') ;?>" ln="<?php echo $ln?>" PID="<?php echo $pst->ID;?>">
    <div class="toast-container toast-pos-right toast-pos-top">
        <div class="toast" id="toast-name-2">
            <div class="toast-flex">
            </div>
        </div>
    </div>
    <div class="quiz_main <?php echo ($redirect != '0' ? ' hidden' :'');?>">
        <div class="panel-start-quiz flex-center-column">
            <div class="quiz_image">
                <img src="<?php echo  plugin_dir_url(__DIR__);?>/img/find-action-for-you.png" />
            </div>
            <div class="quiz_title"><?php echo $pst->post_title;?></div>
            <div class="quiz_content"><?php echo $trand['TAKE_OUR_environmental_quiz'][$ln];?></div>
            <div class="navig-start flex-raw-center mt-15">
                <div class="btn-quiz btn-quiz-green pointer btn-startquiz">
                    <span><?php echo $trand['Start Quiz'][$ln];?></span>
                    <img src="<?php echo  plugin_dir_url(__DIR__);?>/img/arrow-right.png" />
                </div>
            </div>
        </div>
        <div class="panelsWrapperOuter hidden">
            <div class="progressBar">
                <div class="progressBarInner"></div>
            </div>
            <div class="counterPer"><span class="stepNumber"></span>/<span class="totalSteps"></span></div>
            <div class="panelsWrapper">
                <?php $i=0; 
                //foreach($quiz_data_db[$ln] as $item){
                foreach($json as $item){
                     $i++;?>
                <div class="panel hidden" step="<?php echo $i;?>">
                    <div class="question"><?php echo $item['post_title_'.$ln];?></div>
                    <?php if($item['rule'] != 'single'){?>
                    <div class="instructions">
                        <?php echo $trand['Select at least one that applies to you to continue'][$ln];?>
                    </div>
                    <?php }?>

                    <div class="options<?php echo ' '. trim($item['has_long_title']);?>" myrule="<?php echo $item['rule'];?>">
                        <?php foreach($item['answers'] as $answer){?>
                        <label
                            class="thebtn <?php echo  ($answer['behavior'] ? "behavior-".$answer['behavior'] : "");?>"
                            points="<?php echo  $answer['point'];?>">
                            <div class="thebtnInner">
                                <?php if( strlen($item['has_long_title']) > 7 ){?>
                                <img class="not-selected"
                                    src="<?php echo  plugin_dir_url(__DIR__);?>/img/checkbox-not-selected.png" />
                                <img class="selected hidden"
                                    src="<?php echo  plugin_dir_url(__DIR__);?>/img/checkbox-selected.png" />
                                <?php }?>
                                <span><?php echo  $answer['answer_'.$ln] ;?><?php if($_GET['DEBB']) echo ' - '.$answer['point'];?></span>
                            </div>
                        </label>
                        <?php }?>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <div class="navig flex-raw-center hidden">
            <div class="btn-quiz prev-btn-quiz btn-quiz-white pointer">
                <span><?php echo $trand['Back'][$ln];?></span>
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/arrow-left.png" />
            </div>
            <div class="btn-quiz next-btn-quiz btn-quiz-green pointer disabled">
                <span><?php echo $trand['Next'][$ln];?></span>
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/arrow-right.png" />
            </div>
        </div>
    </div>
    <div class="result_main<?php echo  ($redirect != '0' ? '' :' hidden');?>">
<div class="preloaderq hidden">
<img src="<?php echo plugin_dir_url(__DIR__);?>/img/loader.svg" />
</div>
        <div class="result_inner flex">
            <div class="txtc">
                <div class="big-tit"><?php echo $trand['Your Result'][$ln] ;?></div>
                <div class="quote">
                    <?php echo $trand['YOU_DON_t just live by principles'][$ln];?>
                </div>
                <div class="percentage-phrase"><span><?php echo str_replace('s%' , $pts.'% ' , $trand['of people get this result'][$ln]);?></span>&nbsp;
                </div>
                <div class="share-btn flex toast-trigger toast-auto" data-toast="toast-name-2">
                    <div class="inner flex">
                        <img src="<?php echo  plugin_dir_url(__DIR__);?>img/share.png" width="13" height="13" />
                        <span class="shareconti"><?php echo $trand['Share'][$ln];?></span>
                    </div>
                </div>
            </div>
            <div class="qrel">
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/below-60.png"
                    class="res_image_glob per_below_60 <?php echo  ($redirect != 'below_30_1' ? ' hidden' :'');?>" />
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/30-60-per.png"
                    class="res_image_glob per_30-60 <?php echo  ($redirect != '30_60_2' ? ' hidden' :'');?>" />
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/Above-60-per.png"
                    class="res_image_glob per_above-60 <?php echo  ($redirect != 'above_60_3' ? ' hidden' :'');?>" />
                <a class="donateBtn" href="<?php echo $trand['DONATION_LINK'][$ln]?>" target="_blank">
                <?php echo $trand['Donate Now'][$ln];?>
                </a>
            </div>
        </div>
        <div class="actionsWrapper">
            <div class="ResBlock1">
                <div class="container">
                    <div class="impactfull_title">
                        <?php echo $trand['Take more impactful action'][$ln];?>
                    </div>
                    <div class="impactfull_desc">
                        <?php echo $trand['ACTIONTXT'][$ln];?></div>
                    <div class="impactfull_sub_green">
                        <?php echo $trand['Here are the easiest ways you can create momentum'][$ln];?>
                    </div>
                    <div class="cardsWrapper posts-carousel" dir="<?php echo $ln =='ar' ? 'rtl' : 'ltr';?>">
                        <?php
            if($redirect!='0' ){
            foreach ($resultsArray[$redirect] as $res) {
                $id = $res['id_'.$ln];
                
                if($id != 'SF'){
                $card = get_post( $id );
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
                $cats = get_the_category($id);?>
                        <div class="qcard qcard-<?php echo $id;?>">
                            <div class="flexmecol">
                                <div class="carsImg">
                                    <a href="<?php echo get_permalink( $id );?>"><img
                                            src="<?php echo $image[0];?>" /></a>
                                </div>
                                <div class="cardTitle"><?php echo $card->post_title;?></div>
                                <!-- <div class="cardCat">
                                        <a href="<?php echo $cats[0]->cat_link;?>"><?php echo $cats[0]->cat_name;?></a>
                                </div> -->
                                <div><a class="btn-quiz btn-quiz-green" idd="<?php echo $id;?>" href="<?php echo get_permalink( $id );?>">
                                <?php echo $res['btn_txt_slug'] =='JoinUs' ? $trand['Join Us'][$ln] : $trand['Learn More'][$ln] ;?></a>
                                </div>
                            </div>
                        </div>
                        <?php }else{?>
                        <div class="qcard qcard-<?php echo $id;?>">
                            <div class="flexmecol">
                                <div class="carsImg">
                                    <a target="_blank"
                                        href="https://gpmena.secure.force.com/StripePaymentScreen?_gl=1*ntt4hg*_ga*MTgwNzE3Njc3NS4xNjM0MzA2MzM0*_ga_BF1TLGDGBK*MTY2MTg2NzA5NC4xMDguMS4xNjYxODcyNTAxLjAuMC4w"><img
                                            src="<?php echo  plugin_dir_url(__DIR__);?>/img/incident.JPG" /></a>
                                </div>
                                <div class="cardTitle"><?php echo $trand["Web Donations"][$ln];?></div>
                                <div class="cardCat"></div>
                                <div><a class="btn-quiz btn-quiz-green" target="_blank"
                                        href="https://gpmena.secure.force.com/StripePaymentScreen?_gl=1*ntt4hg*_ga*MTgwNzE3Njc3NS4xNjM0MzA2MzM0*_ga_BF1TLGDGBK*MTY2MTg2NzA5NC4xMDguMS4xNjYxODcyNTAxLjAuMC4w">Join
                                        Us</a></div>
                            </div>
                        </div>
                        <?php }?>
                        <?php }}?>
                    </div>
                </div>
            </div>
            <?php if($redirect!='0' && is_array($morForYouArray[$redirect])){?>
            <div class="ResBlock2">
                <div class="container">
                    <div class="impactfull_title"><?php echo $trand['More for You'][$ln];?></div>
                    <div class="parente">
                        <?php foreach($morForYouArray[$redirect] as $res){
                                $id = $res['id_'.$ln];
                                $card = get_post( $id );
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );?>
                        <div class="moreyoucardswrap row">
                            <div class="col-sm-6">
                                <div class="imgfruwrp"><img src="<?php echo $image[0];?>" alt="" /></div>
                            </div>
                            <div class="col-sm-6 flexrightmore">
                                <div class="tittell"><?php echo $card->post_title;?></div>
                                <div class="conti mt-15">
                                    <?php echo $res['desc_'.$ln] != '' ? $res['desc_'.$ln]  : wp_strip_all_tags($card->post_content).' ...' ;?>
                                </div>
                                <div class="flxend"><a class="read-more-lnk mt-15"
                                        href="<?php echo get_permalink( $id );?>"><span
                                            class="txt"><?php echo $trand['Learn More'][$ln]?></span><span
                                            class="bg"></span></a></div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>`
    </div>
</div>