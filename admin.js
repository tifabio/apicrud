var myApp = angular.module('myApp', ['ng-admin']);

myApp.config(['NgAdminConfigurationProvider', function (nga) {
    
    var admin = nga.application('CRUD API').baseApiUrl('api/');
    
    var contatos = nga.entity('contatos');
    
    contatos.listView().fields([
        nga.field('nome').isDetailLink(true),
        nga.field('email'),
        nga.field('fone')
    ]);
    
    contatos.creationView().fields([
        nga.field('nome'),
        nga.field('email'),
        nga.field('fone')
    ]);
    
    contatos.editionView().fields(contatos.creationView().fields());
    
    admin.addEntity(contatos);
    
    nga.configure(admin);
}]);