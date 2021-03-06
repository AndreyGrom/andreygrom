String.prototype.trimMiddle=function(){
    var r=/\s\s+/g;
    return this.trim().replace(r,' ');
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

function get(param) {
    var params = window
        .location
        .search
        .replace('?','')
        .split('&')
        .reduce(
            function(p,e){
                var a = e.split('=');
                p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            },
            {}
        );

    console.log( params[param]);
}
function getUrlVar(){
    var urlVar = window.location.search; // получаем параметры из урла
    var arrayVar = []; // массив для хранения переменных
    var valueAndKey = []; // массив для временного хранения значения и имени переменной
    var resultArray = []; // массив для хранения переменных
    arrayVar = (urlVar.substr(1)).split('&'); // разбираем урл на параметры
    if(arrayVar[0]=="") return false; // если нет переменных в урле
    for (i = 0; i < arrayVar.length; i ++) { // перебираем все переменные из урла
        valueAndKey = arrayVar[i].split('='); // пишем в массив имя переменной и ее значение
        resultArray[valueAndKey[0]] = valueAndKey[1]; // пишем в итоговый массив имя переменной и ее значение
    }
    return resultArray; // возвращаем результат
}
var url_var = getUrlVar();
var img_loader = $('<img src="/system/design/img/load.gif">');

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $(".confirm").click(function(e){
        if ( !confirm("Вы уверены, что хотите это сделать?")){
            e.preventDefault();
        }
    });

    $(".fancybox").fancybox();

});