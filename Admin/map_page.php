<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenStreetMap with Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* Make the map responsive */
        #map {
            
            height: 50vh; /* Responsive height */
            width: 80%;
            left: 300px;

        }
        @media (min-width: 768px) {
            #map {
                height: 70vh; /* Adjust height on larger screens */
            }
        }
        @media (min-width: 1024px) {
            #map {
                height: 80vh; /* Adjust height for even larger screens */
            }
        }
    </style>
</head>
<body>

<h3><center>Los Baños, Laguna Police Locations Map</center></h3>
<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Initialize the map view
    var map = L.map('map').setView([14.1709, 121.2433], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: ''
    }).addTo(map);

    // Fetch locations from fetch_locations.php and add markers
    fetch('fetch_locations.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(location => {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(location.officer_name);
            });
        });

    // Adjust map view on resize to center it properly
    window.addEventListener('resize', function() {
        map.invalidateSize();
    });
    
    
</script>

</body>
</html>
