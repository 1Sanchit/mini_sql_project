<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];

    // Check if voter exists
    $result = $conn->query("SELECT * FROM voters WHERE roll_no='$roll_no'");

    if ($result && $result->num_rows > 0) {
        $_SESSION['roll_no'] = $roll_no;
        header("Location: vote.php");
        exit();
    } else {
        echo "<script>alert('Roll number not found!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voter Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>🧾 Online Voting System</h2>
    <form method="POST">
        <label>Enter Roll No:</label>
        <input type="text" name="roll_no" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
