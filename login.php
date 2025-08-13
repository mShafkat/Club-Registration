<?php
$pageTitle = "Login";
include 'includes/header.php';

// Check if already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'includes/config.php';
    
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        if (password_verify($password, $student['password'])) {
            // Set session variables
            $_SESSION['student_id'] = $student['student_id'];
            $_SESSION['name'] = $student['name'];
            $_SESSION['email'] = $student['email'];
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Student ID not found";
    }
}
?>

<h2>Student Login</h2>
<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="post" action="login.php">
    <div class="form-group">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Register here</a></p>

<?php include 'includes/footer.php'; ?>