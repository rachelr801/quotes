<?php
class Category {
    private $conn;
    private $table = "categories";

    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    // get
    public function read($id = null) {
        $query = "SELECT id, category FROM " . $this->table;

        if ($id) {
            $query .= " WHERE id = :id";
        }

        $stmt = $this->conn->prepare($query);

        if ($id) {
            $stmt->bindParam(":id", $id);
        }

        $stmt->execute();
        return $stmt;
    }

    // create
    public function create() {
        $query = "INSERT INTO " . $this->table . " (category)
                  VALUES (:category)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':category' => $this->category
        ]);
    }

    // update
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET category = :category
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => $this->id,
            ':category' => $this->category
        ]);
    }

    // delete
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => $this->id
        ]);
    }
}