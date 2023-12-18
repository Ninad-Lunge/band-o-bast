<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firebase CRUD</title>
  <script src="https://www.gstatic.com/firebasejs/9.1.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.1.1/firebase-database.js"></script>
  <?php include('php/links.php'); ?>
</head>
<body>
    <form class="row g-3" id="crudForm">
        <div class="col-md-6">
            <label for="sectorID" class="form-label">Sector ID</label>
            <input type="text" class="form-control" id="sectorID">
        </div>
        <div class="col-md-6">
            <label for="title" class="form-label">Sector Title</label>
            <input type="text" class="form-control" id="title">
        </div>
        <div class="col-12">
            <label for="coordinates" class="form-label">Co-ordinates</label>
            <input type="text" class="form-control" id="coordinates">
        </div>
        <div class="col-12">
            <label for="personel" class="form-label">Add Personnel</label>
            <select id="personnel" class="form-select">
                <option selected>Choose...</option>
                <option>Person 1</option>
                <option>Person 2</option>
                <!-- Add more personnel options as needed -->
            </select>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="createRecord()">Create</button>
            <button type="button" class="btn btn-success" onclick="readRecords()">Read</button>
            <button type="button" class="btn btn-warning" onclick="updateRecord()">Update</button>
            <button type="button" class="btn btn-danger" onclick="deleteRecord()">Delete</button>
        </div>
    </form>

    <script src="js/firebaseConfig.js"></script>
    <script src="js/crud.js"></script> <!-- Add this line to include the CRUD operations script -->
</body>
</html>