<?php
function createFlightsTable($pdo) {
    $sql = "
        CREATE TABLE IF NOT EXISTS flights (
            id INT AUTO_INCREMENT PRIMARY KEY,
            departure_time DATETIME NOT NULL,
            arrival_time DATETIME NOT NULL,
            origin VARCHAR(100) NOT NULL,
            destination VARCHAR(100) NOT NULL,
            airline_id INT NOT NULL,
            status ENUM('scheduled', 'delayed', 'canceled', 'on time', 'completed') NOT NULL DEFAULT 'scheduled',
            price DECIMAL(10, 2) NOT NULL,
            capacity INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_airline
                FOREIGN KEY (airline_id)
                REFERENCES airlines(id)
                ON DELETE CASCADE
        );
    ";
    $pdo->exec($sql);
    echo "Table 'flights' created successfully.\n";
}
?>
