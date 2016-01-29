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
    
    $app = new \OnePHP\App();        
    
    $app->get('/api',function() use ($app) {
    });
    
    $app->get('/api/:action', function($action) use ($app) {
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