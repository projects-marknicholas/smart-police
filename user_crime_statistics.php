<?php
include 'includes/header.php';
include 'includes/user_sidebar.php';
include 'includes/db_connection.php';

// Total Incident Reports
$sqlTotalIncidentReports = "SELECT COUNT(*) AS total_incident_reports FROM incident_reports";
$resultTotalIncidentReports = $conn->query($sqlTotalIncidentReports);
$totalIncidentReports = $resultTotalIncidentReports->fetch_assoc()['total_incident_reports'];

// Total Incident Predictions
$sqlTotalIncidentPredictions = "SELECT COUNT(*) AS total_incident_predictions FROM incident_predictions";
$resultTotalIncidentPredictions = $conn->query($sqlTotalIncidentPredictions);
$totalIncidentPredictions = $resultTotalIncidentPredictions->fetch_assoc()['total_incident_predictions'];

// Incident Predictions by Barangay
$sqlPredictionsByBarangay = "SELECT barangay, COUNT(*) AS total_predictions FROM incident_predictions GROUP BY barangay";
$resultPredictionsByBarangay = $conn->query($sqlPredictionsByBarangay);
$predictionsByBarangay = [];
while ($row = $resultPredictionsByBarangay->fetch_assoc()) {
    $predictionsByBarangay[] = $row;
}

// Incidents Over Time
$sqlIncidentsOverTime = "SELECT DATE(dateCommitted) AS incident_date, COUNT(*) AS total_cases FROM incident_reports GROUP BY DATE(dateCommitted)";
$resultIncidentsOverTime = $conn->query($sqlIncidentsOverTime);
$incidentsOverTime = [];
while ($row = $resultIncidentsOverTime->fetch_assoc()) {
    $incidentsOverTime[] = $row;
}

// Crime Incidents Based on Offense Type (Bar Chart)
$sqlCrimeIncidentsByOffenseType = "SELECT offenseType, COUNT(*) AS total_cases FROM incident_reports GROUP BY offenseType";
$resultCrimeIncidentsByOffenseType = $conn->query($sqlCrimeIncidentsByOffenseType);
$crimeIncidentsByOffenseType = [];
while ($row = $resultCrimeIncidentsByOffenseType->fetch_assoc()) {
    $crimeIncidentsByOffenseType[] = $row;
}

// Crime Incidents Based on Offense (New Bar Chart)
$sqlCrimeIncidentsByOffense = "SELECT offense, COUNT(*) AS total_cases FROM incident_reports GROUP BY offense";
$resultCrimeIncidentsByOffense = $conn->query($sqlCrimeIncidentsByOffense);
$crimeIncidentsByOffense = [];
while ($row = $resultCrimeIncidentsByOffense->fetch_assoc()) {
    $crimeIncidentsByOffense[] = $row;
}

// Crime Incidents by Offense in Each Barangay (New Bar Chart)
$sqlCrimeIncidentsByOffenseAndBarangay = "SELECT barangay, offense, COUNT(*) AS total_cases 
                                          FROM incident_reports 
                                          GROUP BY barangay, offense";
$resultCrimeIncidentsByOffenseAndBarangay = $conn->query($sqlCrimeIncidentsByOffenseAndBarangay);
$crimeIncidentsByOffenseAndBarangay = [];
while ($row = $resultCrimeIncidentsByOffenseAndBarangay->fetch_assoc()) {
    $crimeIncidentsByOffenseAndBarangay[] = $row;
}

// Close the database connection
$conn->close();
?>

