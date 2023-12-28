<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>    
    <?php include('php/links.php'); ?>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/style.css">
</head>  

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('components/titlebar.php'); ?>
        </div>
        <div class="row">   
            <div class="col-md-4">                   
                <?php include('components/sidebar.php'); ?>
            </div>
            <div class="col-md-4">                                                                    
                <div class="chart-container" >
                    <canvas id="myPieChart1"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="myPieChart2"></canvas>
                </div>                                                     
            </div>
        </div>     
    </div>

    <!-- Include Firebase scripts and other necessary scripts -->
    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.1/firebase-database-compat.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script src="https://unpkg.com/leaflet-draw" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>
    <script src="https://unpkg.com/leaflet-pip/leaflet-pip.js" defer></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js" defer></script>
    <script src="js/app.js" defer></script>
    <script>
    var data1 = {
        
        datasets: [{
            data: [30, 70],
            backgroundColor: ['', '#36A2EB'],
            hoverBackgroundColor: ['', '#36A2EB']
        }],
        labels: ['Outside zone', 'Inside zone']
    };
    var data2 = {
        datasets: [{
            data: [45, 55],
            backgroundColor: ['', '#FFCE56'],
            hoverBackgroundColor: ['', '#FFCE56']
        }],
        labels: ['Wearing Watch', 'Not Wearing ']
    };

    // Get the context of the canvas element we want to select
    var ctx1 = document.getElementById("myPieChart1").getContext('2d');
    var ctx2 = document.getElementById("myPieChart2").getContext('2d');

    // Create a pie chart
    var myPieChart1 = new Chart(ctx1, {
        type: 'pie',
        data: data1,
    });

    var myPieChart2 = new Chart(ctx2, {
        type: 'pie',
        data: data2,
    });
</script>
</body>

</html>
