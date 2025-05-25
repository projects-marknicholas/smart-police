<?php
include 'includes/db_connection.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $officer_name = trim($_POST['officer_name']);
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if (!empty($officer_name) && !empty($latitude) && !empty($longitude)) {
        $sql = "INSERT INTO police_locations (officer_name, latitude, longitude) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdd", $officer_name, $latitude, $longitude);

        if ($stmt->execute()) {
            $message = "Location added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "All fields are required.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Police Location</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #333;
        }

        label, input, button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }

        input, button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h3>Add Police Location</h3>
        <?php if (!empty($message)) : ?>
            <p class="<?php echo strpos($message, 'Error') !== false ? 'error' : 'message'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>
        <form id="locationForm" method="POST" action="">
            <label for="officer_name">Officer Name:</label>
            <input type="text" name="officer_name" id="officer_name" placeholder="Enter officer name" required>
            
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            
            <button type="submit" id="submitBtn" disabled>Add Location</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('locationForm');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const submitBtn = document.getElementById('submitBtn');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                latitudeInput.value = position.coords.latitude;
                longitudeInput.value = position.coords.longitude;
                submitBtn.disabled = false;
            }, error => {
                alert('Failed to retrieve location. Please allow location access.');
            });
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    </script>
</body>
</html>
