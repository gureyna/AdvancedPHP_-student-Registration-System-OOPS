<?php
include 'conn.php';
$db1 = new dbstudent();
$conn = $db1->getConnection();
include 'student_reg.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student1 = new student($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student1->Name = $_POST['name'];
    $student1->Email = $_POST['email'];
    $student1->Grade = $_POST['grade'];
    $student1->Class = $_POST['class'];
    if ($student1->create()) {
        
            header("Location:showstudent.php?message=success");
          
    } else {
        echo "Error inserting record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #333333;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-image {
            width: 100%;
            height: auto;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-4 form-container">
        <img src="std1.jpg" alt="Student Image" class="form-image">
        
        <!-- Form Section -->
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Grade:</label>
                <input type="text" class="form-control" id="grade" name="grade" placeholder="Enter grade">
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Class (Section):</label>
                <input type="text" class="form-control" id="class" name="class" placeholder="Enter section">
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
