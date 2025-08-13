<?php
$pageTitle = "Register";
include 'includes/header.php';

// Check if already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'includes/config.php';
    
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $department = $conn->real_escape_string($_POST['department']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Check if student ID already exists
    $check_sql = "SELECT student_id FROM students WHERE student_id = '$student_id'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        $error = "Student ID already registered";
    } else {
        $sql = "INSERT INTO students (student_id, name, email, password, department) 
                VALUES ('$student_id', '$name', '$email', '$password', '$department')";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful! Please <a href='login.php'>login</a>.";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<h2>Student Registration</h2>
<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php elseif (isset($success)): ?>
    <div class="success"><?php echo $success; ?></div>
<?php endif; ?>

<form method="post" action="register.php">
    <div class="form-group">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
    </div>
    <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="department">Department:</label>
        <input type="text" id="department" name="department" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>

<?php include 'includes/footer.php'; ?>