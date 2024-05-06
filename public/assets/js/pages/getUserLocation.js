// const x = document.getElementById("demo");

// function getLocation() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(showPosition);
//   } else {
//     x.innerHTML = "Geolocation is not supported by this browser.";
//   }
// }

// function showPosition(position) {
//   x.innerHTML = "Latitude: " + position.coords.latitude +
//   "<br>Longitude: " + position.coords.longitude;
// }

// const x = document.getElementById("location");
// if ("geolocation" in navigator) {
//     navigator.geolocation.getCurrentPosition(
//         (position) => {
//             const lat = position.coords.latitude;
//             const lng = position.coords.longitude;
//             console.log(`Latitude: ${lat}, longitude: ${lng}`);
//         },
//         (error) => {
//             console.error("Error getting user location:", error);\
//             x.innerHTML = "Lokasi anda tidak terdeteksi, harap hidupkan pengaturan lokasi anda!";
//         }
//     );
// } else {
//     console.error("Geolocation is not supported by this browser.");
// }

$(document).ready(function() {
    $( window ).on( "load", function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(locationSuccess);
        } else {
            $("#locationData").html('Browser anda tidak support layanan lokasi!');
        }

        function locationSuccess(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            $("#locationData").html("Latitude: " + latitude + "<br>Longitude: " + longitude);
        }
    });
});