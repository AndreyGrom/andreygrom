(function( $ ){
    $.fn.upload_files = function( options ) {
        var settings = $.extend( {
            'action' : 'files-upload',
            'module' : 'catalog',
            'id'     : '0',
            'append' : '.file-list',
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
                    url         : '?c=files',
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


function RemoveFile(id, obj, module) {
    var data = 'action=remove-file&id=' + id + '&module=' + module;
    $.ajax({
        url         : "?c=files",
        type        : 'POST',
        data        : data,
        success     : function( respond){
            console.log(respond);
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


