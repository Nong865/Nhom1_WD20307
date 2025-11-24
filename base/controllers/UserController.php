<?php
require_once "./configs/auth.php";
require_once "./models/User.php";

class UserController {

    public function index() {
        requireRole([1]);
        $model = new User();
        $users = $model->getAll();

        $active = 'user';
        $content = "./views/user/index.php";

        require "./views/main.php";
    }

    public function create() {
        requireRole([1]);

        $active = 'user';
        $content = "./views/user/add.php";

        require "./views/main.php";
    }

    public function store() {
        requireRole([1]);

        $model = new User();
        $model->create($_POST);

        header("Location: index.php?action=userIndex");
        exit;
    }
    public function edit() {
        requireRole([1]);

        $model = new User();
        $user = $model->find($_GET['id']);

        $content = "./views/user/edit.php";
        $active = "user";
        require "./views/main.php";
    }

    public function update() {
        requireRole([1]);

        $model = new User();
        $model->update($_POST['id'], $_POST);

        header("Location: index.php?action=userIndex");
        exit;
    }

    public function delete() {
        requireRole([1]);

        $model = new User();
        $model->delete($_GET['id']);

        header("Location: index.php?action=userIndex");
        exit;
    }
}
