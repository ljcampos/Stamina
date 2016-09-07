(function() {
  'use strict';
  angular.module('menthor').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('menthor', {
      url: '/mentor',
      templateUrl: 'app/menthor/views/menthor.html',
      controller: 'MenthorController'
    });
  }
} ());