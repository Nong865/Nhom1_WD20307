<?php

require_once "BaseModel.php";

class TourJournalModel extends BaseModel
{
    protected $table = "tour_journals";

    public function getByTour($tour_id)
    {
        return $this->query("SELECT * FROM $this->table WHERE tour_id = ?", [$tour_id]);
    }

    public function find($id)
    {
        return $this->queryOne("SELECT * FROM $this->table WHERE id = ?", [$id]);
    }

    public function create($data)
    {
        return $this->insert($this->table, $data);
    }

    public function updateJournal($id, $data)
    {
        return $this->update($this->table, $data, "id = $id");
    }

    public function deleteJournal($id)
    {
        return $this->delete($this->table, "id = $id");
    }
}
