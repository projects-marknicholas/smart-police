<?php
class DataController{
  public function incident_reports() {
    global $conn;
    date_default_timezone_set('Asia/Manila');
    $response = array();
  
    // Fetch all incident reports without pagination
    $query = "SELECT * FROM incident_reports";
    $result = $conn->query($query);
  
    if ($result->num_rows > 0) {
      $reports = array();
      while ($row = $result->fetch_assoc()) {
        $reports[] = [
          'region' => $row['region'],
          'province' => $row['province'],
          'municipal' => $row['municipal'],
          'barangay' => $row['barangay'],
          'dateCommitted' => $row['dateCommitted'],
          'timeCommitted' => $row['timeCommitted'],
          'stageoffelony' => $row['stageoffelony'],
          'offense' => $row['offense'],
          'offenseType' => $row['offenseType'],
        ];
      }
      $response['status'] = 'success';
      $response['message'] = 'Data retrieved successfully!';
      $response['data'] = $reports;
    } else {
      $response['status'] = 'error';
      $response['message'] = 'No reports found';
    }
  
    echo json_encode($response);
  }  

  public function insert_incident_predictions(){
    global $conn;
    date_default_timezone_set('Asia/Manila');
    $response = array();

    $data = json_decode(file_get_contents("php://input"), true);
    $region = htmlspecialchars(isset($data['region']) ? $data['region'] : '');
    $province = htmlspecialchars(isset($data['province']) ? $data['province'] : '');
    $municipal = htmlspecialchars(isset($data['municipal']) ? $data['municipal'] : '');
    $barangay = htmlspecialchars(isset($data['barangay']) ? $data['barangay'] : '');
    $dateCommitted = htmlspecialchars(isset($data['dateCommitted']) ? $data['dateCommitted'] : '');
    $timeCommitted = htmlspecialchars(isset($data['timeCommitted']) ? $data['timeCommitted'] : '');
    $stageoffelony = htmlspecialchars(isset($data['stageoffelony']) ? $data['stageoffelony'] : '');
    $offense = htmlspecialchars(isset($data['offense']) ? $data['offense'] : '');
    $offenseType = htmlspecialchars(isset($data['offenseType']) ? $data['offenseType'] : '');

    // Validation for required fields
    if (empty($region)) {
      $response['status'] = 'error';
      $response['message'] = 'Region cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($province)) {
      $response['status'] = 'error';
      $response['message'] = 'Province cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($municipal)) {
      $response['status'] = 'error';
      $response['message'] = 'Municipal cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($barangay)) {
      $response['status'] = 'error';
      $response['message'] = 'Barangay cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($dateCommitted)) {
      $response['status'] = 'error';
      $response['message'] = 'Date Committed for cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($timeCommitted)) {
      $response['status'] = 'error';
      $response['message'] = 'Time Committed cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($stageoffelony)) {
      $response['status'] = 'error';
      $response['message'] = 'Stage of Felony cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($offense)) {
      $response['status'] = 'error';
      $response['message'] = 'Offense cannot be empty';
      echo json_encode($response);
      return;
    }
    if (empty($offenseType)) {
      $response['status'] = 'error';
      $response['message'] = 'Offense Type cannot be empty';
      echo json_encode($response);
      return;
    }

    // Check if an entry with the same dateCommitted and timeCommitted already exists
    $checkQuery = "SELECT COUNT(*) FROM incident_predictions WHERE dateCommitted = ? AND timeCommitted = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param('ss', $dateCommitted, $timeCommitted);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count > 0) {
      $response['status'] = 'error';
      $response['message'] = 'An incident with the same date and time already exists.';
      echo json_encode($response);
      return;
    }

    $sql = "INSERT INTO incident_predictions (region, province, municipal, barangay, dateCommitted, timeCommitted, stageoffelony, offense, offenseType)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      'sssssssss',
      $region,
      $province,
      $municipal,
      $barangay,
      $dateCommitted,
      $timeCommitted,
      $stageoffelony,
      $offense,
      $offenseType
    );

    if ($stmt->execute()){
      $response['status'] = 'success';
      $response['message'] = 'Incident Report added successfully!';
      echo json_encode($response);
    } else{
      $response['status'] = 'error';
      $response['message'] = 'Failed to add subject.';
      error_log('MySQL Error: ' . $stmt->error);  
      echo json_encode($response);
      return;
    }

    $stmt->close();
  }
}
?>