<div class="content">
    <h2>Crime Statistics & Predictions</h2>
    <div class="statistics-overview">
        <p>Total Incident Reports: <strong><?php echo $totalIncidentReports; ?></strong></p>
        <p>Total Incident Predictions: <strong><?php echo $totalIncidentPredictions; ?></strong></p>
    </div>
    <div class="crime-charts">
        <!-- Bar Chart for Predictions by Barangay -->
        <canvas id="predictionsByBarangayChart"></canvas>
        <!-- Line Chart for Incidents Over Time -->
        <canvas id="incidentsOverTimeChart"></canvas>
        <!-- Bar Chart for Crime Incidents Based on Offense Type -->
        <canvas id="crimeIncidentsByOffenseTypeChart"></canvas>
        <!-- Bar Chart for Crime Incidents Based on Offense -->
        <canvas id="crimeIncidentsByOffenseChart"></canvas>
        <!-- Bar Chart for Crime Incidents by Offense in Each Barangay -->
        <canvas id="crimeIncidentsByOffenseAndBarangayChart"></canvas>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data for Incident Predictions by Barangay (Bar Chart)
    const predictionsByBarangayLabels = <?php echo json_encode(array_column($predictionsByBarangay, 'barangay')); ?>;
    const predictionsByBarangayData = <?php echo json_encode(array_column($predictionsByBarangay, 'total_predictions')); ?>;

    const predictionsByBarangayChart = new Chart(document.getElementById('predictionsByBarangayChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: predictionsByBarangayLabels,
            datasets: [{
                label: 'Incident Predictions by Barangay',
                data: predictionsByBarangayData,
                backgroundColor: '#36A2EB',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Incident Predictions by Barangay'
                }
            }
        }
    });

    // Data for Incidents Over Time (Line Chart)
    const incidentsOverTimeLabels = <?php echo json_encode(array_column($incidentsOverTime, 'incident_date')); ?>;
    const incidentsOverTimeData = <?php echo json_encode(array_column($incidentsOverTime, 'total_cases')); ?>;

    const incidentsOverTimeChart = new Chart(document.getElementById('incidentsOverTimeChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: incidentsOverTimeLabels,
            datasets: [{
                label: 'Incidents Over Time',
                data: incidentsOverTimeData,
                borderColor: '#FF6384',
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Incidents Over Time'
                }
            },
            scales: {
                x: { title: { display: true, text: 'Date' } },
                y: { title: { display: true, text: 'Total Incidents' } },
            }
        }
    });

    // Data for Crime Incidents Based on Offense Type (Bar Chart)
    const crimeIncidentsByOffenseTypeLabels = <?php echo json_encode(array_column($crimeIncidentsByOffenseType, 'offenseType')); ?>;
    const crimeIncidentsByOffenseTypeData = <?php echo json_encode(array_column($crimeIncidentsByOffenseType, 'total_cases')); ?>;

    const crimeIncidentsByOffenseTypeChart = new Chart(document.getElementById('crimeIncidentsByOffenseTypeChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: crimeIncidentsByOffenseTypeLabels,
            datasets: [{
                label: 'Crime Incidents by Offense Type',
                data: crimeIncidentsByOffenseTypeData,
                backgroundColor: '#4BC0C0',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Crime Incidents by Offense Type'
                }
            },
            scales: {
                x: { title: { display: true, text: 'Offense Type' } },
                y: { title: { display: true, text: 'Total Cases' } },
            }
        }
    });

    // Data for Crime Incidents Based on Offense (New Bar Chart)
    const crimeIncidentsByOffenseLabels = <?php echo json_encode(array_column($crimeIncidentsByOffense, 'offense')); ?>;
    const crimeIncidentsByOffenseData = <?php echo json_encode(array_column($crimeIncidentsByOffense, 'total_cases')); ?>;

    const crimeIncidentsByOffenseChart = new Chart(document.getElementById('crimeIncidentsByOffenseChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: crimeIncidentsByOffenseLabels,
            datasets: [{
                label: 'Crime Incidents by Offense',
                data: crimeIncidentsByOffenseData,
                backgroundColor: '#FF5733',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Crime Incidents by Offense'
                }
            },
            scales: {
                x: { title: { display: true, text: 'Offense' } },
                y: { title: { display: true, text: 'Total Cases' } },
            }
        }
    });

    // Data for Crime Incidents by Offense in Each Barangay (Bar Chart)
    const crimeIncidentsByOffenseAndBarangayLabels = <?php echo json_encode(array_column($crimeIncidentsByOffenseAndBarangay, 'barangay')); ?>;
    const crimeIncidentsByOffenseAndBarangayData = <?php echo json_encode(array_column($crimeIncidentsByOffenseAndBarangay, 'total_cases')); ?>;
    const crimeIncidentsByOffenseAndBarangayOffenses = <?php echo json_encode(array_column($crimeIncidentsByOffenseAndBarangay, 'offense')); ?>;

    const crimeIncidentsByOffenseAndBarangayChart = new Chart(document.getElementById('crimeIncidentsByOffenseAndBarangayChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: crimeIncidentsByOffenseAndBarangayLabels,
            datasets: [{
                label: 'Crime Incidents by Offense in Each Barangay',
                data: crimeIncidentsByOffenseAndBarangayData,
                backgroundColor: '#FFC300',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Crime Incidents by Offense in Each Barangay'
                }
            },
            scales: {
                x: { title: { display: true, text: 'Barangay' } },
                y: { title: { display: true, text: 'Total Cases' } },
            }
        }
    });
</script>
