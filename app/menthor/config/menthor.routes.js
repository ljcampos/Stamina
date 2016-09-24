(function() {
  'use strict';
  angular.module('menthor').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.menthor.list', {
      url: '/mentor',
      templateUrl: 'app/menthor/views/menthor.list.html',
      controller: 'MenthorController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.menthor.view', {
      url: '/mentor/view/:id',
      templateUrl: 'app/menthor/views/menthor.view.html',
      controller: 'MenthorController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.menthor.add', {
      url: '/mentor/add',
      templateUrl: 'app/menthor/views/menthor.add.html',
      controller: 'MenthorController',
      data: {
        requireLogin: true,
        role: 1
      }
    }).state('admin.menthor.edit', {
      url: '/mentor/edit/:id',
      templateUrl: 'app/menthor/views/menthor.edit.html',
      controller: 'MenthorController',
      data: {
        requireLogin: true,
        role: 1
      }
    });
  }
} ());