<?php
    require_once 'lib/one_framework.php';
    require_once 'lib/json_db.php';
    require_once 'model/base.php';
    
    // carrega a model se existir, senão usa a base model
    function load($model) {
        $path = './model/' . strtolower($model) . '.php';
        if (file_exists($path)) {
            require_once $path;
        } else {
            $model = 'base';
        }
        
        return $model;
    }
    
    function auth() {
        $response = array(
                "success" => true,
                "token" => md5(date(DATE_ATOM))
            );
        return $response;
    }
    
    function checkAuth($token) {
        $response = array("success" => true);
        
        if ($token == '') {
            $response["success"] = false;
            $response["message"] = "INVALID_TOKEN";
        }
        
        return $response;
    }
    
    $app = new \OnePHP\App();        
    
    $app->get('/api',function() use ($app) {
    });
    
    $app->get('/api/:action', function($action) use ($app) {
        // verifica o Token
        $auth = checkAuth($app->getRequest()->header("Authorization"));
        if (!$auth["success"]) {
            $app->JsonResponse($auth);
            return;
        }
        // define o nome da model, se não existir usa a base model
        $entity = ucfirst(load($action));
        // instancia a model, passando o nome da action (tabela) como parametro
        $model = new $entity($action);
        // chama o metodo
        try {
            $response = $model->getAll();
            // imprime a resposta em JSON
            $app->JsonResponse($response);
        } catch (Exception $e) {
            // imprime a resposta em JSON
            $app->JsonResponse('['.$e->getMessage().']', 500);
        }
    });
    
    $app->get('/api/:action/:id', function($action, $id) use ($app) {
        // verifica o Token
        $auth = checkAuth($app->getRequest()->header("Authorization"));
        if (!$auth["success"]) {
            $app->JsonResponse($auth);
            return;
        }
        // define o nome da model, se não existir usa a base model
        $entity = ucfirst(load($action));
        // instancia a model, passando o nome da action (tabela) como parametro
        $model = new $entity($action);
        // chama o metodo
        try {
            $response = $model->getById($id);
            // imprime a resposta em JSON
            $app->JsonResponse($response);
        } catch (Exception $e) {
            // imprime a resposta em JSON
            $app->JsonResponse('['.$e->getMessage().']', 500);
        }
    });
    
    $app->post('/api/:action', function($action) use ($app) {
        // login
        if ($action == "auth") {
            $response = auth();
            $app->JsonResponse($response);
            return;
        }
        // verifica o Token
        $auth = checkAuth($app->getRequest()->header("Authorization"));
        if (!$auth["success"]) {
            $app->JsonResponse($auth);
            return;
        }
        $data = (array)json_decode($app->getRequest()->getBody());
        // define o nome da model, se não existir usa a base model
        $entity = ucfirst(load($action));
        // instancia a model, passando o nome da action (tabela) como parametro
        $model = new $entity($action);
        // chama o metodo
        try {
            $response = $model->save($data);
            // imprime a resposta em JSON
            $app->JsonResponse($response);
        } catch (Exception $e) {
            // imprime a resposta em JSON
            $app->JsonResponse('['.$e->getMessage().']', 500);
        }
    });
    
    $app->put('/api/:action/:id', function($action, $id) use ($app) {
        // verifica o Token
        $auth = checkAuth($app->getRequest()->header("Authorization"));
        if (!$auth["success"]) {
            $app->JsonResponse($auth);
            return;
        }
        $data = (array)json_decode($app->getRequest()->getBody());
        // define o nome da model, se não existir usa a base model
        $entity = ucfirst(load($action));
        // instancia a model, passando o nome da action (tabela) como parametro
        $model = new $entity($action);
        // chama o metodo
        try {
            $response = $model->save($data, $id);
            // imprime a resposta em JSON
            $app->JsonResponse($response);
        } catch (Exception $e) {
            // imprime a resposta em JSON
            $app->JsonResponse('['.$e->getMessage().']', 500);
        }
    });
    
    $app->delete('/api/:action/:id', function($action, $id) use ($app) {
        // verifica o Token
        $auth = checkAuth($app->getRequest()->header("Authorization"));
        if (!$auth["success"]) {
            $app->JsonResponse($auth);
            return;
        }
        // define o nome da model, se não existir usa a base model
        $entity = ucfirst(load($action));
        // instancia a model, passando o nome da action (tabela) como parametro
        $model = new $entity($action);
        // chama o metodo
        try {
            $response = $model->delete($id);
            // imprime a resposta em JSON
            $app->JsonResponse($response);
        } catch (Exception $e) {
            // imprime a resposta em JSON
            $app->JsonResponse('['.$e->getMessage().']', 500);
        }
    });
    
    $app->listen();
?>