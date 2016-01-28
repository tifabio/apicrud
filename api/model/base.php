<?php

class Base {
    protected $db;
    protected $table;
    
    public function __construct($table) {
        if(!file_exists("json")) {
            mkdir("json");
        }
        $this->db = new JsonDB("./json/");
        
        $this->table = $table;
        
        try {
            $this->db->selectAll($this->table);
        } catch (Exception $e) {
            $this->db->createTable($this->table);
        }
    }
    
    public function getAll() {
        $data = $this->db->selectAll($this->table);
        return ($data == null) ? array() : $data;
    }
    
    public function getById($id) {
        $data = $this->db->select($this->table, "id", $id);
        return ($data == null) ? array() : $data[0];
    }
    
    public function save($data, $id = 0) {
        if ($id > 0) {
            $data["id"] = $id;
            $this->db->update($this->table, "id", $id, $data);
        } else {
            $data["id"] = $this->incrementId();
            $this->db->insert($this->table, $data);
        }
        
        return $data;
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, "id", $id);
    }
    
    private function incrementId() {
        $data = $this->getAll();
        if(empty($data)) {
            return 1;
        } else {
            $last = end($data);
            $nextId = (int)$last["id"] + 1;
            return $nextId;
        }
    }
}

?>