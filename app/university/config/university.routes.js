(function() {
  'use strict';
  angular.module('university').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.university.list', {
      url: '/university',
      templateUrl: 'app/university/views/university.list.html',
      controller: 'UniversityController',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.university.view', {
      url: '/university/view/:id',
      controller: 'UniversityViewController',
      templateUrl: 'app/university/views/university.view.html',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.university.edit', {
      url: '/university/edit/:id',
      controller: 'UniversityEditController',
      templateUrl: 'app/university/views/university.edit.html',
      data: {
        requireLogin: true,
        role: 1
      }
    })
    .state('admin.university.add', {
      url: '/university/add',
      templateUrl: 'app/university/views/university.add.html',
      controller: 'UniversityController',
      data: {
        requireLogin: true,
        role: 1
      }
    });
  }
} ());