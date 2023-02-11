<?php
    require_once('../Database.php');
    require_once('../Booking/Booking.php');

    $db = Database::dbConnect();

    $id = $_POST['id'];
    if ($id) {
        try {
            $Booking = new Booking($db);
            $Booking->delete($id);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>
