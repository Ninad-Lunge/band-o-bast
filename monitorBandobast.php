<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formal Dashboard with Geofencing Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- Mapbox GL JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .navbar {
            height: 54px;
        }

        .navbar img {
            width: 20px;
            margin-right: 10px;
            margin-left: 5px;
        }

        .navbar h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            line-height: 20px;
        }

        #left-sidebar2{
            height: 100%;
            width: 100%;
        }
        .sidebar img.logo {
            width: 30px;
            height: auto;
            margin-top: 30px;
            margin-right: 20%;
            align-items: center;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar img.logo:hover::after {
            content: attr(data-name);
            position: absolute;
            top: 100%;
            left: 0%;
            transform: translateX(-50%);
            background-color: #fcf7f7;
            color: #f9f6f6;
            border-radius: 0px;
            font-size: 14px;
            z-index: 1;
        }

        .col-md-2.sidebar {
            flex: 0 0 3%;
            height: 100vh;
            width: 100%;
            background-color: #fffcfc;
            flex-direction: column;
            overflow: hidden;
        }

        .col-md-2.sidebar img.logo:hover {
            transform: scale(1.2);
        }

        .row {
            height: 100vh;
        }

        .sector-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .panel {
          height: 630px;
          width: 100%;
          padding: 20px;
          color: #333;
          background-color: #fff;
          margin-right: 0px;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease-in-out;
          display: flex;
          flex-direction: column;
          overflow: auto;
          font-size: 6px;       
        }
        
        #map {
        height: 650px;
        margin-top: 0px;
        margin-right: 0;
        }
        .coordinates-display {
          font-size: 14px;
          height: 10px;
        }

        #coordinatesForm {
          display: flex;
          flex-direction: column;
          gap: 20px;
          width:80%;
        }

        #coordinatesForm label {
          display: block;
        }

        #coordinatesForm input {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
        }

        #coordinatesForm button {
          width: auto;
          padding: 10px;
          background-color: #333;
          color: #fff;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          transition: background-color 0.3s, color 0.3s;
        }

        #coordinatesForm button:hover {
          background-color: #555; /* Darker gray on hover */
        }
    </style>


</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark navbar-expand-sm">
        <img src="image/WhatsApp_Image_2023-12-07_at_13.39.46_4919e1c9-removebg-preview.png" alt="Website Logo"
            class="navbar-brand">
        <h1 class="navbar-brand">Band-O-Bast System</h1>
    </nav>

    <div class="container-fluid">
        <div class="row">
        
            <nav class="col-md-2   sidebar mr-auto" style="padding-right: 3%;background-color: #e6e5e5;">
            <a href="dashboard.php"><img class="logo" src="image/home_25694.png" alt="Pin Logo" data-name="Pin Logo"></a>
            <a href="sector.php"><img class="logo" src="image/pin_1217301.png" alt="Pin Logo" data-name="Pin Logo"></a>
    <a href="monitorBandobast.php"><img class="logo" src="image/search_5140760.png" alt="Search Logo" data-name="Search Logo"></a>
    <a href="profile.php"><img class="logo" src="image/account_3033143.png" alt="Account Logo" data-name="Account Logo"></a>
    <a href="report.php"><img class="logo" src="image/report_7965820.png" alt="Account Logo" data-name="Account Logo"></a>
            </nav>

            <div class="col col-md-3 h-630px">
                <div id="left-sidebar2" class="col-md-auto sidebar" style="padding-left:0px ;padding-top: 4px;padding-right: 0px;">
                    <div class="panel" style="height: 635px;text-align:center;padding-left: 0px;padding-top: 5px;" id="scrollablePanel">                
                    <div id="sectors-list"></div>
            <div class="accordion" id="accordionExample"></div>

                        </div>        
                    </div>
                </div>
           

            <div class="col">
                <div class="col-md-auto" id="map"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/leaflet-pip/leaflet-pip.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script src="js/app.js"></script>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Mapbox GL JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>

    <script>
        $(document).ready(function () {
            // Load sectors on page load
            loadSectors();

            function loadSectors() {
                // Make an AJAX request to the backend to get the list of sectors
                $.ajax({
                    url: 'Demo-dummydata.php', // Change to your backend file
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        displaySectors(data);
                    },
                    error: function () {
                        console.error('Error fetching sectors');
                    }
                });
            }

            function displaySectors(sectors) {
                var sectorsList = $('#sectors-list');

                // Loop through each sector and create HTML for accordion items
                sectors.forEach(function (sector, index) {
                    var accordionItem = $('<div class="accordion-item">').appendTo(sectorsList);

                    // Accordion header
                    var accordionHeader = $('<h2 class="accordion-header" id="heading' + index + '">').appendTo(accordionItem);
                    var accordionButton = $('<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' + index + '" aria-expanded="false" aria-controls="collapse' + index + '">')
                        .text('Sector: ' + sector.name)
                        .appendTo(accordionHeader);

                    // Accordion body
                    var accordionBody = $('<div id="collapse' + index + '" class="accordion-collapse collapse" aria-labelledby="heading' + index + '" data-bs-parent="#accordionExample">').appendTo(accordionItem);
                    var accordionBodyContent = $('<div class="accordion-body">').appendTo(accordionBody);

                    // Officer List for Accordion Item
                    var officersList = $('<ul>').appendTo(accordionBodyContent);
                    sector.officers.forEach(function (officer) {
                        var officerItem = $('<li>').text('Officer: ' + officer).appendTo(officersList);

                        // Add click event to officer name to open profile page
                        officerItem.click(function () {
                            openProfilePage(officer);
                            accordionBody.collapse('hide'); // Hide the accordion body after opening profile page
                        });
                    });

                    // Display coordinates
                    var coordinatesInfo = $('<p>').text('Coordinates: ' + sector.coordinates.latitude + ', ' + sector.coordinates.longitude).appendTo(accordionBodyContent);
                });
            }

            function openProfilePage(officerName) {
                // Construct the URL for the profile page, you might need to adjust the path
                var profilePageUrl = 'ProfilePage.html?officer=' + encodeURIComponent(officerName);

                // Use window.location.href to navigate to the profile page
                window.location.href = profilePageUrl;
            }
        });
</script>
</body>
</html>