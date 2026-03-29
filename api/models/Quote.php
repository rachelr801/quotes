<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // post properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;

        public function __construct($db) {
            $this->conn = $db;
        }

        // get all
        public function read($params = []) {
            $query = "SELECT q.id, q.quote, a.author, c.category
                    FROM quotes q
                    JOIN authors a ON q.author_id = a.id
                    JOIN categories c ON q.category_id = c.id";
            
            $conditions = [];
            
            if(!empty($params['id'])){
                $conditions[] = "q.id = :id";
            }
            if(!empty($params['author_id'])){
                $conditions[] = "q.author_id = :author_id";
            }
            if(!empty($params['category_id'])){
                $conditions[] = "q.category_id = :category_id";
            }

            if(count($conditions) > 0){
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = $this->conn->prepare($query);

            foreach($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt;
        }

    	// create
        public function create(){
            $query = "INSERT INTO quotes (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)";
            $stmt = $this->conn->prepare
            
            return $stmt->execute([
                ':quote' => $this->quote,
                ':author_id' => $this->author_id,
                ':category_id' => $this->category_id
            ]);
        }

    	// update
        public function update(){
            $query = "UPDATE quotes
            		  SET quote=:quote, author_id=:author_id, category_id=:category_id
                      WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            
            return $stmt->execute([
                ':id' => $this->id,
                ':quote' => $this->quote,
                ':author_id' => $this->author_id,
                ':category_id' => $this->category_id               
            ]);
        }

    	// delete
        public function delete(){
            $query = "DELETE FROM quotes WHERE id = :id";
            $stmt = $this->execute([':id' => $this->id])
        }
    }