<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Locations Map - Los Baños, Laguna</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* General styling for content */
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

        /* Make the map responsive and centered */
        #map {
            height: 50vh; /* Responsive height */
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button-container {
            margin-top: 20px; /* Added margin-top to separate the buttons from the map */
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #003662;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media (min-width: 768px) {
            #map {
                height: 60vh; /* Adjust height on larger screens */
            }
        }

        @media (min-width: 1024px) {
            #map {
                height: 70vh; /* Adjust height for even larger screens */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Los Baños, Laguna Police Station Map</h3>
    <!-- Map Container -->
    <div id="map"></div>

    <!-- Buttons to control map actions -->
    <div class="button-container">
        <button class="btn" onclick="tracePoliceStation()">Trace Police Station</button>
        <button class="btn" onclick="resetMap()">Reset Map</button>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Initialize the map view
    var map = L.map('map', {
        zoomControl: false  // Disable the default zoom control
    }).setView([14.1714, 121.2401], 12);  // Centering the map on Los Baños at zoom level 12

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: ''
    }).addTo(map);

    // Add custom zoom controls to the right side
    L.control.zoom({
        position: 'topright'  // This places the zoom controls on the top right
    }).addTo(map);

    // Police station location: Villegas St, 4030 Los Baños, Philippines
    // Police station location: updated coordinates
    var policeStationLocation = [14.18180, 121.22458];  // Updated coordinates

    // Add police station marker
    var policeStation = L.icon({
        iconUrl: 'police_station.png',  // Add the image of the marker
        iconSize: [32, 32],  // Customize the size of the icon
        iconAnchor: [16, 32],  // Set the anchor of the icon
        popupAnchor: [0, -32]  // Adjust the popup position
    });

    // Add police station marker
    var policeMarker = L.marker(policeStationLocation, {icon: policeStation})
        .addTo(map)
        .bindPopup('<strong>Los Baños Police Station</strong><br>Villegas St, 4030 Los Baños, Philippines');

    // Trace Police Station: Focus the map on the updated police station location
    function tracePoliceStation() {
        map.setView(policeStationLocation, 18);  // Zoom in to a higher zoom level (18) for a more detailed view
        policeMarker.openPopup(); // Show the popup for the police station
    }

    // Reset Map: Reset map view to the original position with zoom level 12
    function resetMap() {
        map.setView([14.1714, 121.2401], 12);  // Reset to the original view with zoom level 12
        map.setZoom(12);  // Ensure the zoom level is at 12
    }

    // Fetch locations from fetch_locations.php and add markers
    fetch('fetch_locations.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(location => {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(`<strong>${location.officer_name}</strong><br>${location.barangay_name}`);
            });
        });

    // Adjust map view on resize to center it properly
    window.addEventListener('resize', function() {
        map.invalidateSize();
    });
</script>

</body>
</html>
