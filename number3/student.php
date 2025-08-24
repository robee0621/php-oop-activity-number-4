<?php
require_once "Database.php";

class Student extends Database {
    protected $table = "students";

    public function addStudent($data) {
        return $this->create($this->table, $data);
    }

    public function getStudents($conditions = []) {
        return $this->read($this->table, $conditions);
    }

    public function updateStudent($data, $conditions) {
        return $this->update($this->table, $data, $conditions);
    }

    public function deleteStudent($conditions) {
        return $this->delete($this->table, $conditions);
    }
}
?>
