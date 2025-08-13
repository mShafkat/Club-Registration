<?php
$pageTitle = "Browse Clubs";
include 'includes/header.php';
require 'includes/config.php';

// Get all clubs
$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);
?>

<h2>Available Clubs at ULAB</h2>

<div class="club-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($club = $result->fetch_assoc()): ?>
            <div class="club-card">
                <h3><?php echo htmlspecialchars($club['name']); ?></h3>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($club['category']); ?></p>
                <p><strong>Meeting Schedule:</strong> <?php echo htmlspecialchars($club['meeting_schedule']); ?></p>
                <p><strong>Advisor:</strong> <?php echo htmlspecialchars($club['advisor']); ?></p>
                <p><?php echo htmlspecialchars($club['description']); ?></p>
                <?php if (isset($_SESSION['student_id'])): ?>
                    <a href="join_club.php?club_id=<?php echo $club['club_id']; ?>" class="btn">Join Club</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No clubs available at the moment.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>