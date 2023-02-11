<?php
    require_once('../Database.php');
    require_once('../Utils.php');
    require_once('./Booking.php');

    $db = Database::dbConnect();
    $Booking = new Booking($db);

    session_start();
    $toke_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($toke_byte);
    $_SESSION['csrf_token'] = $csrf_token;

    if (!empty($_SESSION['bookingFormError'])) {
        $errorMessages = $_SESSION['bookingFormError'];
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
    <script>
        function formReset() {
            document.bookingForm.reset();
        }
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php if(!empty($errorMessages)): ?>
            <?php foreach($errorMessages as $errorMessage): ?>
                <p class="text-danger"><?php echo $errorMessage ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="mt-5">
            <form method="POST" action="index.php" class="h-adr" name="bookingForm">
                <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                <span class="p-country-name" style="display:none;">Japan</span>
                <div class="form-group">
                    <label>お名前</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['name'] ?>">
                </div>
                <div class="form-group">
                    <label>電話番号</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $_SESSION['phone'] ?>">
                </div>
                <div class="form-group">
                    <label>郵便番号</label>
                    <input type="text" class="form-control p-postal-code" name="postal_code" value="<?php echo $_SESSION['postal_code'] ?>">
                </div>
                <div class="form-group">
                    <label>住所</label>
                    <input type="text" class="form-control p-region p-locality p-street-address p-extended-address" name="address" value="<?php echo $_SESSION['address'] ?>">
                </div>
                <div class="form-group">
                    <label>人数</label>
                    <input type="text" class="form-control" name="member" value="<?php echo $_SESSION['member'] ?>">
                </div>
                <div class="form-group">
                    <label>日付</label>
                    <input type="datetime-local" class="form-control" name="start" value="<?php echo $_SESSION['start'] ?>">
                    <input type="datetime-local" class="form-control mt-3" name="end" value="<?php echo $_SESSION['end'] ?>">
                </div>
                <div class="form-group">
                    <label>備考</label>
                    <textarea class="form-control" name="memo" id="" cols="100" rows="5"></textarea>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary" type="submit">送信</button>
                    <button class="btn btn-secondary" type="button" onclick="formReset()">リセット</button>
                </div>
            </form>
        </mt-5>
    </div>
</body>
</html>