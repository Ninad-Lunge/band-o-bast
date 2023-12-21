<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeviceDetails</title>
    <?php include('php/links.php'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/style.css">
</head>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('components/titlebar.php'); ?>
        </div>
        <div class="row">
            <?php include('components/sidebar.php'); ?>
            <div class="col my-1 ps-0 me-2 border border-dark">
                <div class="col" style="padding-left: 4%;">
                    <h2 style="text-align: center; margin-top: 2%;"> Device Details</h2>
                    <div id="geofences">
                        <form id="DeviceDetails">
                            <div class="row mt-lg-6">
                            <div class="col-3" style="margin-top: 2%;">
                                    <label class="form-label">Device Id</label>
                                    <input type="text" class="form-control" value="" id="device_id">
                                </div>
                                <br>
                                <br>
                                <div class="col-12" style="margin-top: 2%;">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" value="" id="fname">
                                </div>
                                <div class="col-6" style="margin-top: 2%;">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" value="" id="lname">
                                </div>
                                <div class="col-6" style="margin-top: 2%;">
                                    <label class="form-label">Enrollment Id</label>
                                    <input type="text" class="form-control" value="" id="enrollment_id">
                                </div>
                                <div class="col-6" style="margin-top: 2%;">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" class="form-control" value="" id="mobile">
                                </div>
                                <div class="col-12" style="margin-top: 2%;">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" value="" id="email">
                                </div>
                                <div class="col-3" style="margin-top: 2%;">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" class="form-control" value="00.000000" id="latitude">
                                </div>
                                <div class="col-3" style="margin-top: 2%;">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" class="form-control" value="00.000000" id="longitude">
                                </div>
                                <div></div>
                                <br>
                                <br>
                                <button type="submit" id="submit" value="submit" class="d-grid gap-2 col-6 mx-auto  btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/leaflet-pip/leaflet-pip.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="app.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/7.14.1-0/firebase.js"></script>
<script type="module">

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-analytics.js";
    import { getDatabase, ref, set, get, child } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries
  
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
    apiKey: "AIzaSyCDKaEz_uAye0bpcefq-lYp8VSOyfNAdSA",
    authDomain: "band-o-bast-7c5f1.firebaseapp.com",
    databaseURL: "https://band-o-bast-7c5f1-default-rtdb.firebaseio.com",
    projectId: "band-o-bast-7c5f1",
    storageBucket: "band-o-bast-7c5f1.appspot.com",
    messagingSenderId: "1066451383075",
    appId: "1:1066451383075:web:9b4b0f1e1baf6976621296",
    measurementId: "G-5NCH6X0MX6"
  };
  
   
  firebase.initializeApp(firebaseConfig);  // initializing firebase

///Database reference
var DeviceDetailsDB = firebase.database().ref('DeviceDetails');

document.getElementById('DeviceDetails').addEventListener('submit', submitForms);

function submitForms(e) {
    e.preventDefault();
    var device_id = getElementVal('device_id');
    var fname = getElementVal('fname');
    var lname = getElementVal('lname');
    var enrollment_id = getElementVal('enrollment_id');
    var mobile = getElementVal('mobile');
    var email = getElementVal('email');
    var latitude = getElementVal('latitude');
    var longitude = getElementVal('longitude');

    
    saveDeviceDetails(device_id,fname, lname,  enrollment_id, mobile, email, latitude, longitude);

   
    saveGeofences(device_id, fname, lname, latitude, longitude);
}

const saveDeviceDetails = (device_id,fname, lname,  enrollment_id, mobile, email, latitude, longitude) => {
   // var newDeviceDetails = DeviceDetailsDB.push();
    var newDeviceDetails = firebase.database().ref('DeviceDetails/' + device_id);

    newDeviceDetails.set({
        device_id: device_id,
        fname: fname,
        lname: lname,
        enrollment_id: enrollment_id,
        mobile: mobile,
        email: email,
        latitude: latitude,
        longitude: longitude,
    });
};

const saveGeofences = (device_id, fname, lname, latitude, longitude) => {
    var geofencesRef = firebase.database().ref('geofences/' + device_id);

    geofencesRef.set({
        fname:fname,
        lname:lname,
        latitude: latitude,
        longitude: longitude,
    });
};

const getElementVal = (id) => {
    return document.getElementById(id).value;
};
</script>
</body>

</html>