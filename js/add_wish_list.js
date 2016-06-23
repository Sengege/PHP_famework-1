/**
 * Created by adamkisala on 07/05/2016.
 */

jQuery(document).ready(function($){
    $('.like_heart').on("click", function(){
        var c=$(this),b=c.attr("id"),d=c.attr("value");
        $.post('../classes/routers/wish_list_router.php', {item_id : b, user_id : d}, function (data) {

            if(data=="REMOVED"){
                //alert(data)
                return true
            } else if(data=="ADDED") {
                //alert(data)
                return false
            } else {
                //alert(data)
            }
            //TODO change glyphicon icon colour somehow
            $(this).child('i').toggleClass('glyphicon glyphicon-heart grey').toggleClass('glyphicon glyphicon-heart blue');
        })
        
    });
});

