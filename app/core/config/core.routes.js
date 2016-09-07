(function() {
  'use strict';
  angular.module('core').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {
    // $urlRouterProvider.otherwise(function ($injector, $location) {
    //   $injector.get('$state').transitionTo('/', null, {
    //     location: false
    //   });
    // });

    /*
    .state('index', {
            url: '/',
            views: {
              '@' : {
                templateUrl: 'layout.html',
                controller: 'IndexCtrl'
              },
              'top@index' : { templateUrl: 'tpl.top.html',},
              'left@index' : { templateUrl: 'tpl.left.html',},
              'main@index' : { templateUrl: 'tpl.main.html',},
            },
          })
        .state('index.list', {
            url: '/list',
            templateUrl: 'list.html',
            controller: 'ListCtrl'
          })
    */

    $stateProvider
    .state('admin', {
      url: '/',
      views:{
        '@': {
          //templateUrl: 'app/core/views/admin.html'
          templateUrl: 'app/templates/layouts/admin_layout.html'
        },
        'admin_aside@admin': {templateUrl: 'app/templates/partials/admin_aside.html'},
        'admin_navbar@admin': {templateUrl: 'app/templates/partials/admin_navbar.html'}
      }
    })
    .state('entrepreneur', {
      url: '/entrepreneur',
      templateUrl: 'app/core/views/entrepreneur.html'
    })
  }
} ());
