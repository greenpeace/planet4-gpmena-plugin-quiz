jQuery(document).ready(function ($) {

  class SlickCarousel {
            
    constructor() {
        this.initiateCarousel();        
    }
    
    initiateCarousel() {
        var slidesToShow=3;
        var slidesToScroll=3;
        if (window.matchMedia('screen and (max-width: 600px)').matches) {
            slidesToShow = 1
            slidesToScroll = 1
        }else{
            slidesToShow = 3
            slidesToScroll = 3
        }

    $(".posts-carousel").slick({
        autoplay: false,
        autoplaySpeed: 1000,
        slidesToShow: slidesToShow,
        slidesToScroll: slidesToScroll,
        infinite: false,
        rtl: $(".posts-carousel").attr('dir') =='rtl'
    } );
}
}
new SlickCarousel();

function showToast(source=null,html){
    var tostContent = html ? html+'<a href="#" class="close-toast">X</a>' : '<span><b>The result URl</b> has been copied to the clipboard.</span><a href="#" class="close-toast">X</a>';
    $('.toast').html(tostContent)

    //$(this).addClass('clicked').html('Copied');
    //var currentURL = window.location.href;
    //navigator.clipboard.writeText(currentURL);

    datatoast = $("#toast-name-2");
    
    datatoast.parent().css({
      'display': 'flex',
      'position': 'absolute',
      'top': '70px',
      'margin-left': '-50%',
      'left': '50%',
      'right': '0',
      'z-index':'999'
    });
    datatoast.css('display','flex')
    $( datatoast).fadeIn(400).delay(1500).fadeOut(400);

    // if ( $( datatoast ).hasClass( "toast-auto" ) && !$( datatoast).is(":visible") ){ 
    //   console.log('up')
    // }
    // else if ( !$( datatoast).is(":visible") ){
    //   console.log('doewn')
    //   $( datatoast).fadeIn(400);
    // };
}


  $(".toast-trigger").click(function(e,html){
    if($(this).hasClass('clicked')) return;

    var tostContent = '<span><b>The result URl</b> has been copied to the clipboard.</span><a href="#" class="close-toast">X</a>';
    $('.toast').html(tostContent)

    $(this).addClass('clicked').html('Copied');
    var currentURL = window.location.href;
    navigator.clipboard.writeText(currentURL);

    datatoast = $(this).attr("data-toast");
    if ( $( this ).hasClass( "toast-auto" ) && !$("#" + datatoast).is(":visible") ){ 
      $("#" + datatoast).fadeIn(400).delay(2000).fadeOut(400);
    }
    else if ( !$("#" + datatoast).is(":visible") ){
      $("#" + datatoast).fadeIn(400);
    };
  });
  
  $(".QUIZ-proj-wrapper").on('click' , '.close-toast',function(e){
    e.preventDefault();
    $(this).closest('.toast-container').fadeOut(400);
  });


  var step = 0;
  var totalSteps = $(".panelsWrapper").children(".panel").length;
  $('.totalSteps').html(totalSteps)
  //console.log(totalSteps,'totalSteps')
  
  $(".btn-startquiz").click(function () {
    $(".panel-start-quiz").addClass("hidden");
    $(".navig").removeClass("hidden");
    $(".panelsWrapperOuter").removeClass("hidden");
    $(".panel:eq(0)").removeClass("hidden");
    step=1;
    $(".stepNumber").html(step );
  });


  $(".prev-btn-quiz").click(function () {
    step -= 1;
    if (step == 0) {
      $(".panel-start-quiz").removeClass("hidden");
      $(".navig").addClass("hidden");
      $(".panelsWrapperOuter").addClass("hidden");
      $(".panel:eq(0)").addClass("hidden");
    } else {
      $(".panel").addClass("hidden");
      $(".panel:eq(" + (step-1) + ")").removeClass("hidden");
      $(".stepNumber").html(step );
      $(".progressBarInner").css("width", (step ) * 10 + "%");
      $(".next-btn-quiz").removeClass("disabled");
    }
  });


  var redirect=0;


  $(".next-btn-quiz").click(function () {
    if ($(this).hasClass("disabled")) return;
    
    if (step <= totalSteps ) {
      step += 1;
      
      $(".panel").addClass("hidden");
      $(".panel:eq(" + (step-1) + ")").removeClass("hidden");
      $(".stepNumber").html(step );
      $(".progressBarInner").css("width", (step * 10) + "%");

      if ( $(".panel:eq("+(step-1)+") .options").find(".thebtn.selected").length ==  0 ) {
        $(".next-btn-quiz").addClass("disabled");
      } else {
        $(".next-btn-quiz").removeClass("disabled");
      }
    }
    var perc = calculatePoints();
    
    

    if (step > totalSteps) {

      if(DEBUGG){
        return;
      }

      $(".res_image_glob ").addClass("hidden");
      $(".quiz_main").addClass("hidden");
      $(".result_main").removeClass("hidden");
      if (perc < 30) {
        perc_txt = "Below 30%";
        redirect = 'below_30_1';
        $(".res_image_glob.per_below_60").removeClass("hidden");
      }
      if (perc > 60) {
        perc_txt = "Above 60%";
        $(".res_image_glob.per_above-60").removeClass("hidden");
        redirect = 'above_60_3';
      }
      if (perc >= 30 && perc <= 60) {
        perc_txt = "30-60%";
        $(".res_image_glob.per_30-60").removeClass("hidden");
        redirect = '30_60_2';
      }
      $(".perc").html(perc + "%");
      
      $('.result_main .result_inner').hide();
      $('.result_main').css('height','600px');
      $('.preloaderq').removeClass('hidden');
      
      
      window.location.href = templateUrl+'/'+my_slug+'?r='+redirect+'&pts='+perc;
      $('.page-header-title').closest('.container').css('display','none');
    }
  });

if(redirect!=0){
  $('.result_main').show();
}
  

  $(".thebtn").click(function (e) {
    e.preventDefault();
    $optionsParent = $(this).closest(".options");
  
    
    var lengtheSelected = $optionsParent.find('.thebtn.selected').length;

    if( $optionsParent.attr('myrule') == 'max_2' && lengtheSelected == 2 && !$(this).hasClass('selected')){
    
      
      showToast('thebtn','<span>You can only select <strong>2</strong> options!</span>')
      //window.scrollTo({top: 0, behavior: 'smooth'});
      $('html, body').animate({scrollTop:0},'50');
      return;
        
    }
    
    if (
      !$(this).hasClass("behavior-none") &&
      !$(this).hasClass("behavior-all")
    ) {
      //$optionsParent.find(".thebtn").removeClass("selected");
      if (!$(this).hasClass("selected")) {
        $(this).addClass("selected");
        $(this).find("img.selected").removeClass("hidden");
        $(this).find("img.not-selected").addClass("hidden");
      } else {
        $(this).removeClass("selected");
        $(this).find("img.selected").addClass("hidden");
        $(this).find("img.not-selected").removeClass("hidden");
      }
      $optionsParent.find(".thebtn.behavior-none").removeClass("selected");
      $optionsParent.find(".thebtn.behavior-all").removeClass("selected");
      $optionsParent
        .find(".thebtn.behavior-none img.selected")
        .addClass("hidden");
      $optionsParent
        .find(".thebtn.behavior-none img.not-selected")
        .removeClass("hidden");
      $optionsParent
        .find(".thebtn.behavior-all img.selected")
        .addClass("hidden");
      $optionsParent
        .find(".thebtn.behavior-all img.not-selected")
        .removeClass("hidden");
    }
    if ($(this).hasClass("behavior-none")) {
      //  $(this).toggleClass("selected");
      $optionsParent.find(".thebtn").each(function (i, obj) {
      //  if (!$(obj).hasClass("behavior-none")) {   }
          $(obj).removeClass("selected");
          $(obj).find("img.selected").addClass("hidden");
          $(obj).find("img.not-selected").removeClass("hidden");
     
      });
      if (!$(this).hasClass("selected")) {
        $(this).addClass("selected");
        $(this).find("img.selected").removeClass("hidden");
        $(this).find("img.not-selected").addClass("hidden");
      } else {
        if (!$(this).hasClass("allSelected")) {
          $(this).removeClass("selected");
          $(this).find("img.selected").addClass("hidden");
          $(this).find("img.not-selected").removeClass("hidden");
        }
      }
    }
    if ($(this).hasClass("behavior-all")) {
      //$(this).toggleClass("selected");
      $optionsParent.find(".thebtn.behavior-none").addClass("allSelected");
      $optionsParent.find(".thebtn").each(function (i, obj) {
        $(obj).addClass("selected");
        $(obj).find("img.selected").removeClass("hidden");
        $(obj).find("img.not-selected").addClass("hidden");
      });
      $optionsParent.find(".thebtn.behavior-none").removeClass("selected");
      $optionsParent
        .find(".thebtn.behavior-none img.selected")
        .addClass("hidden");
      $optionsParent
        .find(".thebtn.behavior-none img.not-selected")
        .removeClass("hidden");
    }


    
    

    
    if ($(this).closest(".options").find(".thebtn.selected").length == 0) {
      $(".next-btn-quiz").addClass("disabled");
    } else {
      $(".next-btn-quiz").removeClass("disabled");
    }
  calculatePoints()
  });



  function calculatePoints() {
    var pointsSum = 0;
    var selectedCount = 0;


    $(".thebtn").each(function (i, obj) {
      if ($(obj).hasClass("selected")) {
        selectedCount+=1;
        var points = parseInt($(obj).attr("points"));
         
        pointsSum += points;
      }
    });

    //var perc = ((cnt * 100) / 136 ).toFixed(0);
    // var perc = ((pointsSum * 100) / 113 ).toFixed(0);

    var perc = (((pointsSum / 5) / selectedCount) * 100).toFixed(0) ;

    //console.log({perc , selectedCount})

if(DEBUGG){
  $("#toast-name-2").css('display','block')
  $("#toast-name-2").html(`<span>Points sum: <strong>${pointsSum}</strong>, Percentage: ${perc}`)
}

return perc;

}
    

  
});
