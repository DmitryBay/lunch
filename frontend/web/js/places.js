/**
 * Created by dmitry on 26.02.2018.
 */

function getRectFromBounds(bounds) {
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    return [ne.lat(), ne.lng(), sw.lat(), sw.lng()];
};


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


$('body').on('change', '#placesearch-category_id input', function (e) {
    // alert();
    updateResult($('#search-form'));
});
$('body').on('click', '.spots-category.nav-tabs li a', function (e) {
    $(this).closest('.spots-category').find('.nav-link').removeClass('active');
    $(this).addClass('active');
    $('#placesearch-category_id').val($(this).attr('data-id'));
    updateResult($('#search-form'));
    return false;
});


$("body").on("click", ".place-results .item a", function (event) {
    event.preventDefault();
    $('.place-results .item').removeClass('active');

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
        '/place/place-info',
        data
        ,
        function (respond) {
            if (respond['success'] == '1') { //если ошибки нет то продолжаем
                $('.place-info').html(respond.html);
                $(obj).closest('.item').addClass('active');


                var latlngset = new google.maps.LatLng(respond.lat, respond.lng);
                map.setCenter(latlngset);
                // map.setZoom(12);

                history.pushState('data', '', '?id=' + respond.id);

                //  $(obj).closest('.dropdown-block').find('.dropdown-toggle').html(respond['textStatus']) ;
                // $(obj).closest('.dropdown-menu') .html(respond['textActions']) ;


            } else if (respond['success'] == '0') {
                alert(respond['error_text']);

                $(obj).attr('data-action', action);

            }

        }
    ).fail(function (xhr, status, error) {

        showError(xhr, status, error);


    });
    return false;
});

