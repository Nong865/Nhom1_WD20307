<?php
require_once "models/BaseModel.php";

class HuongDanVien extends BaseModel 
{
    protected $table = "huong_dan_vien";
    protected $key = "id";

    public function getAllWithGroups()
    {
        $sql = "
            SELECT h.*, 
                GROUP_CONCAT(n.ten_nhom SEPARATOR ', ') AS nhom
            FROM huong_dan_vien h
            LEFT JOIN hdv_nhom hn ON h.id = hn.hdv_id
            LEFT JOIN nhom_hdv n ON hn.nhom_id = n.id
            GROUP BY h.id
        ";
        return $this->queryAll($sql);
    }

    public function getGroups()
    {
        return $this->queryAll("SELECT * FROM nhom_hdv");
    }

    public function getHdvGroups($id)
    {
        return $this->queryAll("SELECT nhom_id FROM hdv_nhom WHERE hdv_id = $id");
    }

    public function saveGroups($hdv_id, $group_ids)
    {
        $this->query("DELETE FROM hdv_nhom WHERE hdv_id = $hdv_id");

        foreach ($group_ids as $gid) {
            $this->insertRaw("INSERT INTO hdv_nhom (hdv_id, nhom_id) VALUES (?, ?)", [$hdv_id, $gid]);
        }
    }
}
