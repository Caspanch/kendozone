/**
 * Created by julien on 04/10/16.
 */
$( document ).ready(function() {


    $('#locationpicker-default').locationpicker({
        location: {latitude: latitude, longitude: longitude},
        radius: 300,
        inputBinding: {
            latitudeInput: $('#latitude'),
            longitudeInput: $('#longitude'),
            radiusInput: $('#us2-radius'),
            locationNameInput: $('#address')
        },
        enableAutocomplete: true,
        onchanged: function (currentLocation, radius, isMarkerDropped) {
            var addressComponents = $(this).locationpicker('map').location.addressComponents;
            $("#latitude").val(currentLocation.latitude);
            $("#longitude").val(currentLocation.longitude);
            updateControls(addressComponents);

        }, oninitialized: function (component) {

            $('#address').val(club.address);
            $('#city').val(club.city);
            $('#CP').val(club.CP);
            $('#state').val(club.state);
            $('#latitude').val(club.latitude);
            $('#longitude').val(club.longitude);
        }

    });

    function updateControls(addressComponents) {
        $('#city').val(addressComponents.city);
        $('#CP').val(addressComponents.postalCode);
        $('#state').val(addressComponents.stateOrProvince);

    }
});