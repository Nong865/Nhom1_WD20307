<?php
require_once "models/BaseModel.php";

class TourJournalModel extends BaseModel
{
    protected $table = "tour_journals";
    protected $key = "id";

    public function getByTour($tour_id)
    {
        return $this->queryAll(
            "SELECT * FROM {$this->table} WHERE tour_id = ? ORDER BY created_at DESC",
            [$tour_id]
        );
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public function updateJournal($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteJournal($id)
    {
        return $this->delete($id);
    }
}
