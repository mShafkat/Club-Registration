<?php
$pageTitle = "Join Club";
include 'includes/header.php';
require 'includes/auth_check.php';
require 'includes/config.php';

if (!isset($_GET['club_id']) || !is_numeric($_GET['club_id'])) {
    header("Location: clubs.php");
    exit();
}

$club_id = (int) $_GET['club_id'];
$student_id = $_SESSION['student_id'];
$message = "";

// Check if already a member
$stmt = $conn->prepare("SELECT 1 FROM memberships WHERE student_id = ? AND club_id = ?");
$stmt->bind_param("ii", $student_id, $club_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $message = "You are already a member of this club.";
} else {
    // Get club info
    $club_stmt = $conn->prepare("SELECT name FROM clubs WHERE club_id = ?");
    $club_stmt->bind_param("i", $club_id);
    $club_stmt->execute();
    $club_result = $club_stmt->get_result();
    $club = $club_result->fetch_assoc();

    if (!$club) {
        $message = "Club not found.";
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Join the club
        $join_date = date('Y-m-d');
        $insert_stmt = $conn->prepare("INSERT INTO memberships (student_id, club_id, join_date) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("iis", $student_id, $club_id, $join_date);

        if ($insert_stmt->execute()) {
            $message = "You have successfully joined " . htmlspecialchars($club['name']) . "!";
        } else {
            $message = "Error joining club: " . $conn->error;
        }
    }
}
?>

<h2>Join Club</h2>

<?php if (!empty($message)): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
    <a href="clubs.php" class="btn">Back to Clubs</a>
<?php elseif (!empty($club)): ?>
    <p>Are you sure you want to join <strong><?= htmlspecialchars($club['name']) ?></strong>?</p>
    <form method="post" action="join_club.php?club_id=<?= $club_id ?>">
        <button type="submit" class="btn">Confirm Join</button>
        <a href="clubs.php" class="btn btn-secondary">Cancel</a>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
