var myApp = angular.module('myApp', ['ng-admin']);

myApp.config(['NgAdminConfigurationProvider', function (nga) {
    
    var admin = nga.application('CRUD API').baseApiUrl('api/');
    
    var contatos = nga.entity('contatos');
    
    contatos.listView().fields([
        nga.field('nome'),
        nga.field('email'),
        nga.field('sexo')
            .map(function truncate(value) {
                if (value == "M") return "Masculino";
                if (value == "F") return "Feminino";
            })
            .cssClasses('hidden-xs'),
        nga.field('data_nascimento','date')
            .label('Nascimento')
            .format('dd/MM/yyyy')
            .cssClasses('hidden-xs')
    ]).listActions(['show', 'edit', 'delete']);
    
    contatos.creationView().fields([
        nga.field('nome').validation({ required: true}),
        nga.field('email','email').validation({ required: true}),
        nga.field('sexo', 'choice').choices([
            { value: 'M', label: 'Masculino' },
            { value: 'F', label: 'Feminino' }
        ]).attributes({ placeholder: 'Selecione' }),
        nga.field('data_nascimento', 'date')
            .label('Nascimento')
            .defaultValue(new Date())
            .format('dd/MM/yyyy')
    ]);
    
    contatos.showView().fields(contatos.creationView().fields());
    
    contatos.editionView().fields(contatos.creationView().fields());
    
    admin.addEntity(contatos);
    
    var logout = nga.entity('logout').readOnly();
    
    admin.menu(nga.menu()
        .addChild(nga.menu(contatos).icon('<i class="fa fa-user fa-lg"></i>'))
        .addChild(nga.menu(logout).link('logout').icon('<i class="fa fa-sign-out fa-lg"></i>'))
    );
    
    nga.configure(admin);
}]);

myApp.config(['RestangularProvider', function(RestangularProvider) {
    RestangularProvider.addFullRequestInterceptor(function(element, operation, what, url, headers, params) {
        headers['Authorization'] = token;
        return { headers: headers };
    });
    RestangularProvider.addResponseInterceptor(function(data, operation, what, url, response) {
        if (data.success == false && data.message == "INVALID_TOKEN") {
            window.location.replace("/login");
        }
        return data;
    });
}]);

myApp.config(['$stateProvider', function ($stateProvider) {
    $stateProvider.state('logout', {
        parent: 'main',
        url: '/logout'
    });
}]);

window.onhashchange = function() {
    if(location.hash == '#/logout') {
        window.location.replace("/login");
    }
}