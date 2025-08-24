<?php
require_once "Database.php";

class Attendance extends Database {
    protected $table = "attendance";

    public function addAttendance($data) {
        return $this->create($this->table, $data);
    }

    public function getAttendance($conditions = []) {
        return $this->read($this->table, $conditions);
    }

    public function updateAttendance($data, $conditions) {
        return $this->update($this->table, $data, $conditions);
    }

    public function deleteAttendance($conditions) {
        return $this->delete($this->table, $conditions);
    }
}
?>
