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
                <img class="logo" src="image/pin_1217301.png" alt="Pin Logo" data-name="Pin Logo">
                <img class="logo" src="image/search_5140760.png" alt="Search Logo" data-name="Search Logo">
                <img class="logo" src="image/account_3033143.png" alt="Account Logo" data-name="Account Logo">
                <img class="logo" src="image/report_7965820.png" alt="report Logo" data-name="report Logo">
            </nav>

            <div class="col col-md-3">
                <div id="left-sidebar2" class="col-md-auto" style="padding-left:0px ;padding-top: 4px;padding-right:0px;">
                <div class="panel" style="height: 90%; text-align: center;">
                    panel
                    </div>
                </div>
            </div>

            <div class="col">
               main
            </div>

        </body>

        </html>
