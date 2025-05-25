<?php 
include 'includes/header.php'; 
include 'includes/sidebar.php'; 
include 'includes/db_connection.php'; 
// Sa login process (example)
$stmt = $conn->prepare("SELECT * FROM user_list WHERE username = ? AND status = 'active'");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Continue with login
} else {
    $error_message = "Your account is inactive. Please verify your email.";
}

?>


<div class="content">
    <h2>User List</h2>

    <!-- Table for displaying the user list -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch users from the database
            $sql = "SELECT id, username, email, role, created_at FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>" . ucfirst($row['role']) . "</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}' class='btn-edit'>Edit</a>
                            <a href='delete_user.php?id={$row['id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    /* Basic Layout */
    .content {
        margin-left: 15px;
        padding: 20px;
    }

    h2 {
        color: #003662;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #003662;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn-edit, .btn-delete {
        padding: 5px 10px;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .btn-edit {
        background-color: #ffa500;
    }

    .btn-edit:hover {
        background-color: #ff4500;
    }

    .btn-delete {
        background-color: #f44336;
    }

    .btn-delete:hover {
        background-color: #d32f2f;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content {
            margin-left: 0;
            padding: 10px;
        }

        table {
            font-size: 14px;
        }

        h2 {
            font-size: 20px;
        }
    }
</style>
