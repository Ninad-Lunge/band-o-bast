// Add this script as a new file named crud.js

// Function to create a new record
function createRecord() {
    const sectorID = document.getElementById('sectorID').value;
    const title = document.getElementById('title').value;
    const coordinates = document.getElementById('coordinates').value;
    const personnel = document.getElementById('personnel').value;

    // Push data to the database
    const newRecordRef = firebase.database().ref('records').push();
    newRecordRef.set({
        sectorID: sectorID,
        title: title,
        coordinates: coordinates,
        personnel: personnel
    });
}

// Function to read all records
function readRecords() {
    // Read data from the database
    firebase.database().ref('records').once('value')
        .then(snapshot => {
            const records = snapshot.val();
            console.log(records);
        });
}

// Function to update a record
function updateRecord() {
    const sectorID = document.getElementById('sectorID').value;
    const title = document.getElementById('title').value;
    const coordinates = document.getElementById('coordinates').value;
    const personnel = document.getElementById('personnel').value;

    // Update data in the database
    firebase.database().ref('records/' + sectorID).set({
        sectorID: sectorID,
        title: title,
        coordinates: coordinates,
        personnel: personnel
    });
}

// Function to delete a record
function deleteRecord() {
    const sectorID = document.getElementById('sectorID').value;

    // Delete data from the database
    firebase.database().ref('records/' + sectorID).remove();
}