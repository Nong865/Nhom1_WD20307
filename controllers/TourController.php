<?php
require_once dirname(__DIR__) . '/configs/helper.php';
require_once dirname(__DIR__) . '/models/TourModel.php';
class TourController {

    private $tourModel;

    public function __construct() {
        $this->tourModel = new TourModel();
    }

    public function index() {
        $tours = $this->tourModel->getAll();
        $active = 'tour';

        $content = render("tours/list", [
            'tours' => $tours,
            'active' => $active
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function add() {
        $active = 'tour';

        $content = render("tours/add", []);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function edit() {
        $id = $_GET['id'];
        $tour = $this->tourModel->find($id);

        $content = render("tours/edit", [
            'tour' => $tour,
            'active' => 'tour'
        ]);

        include dirname(__DIR__) . "/views/main.php";
    }

    public function save() {
        $img = null;

        if (!empty($_FILES['main_image']['name'])) {
            $name = "tour_img_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $name;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
            $img = $path;
        }

        $data = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date'],
            "main_image" => $img
        ];

        $this->tourModel->insert($data);
        header("Location: index.php?action=listTours");
    }

    public function update() {
        $id = $_POST['id'];
        $img = $_POST['old_image'];

        if (!empty($_FILES['main_image']['name'])) {
            $name = "tour_img_" . uniqid() . ".jpg";
            $path = "assets/uploads/" . $name;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $path);
            $img = $path;
        }

        $data = [
            "name" => $_POST['name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "start_date" => $_POST['start_date'],
            "end_date" => $_POST['end_date'],
            "main_image" => $img
        ];

        $this->tourModel->updateTour($id, $data);
        header("Location: index.php?action=listTours");
    }

    public function delete() {
        $id = $_GET['id'];
        $this->tourModel->delete($id);
        header("Location: index.php?action=listTours");
    }
}
