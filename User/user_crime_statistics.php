    <?php
    include 'includes/header.php';
    include 'includes/sidebar.php';
    include 'includes/db_connection.php';
   

    // Total Police Reports
    $sqlTotalPoliceReports = "SELECT COUNT(*) AS total_police_reports FROM police_reports";
    $resultTotalPoliceReports = $conn->query($sqlTotalPoliceReports);
    $totalPoliceReports = $resultTotalPoliceReports->fetch_assoc()['total_police_reports'];

    // Total Incident Reports
    $sqlTotalIncidentReports = "SELECT COUNT(*) AS total_incident_reports FROM incident_reports";
    $resultTotalIncidentReports = $conn->query($sqlTotalIncidentReports);
    $totalIncidentReports = $resultTotalIncidentReports->fetch_assoc()['total_incident_reports'];

    // Total Crime Statistics by Year (using incident_reports)
    $sqlCrimeByYear = "SELECT YEAR(incident_date) AS year, COUNT(*) AS total_crimes 
                    FROM incident_reports GROUP BY YEAR(incident_date)";
    $resultCrimeByYear = $conn->query($sqlCrimeByYear);
    $crimeByYearData = [];
    while ($row = $resultCrimeByYear->fetch_assoc()) {
        $crimeByYearData[] = $row;
    }

    // Crime Statistics by Location
    $sqlCrimeByLocation = "SELECT location, COUNT(*) AS total_incidents 
                        FROM incident_reports GROUP BY location";
    $resultCrimeByLocation = $conn->query($sqlCrimeByLocation);
    $crimeByLocationData = [];
    while ($row = $resultCrimeByLocation->fetch_assoc()) {
        $crimeByLocationData[] = $row;
    }

    // Crime Statistics by Incident Type
    $sqlCrimeByType = "SELECT incident_type AS crime_type, COUNT(*) AS total_cases 
                    FROM incident_reports GROUP BY incident_type";
    $resultCrimeByType = $conn->query($sqlCrimeByType);
    $crimeByTypeData = [];
    while ($row = $resultCrimeByType->fetch_assoc()) {
        $crimeByTypeData[] = $row;
    }
    ?>

    <div class="content">
        <h2>Crime Statistics</h2>



        <div class="crime-charts">
            
            <!-- Pie Chart for Total Crimes by Year -->
            <canvas id="crimeByYearChart"></canvas>

            <!-- Pie Chart for Crimes by Location -->
            <canvas id="crimeByLocationPieChart"></canvas>

            <!-- Pie Chart for Crimes by Type -->
            <canvas id="crimeByTypeBarChart"></canvas>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js Datalabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        // Data for Total Crimes by Year (Pie Chart)
        const crimeByYearLabels = <?php echo json_encode(array_column($crimeByYearData, 'year')); ?>;
        const crimeByYearData = <?php echo json_encode(array_column($crimeByYearData, 'total_crimes')); ?>;

        const crimeByYearChart = new Chart(document.getElementById('crimeByYearChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: crimeByYearLabels,
                datasets: [{
                    label: 'Total Crimes by Year',
                    data: crimeByYearData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
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
                        text: 'Total Crimes in Los Baños by Years'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((acc, curr) => acc + curr, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return percentage + '%'; // Show percentage
                        },
                        color: '#fff',
                    }
                }
            }
        });

        // Data for Crime Statistics by Location (Pie Chart)
        const crimeByLocationLabels = <?php echo json_encode(array_column($crimeByLocationData, 'location')); ?>;
        const crimeByLocationData = <?php echo json_encode(array_column($crimeByLocationData, 'total_incidents')); ?>;

        const crimeByLocationPieChart = new Chart(document.getElementById('crimeByLocationPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: crimeByLocationLabels,
                datasets: [{
                    label: 'Total Incidents by Location',
                    data: crimeByLocationData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
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
                        text: 'Total Reports in Los Baños by Location'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((acc, curr) => acc + curr, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return percentage + '%'; // Show percentage
                        },
                        color: '#fff',
                    }
                }
            }
        });

        // Data for Crime Statistics by Type (Pie Chart)
        const crimeByTypeLabels = <?php echo json_encode(array_column($crimeByTypeData, 'crime_type')); ?>;
        const crimeByTypeData = <?php echo json_encode(array_column($crimeByTypeData, 'total_cases')); ?>;

        const crimeByTypeBarChart = new Chart(document.getElementById('crimeByTypeBarChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: crimeByTypeLabels,
                datasets: [{
                    label: 'Total Cases by Type',
                    data: crimeByTypeData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
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
                        text: 'Total Cases in Los Baños by Type of Incident'
                    },
                    datalabels: {
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((acc, curr) => acc + curr, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return percentage + '%'; // Show percentage
                        },
                        color: '#fff',
                    }
                }
            }
        });
    </script>

    <style>
        .content {
            margin-left: 10px;
            padding: 20px;
        }

        h2 {
            color: #8B0000;
        }

        .statistics-overview {
            margin-bottom: 30px;
        }

        .crime-charts canvas {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
    </style>

    <?php
    $conn->close();
    ?>
