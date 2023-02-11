<?php

require_once('../Utils.php');

Class Booking
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getDataForFullCalendar()
    {
        $stmt = $this->db->prepare('SELECT * FROM bookings ORDER BY create_date DESC');
        $stmt->execute();
        $bookings = $stmt->fetchALL(PDO::FETCH_ASSOC);

        $array = [];
        $index = 0;
        foreach ($bookings as $booking) {
            $array[$index]['event_id'] = $booking['id'];
            $array[$index]['title'] = $booking['name']. '様';
            $array[$index]['start'] = $booking['start'];
            $array[$index]['end'] = $booking['end'];
            $array[$index]['phone'] = $booking['phone'];
            $array[$index]['postal_code'] = $booking['post_code'];
            $array[$index]['address'] = $booking['address'];
            $array[$index]['member'] = $booking['member'];
            $array[$index]['memo'] = $booking['memo'];
            $array[$index]['allDay'] = true;
            $index += 1;
        }
        return json_encode($array);
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM bookings ORDER BY create_date DESC');
        $stmt->execute();
        $bookings = $stmt->fetchALL(PDO::FETCH_ASSOC);

        return $bookings;
    }

    public function create($db, $postData)
    {
        $stmt = $this->db->prepare('INSERT INTO bookings (name, phone, post_code, address, member, start, end, memo, create_date)
        VALUES (:name, :phone, :post_code, :address, :member, :start, :end, :memo, now())');
        $stmt->bindValue(':name', Utils::h($postData['name']));
        $stmt->bindValue(':phone', Utils::h($postData['phone']));
        $stmt->bindValue(':post_code', Utils::h($postData['postal_code']));
        $stmt->bindValue(':address', Utils::h($postData['address']));
        $stmt->bindValue(':member', Utils::h($postData['member']));
        $stmt->bindValue(':start', Utils::h($postData['start']));
        $stmt->bindValue(':end', Utils::h($postData['end']));
        $stmt->bindValue(':memo', Utils::h($postData['memo']));
        $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM bookings WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

public function createValidation($postData)
    {
        $error = [];
        if (!$postData['name']) {
            $error[] = '名前を入力してください';
        }

        if (!$postData['phone']) {
            $error[] = '電話番号を入力してください';
        }

        if (!$postData['postal_code']) {
            $error[] = '郵便番号を入力してください';
        }

        if (!$postData['address']) {
            $error[] = '住所を入力してください';
        }

        if (!$postData['member']) {
            $error[] = '人数を入力してください';
        }

        if (!$postData['start']) {
            $error[] = '開始日を入力してください';
        }

        if (!$postData['end']) {
            $error[] = '終了日を入力してください';
        }

        return $error;
    }
}