<?php
    require_once "fakeapi.php";

    $api = new FakeAPI("api.json");
    
    $api->get($_GET["action"], $_GET["filter"]);
    
    $api->post($_POST["action"]);
    
    $api->response();
?>