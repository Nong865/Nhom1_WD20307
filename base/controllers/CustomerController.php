<?php
require_once __DIR__ . '/../models/TourCustomer.php';

class CustomerController {

    private $model;

    public function __construct() {
        $this->model = new TourCustomer();
    }

    // Danh sách khách theo tour
  public function listByTour() {
    $tour_id = $_GET['tour_id'];
    $customers = $this->model->getByTour($tour_id);

    // Gán biến cho layout
    $title = "Danh sách khách theo tour";
    $active = "customer";
    $content = __DIR__ . '/../views/customer/customers_by_tour.php';

    // Load đúng layout
    require __DIR__ . '/../views/main.php';
}



    // Check-in / điểm danh
    public function checkin() {
        $id = $_POST['id'];
        $status = $_POST['status']; // arrived | not_arrived | absent
        $this->model->updateCheckin($id, $status);

        header("Location: index.php?action=listCustomerByTour&tour_id=" . $_POST['tour_id']);
    }

    // Phân phòng
    public function assignRoom() {
        $id = $_POST['id'];
        $roomId = $_POST['room_id'];

        $this->model->updateRoom($id, $roomId);

        header("Location: index.php?action=listCustomerByTour&tour_id=" . $_POST['tour_id']);
    }
    // In danh sách đoàn
public function printCustomerList() {
    $tour_id = $_GET['tour_id'];

    // Lấy danh sách khách
    $customers = $this->model->getByTour($tour_id);

    // Lấy thông tin tour nếu cần
    $tour = $this->model->getTourInfo($tour_id);

    require_once __DIR__ . '/../views/customer/printList.php';
}
public function addForm() {
    $tour_id = $_GET['tour_id'];

    $title = "Thêm khách vào đoàn";
    $active = "customer";
    $content = __DIR__ . '/../views/customer/add.php';

    require __DIR__ . '/../views/main.php';
}
public function add() {
    $data = [
        'tour_id' => $_POST['tour_id'],
        'name' => $_POST['name'],
        'gender' => $_POST['gender'],
        'birth_year' => ($_POST['birth_year'] !== "") ? $_POST['birth_year'] : null,
        'phone' => $_POST['phone'],
        'passport' => $_POST['passport'],
        'special_note' => $_POST['special_note'],
        'payment_status' => $_POST['payment_status']
    ];

    $this->model->addCustomer($data);

    header("Location: index.php?action=listCustomerByTour&tour_id=".$_POST['tour_id']);
}
public function editForm() {
    $id = $_GET['id'];
    $customer = $this->model->findCustomer($id);

    $title = "Sửa thông tin khách";
    $active = "customer";
    $content = __DIR__ . '/../views/customer/edit.php';

    require __DIR__ . '/../views/main.php';
}
public function edit() {
    $id = $_POST['id'];

    $data = [
        'name' => $_POST['name'],
        'gender' => $_POST['gender'],
        'birth_year' => ($_POST['birth_year'] !== "") ? $_POST['birth_year'] : null,
        'phone' => $_POST['phone'],
        'passport' => $_POST['passport'],
        'special_note' => $_POST['special_note'],
        'payment_status' => $_POST['payment_status']
    ];

    $this->model->updateCustomer($id, $data);

    header("Location: index.php?action=listCustomerByTour&tour_id=".$_POST['tour_id']);
}
public function delete() {
    $id = $_GET['id'];
    $tour_id = $_GET['tour_id'];

    $this->model->deleteCustomer($id);

    header("Location: index.php?action=listCustomerByTour&tour_id=$tour_id");
}

}
