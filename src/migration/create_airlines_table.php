<?php
function createAirlinesTable($pdo) {
    $sql = "
        CREATE TABLE IF NOT EXISTS airlines (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            iata_code VARCHAR(3) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
    ";
    $pdo->exec($sql);
    echo "Table 'airlines' created successfully.\n";
}
?>
