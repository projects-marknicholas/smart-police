<?php
include 'includes/db_connection.php';

// SQL to fetch predicted crime data
$sql = "SELECT region, province, municipal, barangay FROM incident_predictions WHERE dateCommitted = CURDATE()";
$result = $conn->query($sql);

// Initialize an empty array to store the locations
$locations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Create a full address string (for use with Nominatim API)
        $address = "{$row['barangay']}, {$row['municipal']}, {$row['province']}, {$row['region']}, Philippines";

        // Use Nominatim API to get coordinates from the address
        $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);
        $geoData = file_get_contents($url);
        $geoData = json_decode($geoData, true);

        if (!empty($geoData)) {
            $latitude = $geoData[0]['lat'];
            $longitude = $geoData[0]['lon'];

            // Add location data to the locations array
            $locations[] = [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'region' => $row['region'],
                'province' => $row['province'],
                'municipal' => $row['municipal'],
                'barangay' => $row['barangay']
            ];
        }
    }
}

// Return the locations as JSON
echo json_encode($locations);
?>
