<?php

require_once "models/TourJournalModel.php";
require_once "models/TourModel.php";  // để load danh sách tour

class TourJournalController
{
    private $journal;
    private $tour;

    public function __construct()
    {
        $this->journal = new TourJournalModel();
        $this->tour = new TourModel();
    }

    /* ============================
          DANH SÁCH NHẬT KÝ
    ============================ */
    public function index()
    {
        $tour_id = $_GET['tour_id'] ?? null;

        if (!$tour_id) {
            die("Thiếu tour_id");
        }

        $tour = $this->tour->find($tour_id);
        $journals = $this->journal->getByTour($tour_id);

        include "views/journal/index.php";
    }

    /* ============================
              FORM THÊM
    ============================ */
    public function create()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        include "views/journal/create.php";
    }

    /* ============================
               LƯU
    ============================ */
    public function store()
    {
        $data = [
            "tour_id" => $_POST['tour_id'],
            "title" => $_POST['title'],
            "content" => $_POST['content'],
            "created_at" => date("Y-m-d H:i:s")
        ];

        $this->journal->create($data);

        header("Location: ?action=journalIndex&tour_id=" . $_POST['tour_id']);
    }

    /* ============================
               FORM SỬA
    ============================ */
    public function edit()
    {
        $id = $_GET['id'];
        $row = $this->journal->find($id);

        include "views/journal/edit.php";
    }

    /* ============================
                UPDATE
    ============================ */
    public function update()
    {
        $id = $_POST['id'];
        $tour_id = $_POST['tour_id'];

        $data = [
            "title" => $_POST['title'],
            "content" => $_POST['content']
        ];

        $this->journal->updateJournal($id, $data);

        header("Location: ?action=journalIndex&tour_id=$tour_id");
    }

    /* ============================
                 DELETE
    ============================ */
    public function delete()
    {
        $id = $_GET['id'];
        $tour_id = $_GET['tour_id'];

        $this->journal->deleteJournal($id);

        header("Location: ?action=journalIndex&tour_id=$tour_id");
    }
}
