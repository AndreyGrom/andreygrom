$("#accept-coockies").click(function(){
    $.cookie('conf', '1', { expires: 365, path: '/' });
    $("#coockie-box").hide();
});

if ( $.cookie('conf') == null ) {
    $("#coockie-box").show();
}
window.alert_info = (message) => {
    $('#PromiseAlert .modal-body p').html(message);
    var PromiseAlert = $('#PromiseAlert').modal({
        keyboard: false,
        backdrop: 'static'
    }).modal('show');
    return new Promise(function (resolve, reject) {
        PromiseAlert.on('hidden.bs.modal', resolve);
    });
};
if ($(window).width() > 400){
    var el = $("#navbar-custom"),
    s2 = $(".s2");
    if (s2.length > 0){
        var elt = el.offset().top  + $(s2).offset().top ;
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

}
$("a.fancybox").fancybox();

var img_loader = $('<img class="loader-btn-img" src="/system/design/img/load.gif">');

$("#comments-form").submit(function(e){
    $("#add-comment").prepend(img_loader);
    e.preventDefault();
    var data = $(this).serialize();
    data += "&action=add-comment";
    $.ajax({
        type: "POST",
        data: data,
        success: function(msg){
            img_loader.remove();
            msg = JSON.parse(msg);
            if (msg.status === '1'){
                location.reload();
            } else if (msg.error === false){
                alert_info("Успех: " + msg.status);
            }
            else {
                alert_info("Ошибка: " + msg.error);
            }
        }
    });
    return false;
});
$(".comment-reply").click(function(e){
    e.preventDefault();
    var user_name = $(this).closest('.comment-meta').find(".comment-user-name").text();
    $("#reply-user-comment").text(user_name);
    $("#reply-panel").show();
    $("#comment-parent").val($(this).attr("href"));
    $("#comment").val(user_name+', ');
    var user_parent = $(this).attr("href");
    document.location.href='#comments-form';
});
$("#no-reply").click(function(e){
    e.preventDefault();
    $("#comment-parent").val('0');
    $("#reply-panel").hide();
    $("#comment").val('');
});