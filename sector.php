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
            border-radius: 5px;
            font-size: 14px;
            z-index: 1;
        }

        .col-md-2.sidebar {
            flex: 0 0 3%;
            height: 100vh;
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
            height: 100%;
            width: 100%;
            
            color: #333;
            background-color: #fff;
            
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }
        .sector {
            border: 2px solid #3498db; /* Change the color as needed */
            padding: 10px;
            margin: 10px;
            display: inline-block;
        }

        .panel input,
        .panel select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .panel button {
            width: auto;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .panel button:hover {
            background-color: #555;
        }

        .created-sectors {
            margin-top: 20px;
        }

        .sector-box p {
            margin: 0;
        }

        .sector-box button {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .sector-box button:hover {
            background-color: #555;
        }

        .notification-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        

      

        #map {
            height: 650px;
            /* width: 76%; */
            margin-top: 0px;
            margin-right: 0;
        }

        #coordinatesForm button:hover {
            background-color: #555;
        }

        .panel h3 {
            cursor: pointer;
        }

        #sectorOptions {
            display: none;
        }

        .created-sectors {
            margin-top: 5px;
        }
        .custom-width {
    width: 100%; /* Adjust the percentage as needed */
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

            <div class="col col-md-3">
                <div id="left-sidebar2" class="col-md-auto" style="padding-left:0px ;padding-top: 4px;padding-right:0px;">
                <div class="panel">
    <h5 onclick="toggleSectorOptions()">Create Sector&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <img src="image/plus_1828919.png" alt="+" style="width: 20px; height: auto;">
    </h5>
    <div id="sectorOptions" style="display: none;">
        <label for="sectorName">Sector Name:</label>
        <input type="text" id="sectorName" name="sectorName" placeholder="Enter sector name" required>

        <label for="shape">Shape:</label>
        <select id="shape" name="shape">
            <option value="circle">Circle</option>
            <option value="rectangle">Rectangle</option>
            <option value="polygon">Polygon</option>
        </select>

        <button type="button" onclick="createSector()">Create Sector</button>
    </div>

    <div id="sectorsList">
        <!-- Display created sectors here -->
    </div>

    <div id="officerDetails" style="display: none;">
        <h5 id="officerDetailsHeader">Add Officer Details</h5>
        <label for="officerName">Officer Name:</label>
        <input type="text" id="officerName" name="officerName" placeholder="Enter officer name" required>

        <label for="badgeNumber">Badge Number:</label>
        <input type="text" id="badgeNumber" name="badgeNumber" placeholder="Enter badge number" required>

        <!-- Add other officer details fields as needed -->

        <button type="button" onclick="addOfficer()">Add Officer</button>
    </div>
</div>
                </div>
            </div>


            <div class="col" style="padding-left: 0px;">
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
    <script src="app.js"></script>

    <script>
    var sectors = [];

    function toggleSectorOptions() {
        var sectorOptions = document.getElementById("sectorOptions");
        var officerDetails = document.getElementById("officerDetails");

        sectorOptions.style.display = "block";
        officerDetails.style.display = "none";
    }

    function createSector() {
        var sectorName = document.getElementById("sectorName").value;
        var shape = document.getElementById("shape").value;

        var newSector = {
            name: sectorName,
            shape: shape
        };

        sectors.push(newSector);

        // Hide the input fields for creating a sector
        var sectorOptions = document.getElementById("sectorOptions");
        sectorOptions.style.display = "none";

        // Display the created sector with the "Add Officers" button
        displaySectors();

        // Display the officer details section
        var officerDetails = document.getElementById("officerDetails");
        officerDetails.style.display = "block";
    }

    function displaySectors() {
        var sectorsList = document.getElementById("sectorsList");
        sectorsList.innerHTML = "";

        sectors.forEach(function (sector, index) {
            var sectorElement = document.createElement("div");
            sectorElement.classList.add("sector");
            sectorElement.innerHTML = `<p>${sector.name}</p>
                                       <button type="button" onclick="showOfficerDetails(${index})">Add Officers</button>`;
            sectorsList.appendChild(sectorElement);
        });
    }

    function showOfficerDetails(sectorIndex) {
        var officerDetails = document.getElementById("officerDetails");
        officerDetails.style.display = "block";

        // You can add logic to populate officer details for the selected sector
        // and then display the officer details section for the selected sector
        // ...

        // Optionally, you can reset officer details form fields
        document.getElementById("officerName").value = "";
        document.getElementById("badgeNumber").value = "";
    }

    function addOfficer() {
        document.getElementById("officerName").value = "";
        document.getElementById("badgeNumber").value = "";
    }
</script>
</body>

</html>