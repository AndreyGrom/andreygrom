$(document).ready(function(){
    tinymce.init({
        selector:'.textarea-edit',
        language : 'ru',
        plugins: [
            "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern jbimages"
        ],
        extended_valid_elements : 'embed[param|src|type|width|height|flashvars|wmode|allowscriptaccess|allowfullscreen],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],div[*],p[*],span[*],i[*],a[*],object[width|height|classid|codebase|embed|param],param[name|value]',
        media_strict: false,
        menubar : false,
        global_xss_filtering:true,
        relative_urls : false,
        document_base_url : "/",
        /*fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt",*/
        toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect |  forecolor backcolor | bullist numlist | outdent indent blockquote | link unlink anchor image jbimages media code | preview ",
        image_advtab: true ,

        external_filemanager_path:"/system/plugins/justboil/",
        filemanager_title:"Responsive Filemanager" ,
        //external_plugins: { "filemanager" : "/system/plugins/justboil/plugin.min.js"}
    });
});