<?php
$pageTitle = "Join Club";
include 'includes/header.php';
require 'includes/auth_check.php';
require 'includes/config.php';

if (!isset($_GET['club_id'])) {
    header("Location: clubs.php");
    exit();
}

$club_id = $conn->real_escape_string($_GET['club_id']);
$student_id = $_SESSION['student_id'];

// Check if already a member
$check_sql = "SELECT * FROM memberships WHERE student_id = '$student_id' AND club_id = '$club_id'";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows > 0) {
    $message = "You are already a member of this club.";
} else {
    // Get club info
    $club_sql = "SELECT name FROM clubs WHERE club_id = '$club_id'";
    $club_result = $conn->query($club_sql);
    $club = $club_result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Join the club
        $join_date = date('Y-m-d');
        $insert_sql = "INSERT INTO memberships (student_id, club_id, join_date) 
                       VALUES ('$student_id', '$club_id', '$join_date')";
        
        if ($conn->query($insert_sql) {
            $message = "You have successfully joined " . htmlspecialchars($club['name']) . "!";
        } else {
            $message = "Error joining club: " . $conn->error;
        }
    }
}
?>

<h2>Join Club</h2>

<?php if (isset($message)): ?>
    <div class="message"><?php echo $message; ?></div>
    <a href="clubs.php" class="btn">Back to Clubs</a>
<?php else: ?>
    <p>Are you sure you want to join <strong><?php echo htmlspecialchars($club['name']); ?></strong>?</p>
    <form method="post" action="join_club.php?club_id=<?php echo $club_id; ?>">
        <button type="submit" class="btn">Confirm Join</button>
        <a href="clubs.php" class="btn btn-secondary">Cancel</a>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>