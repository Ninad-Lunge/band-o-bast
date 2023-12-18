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

var geocoder = L.Control.geocoder({
  defaultMarkGeocode: false
}).on('markgeocode', function (e) {
  map.fitBounds(e.geocode.bbox);
}).addTo(map);

var geofenceCoordinates = [];

map.on(L.Draw.Event.CREATED, function (event) {
  var layer = event.layer;
  drawnItems.addLayer(layer);
  geofenceCoordinates = layer.getLatLngs()[0].map(point => [point.lat, point.lng]);

  // Add click event listener to the new geofence polygon
  layer.on('click', function () {
    var geofenceName = prompt('Enter a name for the geofence:');
    if (geofenceName) {
      // Store the geofence name in the database
      var geofenceData = {
        name: geofenceName,
        coordinates: geofenceCoordinates
      };

      database.ref('geofences').push(geofenceData, function (error) {
        if (error) {
          showToast('Error', 'Failed to save geofence to the database: ' + error.message, 'bg-danger');
        } else {
          showToast('Success', 'Geofence saved successfully!', 'bg-success');
        }
      });

      // Display the geofence name on the polygon
      addLabelToPolygon(layer, geofenceName);
    }
  });
});

$('#coordinatesForm').submit(function (event) {
  event.preventDefault();

  if (geofenceCoordinates.length < 3) {
    showToast('Error', 'Please add at least three coordinates for the geofence.', 'bg-danger');
    return;
  }

  var geofenceName = $('#geofenceName').val().trim();
  if (geofenceName === '') {
    showToast('Error', 'Please enter a name for the geofence.', 'bg-danger');
    return;
  }

  // Push geofence data to Firebase Realtime Database
  var geofenceData = {
    name: geofenceName,
    coordinates: geofenceCoordinates
  };

  database.ref('geofences').push(geofenceData, function (error) {
    if (error) {
      showToast('Error', 'Failed to save geofence to the database: ' + error.message, 'bg-danger');
    } else {
      showToast('Success', 'Geofence saved successfully!', 'bg-success');
      // Clear form inputs and layers
      $('#geofenceName').val('');
      clearCoordinates();
    }
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

  // Remove the toast from the DOM after it hides
  setTimeout(function () {
    toast.remove();
  }, autoHide + delay);
}

function addLabelToPolygon(polygon, label) {
  var bounds = polygon.getBounds();
  var center = bounds.getCenter();
  var labelElement = $('<div class="geofence-label">').text(label);

  // Position the label near the center of the polygon
  labelElement.css({
    top: map.latLngToLayerPoint(center).y + 'px',
    left: map.latLngToLayerPoint(center).x + 'px'
  });

  // Add the label to the map container
  map.getContainer().appendChild(labelElement[0]);
}

// function addCoordinate() {
//   var latitude = parseFloat($('#latitude').val());
//   var longitude = parseFloat($('#longitude').val());

//   if (!isNaN(latitude) && !isNaN(longitude)) {
//     geofenceCoordinates.push([latitude, longitude]);
//     drawnItems.clearLayers();
//     L.polygon(geofenceCoordinates).addTo(drawnItems);
//   } else {
//     showToast('Error', 'Invalid coordinates. Please enter numeric values.', 'bg-danger');
//   }
// }

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

// function checkPoint() {
//   var latitude = parseFloat($('#latitude').val());
//   var longitude = parseFloat($('#longitude').val());

//   if (!isNaN(latitude) && !isNaN(longitude)) {
//       var point = { lat: latitude, lng: longitude };
//       var result = isPointInsideGeofence(point);

//       if (result) {
//           showToast('Success', 'Point is inside the geofence!', 'bg-success');
//       } else {
//           showToast('Warning', 'Point is outside the geofence.', 'bg-warning');
//       }
//   } else {
//       showToast('Error', 'Invalid coordinates. Please enter numeric values.', 'bg-danger');
//   }
// }

// var map;

// function initializeMap(latitude, longitude) {
//   if (!map) {
//     map = L.map('map').setView([latitude, longitude], 13);

//     // Add a tile layer
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//       attribution: '© OpenStreetMap contributors'
//     }).addTo(map);

//     // Add a marker to the map
//     var marker = L.marker([latitude, longitude]).addTo(map);

//     // Add a popup to the marker
//     marker.bindPopup("<b>Hello World!</b><br>This is a sample marker.").openPopup();
//   } else {
//     // Map is already initialized, so re-adjust the view
//     map.setView([latitude, longitude], 13);

//     // Remove existing marker and add a new one
//     map.eachLayer(function (layer) {
//       if (layer instanceof L.Marker) {
//         layer.remove();
//       }
//     });

//     // Add a new marker to the map
//     var marker = L.marker([latitude, longitude]).addTo(map);

//     // Add a popup to the marker
//     marker.bindPopup("<b>Hello World!</b><br>This is a sample marker.").openPopup();
//   }
// }

// function checkPoint(latitude, longitude) {
//   if (!isNaN(latitude) && !isNaN(longitude)) {
//     var point = { lat: latitude, lng: longitude };
//     var result = isPointInsideGeofence(point);

//     if (result) {
//       console.log('Point is inside the geofence.');
//     } else {
//       console.log('Point is outside the geofence.');
//     }
//   } else {
//     console.error('Invalid coordinates. Please enter numeric values.');
//   }
// }

$('#coordinatesForm').submit(function (event) {
event.preventDefault();
if (geofenceCoordinates.length < 3) {
    alert('Please add at least three coordinates for the geofence.');
    return;
}
});