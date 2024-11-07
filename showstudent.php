<?php
include 'conn.php'; 
include 'student_reg.php';
$db1 = new dbstudent();
$conn = $db1->getConnection();

if ($conn) {
    $student1 = new student($conn);
} else {
    echo "Failed to connect to the database.";
}


if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    $query = "DELETE FROM students WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Student deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to delete student.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            border-radius: 10px 10px 0 0;
            width: 100%;
            height: auto;
        }
        .table-container {
            padding: 15px;
        }
        .btn-update {
            background-color: #28a745;
            color: white;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card">
            <!-- Image Section -->
            <img src="y.jpg" alt="Student Image">
            
            <!-- Table Section -->
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Class</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($student1)) {
                            $result = $student1->read();
                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>".$row['ID']."</td>
                                        <td>".$row['Name']."</td>
                                        <td>".$row['Email']."</td>
                                        <td>".$row['Grade']."</td>
                                        <td>".$row['Class']."</td>
                                        <td>
                                            <a href='updatestd.php?id=".$row['ID']."' class='btn btn-sm btn-update'>Update</a>
                                            <form action='' method='POST' style='display:inline;'>
                                                <input type='hidden' name='delete_id' value='".$row['ID']."'>
                                                <button type='submit' name='delete' class='btn btn-sm btn-delete' onclick='return confirm(\"Are you sure you want to delete this student?\");'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Error initializing student class</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
