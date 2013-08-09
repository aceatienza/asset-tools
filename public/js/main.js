requirejs.config({
    // By default load any module IDs from js/lib
    // 'control' prefix in routes
    // jquery-2.0.3.min.js, IE9 and above
    baseUrl: '/js/lib',
    locale: 'en-us',
    paths: {
        'cms': '/js/cms',
        'asset': '/js/asset',
        'portfolio': '/js/portfolio'
    }
});

// consider namespacing if application grows large
// var AssetToolnamespace = AssetToolnamespace || {};

// Start the main app logic
requirejs(['jquery', 'cms', 'asset', 'portfolio'],function ($, cms, asset, portfolio) {

    var pathArray = window.location.href.split( '/' ),
        protocol = pathArray[0],
        host = pathArray[2],
        baseUrl = protocol + '://' + host,
        currentPath = pathArray[pathArray.length-1];

    //  First child
    $.fn.child = function(s) {
        return $(this).children(s)[0];
    };

    // AssetToolnamespace.cms = new cms();
    // console.log(AssetToolnamespace.cms);

    // TODO: Lazy load settings since it won't be common
    // Load on clicking settings or if url relativePath is 'edit'
    // Can also lazy load based on paths after /control
    /* Start all objects from here */
    var cms2 = new cms();
    cms2.init();

    var asset2 = new asset();
    asset2.init();

    var portfolio2 = portfolio();
    portfolio2.init();

    // add to namespace if you'd like to test in Chrome or other
    // AssetToolnamespace.cms2 = cms2;
    // AssetToolnamespace.asset2 = asset2;

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

});




