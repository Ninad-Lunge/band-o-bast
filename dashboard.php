<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include('php/links.php'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('components/titlebar.php'); ?>
        </div>
        <div class="row">
            <?php include('components/sidebar.php'); ?>
            <div class="col my-1 ps-0 me-2 border border-dark">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <!-- Include Firebase scripts -->
    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-database-compat.js"></script>

    <!-- Load other scripts -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script src="https://unpkg.com/leaflet-draw" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>
    <script src="https://unpkg.com/leaflet-pip/leaflet-pip.js" defer></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js" defer></script>
    <script src="js/app.js" defer></script>

    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyCDKaEz_uAye0bpcefq-lYp8VSOyfNAdSA",
            authDomain: "band-o-bast-7c5f1.firebaseapp.com",
            databaseURL: "https://band-o-bast-7c5f1-default-rtdb.firebaseio.com",
            projectId: "band-o-bast-7c5f1",
            storageBucket: "band-o-bast-7c5f1.appspot.com",
            messagingSenderId: "1066451383075",
            appId: "1:1066451383075:web:9b4b0f1e1baf6976621296",
            measurementId: "G-5NCH6X0MX6"
        };

        firebase.initializeApp(firebaseConfig);

        const database = firebase.database();

        const dataPath = "/gpsData/";
        var map;

        // const deviceId = [1, 2, 3, 4];
        // deviceId.forEach(Id){
        //     dataPath = 
        // }

        function initializeMap(latitude, longitude) {
            if (!map) {
                map = L.map('map').setView([latitude, longitude], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    // attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                var marker = L.marker([latitude, longitude]).addTo(map);

                marker.bindPopup("<b>Location</b>").openPopup();
            } else {
                map.setView([latitude, longitude], 13);

                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        layer.remove();
                    }
                });

                var marker = L.marker([latitude, longitude]).addTo(map);

                marker.bindPopup("<b>Location</b>").openPopup();
            }
        }

        function checkPoint(latitude, longitude) {
            if (!isNaN(latitude) && !isNaN(longitude)) {
                var point = { lat: latitude, lng: longitude };
                var result = isPointInsideGeofence(point);

                if (!result) {
                    // Point is outside the geofence, display toast
                    var toastTitle = 'Warning';
                    var toastMessage = 'Point is outside the geofence.';
                    var toastClass = 'bg-warning';
                    showToast(toastTitle, toastMessage, toastClass);
                } else {
                    // Point is inside the geofence, log to console
                    console.log('Point is inside the geofence.');
                }
            } else {
                showToast('Error', 'Invalid coordinates. Please enter numeric values.', 'bg-danger');
            }
        }

        database.ref(dataPath).on("value", function (snapshot) {
            const jsonData = snapshot.val();

            let latitude;
            let longitude;

            const gpsDataKeys = Object.keys(jsonData.gpsData);

            if (gpsDataKeys.length > 0) {
                const firstKey = gpsDataKeys[0];
                const coordinatesString = jsonData.gpsData[firstKey];

                const regex = /latitude:(.*),longitude:(.*)/;
                const match = coordinatesString.match(regex);

                if (match && match.length === 3) {
                    latitude = parseFloat(match[1].trim());
                    longitude = parseFloat(match[2].trim());
                }

                initializeMap(latitude, longitude);
                checkPoint(latitude, longitude);
            } else {
                console.log('No gpsData available.');
            }
        });

        setInterval(function () {
            // Additional tasks if needed
        }, 5000);
    </script>
</body>
</html>