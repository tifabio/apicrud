var myApp = angular.module('myApp', ['ng-admin']);

myApp.config(['NgAdminConfigurationProvider', function (nga) {
    
    var admin = nga.application('CRUD API');
    
    nga.configure(admin);
}]);