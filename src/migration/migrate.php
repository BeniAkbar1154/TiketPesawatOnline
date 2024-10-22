<?php
require_once __DIR__ . '/../../database/db_connection.php';
require_once 'create_users_table.php';
require_once 'create_airlines_table.php';
require_once 'create_flights_table.php';

try {
    createUsersTable($pdo);
    createAirlinesTable($pdo);
    createFlightsTable($pdo);

    echo "All tables created successfully!";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
