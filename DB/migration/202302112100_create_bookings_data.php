<?php

    require_once('../../Database.php');
    $db = Database::dbConnect();
    $bookings = [];
    $bookings =[
        ['name'=> 'テストデータ1', 'phone' => '09012341234', 'post_code' => '1231234', 'address' => '東京都テスト1', 'member' => '2', 'memo' => 'メモ1'],
        ['name'=> 'テストデータ2', 'phone' => '09012341235', 'post_code' => '1231235', 'address' => '東京都テスト2', 'member' => '3', 'memo' => 'メモ2'],
        ['name'=> 'テストデータ3', 'phone' => '09012341236', 'post_code' => '1231236', 'address' => '東京都テスト3', 'member' => '4', 'memo' => 'メモ3'],
        ['name'=> 'テストデータ4', 'phone' => '09012341237', 'post_code' => '1231237', 'address' => '東京都テスト4', 'member' => '5', 'memo' => 'メモ4'],
        ['name'=> 'テストデータ5', 'phone' => '09012341238', 'post_code' => '1231238', 'address' => '東京都テスト5', 'member' => '6', 'memo' => 'メモ5']
    ];

    $index = 1;
    foreach ($bookings as $booking) {
        $startDay = date("Y-m-d H:i:s",strtotime("+" . $index ."day"));
        $endDay = date("Y-m-d H:i:s",strtotime("+" . $index + 1 ."day"));
        $stmt = $db->prepare('INSERT INTO bookings (name, phone, post_code, address, member, start, end, memo, create_date)
        VALUES (:name, :phone, :post_code, :address, :member, :start, :end, :memo, now())');
        $stmt->bindValue(':name', $booking['name']);
        $stmt->bindValue(':phone', $booking['phone']);
        $stmt->bindValue(':post_code', $booking['post_code']);
        $stmt->bindValue(':address', $booking['address']);
        $stmt->bindValue(':member', $booking['member']);
        $stmt->bindValue(':start', $startDay);
        $stmt->bindValue(':end', $endDay);
        $stmt->bindValue(':memo', $booking['memo']);
        $index += 1;
        $stmt->execute();
    }
?>
