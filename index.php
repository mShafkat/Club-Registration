<?php
$pageTitle = "Home";
include 'includes/header.php';
?>

<h2>Welcome to ULAB Club Membership System</h2>
<p>Browse and join various clubs at University of Liberal Arts Bangladesh.</p>

<?php if (isset($_SESSION['student_id'])): ?>
    <div class="welcome-message">
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
        <p>You can browse clubs or view your current memberships.</p>
    </div>
<?php else: ?>
    <div class="login-prompt">
        <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to join clubs.</p>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>