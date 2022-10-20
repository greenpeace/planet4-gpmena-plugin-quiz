<?php
/*
Template Name: Quiz Page
https://www.figma.com/file/waDWQvMBf42Q3yvxl8N223/Greenpeace?node-id=399%3A2206
//     
*/
wp_head();
$ln = get_locale();
//$quiz = get_all_quiz();
//print_r($quiz->data);
define( 'PLUGIN_DIR', dirname(__DIR__).'/' );  
$string = file_get_contents( PLUGIN_DIR."/json/quiz".($ln=='ar' ? '_ar' :'').".json" );
$tran = file_get_contents( PLUGIN_DIR."/json/strings.json" );

$trand = json_decode($tran, true);

$json = json_decode($string, true);
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="QUIZ-proj-wrapper<?php echo($ln=='ar' ? ' lang_ar' :'')." PID:".$post->ID?>">
<div class="quiz_main">
<div class="panel-start-quiz flex-center-column">
    <div class="quiz_image">
        <img src="<?php echo plugin_dir_url(__DIR__)?>/img/find-action-for-you.png" />
    </div>
    <div class="quiz_title"><?php echo $post->post_title;?></div>
    <div class="quiz_content"><?php echo $post->post_content;?></div>
    <div class="btn-quiz btn-quiz-green pointer btn-startquiz"><span><?php echo $ln =="ar" ? $trand['Start Quiz'] : 'Start Quiz';?></span><img
            src="<?php echo plugin_dir_url(__DIR__)?>/img/arrow-right.png" /></div>
</div>
<div class="panelsWrapperOuter hidden">
    <div class="progressBar">
        <div class="progressBarInner"></div>
    </div>
    <div class="counterPer"><span class="stepNumber">1</span>/<span class="totalSteps">10</span></div>
    <div class="panelsWrapper">
        <?php $i=0; foreach($json as $item){ $i++;?>
        <div class="panel hidden" step="<?php echo $i;?>">
            <div class="question"><?php echo $item['post_title']?></div>
            <div class="instructions"><?php echo $ln=="ar" ? $trand['Select at least one that applies to you to continue'] : "'Select at least one that applies to you to continue'"; ?></div>
            <div class="options <?php echo trim($item['has_long_title']);?>">
                <?php foreach($item['answers'] as $answer){?>
               <label class="thebtn <?php echo ($answer['behavior'] ? "behavior-".$answer['behavior'] : "");?>" points="<?php echo $answer['point']?>">
               <div class="thebtnInner">
                   <?php if( strlen($item['has_long_title']) > 7 ){?>
                    <img class="not-selected" src="<?php echo plugin_dir_url(__DIR__)?>/img/checkbox-not-selected.png" />
                    <img class="selected hidden" src="<?php echo plugin_dir_url(__DIR__)?>/img/checkbox-selected.png" />
                    <?php }?>
                    <input name="<?php echo str_replace("-" , "_" , $item['slug']);?>" type="checkbox" class="hidecheck" value="<?php echo $answer['answer']?>">
                    <span><?php echo $answer['answer']?></span>
                </div>   
                </label>
                <?php }?>
            </div>
        </div>
        <?php }?>
    </div>
</div>
<div class="navig flex-raw-center hidden">
    <div class="btn-quiz prev-btn-quiz btn-quiz-white pointer"><span><?php echo $ln =="ar" ? $trand['Back'] : 'Back'; ?></span><img
            src="<?php echo plugin_dir_url(__DIR__)?>img/arrow-left.png" /></div>
    <div class="btn-quiz next-btn-quiz btn-quiz-green pointer disabled"><span><?php echo $ln=="ar" ? $trand['Next'] : 'Next'; ?></span><img
            src="<?php echo plugin_dir_url(__DIR__)?>img/arrow-right.png" /></div>
</div>
</div>
<div class="result_main hidden">
<div class="result_inner flex">
    <div class="txtc">
        <div class="big-tit"><?php echo $ln=='ar' ? $trand['Your Result'] : 'Your Result'; ?></div>
        <div class="quote"><?php echo $ln=='ar' ? $trand['You don’t just live by principlesYour Result'] : 'You don’t just live by principlesYour Result'; ?></div>
        <div class="percentage-phrase" >&nbsp;<span class="perc">61%</span>&nbsp;<span><?php echo $ln=='ar' ? $trand['of people get this result'] : 'of people get this result';?></span>&nbsp;</div>
        <div class="share-btn flex">
            <div class="inner flex">
                <img src="<?php echo plugin_dir_url(__DIR__)?>img/share.png" width="13" height="13" />
                <span><?php echo $ln=='ar' ? $trand['Share'] : 'Share'; ?></span>
            </div>
        </div>    
    </div>
    <div class="qrel">
        <img src="<?php echo plugin_dir_url(__DIR__)?>img/Above-60-per.png" class="res_image_glob per_above-60 hidden" />
        <img src="<?php echo plugin_dir_url(__DIR__)?>img/30-60-per.png" class="res_image_glob per_30-60 hidden" />
        <img src="<?php echo plugin_dir_url(__DIR__)?>img/below-60.png" class="res_image_glob per_below_60 hidden" />
        <div class="donateBtn"><?php echo $ln=='ar' ? $trand['Donate Now'] : 'Donate Now'; ?></div>
    </div>
</div>
</div>
</div>