<?php
// Include the database connection
include 'includes/db_connection.php';

// SQL query to fetch location data
$query = "SELECT officer_name, latitude, longitude FROM police_locations";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    $locations = array();
    
    // Fetch all rows as an associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $locations[] = $row;
    }

    // Return the data as JSON
    echo json_encode($locations);
} else {
    // If the query failed, return an empty array
    echo json_encode([]);
}

// Close the database connection
mysqli_close($conn);
?>
