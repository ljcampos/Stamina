(function() {
  'use strict';
  angular.module('university').config(['$stateProvider', '$urlRouterProvider', CoreRoutesConfig]);

  function CoreRoutesConfig($stateProvider, $urlRouterProvider) {

    $stateProvider
    .state('admin.university.list', {
      url: '/university',
      templateUrl: 'app/university/views/university.list.html',
      controller: 'UniversityController'
    })
    .state('admin.university.view', {
      url: '/university/view',
      templateUrl: 'app/university/views/university.view.html'
    })
    .state('admin.university.add', {
      url: '/university/add',
      templateUrl: 'app/university/views/university.add.html'
    });
  }
} ());