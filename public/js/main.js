requirejs.config({
    // By default load any module IDs from js/lib
    // 'control' prefix in routes
    // jquery-2.0.3.min.js
    baseUrl: '../js/lib',
    locale: 'en-us',
    paths: {
        'cms': '../cms'
    }
});


// // Start the main app logic.
requirejs(['jquery', 'cms'],function ($, cms) {

    // load in case initial global is needed
    $(document).ready(function(){

        var cmsSetting = null;  // lazy-load the settings
        var $settings = $('#settings');

        var cms2 = new cms();
        // console.log(cms2); // Object

        cms2.init();

        // $settings.on('click', function(e){
        //     e.preventDefault();
        //     console.log('settings clicked');
        //     cms.init();
        // });

//         // $('#fileupload').fileupload({
//         //     url: "{{url('upload');}}",
//         //     dataType: 'json',
//         //     done: function (e, data) {
//         //         $('#progress').hide();
//         //         resetCoords();
//         //         $.each(data.result.files, function (index, file) {
//         //             console.log(file);
//         //                             console.log(file.name);

//         //             $('#files').html($('<img/>').attr('src',file));
//         //             $('.preview').attr('src',file);
//         //         });
//         //     },
//         //     fail: function(){
//         //         alert('Error uploading an image');
//         //     },
//         //     always: function(e,data){
//         //         $('#progress').hide();
//         //     },
//         //     start: function(e,data){
//         //         $('#progress').show();
//         //     },
//         //     acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
//         //     maxFileSize: 5000000, 
//         //     maxNumberOfFiles: 1,
//         //     progressall: function (e, data) {
//         //         var progress = parseInt(data.loaded / data.total * 100, 10);
//         //         $('#progress .bar').css(
//         //             'width',
//         //             progress + '%'
//         //         );
//         //     }
//         // });
    });  // self-starting function
});




