<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Voting System</title>
</head>
<body>
    <h2>Welcome to the Online Voting System</h2>

    <form action="vote.php" method="POST">
        <label>Enter Roll Number:</label>
        <input type="text" name="roll_no" required>
        <br><br>

        <label>Select Candidate:</label>
        <select name="candidate_id" required>
            <?php
            $sql = "SELECT * FROM candidates";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['id']."'>".$row['name']."</option>";
            }
            ?>
        </select>
        <br><br>

        <input type="submit" value="Vote">
    </form>
</body>
</html>
