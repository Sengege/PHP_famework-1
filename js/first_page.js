$(document).ready(function() {

    //when mouse into main_box,change four inner box's css
    $("#main_box").mouseenter(function() {
    	$("#img").attr("src","../images/1_items.jpg");
        $("#inner01_box").css("opacity", "1");
        $("#inner02_box").css("opacity", "1");
        $("#inner03_box").css("opacity", "1");
        $("#inner04_box").css("opacity", "1");
    });

    //when mouse into inner01_box,change backgroud img and others inner box's css.
    $("#inner01_box").mouseenter(function() {
        $("#img").attr("src","../images/1_items.jpg");
        $("#inner01_box").css("opacity", "1");
        $("#inner02_box").css("opacity", "0.5");
        $("#inner03_box").css("opacity", "0.5");
        $("#inner04_box").css("opacity", "0.5");
    });
    $("#inner01_box").mouseleave(function() {
        $("#inner02_box").mouseenter(function() {
            $("#inner02_box").css("opacity", "1");
            $("#inner01_box").css("opacity", "0.5");
            $("#inner03_box").css("opacity", "0.5");
            $("#inner04_box").css("opacity", "0.5");

        });
    });


    $("#inner02_box").mouseenter(function() {
    	$("#img").attr("src","../images/2_experence.jpg");
        $("#inner02_box").css("opacity", "1");
        $("#inner01_box").css("opacity", "0.5");
        $("#inner03_box").css("opacity", "0.5");
        $("#inner04_box").css("opacity", "0.5");
    });
    $("#inner03_box").mouseenter(function() {
    	$("#img").attr("src","../images/3_skill.jpg");
        $("#inner03_box").css("opacity", "1");
        $("#inner02_box").css("opacity", "0.5");
        $("#inner01_box").css("opacity", "0.5");
        $("#inner04_box").css("opacity", "0.5");
    });
    $("#inner04_box").mouseenter(function() {
    	$("#img").attr("src","../images/4_home.jpg");
        $("#inner04_box").css("opacity", "1");
        $("#inner02_box").css("opacity", "0.5");
        $("#inner03_box").css("opacity", "0.5");
        $("#inner01_box").css("opacity", "0.5");
    });
});