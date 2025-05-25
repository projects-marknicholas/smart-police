<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>

<div class="content">
  <h2>Incident Reports</h2>

  <!-- Button to trigger the yearly filter modal -->
  <button id="yearlyBtn" class="btn-yearly">Yearly Report</button>

  <!-- Modal for selecting a year -->
  <div id="yearModal" class="modal" style="display: none;">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h3>Select Year</h3>
      <label for="yearSelect">Year:</label>
      <select id="yearSelect">
        <option value="">All Years</option>
        <?php
        // Fetch distinct years from the incident_reports table
        $yearQuery = "SELECT DISTINCT YEAR(dateCommitted) AS year FROM incident_reports ORDER BY year DESC";
        $yearResult = $conn->query($yearQuery);

        while ($yearRow = $yearResult->fetch_assoc()) {
          echo "<option value='{$yearRow['year']}'>{$yearRow['year']}</option>";
        }
        ?>
      </select>
      <button id="applyYearFilter" class="btn-apply">Apply Filter</button>
    </div>
  </div>

  <!-- Table displaying all incident reports -->
  <table>
    <thead>
      <tr>
        <th>Region</th>
        <th>Province</th>
        <th>Municipal</th>
        <th>Barangay</th>
        <th>Date Committed</th>
        <th>Time Committed</th>
        <th>Stage of Felony</th>
        <th>Offense</th>
        <th>Offense Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="incidentTable">
      <?php
      // Retrieve all incident reports to display initially
      $sql = "SELECT * FROM incident_reports";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr data-year='" . date('Y', strtotime($row['dateCommitted'])) . "'>
              <td>{$row['region']}</td>
              <td>{$row['province']}</td>
              <td>{$row['municipal']}</td>
              <td>{$row['barangay']}</td>
              <td>" . date('Y-m-d', strtotime($row['dateCommitted'])) . "</td>
              <td>" . date('g:i A', strtotime($row['timeCommitted'])) . "</td>
              <td>{$row['stageoffelony']}</td>
              <td>{$row['offense']}</td>
              <td>{$row['offenseType']}</td>
              <td>
                <a href='edit_incident_report.php?id={$row['id']}' class='btn-edit'>Edit</a>
              </td>
            </tr>";
        }
      } else {
        echo "<tr><td colspan='10'>No incident reports found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>

<script>
  // Get modal and button elements
  var modal = document.getElementById("yearModal");
  var btn = document.getElementById("yearlyBtn");
  var span = document.getElementById("closeModal");

  // Open the modal when the button is clicked
  btn.onclick = function () {
    modal.style.display = "flex";
  }

  // Close the modal when the 'x' span is clicked
  span.onclick = function () {
    modal.style.display = "none";
  }

  // Close the modal when clicking outside of the modal content
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // Filter table rows based on selected year
  document.getElementById("applyYearFilter").onclick = function () {
    var selectedYear = document.getElementById("yearSelect").value;
    var rows = document.querySelectorAll("#incidentTable tr");

    rows.forEach(function (row) {
      var rowYear = row.getAttribute("data-year");
      row.style.display = selectedYear === "" || rowYear === selectedYear ? "table-row" : "none";
    });

    // Close modal after applying the filter
    modal.style.display = "none";
  };
</script>
