jQuery(document).ready(function ($) {

    //$('.main_row_q_p .answers').addClass('hideme');
    
    $('.show_nsr_trigger').click(function(e){
        e.preventDefault();
        var $parent = $(this).closest('.main_row_q_p');
        $('.main_row_q_p .answers').addClass('hideme');
        $parent.find('.answers').fadeToggle(500);
        $parent.addClass('selected');
    });

    $(".wrapper_admin_qqq .tab").addClass('hideme');
    $(".wrapper_admin_qqq .tab:eq(0)").removeClass('hideme');
    $(".tabs_admin_quiz_lng h1:eq(0)").addClass('selected')
    
    $(".tabs_admin_quiz_lng h1").click(function(){
        $(".tabs_admin_quiz_lng h1").removeClass('selected');
        $(this  ).addClass('selected');

        var ln = $(this).attr('ln');
        $(".wrapper_admin_qqq .tab").addClass('hideme');
        $(".wrapper_admin_qqq .tab-"+ln).removeClass('hideme');

    });



})