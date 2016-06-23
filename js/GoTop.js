$(document).ready(function(){
    $("#goToTop").hide()
    $(function(){
        $(window).scroll(function(){
            if($(this).scrollTop()>1){
                $("#goToTop").fadeIn();
            } else {
                $("#goToTop").fadeOut();
            }
        });
    });
    $("#goToTop a").click(function(){
        $("html,body").animate({scrollTop:0},800);
        return false;
    });
});/**
 * Created by adamkisala on 30/05/2016.
 */
