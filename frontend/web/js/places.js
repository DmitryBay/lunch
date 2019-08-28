function getRectFromBounds(bounds) {
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    return [ne.lat(), ne.lng(), sw.lat(), sw.lng()];
};

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        $.growl.error({message: "Geolocation is not supported by this browser."});
        // x.innerHTML = "";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;
}

(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);


$("body").on("click", ".search-results    .item a", function (event) {
    event.preventDefault();
    $('.rest-results .item').removeClass('active');

    var obj = this;
    var id = $(obj).closest('.item').attr('data-id');
    $(obj).attr('data-action', '');
    var param = $('meta[name=csrf-param]').attr("content");
    var token = $('meta[name=csrf-token]').attr("content");

    var data = {
        id: id,
        // status: status,
        _csrf: token
    };

    $.post(
        '/restaurants/info',
        data
        ,
        function (respond) {

            $('.rest-info').removeClass('d-none').html(respond.html);
            $(obj).closest('.item').addClass('active');
            var latlngset = new google.maps.LatLng(respond.location.lat, respond.location.lng);
            map.setCenter(latlngset);
            // map.setZoom(12);

            history.pushState('data', '', '?id=' + respond.id);

            //  $(obj).closest('.dropdown-block').find('.dropdown-toggle').html(respond['textStatus']) ;
            // $(obj).closest('.dropdown-menu') .html(respond['textActions']) ;


        }
    ).fail(function (xhr, status, error) {

        showError(xhr, status, error);


    });
    return false;
});

$(document).mouseup(function (e) {
    var container = $(".dropd-menu");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.closest('.dropd').removeClass('open');
        // DF.updateResult($('#search-form'));
    }
});


function loadPlaceInfo(dataId, map) {
    var id = dataId;
    var param = $('meta[name=csrf-param]').attr("content");
    var token = $('meta[name=csrf-token]').attr("content");
    var data = {
        id: id,
        // status: status,
        _csrf: token
    };
    $.post(
        '/restaurants/info',
        data,
        function (respond) {
            $('.rest-info').removeClass('d-none').html(respond.html);
            var latlngset = new google.maps.LatLng(respond.location.lat, respond.location.lng);
            map.setCenter(latlngset);
            // map.setZoom(12);
            //  $(obj).closest('.dropdown-block').find('.dropdown-toggle').html(respond['textStatus']) ;
            // $(obj).closest('.dropdown-menu') .html(respond['textActions']) ;
        }
    ).fail(function (xhr, status, error) {

        showError(xhr, status, error);


    });
}

function setMapOnAll(map) {
    for (var i = 0; i < this.markers.length; i++) {
        this.markers[i].setMap(map);
    }
}


function updateResult(form) {
    // this.setMapOnAll(this.map);
    this.params = $(form).serializeFormJSON();
    var url = '/restaurants/ajax-search';
    $.post(
        url,
        this.params
        ,
        function (respond) {
            addMarkers(respond['items']);
            $('#search-results').html('');
            $('#search-results').html($('#rest-_view').render(respond));
        }
    ).fail(function (xhr, status, error) {

        showError(xhr, status, error);
    });


    //console.log(this.params);
}

$('body').on('change', '#search-form input', function (e) {
    // alert();
    updateResult($('#search-form'));
});

