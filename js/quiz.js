jQuery(document).ready(function ($) {
  $.getJSON("http://time.jsontest.com", function (data) {
    var text = `Date: ${data.date}<br>
                    Time: ${data.time}<br>
                    Unix time: ${data.milliseconds_since_epoch}`;
    $(".mypanel").html(text);
  });
  var selected = [];
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
        redirect = 1;
        $(".res_image_glob.per_below_60").removeClass("hidden");
      }
      if (perc > 60) {
        perc_txt = "Above 60%";
        $(".res_image_glob.per_above-60").removeClass("hidden");
        redirect = 3;
      }
      if (perc >= 30 && perc <= 60) {
        perc_txt = "30-60%";
        $(".res_image_glob.per_30-60").removeClass("hidden");
        redirect = 2;
      }
      $(".perc").html(perc + "%");
      
      window.location.href = templateUrl+'/find-action-for-you?r='+redirect+'&pts='+perc;
      
    }

    
  });
  function toggleImage(clicked) {
    if ($(clicked).find("img.selected").hasClass("hidden")) {
      $(clicked).find("img.selected").removeClass("hidden");
      $(clicked).find("img.not-selected").addClass("hidden");
    } else {
      $(clicked).find("img.selected").addClass("hidden");
      $(clicked).find("img.not-selected").removeClass("hidden");
    }
  }
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
});
