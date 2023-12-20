<div class="col-auto col-md-2 col-xl-1 px-sm-1 sticky-top" id="sidebar" style="width: 90px;">
    <div class="d-flex flex-column align-items-middle align-items-middle px-1 position-fixed bg-body-secondary" id="sidebar">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-middle mx-3 my-3" id="menu">
            <li class="nav-item pb-5 pt-4">
                <a href="dashboard.php"><i class="fa-solid fa-house-chimney fs-2" style="color: black;"></i></a>
            </li>
            <li class="nav-item pb-5">
                <i class="fa-solid fa-map-location-dot fs-2" style="color: black;" id="toggleDrawControls" onclick="toggleDrawControls()"></i>
            </li>
            <li class="nav-item pb-5">
                <a href="#"><i class="fa-solid fa-desktop fs-2" style="color: black;"></i></a>
            </li>
            <li class="nav-item pb-5">
                <a href="report.php"><i class="fa-solid fa-chart-pie fs-2" style="color: black;"></i></a>
            </li>
        </ul>
        <hr>
        <div class="dropdown p-3 pt-1">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-circle-user fs-2" style="color: black;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../../php/logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>
</div>