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
      views:{
        '@': {
          //templateUrl: 'app/core/views/admin.html'
          templateUrl: 'app/templates/layouts/admin_layout.html'
        },
        'admin_aside@admin': {templateUrl: 'app/templates/partials/admin_aside.html'},
        'admin_navbar@admin': {templateUrl: 'app/templates/partials/admin_navbar.html', controller: 'HeaderController'}
      }
    })
    .state('admin.dashboard', {
      url: '/',
      templateUrl: 'app/core/views/admin.home.html'
    })

    .state('admin.menthor', {
      templateUrl: 'app/menthor/views/mentor.html'
    })

    .state('entrepreneur', {
      // views:{
      //   '@': {
          templateUrl: 'app/templates/layouts/entrepreneur_layout.html'
        //}
        //'entrepreneur_navbar@entrepreneur': {templateUrl: 'app/templates/partials/admin_aside.html'},
      //}
    })
    .state('entrepreneur.dashboard', {
      url: '/emprendedor',
      templateUrl: '/app/entrepreneur/views/entrepreneur.home.html'
    });
  }
} ());
