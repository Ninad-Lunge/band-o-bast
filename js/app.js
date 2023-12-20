var map = L.map('map').setView([20.5937, 78.9629], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

var drawControl;
var drawingControlsVisible = false;

function initializeDrawControls() {
  drawControl = new L.Control.Draw({
    draw: {
      polygon: true,
      rectangle: true,
      circle: true,
      marker: true,
      polyline: true
    },
    edit: {
      featureGroup: drawnItems,
      remove: true
    }
  });
  map.addControl(drawControl);
  drawingControlsVisible = true;
}

function toggleDrawControls() {
  if (drawingControlsVisible) {
    map.removeControl(drawControl);
    drawingControlsVisible = false;
  } else {
    initializeDrawControls();
  }
}

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

const dataPath = "/";
var map;

// function initializeMap(latitude, longitude) {
//   if (!map) {
//       map = L.map('map').setView([latitude, longitude], 13);

//       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//       }).addTo(map);

//       var marker = L.marker([latitude, longitude]).addTo(map);

//       marker.bindPopup("<b>Location</b>").openPopup();
//   } else {
//       map.setView([latitude, longitude], 13);

//       map.eachLayer(function (layer) {
//           if (layer instanceof L.Marker) {
//               layer.remove();
//           }
//       });

//       var marker = L.marker([latitude, longitude]).addTo(map);

//       marker.bindPopup("<b>Location</b>").openPopup();
//   }
// }

function checkPoint(latitude, longitude) {
  if (!isNaN(latitude) && !isNaN(longitude)) {
      var point = { lat: latitude, lng: longitude };
      var result = isPointInsideGeofence(point);

      if (result) {
          console.log('Point is inside the geofence.');
      } else {
          console.log('Point is outside the geofence.');
      }
  } else {
      console.error('Invalid coordinates. Please enter numeric values.');
  }
}

// let latitude;
// let longitude;

// database.ref(dataPath).on("value", function (snapshot) {
//   const jsonData = snapshot.val();

//   const gpsDataKeys = Object.keys(jsonData.gpsData);

//   if (gpsDataKeys.length > 0) {
//       const firstKey = gpsDataKeys[0];
//       const coordinatesString = jsonData.gpsData[firstKey];

//       const regex = /latitude:(.*),longitude:(.*)/;
//       const match = coordinatesString.match(regex);

//       if (match && match.length === 3) {
//           latitude = parseFloat(match[1].trim());
//           longitude = parseFloat(match[2].trim());
//       }

//       initializeMap(latitude, longitude);
//       checkPoint(latitude, longitude);
//   } else {
//       console.log('No gpsData available.');
//   }
// });

setInterval(function () {
}, 5000);

var geocoder = L.Control.geocoder({
  defaultMarkGeocode: false
}).on('markgeocode', function (e) {
  map.fitBounds(e.geocode.bbox);
}).addTo(map);

var geofenceCoordinates = [];

function showForm() {
  $('#form-container').modal('show');
}

map.on(L.Draw.Event.CREATED, function (event) {
  var layer = event.layer;
  drawnItems.addLayer(layer);
  geofenceCoordinates = layer.getLatLngs()[0].map(point => [point.lat, point.lng]);
  showForm();
});

$('#firebaseForm').submit(function (event) {
  event.preventDefault();

  var formData = {
    name: $('#name').val(),
    date: $('#date').val(),
    durationfrom: $('#durationFrom').val(),
    durationto: $('#durationTo').val(),
    options: Array.from($('#options')[0].selectedOptions).map(option => option.value),
    geofenceCoordinates: geofenceCoordinates
  };

  var formsRef = database.ref('geofences');
  formsRef.push(formData)
    .then(function () {
      console.log("Form Data Saved to Firebase:", formData);
      $('#firebaseForm').trigger('reset');
      $('#form-container').modal('hide');
    })
    .catch(function (error) {
      console.error("Error saving form data:", error);
    });
});

function showToast(title, message, bgClass) {
  var toast = $('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">')
    .addClass(bgClass)
    .appendTo(document.body);

  var toastHeader = $('<div class="toast-header">')
    .appendTo(toast);

  $('<strong class="me-auto">').text(title).appendTo(toastHeader);

  var toastBody = $('<div class="toast-body">').text(message).appendTo(toast);

  var autoHide = 5000;
  var delay = 1000;

  var bsToast = new bootstrap.Toast(toast, {
    animation: true,
    autohide: true,
    delay: autoHide
  });

  bsToast.show();

  setTimeout(function () {
    toast.remove();
  }, autoHide + delay);
}

function addLabelToPolygon(polygon, label) {
  var bounds = polygon.getBounds();
  var center = bounds.getCenter();
  var labelElement = $('<div class="geofence-label">').text(label);

  labelElement.css({
    top: map.latLngToLayerPoint(center).y + 'px',
    left: map.latLngToLayerPoint(center).x + 'px'
  });

  map.getContainer().appendChild(labelElement[0]);
}

function clearCoordinates() {
  geofenceCoordinates = [];
  drawnItems.clearLayers();
}

function isPointInsideGeofence(point) {
  if (!geofenceCoordinates || geofenceCoordinates.length === 0) {
      return false;
  }

  var lat = point.lat;
  var lng = point.lng;
  var polygon = {
      type: 'Polygon',
      coordinates: [geofenceCoordinates.map(coord => [coord[1], coord[0]])]
  };
  var isInside = leafletPip.pointInLayer([lng, lat], L.geoJSON(polygon));
  return isInside.length > 0;
}

$('#coordinatesForm').submit(function (event) {
event.preventDefault();
if (geofenceCoordinates.length < 3) {
    alert('Please add at least three coordinates for the geofence.');
    return;
}
});

function fetchOptionsFromFirebase() {
  var geofencesRef = database.ref('DeviceDetails');

  geofencesRef.once('value')
    .then(function (snapshot) {
      var geofences = snapshot.val();
      var deviceIds = [];

      if (geofences) {
        Object.values(geofences).forEach(function (geofence) {
          if (geofence && geofence.device_id) {
            deviceIds.push(geofence.device_id);
          }
        });
      }

      console.log('Device IDs from Firebase:', deviceIds);

      var selectElement = $('#options');
      selectElement.empty();

      deviceIds.forEach(function (deviceId) {
        var optionElement = $('<option>');
        optionElement.val(deviceId).text(deviceId);
        selectElement.append(optionElement);
      });
    })
    .catch(function (error) {
      console.error("Error fetching device IDs from Firebase:", error);
    });
}

$(document).ready(function () {
  fetchOptionsFromFirebase();

  $('#form-container').on('hidden.bs.modal', function () {
      $('#firebaseForm').trigger('reset');
  });

  $('#form-container-submit').on('click', function () {
      $('#form-container').modal('hide');
  });
});

var devicesLayer = L.layerGroup();
map.addLayer(devicesLayer);

function updateDeviceMarkers(deviceData) {
  devicesLayer.clearLayers();

  if (deviceData) {
    Object.values(deviceData).forEach(function (device) {
      if (device && device.latitude && device.longitude) {
        var deviceMarker = L.marker([device.latitude, device.longitude])
          .bindPopup(`<b>Device ID:</b> ${device.device_id}<br><b>Location:</b> ${device.latitude}, ${device.longitude}`);
        devicesLayer.addLayer(deviceMarker);
      }
    });
  }
}

database.ref('DeviceDetails').on('value', function (snapshot) {
  var deviceData = snapshot.val();
  
  setTimeout(function () {
    updateDeviceMarkers(deviceData);
  }, 0);
});