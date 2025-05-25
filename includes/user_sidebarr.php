<!-- Sidebar with Logo and Links -->
<div class="sidebar" id="sidebar">
    <!-- Logo Section -->
    <div class="logo-container">
        <img src="assets/images/logo.png" alt="Logo">
    </div>
    <!-- Sidebar Links -->
    <a href="index.php" class="dashboard-link"><i class="fas fa-home"></i> Dashboard</a>
    <a href="all_services.php"><i class="fas fa-th-list"></i> All Services</a>
    <a href="police-reports.php"><i class="fas fa-file-alt"></i> Police Reports</a>
    <a href="User/user_crime_statistics.php"><i class="fas fa-exclamation-circle"></i> Incident Reports</a>
    <a href="User/crime_statistics.php"><i class="fas fa-chart-bar"></i> Crime Statistics</a>
    
</a>

</div>

<!-- Toggle Button for Sidebar -->
<button class="toggle-btn" id="toggle-btn" aria-label="Toggle Sidebar" onclick="toggleSidebar()">&#9776;</button>

<!-- Include Font Awesome for Icons -->
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
        left: -250px; /* Initially hidden off-screen */
        padding-top: 20px;
        overflow-y: auto;
        transition: transform 0.3s ease;
        z-index: 1000;
        box-shadow: 2px 0px 8px rgba(0, 0, 0, 0.3);
    }

    /* Logo styling */
    .logo-container {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo-container img {
        width: 100px;
        height: auto;
        margin-top: 20px;
    }

    /* Sidebar links styling */
    .sidebar a {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: white;
        text-decoration: none;
        font-size: 18px;
        transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a i {
        margin-right: 15px;
        font-size: 20px;
    }

    .sidebar a:hover {
        background-color: #6A5ACD;
        color: white;
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

    /* Active Sidebar (visible state) */
    .sidebar.active {
        transform: translateX(250px); /* Slide in from the left */
    }

    /* Responsive adjustments for mobile devices */
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
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggle-btn');
        
        // Toggle the sidebar's visibility
        sidebar.classList.toggle('active');

        // Update the toggle button's icon
        toggleButton.innerHTML = sidebar.classList.contains('active') 
            ? "&#10005;"  // X icon
            : "&#9776;";  // Hamburger icon
    }
</script>
