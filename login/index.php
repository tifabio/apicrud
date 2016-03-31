<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CRUD API</title>
        <link rel="stylesheet" href="/ng-admin/ng-admin.min.css">
        <style>
            body {
              padding-top: 40px;
              padding-bottom: 40px;
              background-color: #eee;
            }
            .form-signin {
              max-width: 330px;
              padding: 15px;
              margin: 0 auto;
            }
            .form-signin .form-control {
              position: relative;
              height: auto;
              -webkit-box-sizing: border-box;
                 -moz-box-sizing: border-box;
                      box-sizing: border-box;
              padding: 10px;
              font-size: 16px;
            }
            .form-signin .form-control:focus {
              z-index: 2;
            }
            .form-signin input {
              margin-bottom: 10px;
              border-bottom-right-radius: 0;
              border-bottom-left-radius: 0;
            }
            .form-signin input[type="email"] {
              margin-bottom: -1px;
            }
        </style>
    </head>
    <body ng-app="myAppLogin">
        <div class="container">
            <form class="form-signin" id="form-login" ng-submit="submit()" ng-controller="LoginController" method="POST">
                <h2>Login</h2>
                <input type="email" id="inputEmail" ng-model="login.email" name="email" class="form-control" placeholder="Email" autofocus>
                <input type="password" id="inputPassword" ng-model="login.password" name="password" class="form-control" placeholder="Senha">
                <input type="hidden" id="inputToken" name="token">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            </form>
            <script src="/ng-admin/ng-admin.min.js" type="text/javascript"></script>
            <script type="text/javascript">
                var myAppLogin = angular.module('myAppLogin', []);
            
                myAppLogin.controller('LoginController', function($scope, $http) { 
                    $scope.submit = function() {
                        $http.post('/api/auth', $scope.login).success(function(data){
                            if (data.success) {
                                var form = document.querySelector('#form-login');
                                form.inputToken.value = data.token;
                                form.action = "/" + location.hash;
                                form.submit();
                            }
                        });
                    };
                });
            </script>
        </div>
    </body>
</html>