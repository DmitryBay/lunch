

function getRectFromBounds(bounds) {
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    return [ne.lat(), ne.lng(), sw.lat(), sw.lng()];
};

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        $.growl.error({ message: "Geolocation is not supported by this browser." });
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




$("body").on("click", ".rest-results .item a", function (event) {
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
        '/restaurants/info',
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
                $('.place-info').html(respond.html);
                var latlngset = new google.maps.LatLng(respond.lat, respond.lng);
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


// updateResult($('#search-form'));


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

