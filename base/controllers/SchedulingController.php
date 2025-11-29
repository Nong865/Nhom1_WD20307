<?php
require_once "models/SchedulingModel.php";

class SchedulingController
{
    private $model;

    public function __construct()
    {
        $this->model = new SchedulingModel();
    }

    public function index()
{
    requireRole([1,2,4]);

    $schedules = $this->model->getScheduleList();

    // Lấy nhân sự gán cho từng lịch
    foreach ($schedules as &$sc) {
        $sc['staff'] = $this->model->getStaffBySchedule($sc['id']);
    }

    $active = "schedule";

    $content = render("schedule/list", [
        "schedules" => $schedules
    ]);

    include "views/main.php";
}



    public function add()
    {
        requireRole([1,2]);

        $tours = $this->model->getTourList();
        $content = render("schedule/add", ["tours" => $tours]);

        include "views/main.php";
    }

    public function save()
    {
        $data = [
            "tour_id" => $_POST['tour_id'],
            "start_datetime" => $_POST['start_datetime'],
            "end_datetime" => $_POST['end_datetime'],
            "meeting_point" => $_POST['meeting_point'],
        ];

        $id = $this->model->insertSchedule($data);

        header("Location: index.php?action=assignStaff&id=$id");
    }

    public function assignStaff()
    {
        $id = $_GET['id'];

        $schedule = $this->model->getSchedule($id);
        $staff = $this->model->getStaffList();

        $content = render("schedule/assign_staff", [
            "schedule" => $schedule,
            "staff" => $staff
        ]);

        include "views/main.php";
    }

    public function saveStaff()
{
    $schedule_id = $_POST['schedule_id'];
    $staff_id = $_POST['staff_id'];
    $role = $_POST['role'];

    $this->model->assignStaff($schedule_id, $staff_id, $role);

    header("Location: index.php?action=scheduleIndex");
    exit;
}


    public function assignService()
    {
        $id = $_GET['id'];

        $partners = $this->model->getPartners();
        $schedule = $this->model->getSchedule($id);

        $content = render("schedule/assign_service", [
            "partners" => $partners,
            "schedule" => $schedule
        ]);

        include "views/main.php";
    }

   public function saveService()
{
    $schedule_id = $_POST['schedule_id'];
    $partner_id = $_POST['partner_id'];
    $type = $_POST['type'];
    $qty = $_POST['qty'];

    $this->model->assignService($schedule_id, $partner_id, $type, $qty);

    header("Location: index.php?action=scheduleIndex");
    exit;
}

    
}
