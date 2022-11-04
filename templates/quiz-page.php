<div class="toast-container toast-pos-right toast-pos-top">

<!-- Toast -->
<div class="toast" id="toast-name-2">
<div class="toast-flex">
    <span><b>The result URl</b> has been copied to the clipboard.</span>
    <a href="#" class="close-toast">X</a>
</div>
</div>

</div>

<?php
$ln = get_locale();
define( 'PLUGIN_DIR', dirname(__DIR__)  );
define( 'PLUGINDIRQUIZ', plugin_dir_url(__DIR__) );
$string = file_get_contents( PLUGIN_DIR."/json/quiz".($ln=='ar' ? '_ar' :'').".json" );
$tran = file_get_contents( PLUGIN_DIR."/json/strings.json" );
$trand = json_decode($tran, true);
$json = json_decode($string, true);
$redirect = isset($_GET['r']) ? $_GET['r'] : '0';
$pts = isset($_GET['pts']) ? $_GET['pts'] : 0;
wp_enqueue_script('quiz-script', PLUGINDIRQUIZ.'js/quiz.js?v='.time() ,['jquery']);
wp_enqueue_style( 'slick-css', PLUGINDIRQUIZ.'assets/src/library/css/slick.css', [], false, 'all' );
wp_enqueue_style( 'slick-theme-css', PLUGINDIRQUIZ.'assets/src/library/css/slick-theme.css', ['slick-css'], false, 'all' );
wp_enqueue_style( 'quiz-css', PLUGINDIRQUIZ  . 'css/style.css?v='.time(), false, false , 'all' );
wp_enqueue_script( 'slick-js', PLUGINDIRQUIZ.'assets/src/library/js/slick.min.js', ['jquery'] );
wp_enqueue_script( 'carousel-js', ( PLUGINDIRQUIZ ) . 'assets/src/carousel/index.js', ['jquery', 'slick-js'] );
$pst = get_post();
$id_ar = apply_filters( 'wpml_object_id', $pst->ID, 'object', false, 'ar' );

$resultsArray=array(
        'below_30_1' =>array(
            [
            'id'=>2813,
            'desc'=>''
            ],
            [
            'id'=>2802,
            'desc'=>''
            ],
            ['id'=>2826,
            'desc'=>''
            ],
            ['id'=>8355,
            'desc'=>''
            ],
            ['id'=>'SF',
            'desc'=>''
            ],

        ),
    '30_60_2' =>array(
        ['id'=>5141,'desc'=>''],
        ['id'=>9446,'desc'=>''],
        ['id'=>6169,'desc'=>''],
        ['id'=>'SF','desc'=>''],
        ['id'=>2789,'desc'=>'']
    ),
    'above_60_3' =>array(
        ['id'=>2789,'desc'=>''],
        ['id'=>2393,'desc'=>''],
        ['id'=>8670,'desc'=>''],
        ['id'=>'SF','desc'=>''],
        ['id'=>2823,'desc'=>''],
    )
);



$morForYouArray=array(
    'below_30_1' =>array(
        ['id'=>7783,'desc'=>'']
    ),
    '30_60_2' =>array(
        ['id'=>100000000,'desc'=>'']
    ),
    'above_60_3' =>array(
        ['id'=>10238,'desc'=>''],
        ['id'=>10178,'desc'=>'']
    )
);
?>
<style>
.page-id-<?php echo $pst->ID;?> .page-content.container{max-width:100%;padding: 0;}
.page-id-<?php echo $pst->ID;?> .article-h1,
.page-id-<?php echo $pst->ID;?> .page-header .container{display: none}
.page-id-<?php echo $pst->ID;?> {
    background: url("<?php echo plugin_dir_url(__DIR__ );?>/img/bg.png") 1px 1px no-repeat;
}

</style>
<script type="text/javascript">
    
