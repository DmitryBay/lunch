/*

Автозаполнение
 */

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        // {types: ['geocode']});
        {types: ['(cities)']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}


// [START region_fillform]
function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();


    console.log(place);

    //console.log(place.geometry.viewport.getSouthWest().toJSON().lng);
    if (componentForm['minlng']) {
        $(componentForm['minlng']).val(place.geometry.viewport.getSouthWest().toJSON().lng);
    }
    if (componentForm['maxlng']) {
        $(componentForm['maxlng']).val(place.geometry.viewport.getNorthEast().toJSON().lng);
    }
     if (componentForm['minlat']) {
        $(componentForm['minlat']).val(place.geometry.viewport.getSouthWest().toJSON().lat);
    }
    if (componentForm['maxlat']) {
        $(componentForm['maxlat']).val(place.geometry.viewport.getNorthEast().toJSON().lat);
    }




    if (componentForm['lat']) {
        $(componentForm['lat']).val(place.geometry.location.lat);
    }

    if (componentForm['place_id']) {
        $(componentForm['place_id']).val(place.place_id);
    }

    if (componentForm['lng']) {
        $(componentForm['lng']).val(place.geometry.location.lng);
    }

    if (componentForm['city_title']) {
        var city_text = '';

        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];

            //administrative_area_level_2
            //administrative_area_level_1
            if ((addressType == 'country') || (addressType == 'administrative_area_level_1') || (addressType == 'administrative_area_level_2')) {
                city_text = city_text + ' ' + place.address_components[i].long_name;
            }

            //alert(city_text);

            // alert(addressType);

            /* if (componentForm[addressType]) {
             var val = place.address_components[i][componentForm[addressType]];
             document.getElementById(addressType).value = val;
             }*/
        }

        $(componentForm['city_title']).val(city_text);
    }

    if (componentForm['city_title2']) {
        var city_text2 = '';

        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];

            //administrative_area_level_2
            //administrative_area_level_1
            if ( (addressType == 'administrative_area_level_2') ) {
                city_text2 = city_text2 + ' ' + place.address_components[i].long_name;
            }

            //alert(city_text);

            // alert(addressType);

            /* if (componentForm[addressType]) {
             var val = place.address_components[i][componentForm[addressType]];
             document.getElementById(addressType).value = val;
             }*/
        }

        $(componentForm['city_title2']).val(city_text2);
    }

    if (componentForm['place_id']) {
        $(componentForm['place_id']).val(place.place_id);
    }


    if (componentForm['place_location']) {
        $(componentForm['place_location']).val(''+place.geometry.location.lng()  + ',' + place.geometry.location.lat()  +'');
    }


}