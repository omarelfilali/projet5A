
$(document).ready(function () {

    
  
    $(".unOutilExterne>*").mouseover(function(){
      $(this).parent().css("opacity", 0.4);
    });
  
    $(".unOutilExterne>*").mouseout(function(){
      $(this).parent().css("opacity", 0.7)
    });
  
    $(".unOutilExterne").each(function(){
      $(this).css({
          "background": `${$(this).data("color")} no-repeat`, //url(./ressources/images/liens_utiles/${$(this).data("id")}.png)
          "background-size": "90%",
          "background-position": "center",
      });
    });
    
    $(".unOutilExterne>*").click(function(){
      window.open($(this).parent().data("url"), '_blank');
    });
  
  });
  