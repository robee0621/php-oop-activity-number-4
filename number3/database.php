<?php
class Database {
    private $host = "localhost";
    private $db_name = "school_db";
    private $username = "root";
    private $password = "";
    protected $conn;

    // Establish DB connection
    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Generic CREATE
    public function create($table, $data) {
        $keys = implode(",", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Generic READ
    public function read($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(" AND ", $clauses);
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Generic UPDATE
    public function update($table, $data, $conditions) {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = :$key";
        }
        $updateStr = implode(", ", $updates);

        $cond = [];
        foreach ($conditions as $key => $value) {
            $cond[] = "$key = :cond_$key";
        }
        $condStr = implode(" AND ", $cond);

        $sql = "UPDATE $table SET $updateStr WHERE $condStr";
        $stmt = $this->conn->prepare($sql);

        // Bind values
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":cond_$key", $value);
        }

        return $stmt->execute();
    }

    // Generic DELETE
    public function delete($table, $conditions) {
        $cond = [];
        foreach ($conditions as $key => $value) {
            $cond[] = "$key = :$key";
        }
        $condStr = implode(" AND ", $cond);

        $sql = "DELETE FROM $table WHERE $condStr";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($conditions);
    }
}
?>
