<?php

class FakeAPI {
    private $json;
    private $response;
    
    public function __construct($path) {
        $file = file_get_contents($path);
        $this->json = json_decode($file);
        $this->checkAction();
    }
    
    public function checkAction($action = '') {
        if ($action == "") {
            $this->response = array(
                "success" => false,
                "message" => "Action not defined"
            );
            return false;
        }
        
        if (!$this->json->$action) {
            $this->response = array(
                "success" => false,
                "message" => "Action not exists"
            );
            return false;
        }
        
        return true;
    }
    
    public function get($action, $filter) {
        if ($_GET && $this->checkAction($action)) {
            if ($filter == "") {
                $this->response = $this->json->$action;
            } else {
                foreach ($this->json->$action as $row) {
                    if ($row->id == $filter) {
                        $this->response = $row;
                        break;
                    }
                }
            }
        }
    }
    
    public function post($action) {
        if ($_POST && $this->checkAction($action)) {
            if ($action == "login") {
                $user = $_POST["user"];
                $pass = $_POST["pass"];
                
                if ($user == $this->json->login->user && $pass == $this->json->login->pass) {
                    $this->response = array(
                        "success" => true,
                    );
                } else {
                    $this->response = array(
                        "success" => false,
                    );
                }
            }
        }
    }
    
    public function response() {
        print json_encode($this->response);
    }
}