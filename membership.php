<?php
$pageTitle = "My Memberships";
include 'includes/header.php';
require 'includes/auth_check.php';
require 'includes/config.php';

$student_id = $_SESSION['student_id'];

// Get all memberships for the student
$sql = "SELECT m.membership_id, m.join_date, c.club_id, c.name, c.description, c.meeting_schedule 
        FROM memberships m 
        JOIN clubs c ON m.club_id = c.club_id 
        WHERE m.student_id = '$student_id'";
$result = $conn->query($sql);
?>

<h2>My Club Memberships</h2>

<?php if ($result->num_rows > 0): ?>
    <div class="membership-list">
        <?php while ($membership = $result->fetch_assoc()): ?>
            <div class="membership-card">
                <h3><?php echo htmlspecialchars($membership['name']); ?></h3>
                <p><strong>Joined on:</strong> <?php echo date('F j, Y', strtotime($membership['join_date'])); ?></p>
                <p><strong>Meeting Schedule:</strong> <?php echo htmlspecialchars($membership['meeting_schedule']); ?></p>
                <p><?php echo htmlspecialchars($membership['description']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>You are not a member of any clubs yet. <a href="clubs.php">Browse clubs</a> to join.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>