/**
 * Created by adamkisala on 08/05/2016.
 */

function updateWishList( $item_id, $user_id) {
        //var c=$(this),b=c.attr("id"),d=c.attr("value");
        var heart_container = document.getElementById('like_heart');
        var heart = document.getElementById("like_heart_icon");
        var button = document.getElementById('add_wish_btn');
        $.post('../classes/routers/wish_list_router.php', {item_id: $item_id, user_id: $user_id}, function (data) {
            var myData = jQuery.parseJSON(data);
            if (myData.code == "REMOVED") {
                //alert(data);
                button.innerHTML = "Add to my wish list";
                heart_container.removeChild(heart);
                //heart.style.visibility = 'hidden';
                var inner_heart = document.createElement('span');
                inner_heart.setAttribute('class', 'glyphicon glyphicon-heart');
                inner_heart.setAttribute('style', 'color: red; font-size: 15px;');
                $('#add_wish_btn').removeClass('btn-danger').addClass('btn-default');
                button.appendChild(inner_heart);
                return true
            } else {
                //alert(data);
                var newHeart = document.createElement('i');
                newHeart.setAttribute('class', 'glyphicon glyphicon-heart');
                newHeart.setAttribute('id', 'like_heart_icon');
                newHeart.innerHTML = myData.likes;
                heart_container.appendChild(newHeart);
                //heart.style.visibility = 'visible';
                button.innerHTML = "Remove from my wish list";
                $('#add_wish_btn').removeClass('btn-default').addClass('btn-danger');
                return true
            }
            
        })}

