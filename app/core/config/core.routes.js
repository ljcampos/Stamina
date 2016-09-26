(function() {
  'use strict';
  angular.module('core').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {
    // $urlRouterProvider.otherwise(function ($injector, $location) {
    //   $injector.get('$state').transitionTo('/', null, {
    //     location: false
    //   });
    // });
    //$urlRouterProvider.otherwise("/signin");

    $stateProvider
    .state('admin', {
      views:{
        '@': {
          templateUrl: 'app/templates/layouts/admin_layout.html'
        },
        'admin_aside@admin': {templateUrl: 'app/templates/partials/admin_aside.html', controller: 'UserController'},
        'admin_navbar@admin': {templateUrl: 'app/templates/partials/admin_navbar.html', controller: 'UserController'}
      }
    })
    .state('admin.dashboard', {
      url: '/',
      templateUrl: 'app/core/views/admin.home.html',
      data: {
        requireLogin: true,
        role: 1
      }
    })

    .state('admin.menthor', {
      templateUrl: 'app/menthor/views/mentor.html'
    })

    .state('admin.announcement', {
      templateUrl: 'app/announcement/views/announcement.html'
    })

    .state('admin.university', {
      templateUrl: 'app/university/views/university.html'
    })

    .state('admin.faq', {
      templateUrl: 'app/faq/views/faq.html'
    })

    .state('admin.aplicationform', {
      templateUrl: 'app/aplicationform/views/aplicationform.html'
    })

    .state('entrepreneur', {
      templateUrl: 'app/templates/layouts/entrepreneur_layout.html',
      controller: 'UserController'
    })

    .state('entrepreneur.dashboard', {
      url: '/emprendedor',
      templateUrl: '/app/entrepreneur/views/_entrepreneur.home.html',
      data: {
        requireLogin: true,
        role: 3
      }
    });
  }
} ());
