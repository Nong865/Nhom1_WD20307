<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\Booking;
use App\Models\Tour;


class BookingController extends BaseController
{
    public function index()
    {
        $bookings = (new Booking())->allWithTourAndUser();
        return $this->views('bookings/index', ['bookings' => $bookings]);
    }


    public function create()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        $tour = (new Tour())->find($tour_id);
        return $this->views('bookings/create', ['tour' => $tour]);
    }


    public function store()
    {
        $user_id = $_POST['user_id'] ?? 1; 
        $tour_id = $_POST['tour_id'];
        $seats = (int)($_POST['seats_booked'] ?? 1);


        $tour = (new Tour())->find($tour_id);
        $total = $tour['price'] * $seats;


        $booking = new Booking();
        $booking->create([
            'user_id' => $user_id,
            'tour_id' => $tour_id,
            'seats_booked' => $seats,
            'total_price' => $total
        ]);


        return $this->redirect('/bookings');
    }
}
