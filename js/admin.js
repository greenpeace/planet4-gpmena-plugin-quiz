jQuery(document).ready(function ($) {

    //$('.main_row_q_p .answers').addClass('hideme');
    

    $('.show_nsr_trigger').click(function(e){
        e.preventDefault();
        $('.wrapper_admin_qqq .answers').addClass('dontshow');
        var $parent = $(this).closest('.main_row_q_p');
        $parent.find('.answers').removeClass('dontshow');
        $parent.addClass('selected');
    });

    //$(".wrapper_admin_qqq .tab").addClass('hideme');
    
    $(".tabs_admin_quiz_lng a").click(function(){
        $(".tabs_admin_quiz_lng a").removeClass('selected');
        $(this).addClass('selected');
        var ln = $(this).attr('ln');
        $(".wrapper_admin_qqq .tab").addClass('hideme');
        $(".wrapper_admin_qqq .tab-"+ln).removeClass('hideme');
    });
    
    
    if(window.location.hash){
        var spli = window.location.hash.split('#');
        var ln = spli[1];
        $( '.tabs_admin_quiz_lng a[ln="'+ln+'"]' ).addClass('selected');
        $(".wrapper_admin_qqq .tab-"+ln).removeClass('hideme');
    }else{
        $(".wrapper_admin_qqq .tab:eq(0)").removeClass('hideme');
        $(".tabs_admin_quiz_lng a:eq(0)").addClass('selected')
    }

})