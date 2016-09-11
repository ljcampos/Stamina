(function() {
  'use strict';
  angular.module('menthor').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.menthor.list', {
      url: '/mentor',
      templateUrl: 'app/menthor/views/menthor.list.html',
      controller: 'MenthorController'
    })
    .state('admin.menthor.view', {
      url: '/mentor/view',
      templateUrl: 'app/menthor/views/menthor.view.html'
    })
    .state('admin.menthor.add', {
      url: '/mentor/add',
      templateUrl: 'app/menthor/views/menthor.add.html'
    });
  }
} ());