function addMarkers(newMarkers) {

    // var map = this.map ;

    this.setMapOnAll(null);


    $(newMarkers).each(function (index, item) {
        // locs.push([  $(this).attr('data-name') , $(this).attr('data-lat'),$(this).attr('data-lng') , 'a1', $(this).attr('data-age'), $(this).attr('data-icon'),0 ]);

        var latlngset = new google.maps.LatLng(item.lat, item.lng);


        // var ic = { //icon
        //     url: '', // url
        //     scaledSize: new google.maps.Size(30, 30), // scaled size
        //     origin: new google.maps.Point(0, 0), // origin
        //     anchor: new google.maps.Point(0, 0), // anchor
        //     //define the shape
        //     shape: {coords: [17, 17, 18], type: 'circle'},
        //     //set optimized to false otherwise the marker  will be rendered via canvas
        //     //and is not accessible via CSS
        //     optimized: false,
        //     title: 'spot'
        // };

        var marker = new google.maps.Marker({
            map: map,
            title: item.title,
            position: latlngset,
            dataId: item.id,
            // icon: ic,
            optimized: false
        });

        markers.push(marker);

        google.maps.event.addListener(marker, 'click', (function (marker) {
            return function () {
                // infowindow.setContent(content);
                // infowindow.open(map,marker);
                loadPlaceInfo(marker.dataId, map);
                // $('.place-info').html(content);

            };
        })(marker));


    });

    // var markerCluster = new MarkerClusterer(map, markers,
    //     {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});


}

function startRestUploader(widgetId) {

    console.log('--- Start Uploader' + widgetId);

    var $widget = $(widgetId);
    var url = $widget.attr('data-url');
    var $filesBlock = $(widgetId).find('.files_block');

    var uploader = new ss.SimpleUpload({
        button: $widget,
        url: url,
        name: 'uploadfile',
        multipart: true,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        hoverClass: 'hover',
        focusClass: 'focus',
        multipleSelect: true,
        multiple: true,
        customHeaders: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr("content")
        },
        responseType: 'json',
        startXHR: function () {
            $widget.html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
        },
        onSubmit: function () {

        },
        onComplete: function (filename, response) {

            if (!response) {
                $.growl.error({message: 'Unable to upload file [no response]'});
                return;
            }

            if (response.msg) {
                 $.growl({message: escapeTags(response.msg)});
            } else {
                // $.growl.error({message: "An error occurred and the upload failed."});
            }



            $widget.html('<i class="fas fa-image"></i> Добавить фотографию места');
        },
        onError: function (filename, type, status, statusText, response, uploadBtn, size) {
            $widget.html('<i class="fas fa-image"></i> Добавить фотографию места');
            var json = JSON.parse(response);
            $.growl.error({message: 'Error(' + status + '): ' + json.error_text});
        }
    });

    $widget.on("click", ".files_block a.delete", function () {

    });
    $widget.on("click", ".files_block a.delete", function () {
        var size_ul = $(this).closest('ul.files-ui').find('li').length - 1;
        var ul_papa = $(this).closest('.files_block');
        $(this).closest('li').remove();
        if (size_ul == 0) {
            ul_papa.hide();
        }
        return false;
    });
    $widget.on("click", ".files_block a.revert", function (event) {


        var obj = $(this).closest('li');
        var id = $(this).closest('li').attr('data-key');

        $(obj).find('.shadow').addClass('hidden');
        $(obj).find('.loader').removeClass('hidden');

        $.ajax({
            type: "POST", // or GET
            url: "/site/rotate-image",
            data: {id: id, rotate: 'left'},
            success: function (response) {

                $(obj).find('.shadow').removeClass('hidden');
                $(obj).find('.loader').addClass('hidden');
                if (response['success'] == true) {
                    $(obj).attr('data-key', response.file.id);
                    $(obj).attr('class', response.file.rotateClass);

                    $(obj).find('.img_block .img').attr('style', "background: url('" + escapeTags(response.file.preview) + "') center no-repeat; background-size: cover; ");
                    $(obj).find('input').attr('value', response.file.id);
                } else {
                    console.log(response['error_text']);
                }

            },
            error: function () {
                // something's gone wrong.
            }
        });
        //
        //
        // alert('revert');

        event.preventDefault();


    });
    $("body").on("click", ".files_block a.revert_n", function (event) {


        var obj = $(this).closest('li');
        var id = $(this).closest('li').attr('data-key');
        // $(obj).find('.shadow').html('<i class="fa  fa-spinner  fa-pulse"  aria-hidden="true" ></i>');
        $(obj).find('.shadow').addClass('hidden');
        $(obj).find('.loader').removeClass('hidden');


        $.ajax({
            type: "POST", // or GET
            url: "/site/rotate-image",
            data: {id: id, rotate: 'right'},
            success: function (response) {

                if (response.success == true) {

                    $(obj).find('.shadow').removeClass('hidden');
                    $(obj).find('.loader').addClass('hidden');
                    $(obj).attr('data-key', response.file.id);
                    $(obj).attr('class', response.file.rotateClass);
                    // $(obj).find('.shadow').html('<a href="#" class="revert"></a><a href="#" class="delete"></a>');
                    $(obj).find('.img_block .img').attr('style', "background: url('" + escapeTags(response.file.preview) + "') center no-repeat; background-size: cover; ");
                    $(obj).find('input').attr('value', response.file.id);

                } else {
                    console.log(response['error_text']);
                }
                console.log(response);
                //$("#someElement").doSomething();
            },
            error: function () {
                // something's gone wrong.
            }
        });
        //
        //
        // alert('revert');

        event.preventDefault();


    });
    $("body").on("click", ".files_block a.checkbox", function (event) {


        $(this).closest('ul').find('li').removeClass('active');
        $(this).closest('li').addClass('active');
        $('.main_image').val($(this).closest('li').attr('data-key'));


        //
        //
        // alert('revert');

        event.preventDefault();


    });

    $(".files-ui").sortable();
}


