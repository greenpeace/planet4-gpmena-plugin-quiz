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
        infinite: false
    } );
}
}





  $(".toast-trigger").click(function(e){
    if($(this).hasClass('clicked')) return;
    
    $(this).addClass('clicked').html('Copied');
    var currentURL = window.location.href;
    navigator.clipboard.writeText(window.location.href);

    datatoast = $(this).attr("data-toast");
    if ( $( this ).hasClass( "toast-auto" ) && !$("#" + datatoast).is(":visible") ){ 
      $("#" + datatoast).fadeIn(400).delay(2000).fadeOut(400);
    }
    else if ( !$("#" + datatoast).is(":visible") ){
      $("#" + datatoast).fadeIn(400);
    };
  });
  
  $(".close-toast").click(function(e){
    e.preventDefault();
    $(this).closest('.toast-container').fadeOut(400);
  });


  var step = 0;
  var totalSteps = $(".panelsWrapper").children(".panel").length;
  $(".btn-startquiz").click(function () {
    $(".panel-start-quiz").addClass("hidden");
    $(".navig").removeClass("hidden");
    $(".panelsWrapperOuter").removeClass("hidden");
    $(".panel:eq(0)").removeClass("hidden");
  });
  $(".prev-btn-quiz").click(function () {
    if (step == 0) {
      $(".panel-start-quiz").removeClass("hidden");
      $(".navig").addClass("hidden");
      $(".panelsWrapperOuter").addClass("hidden");
      $(".panel:eq(0)").addClass("hidden");
    } else {
      step -= 1;
      $(".panel").addClass("hidden");
      $(".panel:eq(" + step + ")").removeClass("hidden");
      $(".stepNumber").html(step + 1);
      $(".progressBarInner").css("width", (step + 1) * 10 + "%");
      $(".next-btn-quiz").removeClass("disabled");
    }
  });
  $(".next-btn-quiz").click(function () {
    if ($(this).hasClass("disabled")) return;
    if (step < totalSteps - 1) {
      step += 1;
      $(".panel").addClass("hidden");
      $(".panel:eq(" + step + ")").removeClass("hidden");
      $(".stepNumber").html(step + 1);
      $(".progressBarInner").css("width", (step + 1) * 10 + "%");
      if (
        $(".panel:eq(" + step + ") .options").find(".thebtn.selected").length ==
        0
      ) {
        $(".next-btn-quiz").addClass("disabled");
      } else {
        $(".next-btn-quiz").removeClass("disabled");
      }
    }
    var perc = calculatePoints();
    
    var redirect=0;
    
    if (step == totalSteps - 1) {
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
      
      window.location.href = templateUrl+'/'+my_slug+'?r='+redirect+'&pts='+perc;
      $('.page-header-title').closest('.container').css('display','none');
      
    }

    
  });

  
  $(".thebtn").click(function (e) {
    e.preventDefault();
    $optionsParent = $(this).closest(".options");
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
  });
  function calculatePoints() {
    var cnt = 0;
    $(".thebtn").each(function (i, obj) {
      if ($(obj).hasClass("selected")) {
        var points = parseInt($(obj).attr("points"));
        cnt += points;
      }
    });
    var perc = (cnt * 100) / 127;
    //console.log('perc' , perc.toFixed(0)+"%" , "cnt:" , cnt  )
    return perc.toFixed(0);
  }
    
  if($('.QUIZ-proj-wrapper')){
    setTimeout(function(){
      $('.QUIZ-proj-wrapper').css('display','block');
      new SlickCarousel();
    },100)
  }

  
});
