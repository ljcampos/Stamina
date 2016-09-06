(function() {
  'use strict';
  angular.module('user').config(['$stateProvider', '$urlRouterProvider', UserRoutesConfig]);

  function UserRoutesConfig($stateProvider, $urlRouterProvider) {
    // $urlRouterProvider.otherwise(function ($injector, $location) {
    //   $injector.get('$state').transitionTo('/', null, {
    //     location: false
    //   });
    // });

    $stateProvider
    .state('signin', {
      url: '/signin',
      templateUrl: 'app/user/views/signin.html'
    })
    .state('signup', {
      url: '/signup',
      templateUrl: '/app/user/views/signup.html'
    });
  }
} ());
