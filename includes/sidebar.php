<!-- Sidebar with logo and links -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="assets/images/logo.png" alt="Logo">
    </div>
    <a href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
    </a>
    <a href="user_list.php">
        <i class="fas fa-users"></i> <span>User List</span>
    </a>
   
    
    <a href="incident_reports.php">
        <i class="fas fa-exclamation-triangle"></i> <span>Incident Reports</span>
    </a>
    <a href="crime_statistics.php">
        <i class="fas fa-chart-bar"></i> <span>Crime Statistics</span>
    </a>
    <a href="prediction.php">
        <i class="fas fa-chart-line"></i> <span>Prediction</span>
    </a>
    <a href="map_page.php">
        <i class="fas fa-map-marked-alt"></i> <span>Map Hotspot</span>
    </a>
    <!-- New Link for Police Deployment -->
    <a href="deployment_policeman_map.php">
        <i class="fas fa-shield-alt"></i> <span>Police Deployment</span>
    </a>

    
     <!-- Close button for mobile views -->
     <button class="close-btn" onclick="toggleSidebar()">&#10005;</button>
</div>

<!-- Toggle Button for Sidebar -->
<button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>

<!-- Include Font Awesome script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<style>
    /* Sidebar styling */
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #333;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        overflow-y: auto;
        transform: translateX(-250px); /* Initially hidden */
        transition: transform 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0px 8px rgba(0, 0, 0, 0.3);
    }

    /* Sidebar link styling */
    .sidebar a {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: white;
        text-decoration: none;
        font-size: 18px;
        transition: background-color 0.3s;
    }

    
    .sidebar a i {
        margin-right: 15px;
        font-size: 20px;
    }

    .sidebar a:hover {
        background-color: #6A5ACD;
    }

    .logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo img {
        width: 70%;
        max-width: 180px;
    }

    /* Toggle button styling */
    .toggle-btn {
        font-size: 30px;
        color: white;
        background-color: transparent;
        border: none;
        cursor: pointer;
        position: fixed;
        top: 10px;
        left: 20px;
        z-index: 1100;
        transition: 0.3s;
    }

    .toggle-btn:hover {
        background-color: rgba(0, 0, 0, 0.3);
        border-radius: 50%;
    }

    /* Close button for mobile views */
    .close-btn {
        font-size: 30px;
        color: white;
        background-color: transparent;
        border: none;
        position: absolute;
        top: 20px;
        right: 20px;
        cursor: pointer;
        display: none; /* Hidden by default */
    }

    /* Active Sidebar (show sidebar) */
    .sidebar.active {
        transform: translateX(0); /* Show sidebar when active */
    }

    /* Mobile responsive styling */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .sidebar a {
            font-size: 16px;
        }

        .toggle-btn {
            font-size: 28px;
        }

        .close-btn {
            font-size: 28px;
            display: block; /* Show the close button on mobile */
        }

        .sidebar .logo img {
            width: 80%;
        }
    }

</style>

<script>
    function toggleSidebar() {
        // Toggle active class to show or hide sidebar
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        
        // Toggle close button visibility based on sidebar state
        var closeButton = document.querySelector('.close-btn');
        if (sidebar.classList.contains('active')) {
            closeButton.style.display = 'block'; // Show close button
        } else {
            closeButton.style.display = 'none'; // Hide close button
        }
    }
</script>
    