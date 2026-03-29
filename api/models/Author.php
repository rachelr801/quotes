<?php
class Author {
    private $conn;
    private $table = "authors";
    
    public $id;
    public $author;
    
    public function __construct($db){
        $this->conn = $db;
    }

    // get
    public function read($id = null){
        $query = "SELECT id, author FROM " . $this->table;

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
        $query = "INSERT INTO " . $this->table . " (author)
                  VALUES (:author)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':author' => $this->author
        ]);
    }

    // update
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET author = :author
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => $this->id,
            ':author' => $this->author
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