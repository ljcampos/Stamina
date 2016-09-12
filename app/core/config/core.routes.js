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
          //templateUrl: 'app/core/views/admin.html'
          templateUrl: 'app/templates/layouts/admin_layout.html'
        },
        'admin_aside@admin': {templateUrl: 'app/templates/partials/admin_aside.html'},
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
      templateUrl: '/app/entrepreneur/views/entrepreneur.home.html',
      data: {
        requireLogin: true,
        role: 0
      }
    });
  }
} ());
