(function( $ ){
    $.fn.upload = function( options ) {
        var settings = $.extend( {
            'action' : 'images-upload',
            'module' : 'catalog',
            'id'     : '0',
            'append' : '.image-list',
        }, options);

        this.click(function(e){
            $('<input type="file" multiple>').on('change', function () {
                e.stopPropagation();
                e.preventDefault();
                if( typeof this.files == 'undefined' ) return;
                var data = new FormData();
                $.each( this.files, function( key, value ){
                    data.append( key, value );
                });
                data.append( 'action', settings.action);
                data.append( 'module', settings.module);
                data.append( 'id', settings.id);
                $.ajax({
                    type        : 'POST',
                    url         : '?c=images',
                    data        : data,
                    processData : false,
                    contentType : false,
                    success     : function( respond, status, jqXHR ){
                        respond = JSON.parse(respond);
                        if( typeof respond.error !== '' ){
                            $(settings.append).append(respond.html);
                        }
                        else {
                            alert_info('ОШИБКА: ' + respond.error );
                        }
                    },
                    error: function( jqXHR, status, errorThrown ){
                        alert_info( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
                    }

                });
            }).click();
        });

        return this;

    };
})( jQuery );


function RemoveImage(id, obj, module) {
    var data = 'action=remove-image&id=' + id + '&module=' + module;
    $.ajax({
        url         : "?c=images",
        type        : 'POST',
        data        : data,
        success     : function( respond){
            if( respond == true){
                obj.remove();
            } else {
                alert_info('ОШИБКА: ' + respond );
            }
        },
        error: function( jqXHR, status, errorThrown ){
            alert_info( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }
    });
}
function SkinImage(img_id, material_id, module, table, els, then) {
    var data = 'action=set-skin&img_id=' + img_id + '&material_id=' + material_id + '&module=' + module + '&table=' + table;
    $.ajax({
        url         : '?c=images',
        type        : 'POST',
        data        : data,
        success     : function( respond){
            if( respond == true){
                els.show();
                then.hide();
            } else {
                alert_info('ОШИБКА: ' + respond );
            }
        },
        error: function( jqXHR, status, errorThrown ){
            alert_info( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }
    });
}