var map = new google.maps.Map(document.getElementById('map'), {
    center: {lng: center['lng'], lat: center['lat']},
    // zoom: 4
    zoom: 16
});


var latlngset = new google.maps.LatLng(center.lat, center.lng);


// var ic = { //icon
//     url: center.icon, // url
//     scaledSize: new google.maps.Size(30, 30), // scaled size
//     origin: new google.maps.Point(0, 0), // origin
//     anchor: new google.maps.Point(0, 0), // anchor
//     //define the shape
//     shape: {coords: [17, 17, 18], type: 'circle'},
//     //set optimized to false otherwise the marker  will be rendered via canvas
//     //and is not accessible via CSS
//     optimized: false,
//     title: 'spot'
// };

// var marker = new google.maps.Marker({
//     map: map,
//
//     position: latlngset, icon: ic,
//
//     optimized: false
// });


updateResult($('#search-form'));


$(function () {
    // $('.restaurant-info [data-toggle="popover"]').popover();
    $('.search-results').slimScroll({
        height: '450px',
        // railVisible: true,
        alwaysVisible: true,
        // start: 'bottom'
    });
});

map.addListener('zoom_changed', function () {
    // console.log('zoom: ' + map.getZoom());
    var rect = getRectFromBounds(map.getBounds());

    $('#restaurantsearch-minlat').val(rect[0]);
    $('#restaurantsearch-maxlat').val(rect[2]);

    $('#restaurantsearch-minlng').val(rect[3]);
    $('#restaurantsearch-maxlng').val(rect[1]);
    updateResult($('#search-form'));
    console.log('zoom changed');
});
google.maps.event.addListener(map, 'dragend', function () {
    // var bon = map.getBounds();
    var rect = getRectFromBounds(map.getBounds());

    $('#restaurantsearch-minlat').val(rect[2]);
    $('#restaurantsearch-maxlat').val(rect[0]);
    $('#restaurantsearch-minlng').val(rect[3]);
    $('#restaurantsearch-maxlng').val(rect[1]);
    updateResult($('#search-form'));
    console.log('dragend');
});

// map markers
var markers = [];

// No business on map
var noPoi = [
    {
        featureType: "poi",
        stylers: [
            {visibility: "off"}
        ]
    }
];
map.setOptions({styles: noPoi});


$(".rest-info").on("click", "a.close-rest", function (e) {

    e.preventDefault();

    $(this).closest(".rest-info").addClass("d-none").html("");
    return false;
});
