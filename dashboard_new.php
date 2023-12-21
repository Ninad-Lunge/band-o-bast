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
            <div id="sidePanel" class="side-panel col-md-2">
                <h5>Device List</h5>
                <ul id="deviceList"></ul>
                <button id="addMarkersBtn">Add Markers</button>
            </div>
        </div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-database-compat.js"></script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script src="https://unpkg.com/leaflet-draw" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>
    <script src="https://unpkg.com/leaflet-pip/leaflet-pip.js" defer></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js" defer></script>
    <script src="js/app.js" defer></script>

    <div id="form-container" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Cr̥eate Bandobast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="firebaseForm">
                        <div class="form-group">
                            <label for="name">Title of the Bandobast:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="options">Select the Ground Personnel:</label>
                            <select id="options" name="options" multiple class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="durationFrom">Duration From:</label>
                            <input type="time" class="form-control" id="durationFrom" name="durationFrom" required>

                            <label for="durationTo">Duration To:</label>
                            <input type="time" class="form-control" id="durationTo" name="durationTo" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="form-container-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>