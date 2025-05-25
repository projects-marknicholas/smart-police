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

// 1. Total Incident Reports
$sqlTotalIncidentReports = "SELECT COUNT(*) AS total_incident_reports FROM incident_reports";
$resultTotalIncidentReports = executeQuery($conn, $sqlTotalIncidentReports);
$totalIncidentReports = $resultTotalIncidentReports->fetch_assoc()['total_incident_reports'];

// 2. Total Incident Predictions
$sqlTotalIncidentPredictions = "SELECT COUNT(*) AS total_incident_predictions FROM incident_predictions";
$resultTotalIncidentPredictions = executeQuery($conn, $sqlTotalIncidentPredictions);
$totalIncidentPredictions = $resultTotalIncidentPredictions->fetch_assoc()['total_incident_predictions'];

// 3. Incident Predictions by Barangay
$sqlPredictionsByBarangay = "SELECT barangay, COUNT(*) AS total_predictions 
                            FROM incident_predictions 
                            GROUP BY barangay 
                            ORDER BY total_predictions DESC 
                            LIMIT 10";
$resultPredictionsByBarangay = executeQuery($conn, $sqlPredictionsByBarangay);
$predictionsByBarangay = [];
while ($row = $resultPredictionsByBarangay->fetch_assoc()) {
    $predictionsByBarangay[] = $row;
}

// 4. Incidents Over Time (last 30 days)
$sqlIncidentsOverTime = "SELECT DATE(dateCommitted) AS incident_date, COUNT(*) AS total_cases 
                        FROM incident_reports 
                        WHERE dateCommitted >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                        GROUP BY DATE(dateCommitted) 
                        ORDER BY incident_date";
$resultIncidentsOverTime = executeQuery($conn, $sqlIncidentsOverTime);
$incidentsOverTime = [];
while ($row = $resultIncidentsOverTime->fetch_assoc()) {
    $incidentsOverTime[] = $row;
}

// 5. Top Offense Types
$sqlCrimeIncidentsByOffenseType = "SELECT offenseType, COUNT(*) AS total_cases 
                                  FROM incident_reports 
                                  GROUP BY offenseType 
                                  ORDER BY total_cases DESC 
                                  LIMIT 10";
$resultCrimeIncidentsByOffenseType = executeQuery($conn, $sqlCrimeIncidentsByOffenseType);
$crimeIncidentsByOffenseType = [];
while ($row = $resultCrimeIncidentsByOffenseType->fetch_assoc()) {
    $crimeIncidentsByOffenseType[] = $row;
}

// 6. Top Offenses (with improved handling for long names)
$sqlCrimeIncidentsByOffense = "SELECT offense, COUNT(*) AS total_cases 
                              FROM incident_reports 
                              GROUP BY offense 
                              ORDER BY total_cases DESC 
                              LIMIT 10";
$resultCrimeIncidentsByOffense = executeQuery($conn, $sqlCrimeIncidentsByOffense);
$crimeIncidentsByOffense = [];
while ($row = $resultCrimeIncidentsByOffense->fetch_assoc()) {
    $crimeIncidentsByOffense[] = $row;
}

// 7. Crime by Barangay
$sqlCrimeIncidentsByBarangay = "SELECT barangay, COUNT(*) AS total_cases 
                               FROM incident_reports 
                               GROUP BY barangay 
                               ORDER BY total_cases DESC 
                               LIMIT 10";
