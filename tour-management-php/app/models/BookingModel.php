<?php

namespace App\Models;


class Booking extends Model
{
    public function allWithTourAndUser()
    {
        $sql = 'SELECT b.*, t.title, u.name FROM bookings b JOIN tours t ON b.tour_id=t.id JOIN users u ON b.user_id=u.id';
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO bookings (user_id,tour_id,seats_booked,total_price,status) VALUES (?,?,?,?,?)');
        return $stmt->execute([
            $data['user_id'],
            $data['tour_id'],
            $data['seats_booked'],
            $data['total_price'],
            'pending'
        ]);
    }
}
