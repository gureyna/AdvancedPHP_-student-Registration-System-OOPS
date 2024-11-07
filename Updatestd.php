<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Information</title>
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
<?php

include 'conn.php';
include 'student_reg.php';

$db1 = new dbstudent();
$conn = $db1->getConnection();
$student1 = new student($conn);

$studentData = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM students WHERE ID = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare() failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $studentData = $result->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger'>Student not found.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error executing query: " . htmlspecialchars($stmt->error) . "</div>";
    }

    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>No ID provided.</div>";
}



$conn->close();

// Output the student data for debugging purposes
echo "<pre>";
print_r($studentData);
echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $student1->ID = $_POST['id']; 
    $student1->Name = $_POST['name'];
    $student1->Email = $_POST['email'];
    $student1->Grade = $_POST['grade'];
    $student1->Class = $_POST['class'];

   
    if ($student1->update()) {
        echo "<div class='alert alert-success'>Student updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update student.</div>";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-4 form-container">
     
        <img src="z.jpg" alt="Student Image" class="form-image">
        
       
        <form method="POST" action="">
            
            <input type="hidden" name="id" value="<?php echo isset($studentData['ID']) ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" 
                value="<?php echo $studentData['Name']; ?>"
                placeholder="Enter name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $studentData['Email'] ?>" placeholder="Enter Email" required>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">Grade:</label>
                <input type="text" class="form-control" id="grade" name="grade" value="<?php echo $studentData['Grade']; ?>" placeholder="Enter grade" required>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Class (Section):</label>
                <input type="text" class="form-control" id="class" name="class" value="<?php echo $studentData['Class'] ?>" placeholder="Enter class" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Update</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
