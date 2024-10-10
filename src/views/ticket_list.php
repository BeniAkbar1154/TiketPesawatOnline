<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket List</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h1>Available Tickets</h1>
    <ul>
        <?php foreach ($tickets as $ticket): ?>
            <li>
                <?= htmlspecialchars($ticket['event_name']) ?> - <?= htmlspecialchars($ticket['price']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
