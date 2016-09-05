(function() {
  'use strict';
  angular.module('core').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {
    // $urlRouterProvider.otherwise(function ($injector, $location) {
    //   $injector.get('$state').transitionTo('/', null, {
    //     location: false
    //   });
    // });

    $stateProvider
    .state('admin', {
      url: '/',
      templateUrl: 'app/core/views/admin.html'
    })
    .state('entrepreneur', {
      url: '/entrepreneur',
      templateUrl: 'app/core/views/entrepreneur.html'
    });
  }
} ());