$("body").on("click", ".place-info .user__info a", function (event) {
    event.preventDefault();


    // var obj = $(this);

    //"$('.place-user-info').toggleClass('hidden'); return false;"
    // $('.place-results .item').removeClass('active');

    var $obj = $(this);
    var id = $obj.attr('data-id');
    // $(obj).attr('data-action','');
    var param = $('meta[name=csrf-param]').attr("content");
    var token = $('meta[name=csrf-token]').attr("content");

    var data = {
        id: id,
        // status: status,
        _csrf: token
    };

    $.post(
        '/place/profile-info',
        data
        ,
        function (respond) {

            $('.place-user-info').removeClass('hidden');
            // $('.place-user-info').html(respond.html);

            $('.place-user-info').html($('#profile-_view').render(respond.item));

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
        '/place/place-info',
        data,
        function (respond) {
            if (respond['success'] == '1') { //если ошибки нет то продолжаем
                $('.place-info').html(respond.html);
                var latlngset = new google.maps.LatLng(respond.lat, respond.lng);
                map.setCenter(latlngset);
                // map.setZoom(12);
                //  $(obj).closest('.dropdown-block').find('.dropdown-toggle').html(respond['textStatus']) ;
                // $(obj).closest('.dropdown-menu') .html(respond['textActions']) ;
            } else if (respond['success'] == '0') {
                alert(respond['error_text']);
                $(obj).attr('data-action', action);
            }
        }
    );
}

function setMapOnAll(map) {
    for (var i = 0; i < this.markers.length; i++) {
        this.markers[i].setMap(map);
    }
}


function updateResult(form) {
    // this.setMapOnAll(this.map);
    this.params = $(form).serializeFormJSON();
    var url = '/place/ajax-search';
    $.post(
        url,
        this.params
        ,
        function (respond) {
            addMarkers(respond['items']);
            $('#place-results').html('');
            $('#place-results').html($('#place-_view').render(respond));


        }
    ).fail(function () {
        alert("problem with request");
    });


    //console.log(this.params);
}


function addDefaultPlaces(map, items) {

    $(items).each(function (index, item) {
        // locs.push([  $(this).attr('data-name') , $(this).attr('data-lat'),$(this).attr('data-lng') , 'a1', $(this).attr('data-age'), $(this).attr('data-icon'),0 ]);
        var latlngset = new google.maps.LatLng(item.lat, item.lng);
        var ic = { //icon
            url: item.icon, // url
            scaledSize: new google.maps.Size(30, 30), // scaled size
            origin: new google.maps.Point(0, 0), // origin
            anchor: new google.maps.Point(0, 0), // anchor
            //define the shape
            shape: {coords: [17, 17, 18], type: 'circle'},
            //set optimized to false otherwise the marker  will be rendered via canvas
            //and is not accessible via CSS
            optimized: false,
            title: 'spot'
        };

        var marker = new google.maps.Marker({
            map: map,
            // title: item.title ,
            position: latlngset, icon: ic,
            // sac:1232,
            optimized: false
        });
        // map.setCenter(marker.getPosition());
        var infowindow = new google.maps.InfoWindow();
        var content = '';
        google.maps.event.addListener(marker, 'click', (function (content, marker, infowindow) {
            return function () {
                // infowindow.setContent(content);
                // infowindow.open(map,marker);
                //  console.log(this.sac);
                // alert();
                // $('.place-info').html('12');
                // $('.place-info').html(content);
            };
        })(marker, content, infowindow));
    });


    var myoverlay = new google.maps.OverlayView();
    myoverlay.draw = function () {
        this.getPanes().markerLayer.id = 'markerLayer';
    };
    myoverlay.setMap(map);

}


function addMarkers(newMarkers) {

    // var map = this.map ;

    this.setMapOnAll(null);


    $(newMarkers).each(function (index, item) {
        // locs.push([  $(this).attr('data-name') , $(this).attr('data-lat'),$(this).attr('data-lng') , 'a1', $(this).attr('data-age'), $(this).attr('data-icon'),0 ]);

        var latlngset = new google.maps.LatLng(item.lat, item.lng);

        // console.log(item);
        var ic = { //icon
            url: '', // url
            scaledSize: new google.maps.Size(30, 30), // scaled size
            origin: new google.maps.Point(0, 0), // origin
            anchor: new google.maps.Point(0, 0), // anchor
            //define the shape
            shape: {coords: [17, 17, 18], type: 'circle'},
            //set optimized to false otherwise the marker  will be rendered via canvas
            //and is not accessible via CSS
            optimized: false,
            title: 'spot'
        };

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


// console.log(center);
var map = new google.maps.Map(document.getElementById('map'), {
    center: {lng: center['lng'], lat: center['lat']},
    // zoom: 4
    zoom: 16
});


var latlngset = new google.maps.LatLng(center.lat, center.lng);
var ic = { //icon
    url: center.icon, // url
    scaledSize: new google.maps.Size(30, 30), // scaled size
    origin: new google.maps.Point(0, 0), // origin
    anchor: new google.maps.Point(0, 0), // anchor
    //define the shape
    shape: {coords: [17, 17, 18], type: 'circle'},
    //set optimized to false otherwise the marker  will be rendered via canvas
    //and is not accessible via CSS
    optimized: false,
    title: 'spot'
};

var marker = new google.maps.Marker({
    map: map,
    // title: item.title ,
    position: latlngset, icon: ic,
    // sac:1232,
    optimized: false
});


addDefaultPlaces(map, defaultPlaces);
updateResult($('#search-form'));


$(function () {
    $('.place-info [data-toggle="popover"]').popover();


    $('.place-results').slimScroll({
        height: '500px',
        // railVisible: true,
        alwaysVisible: true,
        // start: 'bottom'
    });
});

map.addListener('zoom_changed', function () {
    // console.log('zoom: ' + map.getZoom());
    var rect = getRectFromBounds(map.getBounds());

    $('#placesearch-minlat').val(rect[0]);
    $('#placesearch-maxlat').val(rect[2]);

    $('#placesearch-minlng').val(rect[3]);
    $('#placesearch-maxlng').val(rect[1]);
    updateResult($('#search-form'));


    console.log('zoom changed');
    // console.log(  map.getBounds());
    // infowindow.setContent('Zoom: ' + map.getZoom());
});


google.maps.event.addListener(map, 'dragend', function () {
    // var bon = map.getBounds();
    var rect = getRectFromBounds(map.getBounds());

    $('#placesearch-minlat').val(rect[2]);
    $('#placesearch-maxlat').val(rect[0]);

    $('#placesearch-minlng').val(rect[3]);
    $('#placesearch-maxlng').val(rect[1]);
    updateResult($('#search-form'));
    console.log('dragend');

});

var markers = [];


$('body').on('click', '.delete-place', function (e) {
    e.preventDefault();

    if (!confirm('Are you sure you want to delete the listing?')) {
        return false;
    }

    // alert( );

    jQuery.post(
        $(this).attr("href"),
        {
            id: $(this).closest('.place-card').attr('data-id')
        }
    )
        .done(function (result) {
            if (result['success'] == true) {

                $('.place-info').html('');
                $('.place-results [data-id="' + result.id + '"]').remove();
                // $(form).html('Feedback sent');
                // console.log('form action');
                // $('.book-step2').removeClass('hidden');
                // $('.book-step2').find('.book-step').attr('href',result.attributes.url);
                // $('.book-step2').find('p').html( result.text);
            } else {
                // $('.book-step2').addClass('hidden');
                alert(result['error_text']);
            }
            //form.parent().replaceWith(result);
        })
        .fail(function () {
            console.log("server error");
        });

    return false;

    // google.maps.event.trigger(map, "resize");
});


