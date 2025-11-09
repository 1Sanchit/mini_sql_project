<?php
session_start();
include 'db.php';

if (!isset($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

$roll_no = $_SESSION['roll_no'];

// Get voter ID
$voter_query = $conn->query("SELECT id FROM voters WHERE roll_no='$roll_no'");
$voter = $voter_query->fetch_assoc();
$voter_id = $voter['id'];

// Check if already voted
$check_vote = $conn->query("SELECT * FROM votes WHERE voter_id='$voter_id'");
if ($check_vote->num_rows > 0) {
    echo "<h3>⚠️ You have already voted!</h3>";
    echo "<a href='result.php'>View Results</a>";
    exit();
}

// Handle voting submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidate_id = $_POST['candidate'];
    $insert_vote = $conn->query("INSERT INTO votes (voter_id, candidate_id) VALUES ('$voter_id', '$candidate_id')");

    if ($insert_vote) {
        echo "<script>alert('Vote submitted successfully!'); window.location='result.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all candidates
$candidates = $conn->query("SELECT * FROM candidates");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vote Now</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?= $roll_no ?> 👋</h2>
    <form method="POST">
        <label>Select Candidate:</label>
        <select name="candidate" required>
            <option value="">-- Select --</option>
            <?php while ($row = $candidates->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (<?= $row['position'] ?>)</option>
            <?php } ?>
        </select>
        <button type="submit">Submit Vote</button>
    </form>
</div>
</body>
</html>
