<?php
    require_once('../Database.php');
    require_once('../Booking/Booking.php');
    require_once('../Utils.php');

    $db = Database::dbConnect();
    $Booking = new Booking($db);

    session_start();
    if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
        $_SESSION['name'] = Utils::h($_POST['name']);
        $_SESSION['phone'] = Utils::h($_POST['phone']);
        $_SESSION['address'] = Utils::h($_POST['address']);
        $_SESSION['postal_code'] = Utils::h($_POST['postal_code']);
        $_SESSION['member'] = Utils::h($_POST['member']);
        $_SESSION['start'] = Utils::h($_POST['start']);
        $_SESSION['end'] = Utils::h($_POST['end']);
        $error = $Booking->createValidation($_POST);

        if (!empty($error)) {
            $_SESSION['bookingFormError'] = $error;
            header("location: new.php");
            exit();
        }
        session_destroy();
        $Booking->create($db, $_POST);
    }
    $Bookings = $Booking->getAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        function deleteBooking(event) {
            const xhr = new XMLHttpRequest();
            const fd = new FormData();
            xhr.open('POST', './delete.php');
            fd.append('id', event.target.value);
            xhr.send(fd);
            bookingList = document.querySelector(`.booking-list-${event.target.value}`)
            bookingList.remove();
        }
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>予約一覧</title>
</head>
<body>
    <div class="container">
        <?php if(!empty($Bookings)): ?>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>電話番号</th>
                        <th>郵便番号</th>
                        <th>住所</th>
                        <th>人数</th>
                        <th>日付</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Bookings as $Booking): ?>
                        <tr class="border-bottom booking-list-<?php echo $Booking['id'] ?>">
                            <td><?php echo $Booking['name']; ?></td>
                            <td><?php echo $Booking['phone']; ?></td>
                            <td><?php echo $Booking['post_code']; ?></td>
                            <td><?php echo $Booking['address']; ?></td>
                            <td><?php echo $Booking['member']; ?></td>
                            <td><?php echo $Booking['start']; ?>〜<?php echo $Booking['end']; ?></td>
                            <td><button class="btn btn-danger delete-button" onclick="deleteBooking(event)" value="<?php echo $Booking['id'] ?>">削除</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>TODOはありません</p>
        <?php endif; ?>
        <div class="text-center">
            <a href="new.php" class="btn btn-primary">新規登録</a>
            <a href="calender.php" class="btn btn-danger">カレンダー</a>

        </div>
    </div>
</body>
</html>