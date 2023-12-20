var map = L.map('map').setView([20.5937, 78.9629], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
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

var geofenceCoordinates = [];

map.on(L.Draw.Event.CREATED, function (event) {
  var layer = event.layer;
  drawnItems.addLayer(layer);
  geofenceCoordinates = layer.getLatLngs()[0].map(point => [point.lat, point.lng]);
});

var coordinatesDisplay = L.DomUtil.create('div', 'coordinates-display');
coordinatesDisplay.style.position = 'absolute';
coordinatesDisplay.style.zIndex = 1000;
map.getContainer().appendChild(coordinatesDisplay);

map.on('mousemove', function (e) {
  var lat = e.latlng.lat.toFixed(6);
  var lng = e.latlng.lng.toFixed(6);
  coordinatesDisplay.innerHTML = `Coordinates: ${lat}, ${lng}`;
});

map.on('mouseout', function () {
  coordinatesDisplay.innerHTML = '';
});

function addCoordinate() {
  var latitude = parseFloat($('#latitude').val());
  var longitude = parseFloat($('#longitude').val());

  if (!isNaN(latitude) && !isNaN(longitude)) {
    geofenceCoordinates.push([latitude, longitude]);
    drawnItems.clearLayers();
    L.polygon(geofenceCoordinates).addTo(drawnItems);
  } else {
    alert('Invalid coordinates. Please enter numeric values.');
  }
}

function clearCoordinates() {
  geofenceCoordinates = [];
  drawnItems.clearLayers();
}

function isPointInsideGeofence(point) {
  var lat = point.lat;
  var lng = point.lng;

  var polygon = geofenceCoordinates.map(coord => [coord[0], coord[1]]);

  var isInside = leafletPip.pointInLayer([lng, lat], L.geoJSON({
    type: 'Polygon',
    coordinates: [polygon],
  }));

  return isInside.length > 0;
}

function checkPoint() {
  var latitude = parseFloat($('#latitude').val());
  var longitude = parseFloat($('#longitude').val());

  if (!isNaN(latitude) && !isNaN(longitude)) {
    var point = { lat: latitude, lng: longitude };
    var result = isPointInsideGeofence(point);

    if (result) {
      $('#result').text('Point is inside the geofence.');
    } else {
      $('#result').text('Point is outside the geofence.');
    }
  } else {
    alert('Invalid coordinates. Please enter numeric values.');
  }
}

$('#coordinatesForm').submit(function (event) {
  event.preventDefault();
  if (geofenceCoordinates.length < 3) {
    alert('Please add at least three coordinates for the geofence.');
    return;
  }
  // Send geofenceCoordinates to the server (back-end) for further processing
  // You can use AJAX to send a request to the server or submit a form, depending on your implementation.
  // Example: $.post('/create_geofence', { coordinates: geofenceCoordinates }, function(response) {...});
});