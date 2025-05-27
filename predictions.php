<?php
include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/db_connection.php';

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Function to safely execute queries
function executeQuery($conn, $sql) {
    $result = $conn->query($sql);
    if (!$result) {
        die("Query error: " . $conn->error);
    }
    return $result;
}

// Query to get all actual and predicted values from prediction table
$sqlPredictionData = "
    SELECT barangay, actual_date, actual_value, predicted_date, predicted_value 
    FROM prediction 
    WHERE barangay IS NOT NULL AND (actual_value IS NOT NULL OR predicted_value IS NOT NULL)
";
$resultPredictionData = executeQuery($conn, $sqlPredictionData);

$predictionDataByBarangay = [];

while ($row = $resultPredictionData->fetch_assoc()) {
    $barangay = $row['barangay'];
    
    if (!isset($predictionDataByBarangay[$barangay])) {
        $predictionDataByBarangay[$barangay] = ['actual' => [], 'predicted' => []];
    }

    // Add actual values
    if ($row['actual_value'] > 0 && $row['actual_date'] != '0000-00-00') {
        $predictionDataByBarangay[$barangay]['actual'][] = [
            'x' => $row['actual_date'],
            'y' => (int)$row['actual_value']
        ];
    }

    // Add predicted values
    if ($row['predicted_value'] > 0 && $row['predicted_date'] != '0000-00-00') {
        $predictionDataByBarangay[$barangay]['predicted'][] = [
            'x' => $row['predicted_date'],
            'y' => round((float)$row['predicted_value'], 2)
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crime Prediction Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .chart-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        canvas {
            width: 100% !important;
            height: 400px !important;
        }
    </style>
</head>
<body>

<?php include 'includes/sidebar.php'; ?>

<div class="content">
    <h1>Crime Prediction Dashboard</h1>

    <?php foreach ($predictionDataByBarangay as $barangay => $data): ?>
        <!-- Graph for each barangay -->
        <div class="chart-container">
            <h3>Crime Trends — <?php echo htmlspecialchars($barangay); ?></h3>
            <canvas id="crimeTrendChart_<?php echo preg_replace('/[^a-zA-Z0-9]/', '_', $barangay); ?>"></canvas>
        </div>
    <?php endforeach; ?>
</div>

<!-- Load Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js "></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns "></script>

<script>
    const predictionData = <?php echo json_encode($predictionDataByBarangay); ?>;

    Object.keys(predictionData).forEach(barangay => {
        const cleanId = barangay.replace(/[^a-zA-Z0-9]/g, '_');
        const ctx = document.getElementById('crimeTrendChart_' + cleanId).getContext('2d');

        const actual = predictionData[barangay].actual || [];
        const predicted = predictionData[barangay].predicted || [];

        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Actual Crimes',
                        data: actual,
                        borderColor: '#2b8cbe',
                        backgroundColor: '#2b8cbe',
                        fill: false,
                        tension: 0.2,
                        pointRadius: 3,
                        borderWidth: 2
                    },
                    {
                        label: 'Predicted Crimes',
                        data: predicted,
                        borderColor: '#e34a33',
                        backgroundColor: '#e34a33',
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.2,
                        pointRadius: 3,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'yyyy-MM-dd',
                            displayFormats: {
                                day: 'MMM d'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Crimes'
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>