$resultCrimeIncidentsByBarangay = executeQuery($conn, $sqlCrimeIncidentsByBarangay);
$crimeIncidentsByBarangay = [];
while ($row = $resultCrimeIncidentsByBarangay->fetch_assoc()) {
    $crimeIncidentsByBarangay[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Statistics Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            flex: 1;
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }
        
        .stat-card h3 {
            margin-top: 0;
            color: #555;
            font-size: 1.1rem;
        }
        
        .stat-value {
            font-size: 2.8rem;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 25px;
        }
        
        .chart-container {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .chart-container h3 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 1.3rem;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        canvas {
            width: 100% !important;
            height: 350px !important;
        }
        
        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .content {
                margin-left: 0;
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Crime Statistics & Predictions Dashboard</h1>
        
        <!-- Summary Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Incident Reports</h3>
                <div class="stat-value"><?php echo number_format($totalIncidentReports); ?></div>
                <p>Historical crime data recorded</p>
            </div>
            <div class="stat-card">
                <h3>Total Predictions</h3>
                <div class="stat-value"><?php echo number_format($totalIncidentPredictions); ?></div>
                <p>Potential incidents forecasted</p>
            </div>
        </div>
        
        <!-- Main Charts Section -->
        <div class="charts-grid">
            <!-- Predictions by Barangay -->
            <div class="chart-container">
                <h3>Top 10 Barangays with Highest Predictions</h3>
                <canvas id="predictionsByBarangayChart"></canvas>
            </div>
            
            <!-- Incidents Over Time -->
            <div class="chart-container">
                <h3>Incidents Trend (Last 30 Days)</h3>
                <canvas id="incidentsOverTimeChart"></canvas>
            </div>
            
            <!-- Offense Type Distribution -->
            <div class="chart-container">
                <h3>Top 10 Offense Types</h3>
                <canvas id="crimeIncidentsByOffenseTypeChart"></canvas>
            </div>
            
            <!-- Offense Distribution (Improved for long names) -->
            <div class="chart-container">
                <h3>Top 10 Offenses</h3>
                <canvas id="crimeIncidentsByOffenseChart"></canvas>
            </div>
            
            <!-- Crime by Barangay -->
            <div class="chart-container">
                <h3>Top 10 Barangays with Most Incidents</h3>
                <canvas id="crimeIncidentsByBarangayChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js with plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        // Color palette
        const colors = [
            '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6',
            '#1abc9c', '#d35400', '#34495e', '#16a085', '#c0392b'
        ];
        
        // Register plugins
        Chart.register(ChartDataLabels);
        
        // 1. Predictions by Barangay (Horizontal Bar Chart)
        new Chart(document.getElementById('predictionsByBarangayChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($predictionsByBarangay, 'barangay')); ?>,
                datasets: [{
                    label: 'Number of Predictions',
                    data: <?php echo json_encode(array_column($predictionsByBarangay, 'total_predictions')); ?>,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        color: '#333',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            return value;
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Number of Predictions',
                            font: {
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Barangay',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
        
        // 2. Incidents Over Time (Area Chart)
        new Chart(document.getElementById('incidentsOverTimeChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($incidentsOverTime, 'incident_date')); ?>,
                datasets: [{
                    label: 'Daily Incidents',
                    data: <?php echo json_encode(array_column($incidentsOverTime, 'total_cases')); ?>,
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderColor: colors[0],
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: colors[0],
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Incidents',
                            font: {
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
        
        // 3. Crime Incidents by Offense Type (Doughnut Chart)
        new Chart(document.getElementById('crimeIncidentsByOffenseTypeChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($crimeIncidentsByOffenseType, 'offenseType')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($crimeIncidentsByOffenseType, 'total_cases')); ?>,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 20
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = (value * 100 / sum).toFixed(1) + '%';
                            return percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 12
                        }
                    }
                },
                cutout: '65%'
            }
        });
        
        // 4. Crime Incidents by Offense (Improved Bar Chart for long names)
        new Chart(document.getElementById('crimeIncidentsByOffenseChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($crimeIncidentsByOffense, 'offense')); ?>,
                datasets: [{
                    label: 'Number of Cases',
                    data: <?php echo json_encode(array_column($crimeIncidentsByOffense, 'total_cases')); ?>,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#333',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            return value;
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                // Split long labels at natural break points
                                const label = context[0].label;
                                // Split at " - " or similar natural breaks
                                return label.split(/(?=\s-\s)/);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Offense',
                            font: {
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            callback: function(value) {
                                // Abbreviate long labels on x-axis
                                const label = this.getLabelForValue(value);
                                if (label.length > 25) {
                                    return label.substring(0, 25) + '...';
                                }
                                return label;
                            },
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: false
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Cases',
                            font: {
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 20,
                        bottom: 70 // Extra space for rotated labels
                    }
                }
            }
        });
        
        // 5. Crime Incidents by Barangay (Horizontal Bar Chart)
        new Chart(document.getElementById('crimeIncidentsByBarangayChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($crimeIncidentsByBarangay, 'barangay')); ?>,
                datasets: [{
                    label: 'Number of Cases',
                    data: <?php echo json_encode(array_column($crimeIncidentsByBarangay, 'total_cases')); ?>,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        color: '#333',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            return value;
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Number of Cases',
                            font: {
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Barangay',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>