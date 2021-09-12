$("#accept-coockies").click(function(){
    $.cookie('conf', '1', { expires: 365, path: '/' });
    $("#coockie-box").hide();
});

if ( $.cookie('conf') == null ) {
    $("#coockie-box").show();
}

if ($(window).width() > 400){
    var el = $("#navbar-custom");
    var elt = el.offset().top  + $(".s2").offset().top ;
    var h = el.height();
    var body_top = $("body").css('padding-top');
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200){
            el.addClass('navbar-custom-2');
            $("#top > div").addClass('container');
            $("#top > div > div").addClass('col-sm-12');
            //$('body').css('padding-top', h);
        } else {
            el.removeClass('navbar-custom-2');
            $("#top > div").removeClass('container');
            $("#top > div > div").removeClass('col-sm-12');
            //$('body').css('padding-top', body_top);
        }
    })
}