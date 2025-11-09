<?php
include 'db.php';

$query = "SELECT candidates.name, COUNT(votes.id) AS total_votes 
          FROM candidates 
          LEFT JOIN votes ON candidates.id = votes.candidate_id 
          GROUP BY candidates.id";
$result = $conn->query($query);

$names = [];
$votes = [];
while ($row = $result->fetch_assoc()) {
    $names[] = $row['name'];
    $votes[] = $row['total_votes'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>📊 Voting Results</h2>
    <canvas id="voteChart"></canvas>
    <a href="login.php">🔁 Back to Login</a>
</div>

<script>
const ctx = document.getElementById('voteChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($names) ?>,
        datasets: [{
            label: 'Votes',
            data: <?= json_encode($votes) ?>,
            backgroundColor: '#0078d7'
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } }
    }
});
</script>
</body>
</html>
