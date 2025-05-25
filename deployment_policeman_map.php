<?php 
    include 'includes/header.php'; 
    include 'includes/sidebar.php'; 
    include 'includes/db_connection.php'; 

    // Fetch incident predictions from the database
    $query = "SELECT * FROM incident_predictions WHERE DATE(dateCommitted) = CURDATE()";
    $result = mysqli_query($conn, $query); 

    // Check if data is retrieved
    if(!$result) {
        echo "Error fetching data from database.";
        exit();
    }

    // Prepare array to store predictions
    $predictions = [];
    while($row = mysqli_fetch_assoc($result)) {
        $predictions[] = $row; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Deployment Map - Los Baños, Laguna</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            background-color: black;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #map {
            height: 50vh;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button-group {
            margin-top: 20px;
        }

        .button-group button {
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            background-color: #003662;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Police Deployment Map for Predicted Crime</h3>
    <div id="map"></div>
    <div class="button-group">
        <button onclick="tracePoliceman()">Trace Policeman</button>
        <button onclick="resetMap()">Reset Map</button>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Initialize the map view
    var map = L.map('map', {
        zoomControl: false
    }).setView([14.1709, 121.2433], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: ''
    }).addTo(map);

    // Add custom zoom controls to the right side
    L.control.zoom({
        position: 'topright'
    }).addTo(map);

    // Define custom police officer icon
    var policeOfficerIcon = L.icon({
        iconUrl: 'police_officer.png', // Path to your police officer icon
        iconSize: [32, 32], // Icon size
        iconAnchor: [16, 32], // Anchor point for positioning
        popupAnchor: [0, -32] // Popup offset
    });

    // Array of predictions from the database (replace this with dynamic data from PHP)
    var predictions = <?php echo json_encode($predictions); ?>;

    // Function to get coordinates from an address using Nominatim API
    function getCoordinates(address) {
        return new Promise(function(resolve, reject) {
            var url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&addressdetails=1&limit=1`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var latitude = data[0].lat;
                        var longitude = data[0].lon;
                        resolve({ latitude: latitude, longitude: longitude });
                    } else {
                        reject("Coordinates not found for address: " + address);
                    }
                })
                .catch(error => reject(error));
        });
    }

    // Loop through predictions and add markers to the map
    predictions.forEach(function(prediction) {
        var address = `${prediction.region}, ${prediction.province}, ${prediction.municipal}, ${prediction.barangay}`;

        // Get the coordinates for the location
        getCoordinates(address)
            .then(function(coordinates) {
                // Add a marker with the police officer icon for each prediction
                var marker = L.marker([coordinates.latitude, coordinates.longitude], { icon: policeOfficerIcon })
                    .addTo(map)
                    .bindPopup(`<strong>Predicted Crime Location</strong><br>
                                Region: ${prediction.region}<br>
                                Province: ${prediction.province}<br>
                                Municipal: ${prediction.municipal}<br>
                                Barangay: ${prediction.barangay}<br>
                                Date: ${prediction.dateCommitted}<br>
                                Time: ${prediction.timeCommitted}<br>
                                Stage of Felony: ${prediction.stageoffelony}<br>
                                Offense: ${prediction.offense}<br>
                                Offense Type: ${prediction.offenseType}`)
                    .openPopup();
            })
            .catch(function(error) {
                console.error(error);
            });
    });

    // Initial map view (default center and zoom)
    var defaultView = {
        center: [14.1709, 121.2433],
        zoom: 13
    };

    // Function to trace policeman (zoom to predicted location)
    function tracePoliceman() {
        map.setView([14.192842590745629, 121.23543583172943], 18); // Zoom in to a default location for now
    }

    // Function to reset the map to the default view
    function resetMap() {
        map.setView(defaultView.center, defaultView.zoom); // Reset map to default center and zoom
    }

    // Adjust map view on resize
    window.addEventListener('resize', function() {
        map.invalidateSize();
    });
</script>

</body>
</html>