var templateUrl = "<?php echo get_option('siteurl') . ($ln=="ar" ? "/ar/" :"/en/") ;?>";
var my_slug = "<?php echo $pst->post_name;?>";
</script>
<div class="QUIZ-proj-wrapper<?php echo ($ln=='ar' ? ' lang_ar' :'');?>" PID="<?php echo $pst->ID;?>">
    <div class="quiz_main <?php echo ($redirect != '0' ? ' hidden' :'');?>">
        <div class="panel-start-quiz flex-center-column">
            <div class="quiz_image">
                <img src="<?php echo  plugin_dir_url(__DIR__);?>/img/find-action-for-you.png" />
            </div>
            <div class="quiz_title"><?php echo $pst->post_title;?></div>
            <div class="quiz_content"><?php echo ($ln =="ar" ? $trand['Lorum_ar'] : $trand['Lorum']) ;?></div>
            <div class="navig flex-raw-center mt-15">
                <div class="btn-quiz btn-quiz-green pointer btn-startquiz">
                    <span><?php echo ($ln =="ar" ? $trand['Start Quiz'] : 'Start Quiz') ;?></span>
                    <img src="<?php echo  plugin_dir_url(__DIR__);?>/img/arrow-right.png" />
                </div>
            </div>

        </div>
        <div class="panelsWrapperOuter hidden">
            <div class="progressBar">
                <div class="progressBarInner"></div>
            </div>
            <div class="counterPer"><span class="stepNumber">1</span>/<span class="totalSteps">10</span></div>
            <div class="panelsWrapper">
                <?php $i=0; foreach($json as $item){ $i++;?>

                <div class="panel hidden" step="<?php echo $i;?>">
                    <div class="question"><?php echo $item['post_title'];?></div>
                    <div class="instructions">
                        <?php echo  ($ln=="ar" ? $trand['Select at least one that applies to you to continue'] : "Select at least one that applies to you to continue" );?>
                    </div>
                    <div class="options <?php echo  trim($item['has_long_title']);?>">
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
                                <input name="<?php echo  str_replace("-" , "_" , $item['slug']);?>" type="checkbox"
                                    class="hidecheck" value="<?php echo  $answer['answer'];?>">
                                <span><?php echo  $answer['answer'];?></span>
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
                <span><?php echo  ($ln =="ar" ? $trand['Back'] : 'Back') ;?></span>
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/arrow-left.png" />
            </div>
            <div class="btn-quiz next-btn-quiz btn-quiz-green pointer disabled">
                <span><?php echo  ($ln=="ar" ? $trand['Next'] : 'Next') ;?></span>
                <img src="<?php echo  plugin_dir_url(__DIR__);?>img/arrow-right.png" />
            </div>
        </div>
    </div>
    <div class="result_main <?php echo  ($redirect != '0' ? '' :' hidden');?>">
        <div class="result_inner flex">
            <div class="txtc">
                <div class="big-tit"><?php echo  ($ln=='ar' ? $trand['Your Result'] : 'Your Result') ;?></div>
                <div class="quote">
                    <?php echo  ($ln=='ar' ? $trand['You don’t just live by principlesYour Result'] : 'You don’t just live by principlesYour Result') ;?>
                </div>
                <div class="percentage-phrase">&nbsp;<span
                        class="perc"><?php echo  $pts;?>%</span>&nbsp;<span><?php echo  ($ln=='ar' ? $trand['of people get this result'] : 'of people get this result');?></span>&nbsp;
                </div>

                <div class="share-btn flex toast-trigger toast-auto" data-toast="toast-name-2">
                    <div class="inner flex">
                        <img src="<?php echo  plugin_dir_url(__DIR__);?>img/share.png" width="13" height="13" />
                        <span class="shareconti"><?php echo  ($ln=='ar' ? $trand['Share'] : 'Share' );?></span>
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
                <div class="donateBtn"><?php echo  ($ln=='ar' ? $trand['Donate Now'] : 'Donate Now') ;?></div>
            </div>
        </div>
        <div class="actionsWrapper">
            <div class="ResBlock1">
            <div class="container">
                    <div class="impactfull_title">
                        <?php echo ($ln=="ar" ? $trand['Take more impactful action'] : 'Take more impactful action');?>
                    </div>
                    <div class="impactfull_desc">
                        <?php echo ($ln=="ar" ? $trand['ACTIONTXT_AR'] : $trand['ACTIONTXT']);?></div>
                    <div class="impactfull_sub_green">
                        <?php echo ($ln=="ar" ? $trand['Here are the easiest ways you can create momentum'] : 'Here are the easiest ways you can create momentum');?>
                    </div>
                    <div class="cardsWrapper posts-carousel">
                        <?php if($redirect!='0'){
            foreach ($resultsArray[$redirect] as $res) {
                if($res['id']!='SF'){
                $card = get_post( $res['id'] );
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $res['id'] ), 'large' );
                $cats = get_the_category($res['id']);?>
                        <div class="qcard qcard-<?php echo $res['id'];?>">
                            <div class="flexmecol">
                                <div class="carsImg">
                                <a href="<?php echo get_permalink( $res['id'] );?>"><img src="<?php echo $image[0];?>" /></a>
                                </div>
                                    <div class="cardTitle"><?php echo $card->post_title;?></div>
                                    <div class="cardCat"><a
                                    href="<?php echo $cats[0]->cat_link;?>"><?php echo $cats[0]->cat_name;?></a>
                                </div>
                                <div><a class="btn-quiz btn-quiz-green" href="<?php echo get_permalink( $res['id'] );?>">Join Us</a></div>
                            </div>
                        </div>
                        <?php }else{?>
                            <div class="qcard qcard-<?php echo $res;?>">
                            <div class="flexmecol">
                                <div class="carsImg">
                                <a target="_blank" href="https://gpmena.secure.force.com/StripePaymentScreen?_gl=1*ntt4hg*_ga*MTgwNzE3Njc3NS4xNjM0MzA2MzM0*_ga_BF1TLGDGBK*MTY2MTg2NzA5NC4xMDguMS4xNjYxODcyNTAxLjAuMC4w"><img src="<?php echo  plugin_dir_url(__DIR__);?>/img/incident.JPG" /></a>
                                </div>
                                    <div class="cardTitle"><?php echo $ln == "ar" ? $trand["Web Donations"] : "Web Donations";?></div>
                                    <div class="cardCat"></div>
                                <div><a class="btn-quiz btn-quiz-green" target="_blank" href="https://gpmena.secure.force.com/StripePaymentScreen?_gl=1*ntt4hg*_ga*MTgwNzE3Njc3NS4xNjM0MzA2MzM0*_ga_BF1TLGDGBK*MTY2MTg2NzA5NC4xMDguMS4xNjYxODcyNTAxLjAuMC4w">Join Us</a></div>
                            </div>
                        </div>

                        <?php }?>
                        
                        
                        <?php }}?>
                    </div>
            </div>
            </div>
            <?php if($redirect!='0' && sizeof($morForYouArray[$redirect])!=0){?>
            <div class="ResBlock2">
            <div class="container">
                    <div class="impactfull_title"><?php echo ($ln=="ar" ? $trand['More for You'] : 'More for You');?></div>
                        <div class="parente">
                            <?php foreach($morForYouArray[$redirect] as $res){
                                $card = get_post( $res['id'] );
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $res['id'] ), 'large' );?>
                                <div class="moreyoucardswrap row">
                                    <div class="col-sm-6"><div class="imgfruwrp"><img src="<?php echo $image[0];?>" alt="" /></div></div>
                                    <div class="col-sm-6 flexrightmore">
                                        <div class="tittell"><?php echo $card->post_title;?></div>
                                        <div class="conti mt-15"><?php echo $res['desc'] != '' ? $res['desc']  : wp_strip_all_tags($card->post_content).' ...' ;?></div>
                                        <div class="flxend"><a class="read-more-lnk mt-15" href="<?php echo get_permalink( $res['id'] );?>"><span class="txt"><?php echo ($ln=="ar" ? $trand['Learn more'] : 'Learn more');?></span><span class="bg"></span></a></div>
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