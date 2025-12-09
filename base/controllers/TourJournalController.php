<?php
require_once "models/TourJournalModel.php";
require_once "models/TourModel.php";

class TourJournalController
{
    private $journal;
    private $tour;

    public function __construct()
    {
        $this->journal = new TourJournalModel();
        $this->tour = new TourModel();
    }

    /* ====================== DANH SÁCH ====================== */
    public function index()
    {
        $tour_id = $_GET['tour_id'] ?? null;

        if (!$tour_id) {
            $_SESSION['error'] = "Vui lòng chọn tour trước.";
            header("Location: index.php?action=listTours");
            exit;
        }

        $tour = $this->tour->find($tour_id);
        $journals = $this->journal->getByTour($tour_id);

        $content = "views/journal/index.php";
        $active = "tour";
        include __DIR__ . '/../views/main.php';
    }

    /* ====================== FORM THÊM ====================== */
    public function create()
    {
        $tour_id = $_GET['tour_id'] ?? null;

        if (!$tour_id) {
            header("Location: index.php?action=listTours");
            exit;
        }

        $content = "views/journal/create.php";
        include __DIR__ . '/../views/main.php';
    }

    /* ====================== LƯU ====================== */
    public function store()
{
    // Tạo thư mục upload nếu chưa có
    $uploadDir = __DIR__ . '/../../assets/uploads/journal/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Lấy dữ liệu form an toàn
    $tour_id      = $_POST['tour_id'] ?? null;
    $journal_date = trim($_POST['journal_date'] ?? '');
    $title        = trim($_POST['title'] ?? '');
    $activities   = trim($_POST['activities'] ?? '');
    $issues       = trim($_POST['issues'] ?? '');
    $feedback     = trim($_POST['feedback'] ?? '');

    if (!$tour_id || $journal_date == '') {
        $_SESSION['error'] = "Thiếu thông tin bắt buộc.";
        header("Location: index.php?action=journalCreate&tour_id=" . $tour_id);
        exit;
    }

    // Upload 1 ảnh
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file['name']);
            $target = $uploadDir . $safeName;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $imagePath = 'assets/uploads/journal/' . $safeName;
            }
        }
    }

    // Dữ liệu lưu DB
    $data = [
        "tour_id"      => $tour_id,
        "journal_date" => $journal_date,
        "title"        => $title,
        "activities"   => $activities,
        "issues"       => $issues,
        "feedback"     => $feedback,
        "image"        => $imagePath,
        "created_at"   => date("Y-m-d H:i:s")
    ];

    $this->journal->create($data);

    header("Location: index.php?action=journalIndex&tour_id=" . $tour_id);
    exit;
}

    /* ====================== FORM SỬA ====================== */
    public function edit()
    {
        $id = $_GET['id'];
        $row = $this->journal->find($id);

        $content = "views/journal/edit.php";
        include __DIR__ . '/../views/main.php';
    }

    /* ====================== UPDATE ====================== */
    public function update()
    {
        $id = $_POST['id'];
        $tour_id = $_POST['tour_id'];

        $uploadDir = "assets/uploads/journal/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $image = $_POST['old_image'];

        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            $filename = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $file['name']);
            $path = $uploadDir . $filename;

            move_uploaded_file($file['tmp_name'], $path);
            $image = $path;
        }

        $data = [
            "tour_id"       => trim($_POST['tour_id']),
            "journal_date"  => trim($_POST['journal_date']),
            "title"         => trim($_POST['title']),
            "activities"    => trim($_POST['activities']),
            "issues"        => trim($_POST['issues']),
            "feedback"      => trim($_POST['feedback']),
            "image"         => $image,
            "updated_at"    => date("Y-m-d H:i:s")
        ];

        $this->journal->updateJournal($id, $data);

        header("Location: index.php?action=journalIndex&tour_id=$tour_id");
        exit;
    }

    /* ====================== DELETE ====================== */
    public function delete()
    {
        $id = $_GET['id'];
        $tour_id = $_GET['tour_id'];

        $this->journal->deleteJournal($id);

        header("Location: index.php?action=journalIndex&tour_id=$tour_id");
        exit;
    }
}
