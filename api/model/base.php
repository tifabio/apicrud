<?php

class Base {
    protected $conn;
    protected $db;
    protected $table;
    
    public function __construct($table) {
        $this->conn = new MongoDB\Driver\Manager(getenv('MONGO_URI'));
        $this->db = getenv('MONGO_DB');
        $this->table = $table;
    }
    
    public function getAll() {
        $data = array();
        
        $query = new MongoDB\Driver\Query([]);
        
        $cursor = $this->conn->executeQuery($this->db.'.'.$this->table, $query);
        
        foreach ($cursor as $document) {
            $doc = (array) $document;
            unset($doc["_id"]);
            $doc["id"] = (string) $document->_id;
            $data[] = $doc;
        }
        
        return $data;
    }
    
    public function getById($id) {
        $data = array();
        
        $query = new MongoDB\Driver\Query(["_id" => new MongoDB\BSON\ObjectID($id)]);
        
        $cursor = $this->conn->executeQuery($this->db.'.'.$this->table, $query);
        
        foreach ($cursor as $document) {
            $doc = (array) $document;
            unset($doc["_id"]);
            $doc["id"] = (string) $document->_id;
            $data = $doc;
        }
        
        return $data;
    }
    
    public function save($data, $id = 0) {
        $bulk = new MongoDB\Driver\BulkWrite();
        
        if ($id > 0) {
            $data["_id"] = new MongoDB\BSON\ObjectID($id);
            
            $filter = ["_id" => $data["_id"]];
            $update = ['$set' => $data];
            
            $bulk->update($filter, $update);
        } else {
            $data["_id"] = new MongoDB\BSON\ObjectID();
            $bulk->insert($data);
        }
        
        $this->conn->executeBulkWrite($this->db.'.'.$this->table, $bulk);
        
        $data["id"] = (string) $data["_id"];
        unset($data["_id"]);
        
        return $data;
    }
    
    public function delete($id) {
        $bulk = new MongoDB\Driver\BulkWrite();
        
        $filter = ["_id" => new MongoDB\BSON\ObjectID($id)];
        
        $bulk->delete($filter);
        
        $this->conn->executeBulkWrite($this->db.'.'.$this->table, $bulk);
    }
}

?>