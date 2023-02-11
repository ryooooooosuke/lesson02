<?php
    require_once('../Database.php');
    $db = Database::dbConnect();

    try {
        $sql = 'CREATE TABLE bookings (
            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(32) NOT NULL,
            phone VARCHAR(32) NOT NULL,
            post_code VARCHAR(10) NOT NULL,
            address VARCHAR(32) NOT NULL,
            member INT(5) NOT NULL,
            start DATETIME,
            end DATETIME,
            memo VARCHAR(255) NOT NULL,
            create_date DATETIME,
            update_date TIMESTAMP
        )';
        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>
