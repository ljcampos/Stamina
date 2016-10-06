(function() {
  'use strict';
  angular.module('aplicationform').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.aplicationform.list', {
      url: '/aplicationform',
      templateUrl: 'app/aplicationform/views/aplicationform.list.html',
      controller: 'AplicationformController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.aplicationform.view', {
      url: '/aplicationform/view/:id',
      templateUrl: 'app/aplicationform/views/aplicationform.view.html',
      controller: 'AplicationformController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.aplicationform.edit', {
      url: '/aplicationform/edit/:id',
      templateUrl: 'app/aplicationform/views/aplicationform.edit.html',
      controller: 'AplicationformController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.aplicationform.add', {
      url: '/aplicationform/add',
      templateUrl: 'app/aplicationform/views/aplicationform.add.html',
      data: {
        requireLogin: true,
        role: 1
      }
    });
  }
} ());